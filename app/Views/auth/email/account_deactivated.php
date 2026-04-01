<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="margin: 0; padding: 0; font-family: Plus Jakarta Sans, sans-serif; background-color: #f1f5f9;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 30px rgba(79, 70, 229, 0.08);">
                    <tr><td style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); height: 6px;"></td></tr>
                    <tr><td align="center" style="padding: 40px 40px 20px;"><h2 style="color: #333; margin-bottom: 10px;">SISTEM ICT4U</h2></td></tr>
                    <tr>
                        <td style="padding: 0 40px 40px;">
                            <hr style="border: none; border-top: 1px solid #f1f5f9; margin-bottom: 30px;">
                            <p style="margin: 0 0 15px; color: #1e293b; font-size: 16px;">Hai <b><?= esc($fullname ?? 'User') ?></b></p>
                            <p style="margin: 0 0 20px; color: #64748b; font-size: 15px; line-height: 1.6;">
                                Akaun ICT4U anda telah berjaya dinyahaktifkan pada waktu berikut:
                            </p>
                            <div style="background-color: #fff7ed; border-radius: 12px; padding: 20px; margin-bottom: 25px; border: 1px solid #fed7aa;">
                                <p style="margin: 0; font-size: 14px; color: #1e293b;"><b>Masa:</b> <?= esc($deactivatedAt ?? '-') ?></p>
                                <p style="margin: 5px 0 0; font-size: 14px; color: #1e293b;"><b>Status:</b> <span style="color: #dc2626; font-weight: 700;">Dinyahaktifkan</span></p>
                            </div>
                            <p style="margin: 0 0 24px; color: #64748b; font-size: 14px; line-height: 1.7; text-align: center;">
                                Jika anda ingin menggunakan semula akaun ini, 
                                <br>klik butang di bawah untuk aktifkan semula akaun anda.</br>
                            </p>
                            <div style="text-align: center; margin-bottom: 24px;">
                                <a href="<?= esc($reactivationLink ?? '#') ?>" style="display: inline-block; background: #4f46e5; color: #ffffff; text-decoration: none; padding: 14px 26px; border-radius: 14px; font-size: 14px; font-weight: 700;">
                                    Aktifkan Semula Akaun
                                </a>
                            </div>
                            <p style="margin: 0; color: #94a3b8; font-size: 12px; text-align: center;">
                                Pautan ini sah selama 24 jam.
                            </p>
                            <br></br>
                            <p style="margin: 0; color: #ff3131; font-size: 12px;  text-align: center;"><b>Bukan tindakan anda? Sila hubungi Admin IT dengan segera.</b></p>
                        </td>
                    </tr>
                    <tr><td align="center" style="padding: 25px; background-color: #f8fafc; color: #94a3b8; font-size: 11px;">&copy; 2026 ICT4U MANAGEMENT SYSTEM</td></tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
