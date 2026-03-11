<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f7ff;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding: 60px 20px;">
        <tr>
            <td align="center">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);">
                    <tr>
                        <td align="center" style="padding: 40px 40px 20px;">
                            <h2 style="color: #333; margin-bottom: 10px;">Sistem ICT4U</h2>
                            <p style="color: #64748b; font-size: 14px; margin: 0;">Notifikasi Keselamatan Akaun</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0 40px 40px;">
                            <hr style="border: none; border-top: 1px solid #f1f5f9; margin-bottom: 30px;">
                            
                            <p style="margin: 0 0 15px; color: #1e293b; font-size: 16px; font-weight: 700;">Hai <?= esc($fullname) ?>,</p>
                            
                            <p style="margin: 0 0 20px; color: #64748b; font-size: 15px; line-height: 1.6;">
                                Kata laluan bagi akaun ICT4U anda telah berjaya <b>dikemaskini</b> pada waktu berikut:
                            </p>

                            <div style="background-color: #f8fafc; border-radius: 12px; padding: 20px; margin-bottom: 30px; border: 1px solid #e2e8f0; text-align: center;">
                                <p style="margin: 0; font-size: 14px; color: #1e293b;"><b>Masa:</b> <?= $updateTime ?></p>
                                <p style="margin: 5px 0 0; font-size: 14px; color: #1e293b;">
                                    <b>Status:</b> <span style="color: #10b981; font-weight: 700;">Berjaya</span>
                                </p>
                            </div>

                            <p style="margin: 0 0 20px; color: #64748b; font-size: 14px; line-height: 1.6;">
                                Jika ini adalah tindakan anda, sila abaikan emel ini.
                            </p>

                            <p style="margin: 0; color: #ef4444; font-size: 13px; font-weight: 700; text-align: center; background-color: #fff1f2; padding: 10px; border-radius: 8px;">
                                 Bukan anda? Sila hubungi Admin IT dengan segera.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 25px; background-color: #f8fafc; color: #94a3b8; font-size: 11px;">
                            &copy; 2026 ICT4U MANAGEMENT SYSTEM
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>