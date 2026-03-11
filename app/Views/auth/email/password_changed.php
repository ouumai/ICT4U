<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Alert: Password Updated</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { width: 100%; max-width: 600px; margin: 20px auto; background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .header { text-align: center; padding-bottom: 20px; border-bottom: 1px solid #eeeeee; }
        .header h2 { color: #333; margin: 0; }
        .content { padding: 20px 0; color: #555; line-height: 1.6; }
        .details { background: #f9f9f9; padding: 15px; border-radius: 5px; margin: 15px 0; border-left: 4px solid #007bff; }
        .footer { text-align: center; font-size: 12px; color: #999; padding-top: 20px; border-top: 1px solid #eeeeee; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>ICT4U Security Alert</h2>
        </div>
        <div class="content">
            <p>Hi <strong><?= esc($fullname) ?></strong>,</p>
            <p>Emel ini adalah untuk memaklumkan bahawa kata laluan bagi akaun ICT4U anda telah berjaya dikemaskini.</p>
            
            <div class="details">
                <strong>Maklumat Aktiviti:</strong><br>
                Masa: <?= esc($updateTime) ?><br>
                Status: Berjaya
            </div>

            <p>Jika anda yang melakukan perubahan ini, anda boleh abaikan emel ini. Tiada tindakan lanjut diperlukan.</p>
            
            <p style="color: #d9534f; font-weight: bold;">PENTING:</p>
            <p>Jika anda <strong>TIDAK</strong> melakukan perubahan ini, sila hubungi admin ICT4U atau pihak IT DigitalUKM dengan segera untuk mengamankan akaun anda.</p>
        </div>
        <div class="footer">
            <p>&copy; 2026 ICT4U MANAGEMENT SYSTEM</p>
        </div>
    </div>
</body>
</html>