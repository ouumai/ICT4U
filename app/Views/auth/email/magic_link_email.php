<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', Arial, sans-serif; background-color: #f4f7ff;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 30px rgba(79, 70, 229, 0.08);">
                    <tr>
                        <td align="center" style="padding: 40px 40px 20px;">
                            <h2 style="color: #333; margin-bottom: 10px; font-weight: 800;">Sistem ICT4U</h2>
                            
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0 40px 40px;">
                            <hr style="border: none; border-top: 1px solid #f1f5f9; margin-bottom: 30px;">
                            <p style="margin: 0 0 15px; color: #1e293b; font-size: 16px; font-weight: 700;">Hai <?= esc($user->username) ?>,</p>
                            <p style="margin: 0 0 30px; color: #64748b; font-size: 15px; line-height: 1.6;">Klik butang di bawah untuk log masuk ke dalam akaun anda secara automatik:</p>
                            
                            <div style="text-align: center; margin-bottom: 30px;">
                                <a href="<?= url_to('magic-link-verify') ?>?token=<?= $token ?>" 
                                style="background-color: #4f46e5; color: #ffffff; padding: 15px 35px; border-radius: 12px; text-decoration: none; font-weight: 700; display: inline-block;">
                                Log Masuk Sekarang
                                </a>
                            </div>

                            <p style="margin: 0; color: #ef4444; font-size: 13px; font-weight: 700; text-align: center;">Pautan ini sah untuk 5 minit sahaja.</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 25px; background-color: #f8fafc; color: #94a3b8; font-size: 11px;">
                            &copy; 2026 ICT4U MANAGEMENT SYSTEM | DigitalUKM
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>