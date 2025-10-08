<?php
// --- SETUP KONEKSI DATABASE ---
require_once '../koneksi.php';
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// --- FUNGSI UNTUK MENGHITUNG IDEAL ---
function calculate_ideal($rata_rata)
{
    if ($rata_rata < 31)
        return 3;
    if ($rata_rata < 61)
        return 4;
    if ($rata_rata < 81)
        return 6;
    if ($rata_rata < 101)
        return 10;
    if ($rata_rata < 151)
        return 13;
    if ($rata_rata < 201)
        return 16;
    return 17;
}

// --- LOGIKA UNTUK MENANGANI AKSI (POST & GET) ---
$action_message = '';
$action_status = ''; // 'success' or 'error'

if (isset($_GET['status']) && $_GET['status'] == 'mutasi_sukses') {
    $action_message = "Hakim berhasil dimutasi.";
    $action_status = 'success';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'add_hakim') {
        // --- LOGIKA UPLOAD FOTO ---
        $foto_filename = null;
        if (isset($_FILES['foto_hakim']) && $_FILES['foto_hakim']['error'] == UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true); // Buat folder jika belum ada
            }
            $file_ext = pathinfo($_FILES['foto_hakim']['name'], PATHINFO_EXTENSION);
            $foto_filename = 'hakim_' . time() . '_' . uniqid() . '.' . $file_ext;
            $target_file = $upload_dir . $foto_filename;

            if (!move_uploaded_file($_FILES['foto_hakim']['tmp_name'], $target_file)) {
                $action_message = "Error: Gagal memindahkan file foto yang diupload.";
                $action_status = 'error';
                $foto_filename = null; // Batalkan jika gagal
            }
        }
        // --- AKHIR MODIFIKASI UPLOAD ---

        $nama_hakim = $_POST['nama_hakim'] ?? '';
        $nik = $_POST['nik'] ?? null;
        $id_pengadilan = $_POST['id_pengadilan'] ?? 0;
        $asal_org = $_POST['asal_org'] ?? '';
        $jabatan = $_POST['jabatan'] ?? '';
        $kepres = $_POST['kepres'] ?? '';
        $tgl_kepres = !empty($_POST['tgl_kepres']) ? $_POST['tgl_kepres'] : null;
        $sk_dirjen = $_POST['sk_dirjen'] ?? '';
        $tgl_sk_dirjen = !empty($_POST['tgl_sk_dirjen']) ? $_POST['tgl_sk_dirjen'] : null;
        $masa_jabatan = $_POST['masa_jabatan'] ?? '';
        $status_perpanjangan = $_POST['status_perpanjangan'] ?? '';
        $tanggal_habis = !empty($_POST['tanggal_habis']) ? $_POST['tanggal_habis'] : null;
        $tmt_pn = !empty($_POST['tmt_pn']) ? $_POST['tmt_pn'] : null;
        $tmt_hk = !empty($_POST['tmt_hk']) ? $_POST['tmt_hk'] : null;
        $sk_pengangkatan_2 = $_POST['sk_pengangkatan_2'] ?? '';
        $tgl_sk_pengangkatan_2 = !empty($_POST['tgl_sk_pengangkatan_2']) ? $_POST['tgl_sk_pengangkatan_2'] : null;

        if (!empty($nama_hakim) && !empty($id_pengadilan)) {
            // MODIFIKASI: Menambahkan kolom 'foto' ke query INSERT
            $sql_insert = "INSERT INTO hakim_perikanan (nama_hakim, nik, foto, id_pengadilan, asal_org, jabatan, kepres, tgl_kepres, sk_dirjen, tgl_sk_dirjen, masa_jabatan, status_perpanjangan, tanggal_habis, tmt_pn, tmt_hk, sk_pengangkatan_2, tgl_sk_pengangkatan_2) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql_insert);
            // MODIFIKASI: Menambahkan tipe 's' untuk foto dan variabel $foto_filename
            $stmt->bind_param("sssisssssssssssss", $nama_hakim, $nik, $foto_filename, $id_pengadilan, $asal_org, $jabatan, $kepres, $tgl_kepres, $sk_dirjen, $tgl_sk_dirjen, $masa_jabatan, $status_perpanjangan, $tanggal_habis, $tmt_pn, $tmt_hk, $sk_pengangkatan_2, $tgl_sk_pengangkatan_2);

            if ($stmt->execute()) {
                $action_message = "Hakim '{$nama_hakim}' berhasil ditambahkan.";
                $action_status = 'success';
            } else {
                $action_message = "Error: Gagal menambahkan hakim. " . $stmt->error;
                $action_status = 'error';
            }
            $stmt->close();
        } else {
            $action_message = "Error: Nama Hakim dan Pengadilan harus diisi.";
            $action_status = 'error';
        }
    }
    if ($_POST['action'] == 'add_pengadilan') {
        $nama_pengadilan = $_POST['nama_pengadilan'] ?? '';
        $hk_ad_hoc = $_POST['hk_ad_hoc'] ?? 0;
        $perkara_2022 = $_POST['th_2022'] ?? 0;
        $perkara_2023 = $_POST['th_2023'] ?? 0;
        $perkara_2024 = $_POST['th_2024'] ?? 0;
        $rata_rata = round(($perkara_2022 + $perkara_2023 + $perkara_2024) / 3);
        $ideal = calculate_ideal($rata_rata);

        if (!empty($nama_pengadilan)) {
            $conn->begin_transaction();
            try {
                $stmt1 = $conn->prepare("INSERT INTO pengadilan (nama_pengadilan) VALUES (?)");
                $stmt1->bind_param("s", $nama_pengadilan);
                $stmt1->execute();
                $new_pengadilan_id = $conn->insert_id;
                $stmt1->close();
                $stmt2 = $conn->prepare("INSERT INTO kebutuhan_perikanan (id_pengadilan, hk_ad_hoc, perkara_2022, perkara_2023, perkara_2024, rata_rata, ideal) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt2->bind_param("iiiiiii", $new_pengadilan_id, $hk_ad_hoc, $perkara_2022, $perkara_2023, $perkara_2024, $rata_rata, $ideal);
                $stmt2->execute();
                $stmt2->close();
                $conn->commit();
                $action_message = "Pengadilan '{$nama_pengadilan}' berhasil ditambahkan.";
                $action_status = 'success';
            } catch (mysqli_sql_exception $e) {
                $conn->rollback();
                $action_message = "Error: Gagal menambahkan pengadilan. Mungkin nama sudah ada.";
                $action_status = 'error';
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
    if ($_GET['action'] == 'delete_hakim' && isset($_GET['id'])) {
        $id_to_delete = intval($_GET['id']);
        $stmt = $conn->prepare("DELETE FROM hakim_perikanan WHERE id = ?");
        $stmt->bind_param("i", $id_to_delete);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    if ($_GET['action'] == 'delete_pengadilan' && isset($_GET['id'])) {
        $id_to_delete = intval($_GET['id']);
        $stmt = $conn->prepare("DELETE FROM pengadilan WHERE id = ?");
        $stmt->bind_param("i", $id_to_delete);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

$pengadilan_list = $conn->query("SELECT id, nama_pengadilan FROM pengadilan ORDER BY nama_pengadilan ASC");

$search_term = $_GET['search'] ?? '';
$sort_order = $_GET['sort'] ?? 'default';

$sql = "SELECT p.id as id_pengadilan, p.nama_pengadilan, kp.hk_ad_hoc, kp.perkara_2023, kp.perkara_2024, kp.rata_rata, kp.ideal, h.*, h.id as id_hakim FROM pengadilan p LEFT JOIN kebutuhan_perikanan kp ON p.id = kp.id_pengadilan LEFT JOIN hakim_perikanan h ON p.id = h.id_pengadilan";
$params = [];
if (!empty($search_term)) {
    $sql .= " WHERE p.nama_pengadilan LIKE ? OR h.nama_hakim LIKE ? OR h.nik LIKE ?";
    $like_term = "%" . $search_term . "%";
    $params = ["sss", $like_term, $like_term, $like_term];
}
if ($sort_order == 'expiration') {
    $sql .= " ORDER BY h.tanggal_habis ASC, p.nama_pengadilan ASC";
} else {
    $sql .= " ORDER BY p.nama_pengadilan ASC, h.nama_hakim ASC";
}
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($params[0], $params[1], $params[2], $params[3]);
}
$stmt->execute();
$result = $stmt->get_result();

$grouped_data = [];
$date_cols_original = ['tgl_kepres', 'tgl_sk_dirjen', 'tmt_pn', 'tmt_hk', 'tgl_sk_pengangkatan_2'];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        foreach ($date_cols_original as $col) {
            $row[$col . '_formatted'] = !empty($row[$col]) ? date('d M Y', strtotime($row[$col])) : 'N/A';
        }
        $base_date_str = null;
        if (!empty($row['tmt_hk'])) {
            $base_date_str = $row['tmt_hk'];
        } elseif (!empty($row['tgl_sk_dirjen'])) {
            $base_date_str = $row['tgl_sk_dirjen'];
        }
        $row['tanggal_habis_baru_formatted'] = 'N/A';
        $row['sisa_jabatan_string'] = 'Tanggal dasar tidak ada';
        $row['status_baru'] = 'Perpanjangan 2x habis N/A';
        if ($base_date_str !== null) {
            $base_date = new DateTime($base_date_str);
            $habis_jabatan_date = (clone $base_date)->modify('+10 years');
            $row['tanggal_habis_baru_formatted'] = $habis_jabatan_date->format('d M Y');
            $today = new DateTime();
            if ($habis_jabatan_date < $today) {
                $row['sisa_jabatan_string'] = 'Telah Berakhir';
            } else {
                $interval = $habis_jabatan_date->diff($today);
                $row['sisa_jabatan_string'] = 'Sisa ' . $interval->y . ' tahun, ' . $interval->m . ' bulan, ' . $interval->d . ' hari';
            }
            $row['status_baru'] = 'Perpanjangan 2x habis ' . $row['tanggal_habis_baru_formatted'];
        }
        $pn = $row['nama_pengadilan'];
        if (!isset($grouped_data[$pn])) {
            $grouped_data[$pn] = [
                'id_pengadilan' => $row['id_pengadilan'],
                'keterangan' => $pn,
                'hk_ad_hoc' => $row['hk_ad_hoc'],
                'perkara_2023' => $row['perkara_2023'],
                'perkara_2024' => $row['perkara_2024'],
                'rata_rata' => $row['rata_rata'],
                'ideal' => $row['ideal'],
                'list_hakim' => []
            ];
        }
        if ($row['id_hakim']) {
            $grouped_data[$pn]['list_hakim'][] = $row;
        }
    }
}
$stmt->close();

$total_data = ['total_hk' => 0, 'total_2023' => 0, 'total_2024' => 0, 'total_rr' => 0, 'total_id' => 0];
if (empty($search_term)) {
    $total_res = $conn->query("SELECT SUM(hk_ad_hoc) as total_hk, SUM(perkara_2023) as total_2023, SUM(perkara_2024) as total_2024, SUM(rata_rata) as total_rr, SUM(ideal) as total_id FROM kebutuhan_perikanan");
    if ($total_res)
        $total_data = $total_res->fetch_assoc();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Hakim Perikanan</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tambahkan Font Awesome CDN di <head> jika belum ada -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&display=swap');

        body {
            font-family: "Karla", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
        }

        .hakim-photo {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #dee2e6;
        }

        .hakim-card {
            background: #f8f9fa;
            border-left: 4px solid #0d6efd;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            padding: 1rem;
        }

        .table-responsive {
            margin-top: 2rem;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-4">
        <div class="card shadow mb-4">
            <div class="card-body">
                <!-- Header -->
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 border-bottom pb-3">
                    <div>
                        <h1 class="h3 fw-bold text-dark mb-0">Data Hakim Ad Hoc Perikanan</h1>
                        <small class="text-muted">Database: <?php echo htmlspecialchars($db_name ?? ''); ?></small>
                    </div>
                    <div class="mt-3 mt-md-0 d-flex gap-2">
                        <!-- Data Usulan: Font Awesome report -->
                        <a href="daftar_usulan.php" class="btn btn-primary">
                            <i class="fa-solid fa-file-lines me-1"></i> Data Usulan
                        </a>
                        <!-- Lihat DRP: Font Awesome eye -->
                        <a href="drp_perikanan.php" class="btn btn-success">
                            <i class="fa-solid fa-eye me-1"></i> Lihat DRP Hakim Ad Hoc Perikanan
                        </a>
                        <!-- Dashboard: Font Awesome dashboard -->
                        <a href="../" class="btn btn-secondary">
                            <i class="fa-solid fa-gauge-high me-1"></i> Dashboard
                        </a>
                    </div>
                </div>
                <?php if (!empty($action_message)): ?>
                    <div class="alert <?php echo $action_status == 'success' ? 'alert-success' : 'alert-danger'; ?> mb-4">
                        <?php echo htmlspecialchars($action_message); ?>
                    </div>
                <?php endif; ?>

                <!-- Manajemen Data -->
                <div class="accordion mb-4" id="manajemenData">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingData">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseData" aria-expanded="false" aria-controls="collapseData">
                                Manajemen Data
                            </button>
                        </h2>
                        <div id="collapseData" class="accordion-collapse collapse" aria-labelledby="headingData"
                            data-bs-parent="#manajemenData">
                            <div class="accordion-body">
                                <div class="row g-4">
                                    <!-- Form Pengadilan -->
                                    <div class="col-lg-6">
                                        <h5 class="fw-semibold mb-3">Tambah Pengadilan Baru</h5>
                                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                            method="POST">
                                            <input type="hidden" name="action" value="add_pengadilan">
                                            <div class="mb-2">
                                                <label class="form-label">Nama Pengadilan</label>
                                                <input type="text" name="nama_pengadilan" required class="form-control">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label">HK Ad Hoc</label>
                                                <input type="number" name="hk_ad_hoc" required class="form-control"
                                                    value="0">
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <label class="form-label">Perkara 2022</label>
                                                    <input type="number" id="th_2022" name="th_2022" required
                                                        class="form-control" value="0">
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">Perkara 2023</label>
                                                    <input type="number" id="th_2023" name="th_2023" required
                                                        class="form-control" value="0">
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">Perkara 2024</label>
                                                    <input type="number" id="th_2024" name="th_2024" required
                                                        class="form-control" value="0">
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <label class="form-label">Rata-rata</label>
                                                    <input type="number" id="rata_rata" name="rata_rata" readonly
                                                        class="form-control bg-light">
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">Ideal</label>
                                                    <input type="number" id="ideal" name="ideal" readonly
                                                        class="form-control bg-light">
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100 mt-2">Simpan
                                                Pengadilan</button>
                                        </form>
                                    </div>
                                    <!-- Form Hakim -->
                                    <div class="col-lg-6">
                                        <h5 class="fw-semibold mb-3">Tambah Hakim Baru</h5>
                                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                            method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="action" value="add_hakim">
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <label class="form-label">Nama Hakim</label>
                                                    <input type="text" name="nama_hakim" required class="form-control">
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">NIK</label>
                                                    <input type="text" name="nik" class="form-control">
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label">Upload Foto</label>
                                                <input type="file" name="foto_hakim" accept="image/*"
                                                    class="form-control">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label">Penugasan</label>
                                                <select name="id_pengadilan" required class="form-select">
                                                    <option value="">-- Pilih Pengadilan --</option>
                                                    <?php mysqli_data_seek($pengadilan_list, 0);
                                                    while ($p = $pengadilan_list->fetch_assoc()): ?>
                                                        <option value="<?= $p['id'] ?>">
                                                            <?= htmlspecialchars($p['nama_pengadilan']) ?>
                                                        </option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <label class="form-label">Asal Organisasi</label>
                                                    <input type="text" name="asal_org" class="form-control">
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">Jabatan</label>
                                                    <input type="text" name="jabatan" class="form-control"
                                                        value="AD HOC PERIKANAN">
                                                </div>
                                            </div>
                                            <div class="mb-2 border rounded p-2 bg-white">
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <label class="form-label">No. Kepres</label>
                                                        <input type="text" name="kepres" class="form-control">
                                                    </div>
                                                    <div class="col">
                                                        <label class="form-label">Tgl. Kepres</label>
                                                        <input type="date" name="tgl_kepres" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <label class="form-label">No. SK Dirjen</label>
                                                        <input type="text" name="sk_dirjen" class="form-control">
                                                    </div>
                                                    <div class="col">
                                                        <label class="form-label">Tgl. SK Dirjen</label>
                                                        <input type="date" name="tgl_sk_dirjen" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <label class="form-label">No. SK Pengangkatan Ke-2</label>
                                                        <input type="text" name="sk_pengangkatan_2"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col">
                                                        <label class="form-label">Tgl. SK Ke-2</label>
                                                        <input type="date" name="tgl_sk_pengangkatan_2"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-2 border rounded p-2 bg-white">
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <label class="form-label">Masa Jabatan</label>
                                                        <input type="text" name="masa_jabatan" class="form-control"
                                                            placeholder="Contoh: 1X">
                                                    </div>
                                                    <div class="col">
                                                        <label class="form-label">Tgl. Habis Jabatan</label>
                                                        <input type="date" name="tanggal_habis" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Status Perpanjangan</label>
                                                    <input type="text" name="status_perpanjangan" class="form-control"
                                                        placeholder="Keterangan status...">
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <label class="form-label">TMT PN</label>
                                                        <input type="date" name="tmt_pn" class="form-control">
                                                    </div>
                                                    <div class="col">
                                                        <label class="form-label">TMT HK</label>
                                                        <input type="date" name="tmt_hk" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-success w-100 mt-2">Simpan
                                                Hakim</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter & Search -->
                <div class="bg-light p-3 rounded mb-4 border">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET"
                        class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label">Cari Hakim / PN / NIK</label>
                            <input type="text" name="search" class="form-control"
                                value="<?php echo htmlspecialchars($search_term); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Urutkan</label>
                            <select name="sort" class="form-select">
                                <option value="default" <?php if ($sort_order == 'default')
                                    echo 'selected'; ?>>Pengadilan
                                    (A-Z)</option>
                                <option value="expiration" <?php if ($sort_order == 'expiration')
                                    echo 'selected'; ?>>Masa
                                    Habis Tercepat</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">Terapkan</button>
                        </div>
                    </form>
                </div>

                <!-- Tabel Data -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>NO.</th>
                                <th class="text-start">PENGADILAN & DETAIL HAKIM</th>
                                <th>HK AD HOC</th>
                                <th>PERKARA 2023</th>
                                <th>PERKARA 2024</th>
                                <th>RATA-RATA</th>
                                <th>IDEAL</th>
                                <th>AKSI PN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($grouped_data)): ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5">Tidak ada data.</td>
                                </tr>
                            <?php else:
                                $i = 1; ?>
                                <?php foreach ($grouped_data as $data): ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td class="text-start">
                                            <div class="fw-bold mb-2"><?= htmlspecialchars($data['keterangan']); ?></div>
                                            <?php if (!empty($data['list_hakim'])): ?>
                                                <?php foreach ($data['list_hakim'] as $hakim): ?>
                                                    <div class="hakim-card">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <img src="<?= !empty($hakim['foto']) ? 'https://sikep.mahkamahagung.go.id/uploads/foto_pegawai/' . $hakim['foto'] : 'https://static.vecteezy.com/system/resources/thumbnails/003/337/584/small_2x/default-avatar-photo-placeholder-profile-icon-vector.jpg'; ?>"
                                                                alt="Foto Hakim" class="hakim-photo me-3">
                                                            <div>
                                                                <div class="fw-bold"><?= htmlspecialchars($hakim['nama_hakim']); ?>
                                                                </div>
                                                                <div class="text-muted small">NIK:
                                                                    <?= htmlspecialchars($hakim['nik']); ?>
                                                                </div>
                                                            </div>
                                                            <div class="ms-auto d-flex gap-2">
                                                                <a href="../mutasi.php?id=<?= $hakim['id_hakim']; ?>"
                                                                    class="btn btn-sm btn-outline-primary">Mutasi</a>
                                                                <a href="../usul.php?id=<?= $hakim['id_hakim']; ?>"
                                                                    class="btn btn-sm btn-outline-success">Usul</a>
                                                                <a href="?action=delete_hakim&id=<?= $hakim['id_hakim']; ?>"
                                                                    class="btn btn-sm btn-outline-danger"
                                                                    onclick="return confirm('Yakin hapus hakim ini?');">Hapus</a>
                                                            </div>
                                                        </div>
                                                        <div class="row small">
                                                            <div class="col-6"><b>Asal:</b> <?= htmlspecialchars($hakim['asal_org']); ?>
                                                            </div>
                                                            <div class="col-6"><b>Jabatan:</b>
                                                                <?= htmlspecialchars($hakim['jabatan']); ?></div>
                                                            <div class="col-6"><b>Kepres:</b> <?= htmlspecialchars($hakim['kepres']); ?>
                                                                (<?= $hakim['tgl_kepres_formatted']; ?>)</div>
                                                            <div class="col-6"><b>SK Dirjen:</b>
                                                                <?= htmlspecialchars($hakim['sk_dirjen']); ?>
                                                                (<?= $hakim['tgl_sk_dirjen_formatted']; ?>)</div>
                                                            <div class="col-6"><b>SK Ke-2:</b>
                                                                <?= htmlspecialchars($hakim['sk_pengangkatan_2']); ?>
                                                                (<?= $hakim['tgl_sk_pengangkatan_2_formatted']; ?>)</div>
                                                            <div class="col-6"><b>Masa Jabatan:</b> 2X</div>
                                                            <div class="col-6"><b>TMT PN:</b> <?= $hakim['tmt_pn_formatted']; ?></div>
                                                            <div class="col-6"><b>TMT HK:</b> <?= $hakim['tmt_hk_formatted']; ?> <span
                                                                    class="text-primary fw-semibold">(<?= $hakim['sisa_jabatan_string']; ?>)</span>
                                                            </div>
                                                            <div class="col-12 mt-2"><b>Status:</b> <span
                                                                    class="text-primary"><?= htmlspecialchars($hakim['status_baru']); ?></span>
                                                            </div>
                                                            <div class="col-12"><b class="text-danger">Habis Jabatan:</b>
                                                                <?= $hakim['tanggal_habis_baru_formatted']; ?></div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($data['hk_ad_hoc'] ?? '0'); ?></td>
                                        <td><?= htmlspecialchars($data['perkara_2023'] ?? '0'); ?></td>
                                        <td><?= htmlspecialchars($data['perkara_2024'] ?? '0'); ?></td>
                                        <td><?= htmlspecialchars($data['rata_rata'] ?? '0'); ?></td>
                                        <td class="fw-bold"><?= htmlspecialchars($data['ideal'] ?? '0'); ?></td>
                                        <td>
                                            <a href="?action=delete_pengadilan&id=<?= $data['id_pengadilan']; ?>"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('PERINGATAN: Yakin hapus pengadilan ini? Semua hakim di dalamnya akan ikut terhapus.');">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <?php if (!empty($grouped_data) && empty($search_term)): ?>
                            <tfoot class="table-light fw-bold">
                                <tr>
                                    <td colspan="2">JUMLAH</td>
                                    <td><?= $total_data['total_hk']; ?></td>
                                    <td><?= $total_data['total_2023']; ?></td>
                                    <td><?= $total_data['total_2024']; ?></td>
                                    <td><?= $total_data['total_rr']; ?></td>
                                    <td><?= $total_data['total_id']; ?></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hitung otomatis rata-rata dan ideal
        function hitungOtomatis() {
            const val2022 = parseInt(document.getElementById('th_2022').value) || 0;
            const val2023 = parseInt(document.getElementById('th_2023').value) || 0;
            const val2024 = parseInt(document.getElementById('th_2024').value) || 0;
            const rataRata = Math.round((val2022 + val2023 + val2024) / 3);
            let ideal;
            if (rataRata < 31) ideal = 3;
            else if (rataRata < 61) ideal = 4;
            else if (rataRata < 81) ideal = 6;
            else if (rataRata < 101) ideal = 10;
            else if (rataRata < 151) ideal = 13;
            else if (rataRata < 201) ideal = 16;
            else ideal = 17;
            document.getElementById('rata_rata').value = rataRata;
            document.getElementById('ideal').value = ideal;
        }
        document.getElementById('th_2022').addEventListener('input', hitungOtomatis);
        document.getElementById('th_2023').addEventListener('input', hitungOtomatis);
        document.getElementById('th_2024').addEventListener('input', hitungOtomatis);
        document.addEventListener('DOMContentLoaded', hitungOtomatis);
    </script>
</body>

</html>