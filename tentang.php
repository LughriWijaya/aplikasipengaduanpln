<?php include '../config/db.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tentang Pembuat Website</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        .about-card {
            display: inline-block;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 6px 32px rgba(0,159,227,0.13);
            padding: 32px 32px 24px 32px;
            margin-top: 30px;
            max-width: 400px;
            text-align: center;
            border-top: 6px solid #009fe3;
            border-bottom: 6px solid #ffe600;
            position: relative;
        }
        .about-card img {
            width: 110px;
            height: 110px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #009fe3;
            margin-bottom: 18px;
            box-shadow: 0 2px 12px rgba(0,159,227,0.10);
        }
        .about-card .badge {
            display: inline-block;
            background: #ffe600;
            color: #003366;
            font-weight: 600;
            border-radius: 8px;
            padding: 4px 14px;
            font-size: 14px;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }
        .about-card h3 {
            margin: 10px 0 6px 0;
            color: #003366;
            font-size: 1.3rem;
            font-weight: 700;
        }
        .about-card p {
            margin: 6px 0;
            color: #333;
            font-size: 1rem;
        }
        .about-card .info-list {
            text-align: left;
            margin: 18px 0 10px 0;
            padding: 0 12px;
        }
        .about-card .info-list b {
            color: #009fe3;
            min-width: 90px;
            display: inline-block;
        }
        .about-card .desc {
            background: #f7fafc;
            border-radius: 8px;
            padding: 10px 14px;
            margin: 14px 0 10px 0;
            color: #003366;
            font-size: 15px;
        }
        .about-card .fitur {
            background: #e0f7fa;
            border-radius: 8px;
            padding: 8px 14px;
            color: #009fe3;
            font-size: 15px;
            margin-bottom: 12px;
        }
        .about-links {
            margin-top: 20px;
        }
        .about-links a.menu {
            margin: 8px 8px 0 8px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="header-pln">
        <h1>Aplikasi Pengaduan PLN</h1>
    </div>
    <div class="container" style="text-align:center;">
        <div class="about-card">
            <img src="lughri.jpg" alt="Foto Profil">
            <h3>Lughri Wijaya Pamungkas</h3>
            <div class="info-list">
                <p><b>NIM:</b> 24SA31A038</p>
                <p><b>Prodi:</b> TEKNOLOGI INFORMASI</p>
                <p><b>No HP:</b> 089-953-210-50</p>
                <p><b>Email:</b> lughriwijaya137@gmail.com</p>
            </div>
        </div>
        <div class="about-links">
            <a href="index.php" class="menu">Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
