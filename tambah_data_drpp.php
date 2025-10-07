<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Hakim Perikanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

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
          <a class="nav-link active" href="tambah_data_drpp.php">Tambah Data</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="compare.php">Bandingkan Data</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Formulir Input Data Hakim Perikanan</h3>
                </div>
                <div class="card-body">
                    <?php
                        // (PHP processing script from previous answer goes here, unchanged)
                        $pesan = '';
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $servername = "localhost"; $username = "root"; $password = ""; $dbname = "sertifikasi_hakim";
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            if ($conn->connect_error) { die("Koneksi Gagal: " . $conn->connect_error); }
                            
                            $nama = $_POST['nama']; $nip_nrp = $_POST['nip_nrp']; $gol_rg = $_POST['gol_rg']; $tempat_lahir = $_POST['tempat_lahir'];
                            $tanggal_lahir = $_POST['tanggal_lahir']; $jenis_kelamin = $_POST['jenis_kelamin']; $agama = $_POST['agama'];
                            $penempatan = $_POST['penempatan']; $asal_organisasi = $_POST['asal_organisasi']; $nama_pasangan = $_POST['nama_pasangan'];
                            $jumlah_anak = $_POST['jumlah_anak']; $pendidikan = $_POST['pendidikan']; $alamat = $_POST['alamat'];
                            $kontak = $_POST['kontak']; $riwayat_pekerjaan = $_POST['riwayat_pekerjaan']; $keterangan = $_POST['keterangan'];
                            
                            $foto_filename = NULL;
                            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                                $target_dir = "foto_hakim/";
                                $foto_filename = uniqid() . '_' . basename($_FILES["foto"]["name"]);
                                $target_file = $target_dir . $foto_filename;
                                if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                                    $foto_filename = NULL; $pesan = '<div class="alert alert-danger">Gagal mengupload foto.</div>';
                                }
                            }

                            $stmt = $conn->prepare("INSERT INTO drp_hakim_perikanan (nama, foto_filename, nip_nrp, gol_rg, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, penempatan, asal_organisasi, nama_pasangan, jumlah_anak, pendidikan, alamat, kontak, riwayat_pekerjaan, keterangan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                            $stmt->bind_param("sssssssssssssssss", $nama, $foto_filename, $nip_nrp, $gol_rg, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $agama, $penempatan, $asal_organisasi, $nama_pasangan, $jumlah_anak, $pendidikan, $alamat, $kontak, $riwayat_pekerjaan, $keterangan);

                            if ($stmt->execute()) { header("Location: drp_perikanan.php?status=sukses"); exit(); } else { $pesan = '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>'; }
                            $stmt->close(); $conn->close();
                        }
                        echo $pesan;
                    ?>
                    <form action="tambah_data_drpp.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Upload Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3"><label for="nip_nrp" class="form-label">NIP / NRP</label><input type="text" class="form-control" id="nip_nrp" name="nip_nrp"></div>
                            <div class="col-md-6 mb-3"><label for="gol_rg" class="form-label">Golongan / Ruang</label><input type="text" class="form-control" id="gol_rg" name="gol_rg"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3"><label for="tempat_lahir" class="form-label">Tempat Lahir</label><input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"></div>
                            <div class="col-md-6 mb-3"><label for="tanggal_lahir" class="form-label">Tanggal Lahir</label><input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3"><label for="jenis_kelamin" class="form-label">Jenis Kelamin</label><select class="form-select" id="jenis_kelamin" name="jenis_kelamin"><option value="PRIA">PRIA</option><option value="WANITA">WANITA</option></select></div>
                            <div class="col-md-6 mb-3"><label for="agama" class="form-label">Agama</label><input type="text" class="form-control" id="agama" name="agama"></div>
                        </div>
                        <div class="mb-3"><label for="penempatan" class="form-label">Penempatan</label><input type="text" class="form-control" id="penempatan" name="penempatan"></div>
                        <div class="mb-3"><label for="asal_organisasi" class="form-label">Asal Organisasi</label><textarea class="form-control" id="asal_organisasi" name="asal_organisasi" rows="2"></textarea></div>
                        <div class="row">
                           <div class="col-md-8 mb-3"><label for="nama_pasangan" class="form-label">Nama Istri/Suami</label><input type="text" class="form-control" id="nama_pasangan" name="nama_pasangan"></div>
                             <div class="col-md-4 mb-3"><label for="jumlah_anak" class="form-label">Jumlah Anak</label><input type="number" class="form-control" id="jumlah_anak" name="jumlah_anak"></div>
                        </div>
                        <div class="mb-3"><label for="pendidikan" class="form-label">Pendidikan</label><textarea class="form-control" id="pendidikan" name="pendidikan" rows="2"></textarea></div>
                        <div class="mb-3"><label for="alamat" class="form-label">Alamat</label><textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea></div>
                        <div class="mb-3"><label for="kontak" class="form-label">Kontak (Email/Telepon)</label><input type="text" class="form-control" id="kontak" name="kontak"></div>
                        <div class="mb-3"><label for="riwayat_pekerjaan" class="form-label">Riwayat Pekerjaan</label><textarea class="form-control" id="riwayat_pekerjaan" name="riwayat_pekerjaan" rows="3"></textarea></div>
                        <div class="mb-3"><label for="keterangan" class="form-label">Keterangan</label><textarea class="form-control" id="keterangan" name="keterangan" rows="2"></textarea></div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <a href="drp_perikanan.php" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>