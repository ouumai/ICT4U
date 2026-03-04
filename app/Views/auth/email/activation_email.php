<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Kod Pengaktifan ICT4U</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', Arial, sans-serif; background-color: #f4f4f4;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="max-width: 600px; background: white; padding: 30px; border-radius: 12px; border: 1px solid #ddd; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                    <tr>
                        <td align="center">
                            <h2 style="color: #333; margin-bottom: 10px; font-weight: 800;">Sistem ICT4U</h2>
                            <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 25px;">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="font-size: 16px; color: #555;">Hai <strong><?= esc($user->username) ?></strong>,</p>
                            <p style="font-size: 16px; color: #555;">Sila gunakan kod pengesahan di bawah untuk mengaktifkan akaun anda:</p>
                            
                            <div style="background-color: #e7f3ff; border: 1px dashed #007bff; padding: 25px; text-align: center; margin: 30px 0; border-radius: 10px;">
                                <h1 style="color: #4f46e5; font-size: 42px; letter-spacing: 12px; margin: 0; font-weight: 800;">
                                    <?= $code ?>
                                </h1>
                            </div>

                            <p style="font-size: 14px; color: #ed213a; text-align: center; font-weight: bold; margin-top: 15px;">
                                Kod ini hanya sah untuk 5 minit sahaja.
                            </p>
                            
                            <p style="font-size: 13px; color: #888; text-align: center; margin-top: 25px;">
                                Jika anda tidak meminta kod ini, sila abaikan emel ini.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding-top: 30px; border-top: 1px solid #eee; margin-top: 20px;">
                            <p style="font-size: 11px; color: #94a3b8; text-transform: uppercase; font-weight: 600;">
                                &copy; 2026 ICT4U MANAGEMENT SYSTEM
                            </p>
                        </td>
                    </tr>
                </table>
                </td>
        </tr>
    </table>
</body>
</html>