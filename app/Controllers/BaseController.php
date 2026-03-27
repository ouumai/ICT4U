<?php

namespace App\Controllers;

use App\Models\AuditLogModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    protected ?AuditLogModel $auditLogModel = null;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        // $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');
        $this->auditLogModel = new AuditLogModel();
        date_default_timezone_set('Asia/Kuala_Lumpur');
    }

    protected function getActorId(): ?int
    {
        if (function_exists('auth') && auth()->loggedIn()) {
            return (int) auth()->user()->id;
        }

        $userId = session()->get('user_id');

        return is_numeric($userId) ? (int) $userId : null;
    }

    protected function getActorName(): string
    {
        if (function_exists('auth') && auth()->loggedIn()) {
            $user = auth()->user();

            return $user->fullname
                ?? $user->username
                ?? $user->email
                ?? 'Pengguna Sistem';
        }

        return (string) (session()->get('username') ?: session()->get('user_name') ?: 'Pengguna Sistem');
    }

    protected function auditValue(mixed $value): string
    {
        if ($value === null || $value === '') {
            return 'kosong';
        }

        if (is_bool($value)) {
            return $value ? 'ya' : 'tidak';
        }

        if (is_array($value)) {
            return implode(', ', array_map(fn ($item) => $this->auditValue($item), $value));
        }

        $stringValue = trim(strip_tags((string) $value));

        if ($stringValue === '') {
            return 'kosong';
        }

        return mb_strimwidth($stringValue, 0, 80, '...');
    }

    protected function diffChanges(array $before, array $after, array $labels = []): array
    {
        $keys = array_unique(array_merge(array_keys($before), array_keys($after)));
        $changes = [];

        foreach ($keys as $key) {
            $oldValue = $before[$key] ?? null;
            $newValue = $after[$key] ?? null;

            if ($oldValue == $newValue) {
                continue;
            }

            $label = $labels[$key] ?? ucwords(str_replace('_', ' ', (string) $key));
            $changes[] = sprintf(
                '%s: %s -> %s',
                $label,
                $this->auditValue($oldValue),
                $this->auditValue($newValue)
            );
        }

        return $changes;
    }

    protected function writeAuditLog(
        string $action,
        string $entityType,
        int|string|null $entityId,
        string $subject,
        array $changes = [],
        ?string $description = null
    ): void {
        if ($this->auditLogModel === null) {
            return;
        }

        $description ??= $subject;

        try {
            $this->auditLogModel->insert([
                'user_id'     => $this->getActorId(),
                'username'    => $this->getActorName(),
                'action'      => $action,
                'entity_type' => $entityType,
                'entity_id'   => $entityId,
                'subject'     => $subject,
                'description' => $description,
                'changes'     => json_encode($changes, JSON_UNESCAPED_UNICODE),
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Gagal simpan audit log: {message}', ['message' => $e->getMessage()]);
        }
    }
}
