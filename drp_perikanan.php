<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DRP Hakim Ad Hoc Perikanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .profile-pic { width: 100%; max-width: 180px; height: 240px; object-fit: cover; border-radius: 0.5rem; background-color: #e9ecef; border: 3px solid #dee2e6; }
        .table-custom td { padding: 0.4rem 0.75rem; vertical-align: top; border: none; }
        .table-custom tr td:first-child { font-weight: 600; width: 170px; }
        .table-custom tr td:nth-child(2) { width: 15px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="drp_perikanan.php">DRP Perikanan</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="drp_perikanan.php">Daftar Hakim</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="tambah_data_drpp.php">Tambah Data</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="compare.php">Bandingkan Data</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
    <div class="text-center mb-4">
        <h1 class="display-6">Daftar Riwayat Pekerjaan Hakim</h1>
        <p class="lead text-muted">Hakim Ad Hoc Perikanan</p>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="drp_perikanan.php" class="d-flex justify-content-end align-items-center gap-2">
                <label for="sort" class="form-label mb-0">Urutkan Berdasarkan:</label>
                <select name="sort" id="sort" class="form-select w-auto">
                    <option value="nama_asc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'nama_asc') echo 'selected'; ?>>Nama (A-Z)</option>
                    <option value="nama_desc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'nama_desc') echo 'selected'; ?>>Nama (Z-A)</option>
                    <option value="penempatan" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'penempatan') echo 'selected'; ?>>Penempatan</option>
                </select>
                <button type="submit" class="btn btn-secondary">Urutkan</button>
            </form>
        </div>
    </div>

    <?php
    // --- PHP SCRIPT ---
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sertifikasi_hakim";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die('<div class="alert alert-danger">Koneksi Gagal: ' . htmlspecialchars($conn->connect_error) . '</div>');
    }

    // Logika untuk sorting
    $sort_option = $_GET['sort'] ?? 'nama_asc';
    $order_by = 'nama ASC'; // Default
    switch ($sort_option) {
        case 'nama_desc':
            $order_by = 'nama DESC';
            break;
        case 'penempatan':
            $order_by = 'penempatan ASC, nama ASC';
            break;
        default:
            $order_by = 'nama ASC';
            break;
    }

    $sql = "SELECT * FROM drp_hakim_perikanan ORDER BY $order_by";
    $result = $conn->query($sql);

    // Notifikasi
    if (isset($_GET['status']) && $_GET['status'] == 'sukses') {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data hakim baru telah berhasil ditambahkan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Card Tampilan Data (Sama seperti sebelumnya)
            echo '<div class="card mb-3">';
            echo '<div class="card-header fs-5">' . htmlspecialchars($row["nama"]) . '</div>';
            echo '<div class="card-body p-4"><div class="row g-4">';
            echo '<div class="col-lg-3 d-flex justify-content-center align-items-start">';
            $foto_folder = 'foto_hakim/';
            $foto_path = $foto_folder . htmlspecialchars($row["foto_filename"] ?? '');
            if (!empty($row["foto_filename"]) && file_exists($foto_path)) {
                echo '<img src="' . $foto_path . '" alt="Foto ' . htmlspecialchars($row["nama"]) . '" class="profile-pic">';
            } else {
                echo '<img src="https://via.placeholder.com/180x240.png?text=Foto" alt="Foto tidak tersedia" class="profile-pic">';
            }
            echo '</div>'; // col-lg-3
            echo '<div class="col-lg-9"><table class="table table-custom">';
            // Data Rows
            echo '<tr><td>NIP / NRP</td><td>:</td><td>' . htmlspecialchars($row["nip_nrp"] ?: '-') . '</td></tr>';
            echo '<tr><td>Golongan / Ruang</td><td>:</td><td>' . htmlspecialchars($row["gol_rg"] ?: '-') . '</td></tr>';
            echo '<tr><td>Tempat, Tgl Lahir</td><td>:</td><td>' . htmlspecialchars(($row["tempat_lahir"] ?? '') . (!empty($row["tempat_lahir"]) && !empty($row["tanggal_lahir"]) ? ', ' : '') . ($row["tanggal_lahir"] ?? '-')) . '</td></tr>';
            echo '<tr><td>Jenis Kelamin</td><td>:</td><td>' . htmlspecialchars($row["jenis_kelamin"] ?: '-') . '</td></tr>';
            echo '<tr><td>Agama</td><td>:</td><td>' . htmlspecialchars($row["agama"] ?: '-') . '</td></tr>';
            echo '<tr><td>Nama Pasangan</td><td>:</td><td>' . htmlspecialchars($row["nama_pasangan"] ?: '-') . '</td></tr>';
            echo '<tr><td>Jumlah Anak</td><td>:</td><td>' . htmlspecialchars($row["jumlah_anak"] ?: '-') . '</td></tr>';
            echo '<tr><td>Penempatan</td><td>:</td><td>' . htmlspecialchars($row["penempatan"] ?: '-') . '</td></tr>';
            echo '<tr><td>Asal Organisasi</td><td>:</td><td>' . nl2br(htmlspecialchars($row["asal_organisasi"] ?: '-')) . '</td></tr>';
            echo '<tr><td>Pendidikan</td><td>:</td><td>' . nl2br(htmlspecialchars($row["pendidikan"] ?: '-')) . '</td></tr>';
            echo '<tr><td>Alamat</td><td>:</td><td>' . nl2br(htmlspecialchars($row["alamat"] ?: '-')) . '</td></tr>';
            echo '<tr><td>Kontak</td><td>:</td><td>' . htmlspecialchars($row["kontak"] ?: '-') . '</td></tr>';
            echo '<tr><td>Riwayat Pekerjaan</td><td>:</td><td>' . nl2br(htmlspecialchars($row["riwayat_pekerjaan"] ?: '-')) . '</td></tr>';
            if ($row["keterangan"]) {
                echo '<tr><td>Keterangan</td><td>:</td><td><strong>' . htmlspecialchars($row["keterangan"]) . '</strong></td></tr>';
            }
            echo '</table></div>'; // col-lg-9
            echo '</div></div></div>'; // row, card-body, card
        }
    } else {
        echo '<div class="alert alert-info text-center">Belum ada data. Silakan klik tombol "Tambah Data Baru" untuk memulai.</div>';
    }
    $conn->close();
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>