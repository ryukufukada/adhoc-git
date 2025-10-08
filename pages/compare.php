<?php
// --- Koneksi dan ambil semua data hakim untuk dropdown ---
require_once '../koneksi.php';

$hakim_list = [];
$sql_list = "SELECT id, nama FROM drp_hakim_perikanan ORDER BY nama ASC";
$result_list = $conn->query($sql_list);
if ($result_list->num_rows > 0) {
    while($row = $result_list->fetch_assoc()) {
        $hakim_list[] = $row;
    }
}

// --- Inisialisasi variabel data ---
$hakim1_data = null;
$hakim2_data = null;

// --- Jika form disubmit (ada id hakim1 dan hakim2 di URL) ---
if (isset($_GET['hakim1']) && isset($_GET['hakim2'])) {
    $id1 = (int)$_GET['hakim1'];
    $id2 = (int)$_GET['hakim2'];

    // Ambil data hakim 1
    $stmt1 = $conn->prepare("SELECT * FROM drp_hakim_perikanan WHERE id = ?");
    $stmt1->bind_param("i", $id1);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $hakim1_data = $result1->fetch_assoc();
    $stmt1->close();

    // Ambil data hakim 2
    $stmt2 = $conn->prepare("SELECT * FROM drp_hakim_perikanan WHERE id = ?");
    $stmt2->bind_param("i", $id2);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $hakim2_data = $result2->fetch_assoc();
    $stmt2->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandingkan Data Hakim</title>
    <!-- Bootstrap 5.3 & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&display=swap');
        body {
            font-family: "Karla", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
            background-color: #f8f9fa;
        }
        .table th, .table td { vertical-align: top; }
    </style>
</head>
<body>
<!-- Navbar utama dengan ikon Font Awesome -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="drp_perikanan.php">
        <i class="fa-solid fa-water me-2"></i>DRP Perikanan
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="drp_perikanan.php">
            <i class="fa-solid fa-users me-1"></i> Daftar Hakim
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="tambah_data_drpp.php">
            <i class="fa-solid fa-user-plus me-1"></i> Tambah Data
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="compare.php">
            <i class="fa-solid fa-table-list me-1"></i> Bandingkan Data
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
    <!-- Judul halaman -->
    <div class="text-center mb-4">
        <h1 class="display-6"><i class="fa-solid fa-table-list me-2"></i>Bandingkan Data Hakim</h1>
    </div>

    <!-- Form pilih hakim untuk dibandingkan -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="compare.php" method="GET" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="hakim1" class="form-label">Pilih Hakim Pertama</label>
                    <select name="hakim1" id="hakim1" class="form-select" required>
                        <option value="">-- Pilih Hakim --</option>
                        <?php foreach($hakim_list as $hakim): ?>
                            <option value="<?php echo $hakim['id']; ?>" <?php if(isset($_GET['hakim1']) && $_GET['hakim1'] == $hakim['id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($hakim['nama']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="hakim2" class="form-label">Pilih Hakim Kedua</label>
                    <select name="hakim2" id="hakim2" class="form-select" required>
                        <option value="">-- Pilih Hakim --</option>
                        <?php foreach($hakim_list as $hakim): ?>
                             <option value="<?php echo $hakim['id']; ?>" <?php if(isset($_GET['hakim2']) && $_GET['hakim2'] == $hakim['id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($hakim['nama']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa-solid fa-magnifying-glass me-1"></i> Bandingkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel hasil perbandingan -->
    <?php if ($hakim1_data && $hakim2_data): ?>
    <div class="card">
        <div class="card-header">
            <i class="fa-solid fa-chart-bar me-2"></i>Hasil Perbandingan
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 20%;">Atribut</th>
                        <th><?php echo htmlspecialchars($hakim1_data['nama']); ?></th>
                        <th><?php echo htmlspecialchars($hakim2_data['nama']); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Daftar field yang dibandingkan
                        $fields = [
                            'NIP / NRP' => 'nip_nrp', 'Golongan / Ruang' => 'gol_rg', 'Tempat, Tgl Lahir' => 'tempat_lahir',
                            'Jenis Kelamin' => 'jenis_kelamin', 'Agama' => 'agama', 'Penempatan' => 'penempatan', 
                            'Asal Organisasi' => 'asal_organisasi', 'Pendidikan' => 'pendidikan', 'Alamat' => 'alamat', 
                            'Kontak' => 'kontak', 'Riwayat Pekerjaan' => 'riwayat_pekerjaan', 'Keterangan' => 'keterangan'
                        ];
                        foreach ($fields as $label => $key) {
                            $value1 = $key === 'tempat_lahir' ? htmlspecialchars($hakim1_data['tempat_lahir'] . ', ' . $hakim1_data['tanggal_lahir']) : nl2br(htmlspecialchars($hakim1_data[$key] ?: '-'));
                            $value2 = $key === 'tempat_lahir' ? htmlspecialchars($hakim2_data['tempat_lahir'] . ', ' . $hakim2_data['tanggal_lahir']) : nl2br(htmlspecialchars($hakim2_data[$key] ?: '-'));
                            echo "<tr><td>$label</td><td>$value1</td><td>$value2</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>