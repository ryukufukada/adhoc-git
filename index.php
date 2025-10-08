<?php
// --- Data dummy untuk hakim (di aplikasi nyata diambil dari database) ---
$data_hakim = [
    [
        "nama" => "Fulan Fulan, S.H., M.H.",
        "nip" => "197508172000031002",
        "sertifikat" => "Hakim Anak"
    ],
];

// --- Data dummy untuk daftar sertifikasi ---
$daftar_sertifikasi = [
    "Sertifikasi Hakim Tindak Pidana Korupsi (Tipikor)",
    "Sertifikasi Hakim Hubungan Industrial",
    "Sertifikasi Hakim Perikanan",
    "Sertifikasi Hakim Niaga",
    "Sertifikasi Hakim Pajak",
    "Sertifikasi Hakim Anak",
    "Sertifikasi Mediator",
    "Sertifikasi Ekonomi Syariah",
    "Sertifikasi Lingkungan Hidup"
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Pengecekan Sertifikasi</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&display=swap');
        body {  
            font-family: "Karla", sans-serif;
            font-optical-sizing: auto;
            font-style: normal; }
        .sidebar-list { max-height: 400px; overflow-y: auto; }
    </style>
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- Header Dashboard -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center border-bottom pb-3 mb-4">
                <div>
                    <h1 class="h3 fw-bold text-dark mb-0">Dashboard Admin</h1>
                    <small class="text-muted">Manajemen Mutasi Hakim Karir</small>
                </div>
                <div class="mt-3 mt-md-0 d-flex gap-2">
                    <!-- Tombol navigasi dengan ikon Font Awesome -->
                    <a href="drp_perikanan.php" class="btn btn-success">
                        <i class="fa-solid fa-eye me-1"></i> Lihat DRP Hakim Ad Hoc Perikanan
                    </a>
                    <a href="index.html" class="btn btn-danger">
                        <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                    </a>
                </div>
            </div>

            <div class="row g-4">
                <!-- Kolom Utama: Tabel Hakim -->
                <div class="col-lg-12">
                    <!-- Navigasi Tab -->
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Semua Hakim</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo dirname($_SERVER['PHP_SELF']); ?>/pages/hakim_perikanan.php">Hakim Perikanan 2025</a>
                        </li>
                    </ul>

                    <!-- Tabel Hakim Bersertifikasi -->
                    <h2 class="h5 fw-semibold mb-3">Daftar Hakim Bersertifikasi</h2>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Hakim</th>
                                    <th>NIP</th>
                                    <th>Sertifikat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data_hakim as $hakim): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($hakim['nama']) ?></td>
                                        <td><?= htmlspecialchars($hakim['nip']) ?></td>
                                        <td><?= htmlspecialchars($hakim['sertifikat']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

