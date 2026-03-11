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
                            <p style="margin: 0 0 20px; color: #64748b; font-size: 15px; line-height: 1.6;">Kata laluan bagi akaun ICT4U anda telah berjaya dikemaskini pada waktu berikut:</p>
                            <div style="text-align: left; background-color: #f8fafc; border-radius: 12px; padding: 20px; margin-bottom: 25px; border: 1px solid #e2e8f0; text-align: center;">
                                <p style="margin: 0; font-size: 14px; color: #1e293b; text-align: left;"><b>Masa:</b> <?= $updateTime ?></p>
                                <p style="margin: 5px 0 0; font-size: 14px; color: #1e293b; text-align: left;"><b>Status:</b> <span style="color: #32CD32; font-weight: 700;">Berjaya</span></p>
                            </div>
                            <p style="margin: 0 0 15px; color: #64748b; font-size: 14px; text-align: center;">Jika ini adalah tindakan anda, sila abaikan emel ini.</p>
                            <p style="margin: 0; color: #ff3131; font-size: 14px;  text-align: center;"><b>Bukan anda? Sila hubungi Admin IT dengan segera.</b></p>
                        </td>
                    </tr>
                    <tr><td align="center" style="padding: 25px; background-color: #f8fafc; color: #94a3b8; font-size: 11px;">&copy; 2026 ICT4U MANAGEMENT SYSTEM</td></tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>