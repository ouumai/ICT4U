<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Shield\Config\Auth as ShieldAuth;
use CodeIgniter\Shield\Authentication\Actions\ActionInterface;
use CodeIgniter\Shield\Authentication\AuthenticatorInterface;
use CodeIgniter\Shield\Authentication\Authenticators\AccessTokens;
use CodeIgniter\Shield\Authentication\Authenticators\HmacSha256;
use CodeIgniter\Shield\Authentication\Authenticators\JWT;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Authentication\Passwords\CompositionValidator;
use CodeIgniter\Shield\Authentication\Passwords\DictionaryValidator;
use CodeIgniter\Shield\Authentication\Passwords\NothingPersonalValidator;
use CodeIgniter\Shield\Authentication\Passwords\PwnedValidator;
use CodeIgniter\Shield\Authentication\Passwords\ValidatorInterface;
use CodeIgniter\Shield\Models\UserModel;

class Auth extends ShieldAuth
{
    public const RECORD_LOGIN_ATTEMPT_NONE    = 0;
    public const RECORD_LOGIN_ATTEMPT_FAILURE = 1;
    public const RECORD_LOGIN_ATTEMPT_ALL     = 2;

    /**
     * --------------------------------------------------------------------
     * View files
     * --------------------------------------------------------------------
     * Dah betulkan path login & register supaya panggil fail dalam folder Views.
     */
    public array $views = [
        'login'                       => 'auth/login',         
        'register'                    => 'auth/register',      
        'forgot'                      => 'auth/forgot_password',
        'reset_password'              => 'auth/reset_password',
        'layout'                      => '\CodeIgniter\Shield\Views\layout',
        'action_email_2fa'            => '\CodeIgniter\Shield\Views\email_2fa_show',
        'action_email_2fa_verify'     => '\CodeIgniter\Shield\Views\email_2fa_verify',
        'action_email_2fa_email'      => '\CodeIgniter\Shield\Views\Email\email_2fa_email',
        'action_email_activate_show'  => 'auth/email_activation',
        'action_email_activate_email' => 'auth/email/activation_email',
        'magic-link-login'            => 'auth/forgot_password', 
        'magic-link-message'          => 'auth/magic_link_message',
        'magic-link-email'            => 'auth/email/magic_link_email',
    ];

    /**
     * --------------------------------------------------------------------
     * Redirect URLs
     * --------------------------------------------------------------------
     * Login dah ditukar ke '/' supaya tak terus paksa ke reset-password.
     */
    public array $redirects = [
        'register'          => '/',
        'login'             => '/',           
        'logout'            => 'login',
        'force_reset'       => 'reset-password',
        'permission_denied' => '/',
        'group_denied'      => '/',
    ];

    public array $actions = [
        'register' => \CodeIgniter\Shield\Authentication\Actions\EmailActivator::class,
        'login'    => null,
    ];

    public array $authenticators = [
        'tokens'  => AccessTokens::class,
        'session' => Session::class,
        'hmac'    => HmacSha256::class,
    ];

    public string $defaultAuthenticator = 'session';
    public string $defaultLocale = 'ms';

    public array $authenticationChain = [
        'session',
        'tokens',
        'hmac',
    ];

    public bool $allowRegistration = true;
    public bool $recordActiveDate = true;
    public bool $allowMagicLinkLogins = true;
    public int $magicLinkLifetime = 300;

    public array $sessionConfig = [
        'field'              => 'user',
        'allowRemembering'   => true,
        'rememberCookieName' => 'remember',
        'rememberLength'     => 30 * DAY,
    ];

    public array $usernameValidationRules = [
        'label' => 'Auth.username',
        'rules' => [
            'required',
            'max_length[30]',
            'min_length[3]',
            'regex_match[/\A[a-zA-Z0-9\.\s]+\z/]',
            'is_unique[users.username]',
        ],
    ];

    public array $emailValidationRules = [
        'label' => 'Auth.email',
        'rules' => [
            'required',
            'max_length[254]',
            'valid_email',
        ],
    ];

    public int $minimumPasswordLength = 8;

    public array $passwordValidators = [
        CompositionValidator::class,
        NothingPersonalValidator::class,
        DictionaryValidator::class,
    ];

    public array $validFields = [
        'email',
    ];

    public array $personalFields = [];
    public int $maxSimilarity = 50;
    public string $hashAlgorithm = PASSWORD_DEFAULT;
    public int $hashMemoryCost = 65536;
    public int $hashTimeCost = 4;
    public int $hashThreads  = 1;
    public int $hashCost = 12;
    public ?string $DBGroup = null;

    public array $tables = [
        'users'             => 'users',
        'identities'        => 'auth_identities',
        'logins'            => 'auth_logins',
        'token_logins'      => 'auth_token_logins',
        'remember_tokens'   => 'auth_remember_tokens',
        'groups_users'      => 'auth_groups_users',
        'permissions_users' => 'auth_permissions_users',
    ];

    public string $userProvider = UserModel::class;

    /**
     * Logic Login Redirect
     */
    public function loginRedirect(): string
    {
        $session = session();
        
        // Hanya paksa reset password kalau guna link email
        if ($session->get('magicLogin')) {
            return $this->getUrl('reset-password'); 
        }

        $url = $session->getTempdata('beforeLoginUrl') ?? setting('Auth.redirects')['login'];
        return $this->getUrl($url);
    }

    public function logoutRedirect(): string
    {
        $url = setting('Auth.redirects')['logout'];
        return $this->getUrl($url);
    }

    public function registerRedirect(): string
    {
        $url = setting('Auth.redirects')['register'];
        return $this->getUrl($url);
    }

    public function forcePasswordResetRedirect(): string
    {
        $url = setting('Auth.redirects')['force_reset'];
        return $this->getUrl($url);
    }

    public function permissionDeniedRedirect(): string
    {
        $url = setting('Auth.redirects')['permission_denied'];
        return $this->getUrl($url);
    }

    public function groupDeniedRedirect(): string
    {
        $url = setting('Auth.redirects')['group_denied'];
        return $this->getUrl($url);
    }

    protected function getUrl(string $url): string
    {
        return match (true) {
            str_starts_with($url, 'http://') || str_starts_with($url, 'https://') => $url,
            route_to($url) !== false                                              => rtrim(url_to($url), '/ '),
            default                                                               => rtrim(site_url($url), '/ '),
        };
    }
}