<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semak Emel | ICT4U</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --brand-color: #ffffff;
            --accent-color: #6366f1;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('<?= base_url('assets/image/roundaboutUKM.jpg') ?>') center/cover no-repeat;
            position: relative;
        }

        /* Overlay Gelap sikit supaya text putih nampak */
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.8), rgba(124, 58, 237, 0.6));
            z-index: 1;
        }

        .main-content {
            position: relative;
            z-index: 2;
            width: 100%;
            /* 1. Lebarkan container: asal 550px, kita naikkan ke 750px atau 800px */
            max-width: 750px; 
            padding: 20px;
            animation: fadeIn 0.8s ease-out;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            /* 2. Pendekkan card: Kecilkan padding atas/bawah (asal 50px) jadi 30px atau 35px */
            padding: 35px 50px; 
            border-radius: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            text-align: center;
            color: white;
        }

        .brand-logo {
            font-weight: 800;
            font-size: 1.5rem;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            letter-spacing: 1px;
        }

        .icon-box {
            font-size: 2.5rem; /* Kecilkan lagi sikit supaya card tak tinggi sangat */
            color: var(--brand-color);
            margin-bottom: 10px; /* Rapatkan dengan tajuk */
            display: inline-block; 
            animation: bounceCustom 2s infinite; 
        }

        @keyframes bounceCustom {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        h1 {
            font-weight: 800;
            font-size: 2.25rem;
            margin-bottom: 15px;
        }

        .message-text {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 35px;
            opacity: 0.9;
        }

        .btn-back {
            background: white;
            color: #4f46e5;
            border: none;
            padding: 15px 30px;
            border-radius: 18px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .btn-back:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 20px -3px rgba(0, 0, 0, 0.2);
            color: #3730a3;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="glass-card">
        <div class="brand-logo">
            <i class="bi bi-cpu-fill"></i> ICT4U SYSTEM
        </div>

        <div class="icon-box">
           <i class="bi bi-envelope-paper-fill"></i>
        </div>

        <h1>Semak Emel!</h1>
        
        <p class="message-text">
            Satu pautan keselamatan telah dihantar ke emel anda. 
            <br>Sila klik pautan tersebut dalam masa <b>5 minit</b> untuk log masuk secara automatik.</br>
        </p>

        <a href="<?= url_to('login') ?>" class="btn-back">
            <i class="bi bi-arrow-left me-2"></i> Kembali ke Log Masuk
        </a>

        <div style="margin-top: 40px; opacity: 0.6; font-size: 0.75rem; font-weight: 700; letter-spacing: 1px;">
            &copy; 2026 ICT4U MANAGEMENT SYSTEM
        </div>
    </div>
</div>

</body>
</html>