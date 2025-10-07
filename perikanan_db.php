<?php
// --- SETUP KONEKSI DATABASE ---
require_once 'koneksi.php';
if ($conn->connect_error) { die("Koneksi ke database gagal: " . $conn->connect_error); }

// --- FUNGSI UNTUK MENGHITUNG IDEAL ---
function calculate_ideal($rata_rata) {
    if ($rata_rata < 31) return 3;
    if ($rata_rata < 61) return 4;
    if ($rata_rata < 81) return 6;
    if ($rata_rata < 101) return 10;
    if ($rata_rata < 151) return 13;
    if ($rata_rata < 201) return 16;
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
        // --- MODIFIKASI: LOGIKA UPLOAD FOTO ---
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
    if ($total_res) $total_data = $total_res->fetch_assoc();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Hakim Perikanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-100">
<div class="container mx-auto p-4 sm:p-6 lg:p-8">
    <div class="bg-white p-6 md:p-10 rounded-xl shadow-lg">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Data Hakim Ad Hoc Perikanan</h1>
                <p class="text-gray-500 mt-1">Database: <?php echo htmlspecialchars($db_name); ?></p>
            </div>
            <div class="flex items-center space-x-2 mt-4 sm:mt-0">
                 <a href="daftar_usulan.php" class="bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-purple-700 transition text-center">
                     Lihat Daftar Usulan
                 </a>
                 <a href="index.php" class="bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-700 transition text-center">
                     Kembali ke Dashboard
                 </a>
            </div>
        </div>
        <?php if (!empty($action_message)): ?>
            <div class="mb-6 p-4 rounded-md text-sm <?php echo $action_status == 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                <?php echo htmlspecialchars($action_message); ?>
            </div>
        <?php endif; ?>
        <details class="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200 transition">
            <summary class="text-xl font-bold text-gray-800 cursor-pointer hover:text-blue-600">Manajemen Data</summary>
            <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-x-12 gap-y-8">
                <div class="space-y-4">
                    <h3 class="font-semibold text-lg text-gray-700 border-b pb-2">Tambah Pengadilan Baru</h3>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="space-y-4">
                        <input type="hidden" name="action" value="add_pengadilan">
                        <div><label class="block text-sm font-medium">Nama Pengadilan</label><input type="text" name="nama_pengadilan" required class="mt-1 block w-full px-3 py-2 border rounded-md"></div>
                        <div><label class="block text-sm font-medium">HK Ad Hoc</label><input type="number" name="hk_ad_hoc" required class="mt-1 block w-full px-3 py-2 border rounded-md" value="0"></div>
                        <div class="grid grid-cols-3 gap-4 border p-4 rounded-md bg-white">
                            <div><label class="block text-sm font-medium">Perkara 2022</label><input type="number" id="th_2022" name="th_2022" required class="mt-1 w-full p-2 border rounded" value="0"></div>
                            <div><label class="block text-sm font-medium">Perkara 2023</label><input type="number" id="th_2023" name="th_2023" required class="mt-1 w-full p-2 border rounded" value="0"></div>
                            <div><label class="block text-sm font-medium">Perkara 2024</label><input type="number" id="th_2024" name="th_2024" required class="mt-1 w-full p-2 border rounded" value="0"></div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-sm font-medium">Rata-rata</label><input type="number" id="rata_rata" name="rata_rata" readonly class="mt-1 w-full p-2 border rounded bg-gray-200"></div>
                            <div><label class="block text-sm font-medium">Ideal</label><input type="number" id="ideal" name="ideal" readonly class="mt-1 w-full p-2 border rounded bg-gray-200"></div>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md font-semibold">Simpan Pengadilan</button>
                    </form>
                </div>
                <div class="space-y-4">
                     <h3 class="font-semibold text-lg text-gray-700 border-b pb-2">Tambah Hakim Baru</h3>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
                        <input type="hidden" name="action" value="add_hakim">
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-sm font-medium">Nama Hakim</label><input type="text" name="nama_hakim" required class="mt-1 w-full p-2 border rounded"></div>
                            <div><label class="block text-sm font-medium">NIK</label><input type="text" name="nik" class="mt-1 w-full p-2 border rounded"></div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium">Upload Foto</label>
                            <input type="file" name="foto_hakim" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>

                        <div><label class="block text-sm font-medium">Penugasan</label><select name="id_pengadilan" required class="mt-1 w-full p-2 border bg-white rounded"><option value="">-- Pilih Pengadilan --</option><?php mysqli_data_seek($pengadilan_list, 0); while($p = $pengadilan_list->fetch_assoc()): echo "<option value='{$p['id']}'>".htmlspecialchars($p['nama_pengadilan'])."</option>"; endwhile; ?></select></div>
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-sm font-medium">Asal Organisasi</label><input type="text" name="asal_org" class="mt-1 w-full p-2 border rounded"></div>
                            <div><label class="block text-sm font-medium">Jabatan</label><input type="text" name="jabatan" class="mt-1 w-full p-2 border rounded" value="AD HOC PERIKANAN"></div>
                        </div>
                         <div class="border p-4 rounded-md bg-white space-y-4">
                             <div class="grid grid-cols-2 gap-4">
                                 <div><label class="block text-sm font-medium">No. Kepres</label><input type="text" name="kepres" class="mt-1 w-full p-2 border rounded"></div>
                                 <div><label class="block text-sm font-medium">Tgl. Kepres</label><input type="date" name="tgl_kepres" class="mt-1 w-full p-2 border rounded"></div>
                             </div>
                             <div class="grid grid-cols-2 gap-4">
                                 <div><label class="block text-sm font-medium">No. SK Dirjen</label><input type="text" name="sk_dirjen" class="mt-1 w-full p-2 border rounded"></div>
                                 <div><label class="block text-sm font-medium">Tgl. SK Dirjen</label><input type="date" name="tgl_sk_dirjen" class="mt-1 w-full p-2 border rounded"></div>
                             </div>
                              <div class="grid grid-cols-2 gap-4">
                                 <div><label class="block text-sm font-medium">No. SK Pengangkatan Ke-2</label><input type="text" name="sk_pengangkatan_2" class="mt-1 w-full p-2 border rounded"></div>
                                 <div><label class="block text-sm font-medium">Tgl. SK Ke-2</label><input type="date" name="tgl_sk_pengangkatan_2" class="mt-1 w-full p-2 border rounded"></div>
                             </div>
                         </div>
                        <div class="border p-4 rounded-md bg-white space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                 <div><label class="block text-sm font-medium">Masa Jabatan</label><input type="text" name="masa_jabatan" class="mt-1 w-full p-2 border rounded" placeholder="Contoh: 1X"></div>
                                 <div><label class="block text-sm font-medium">Tgl. Habis Jabatan</label><input type="date" name="tanggal_habis" class="mt-1 w-full p-2 border rounded"></div>
                             </div>
                            <div><label class="block text-sm font-medium">Status Perpanjangan</label><input type="text" name="status_perpanjangan" class="mt-1 w-full p-2 border rounded" placeholder="Keterangan status..."></div>
                             <div class="grid grid-cols-2 gap-4">
                                 <div><label class="block text-sm font-medium">TMT PN</label><input type="date" name="tmt_pn" class="mt-1 w-full p-2 border rounded"></div>
                                 <div><label class="block text-sm font-medium">TMT HK</label><input type="date" name="tmt_hk" class="mt-1 w-full p-2 border rounded"></div>
                             </div>
                         </div>
                        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-md font-semibold">Simpan Hakim</button>
                    </form>
                </div>
            </div>
        </details>
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 my-8">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div><label class="block text-sm font-medium">Cari Hakim / PN / NIK</label><input type="text" name="search" class="mt-1 w-full p-2 border rounded" value="<?php echo htmlspecialchars($search_term); ?>"></div>
                <div><label class="block text-sm font-medium">Urutkan</label><select name="sort" class="mt-1 w-full p-2 border bg-white rounded"><option value="default" <?php if($sort_order == 'default') echo 'selected'; ?>>Pengadilan (A-Z)</option><option value="expiration" <?php if($sort_order == 'expiration') echo 'selected'; ?>>Masa Habis Tercepat</option></select></div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md font-semibold">Terapkan</button>
            </form>
        </div>
        <div class="overflow-x-auto rounded-lg border border-gray-200">
             <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                <thead class="bg-gray-50 text-center">
                    <tr>
                        <th class="px-4 py-3 font-bold">NO.</th>
                        <th class="px-4 py-3 font-bold text-left">PENGADILAN & DETAIL HAKIM</th>
                        <th class="px-4 py-3 font-bold">HK AD HOC</th>
                        <th class="px-4 py-3 font-bold">PERKARA 2023</th>
                        <th class="px-4 py-3 font-bold">PERKARA 2024</th>
                        <th class="px-4 py-3 font-bold">RATA-RATA</th>
                        <th class="px-4 py-3 font-bold">IDEAL</th>
                        <th class="px-4 py-3 font-bold">AKSI PN</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                     <?php if (empty($grouped_data)): ?>
                        <tr><td colspan="8" class="text-center py-10">Tidak ada data.</td></tr>
                    <?php else: $i = 1; ?>
                        <?php foreach ($grouped_data as $data): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium align-top text-center"><?php echo $i++; ?></td>
                                <td class="px-4 py-3 text-left align-top">
                                    <div class="font-bold text-gray-900 mb-4"><?php echo htmlspecialchars($data['keterangan']); ?></div>
                                    <?php if (!empty($data['list_hakim'])): ?>
                                        <div class="space-y-4">
                                            <?php foreach ($data['list_hakim'] as $hakim): ?>
                                                <div class="p-3 border-l-4 border-blue-300 bg-gray-50/80 rounded-r-lg">
                                                    <div class="flex justify-between items-start">
                                                        <div class="flex items-center space-x-4">
                                                            <img src="<?php echo !empty($hakim['foto']) ? 'uploads/' . htmlspecialchars($hakim['foto']) : 'https://via.placeholder.com/64x64.png?text=FOTO'; ?>" 
                                                                 alt="Foto Hakim" 
                                                                 class="w-16 h-16 rounded-full object-cover border-2 border-gray-200 flex-shrink-0">
                                                            <div>
                                                                <p class="font-bold text-gray-800"><?php echo htmlspecialchars($hakim['nama_hakim']); ?></p>
                                                                <p class="text-xs text-gray-500">NIK: <?php echo htmlspecialchars($hakim['nik']); ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="flex items-center space-x-3 flex-shrink-0 ml-4">
                                                            <a href="mutasi.php?id=<?php echo $hakim['id_hakim']; ?>" class="text-blue-600 text-xs font-bold hover:underline">MUTASI</a>
                                                            <a href="usul.php?id=<?php echo $hakim['id_hakim']; ?>" class="text-green-600 text-xs font-bold hover:underline">USUL</a>
                                                            <a href="?action=delete_hakim&id=<?php echo $hakim['id_hakim']; ?>" class="text-red-500 text-xs font-medium" onclick="return confirm('Yakin hapus hakim ini?');">HAPUS</a>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 text-xs border-t pt-2 grid grid-cols-2 gap-x-4 gap-y-1">
                                                        <p><b>Asal:</b> <?php echo htmlspecialchars($hakim['asal_org']); ?></p>
                                                        <p><b>Jabatan:</b> <?php echo htmlspecialchars($hakim['jabatan']); ?></p>
                                                        <p><b>Kepres:</b> <?php echo htmlspecialchars($hakim['kepres']); ?> (<?php echo $hakim['tgl_kepres_formatted']; ?>)</p>
                                                        <p><b>SK Dirjen:</b> <?php echo htmlspecialchars($hakim['sk_dirjen']); ?> (<?php echo $hakim['tgl_sk_dirjen_formatted']; ?>)</p>
                                                        <p><b>SK Ke-2:</b> <?php echo htmlspecialchars($hakim['sk_pengangkatan_2']); ?> (<?php echo $hakim['tgl_sk_pengangkatan_2_formatted']; ?>)</p>
                                                        <p><b>Masa Jabatan:</b> 2X</p>
                                                        <p><b>TMT PN:</b> <?php echo $hakim['tmt_pn_formatted']; ?></p>
                                                        <p><b>TMT HK:</b> <?php echo $hakim['tmt_hk_formatted']; ?> <span class="text-blue-600 font-semibold">(<?php echo $hakim['sisa_jabatan_string']; ?>)</span></p>
                                                        <p class="col-span-2 mt-1 pt-1 border-t font-semibold text-blue-700"><b>Status:</b> <?php echo htmlspecialchars($hakim['status_baru']); ?></p>
                                                        <p class="col-span-2 font-bold text-red-600"><b>Habis Jabatan:</b> <?php echo $hakim['tanggal_habis_baru_formatted']; ?></p>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 font-semibold align-top text-center"><?php echo htmlspecialchars($data['hk_ad_hoc'] ?? '0'); ?></td>
                                <td class="px-4 py-3 align-top text-center"><?php echo htmlspecialchars($data['perkara_2023'] ?? '0'); ?></td>
                                <td class="px-4 py-3 align-top text-center"><?php echo htmlspecialchars($data['perkara_2024'] ?? '0'); ?></td>
                                <td class="px-4 py-3 align-top text-center"><?php echo htmlspecialchars($data['rata_rata'] ?? '0'); ?></td>
                                <td class="px-4 py-3 font-bold align-top text-center"><?php echo htmlspecialchars($data['ideal'] ?? '0'); ?></td>
                                <td class="px-4 py-3 align-top text-center">
                                    <a href="?action=delete_pengadilan&id=<?php echo $data['id_pengadilan']; ?>" class="text-red-600 text-sm font-medium" onclick="return confirm('PERINGATAN: Yakin hapus pengadilan ini? Semua hakim di dalamnya akan ikut terhapus.');">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                 <?php if (!empty($grouped_data) && empty($search_term)): ?>
                <tfoot class="bg-gray-100 font-bold">
                    <tr class="text-center">
                        <td class="px-4 py-3" colspan="2">JUMLAH</td>
                        <td class="px-4 py-3"><?php echo $total_data['total_hk']; ?></td>
                        <td class="px-4 py-3"><?php echo $total_data['total_2023']; ?></td>
                        <td class="px-4 py-3"><?php echo $total_data['total_2024']; ?></td>
                        <td class="px-4 py-3"><?php echo $total_data['total_rr']; ?></td>
                        <td class="px-4 py-3"><?php echo $total_data['total_id']; ?></td>
                        <td></td>
                    </tr>
                </tfoot>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>
<script>
    function hitungOtomatis() {
        const val2022 = parseInt(document.getElementById('th_2022').value) || 0;
        const val2023 = parseInt(document.getElementById('th_2023').value) || 0;
        const val2024 = parseInt(document.getElementById('th_2024').value) || 0;
        const rataRata = Math.round((val2022 + val2023 + val2024) / 3);
        let ideal;
        if (rataRata < 31) ideal = 3; else if (rataRata < 61) ideal = 4;
        else if (rataRata < 81) ideal = 6; else if (rataRata < 101) ideal = 10;
        else if (rataRata < 151) ideal = 13; else if (rataRata < 201) ideal = 16;
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