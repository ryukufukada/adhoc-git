<?php
// --- SETUP KONEKSI DATABASE ---
require_once 'koneksi.php';
if ($conn->connect_error) { die("Koneksi gagal: " . $conn->connect_error); }

$hakim_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($hakim_id === 0) { die("Error: ID Hakim tidak valid."); }

$stmt_hakim = $conn->prepare("SELECT h.nama_hakim, p.nama_pengadilan, p.id as id_pengadilan_asal FROM hakim_perikanan h JOIN pengadilan p ON h.id_pengadilan = p.id WHERE h.id = ?");
$stmt_hakim->bind_param("i", $hakim_id);
$stmt_hakim->execute();
$hakim = $stmt_hakim->get_result()->fetch_assoc();
if (!$hakim) { die("Error: Hakim tidak ditemukan."); }
$stmt_hakim->close();

$usul_message = '';
// --- LOGIKA PENYIMPANAN DATA BARU ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pengadilan_asal = $hakim['id_pengadilan_asal'];
    $tanggal_usul = !empty($_POST['tanggal_usul']) ? $_POST['tanggal_usul'] : date('Y-m-d');
    $no_surat = $_POST['no_surat'] ?? null;
    $tanggal_surat = !empty($_POST['tanggal_surat']) ? $_POST['tanggal_surat'] : null;
    $tujuan_usul_text = $_POST['tujuan_usul_text'] ?? '';
    $alasan = $_POST['alasan_pindah'] ?? '';
    $nama_berkas_final = null;

    if (isset($_FILES['berkas_usulan']) && $_FILES['berkas_usulan']['error'] == 0) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) { mkdir($upload_dir, 0755, true); }
        $berkas = $_FILES['berkas_usulan'];
        $nama_berkas_final = uniqid() . '-' . basename($berkas['name']);
        $target_file = $upload_dir . $nama_berkas_final;
        if (!move_uploaded_file($berkas['tmp_name'], $target_file)) {
            $nama_berkas_final = null; $usul_message = "Error: Gagal mengupload berkas.";
        }
    }
    
    if (empty($usul_message)) {
        $stmt_insert = $conn->prepare("INSERT INTO usulan_pindah (id_hakim, id_pengadilan_asal, tanggal_usul, no_surat, tanggal_surat, tujuan_usul_text, alasan, nama_berkas) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt_insert === false) { die("SQL Error: " . $conn->error); }
        
        $stmt_insert->bind_param("iissssss", $hakim_id, $id_pengadilan_asal, $tanggal_usul, $no_surat, $tanggal_surat, $tujuan_usul_text, $alasan, $nama_berkas_final);
        
        if ($stmt_insert->execute()) {
            header("Location: daftar_usulan.php?status=sukses");
            exit();
        } else {
            $usul_message = "Error: Gagal menyimpan usulan: " . $stmt_insert->error;
        }
        $stmt_insert->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usulan Pindah Hakim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-4 sm:p-6 lg:p-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg">
        <h1 class="text-2xl font-bold text-gray-800 border-b pb-4">Usulan Pindah Hakim</h1>
        <div class="my-6 p-4 bg-gray-50 rounded-lg">
            <p class="text-sm font-medium text-gray-500">Nama Hakim</p>
            <p class="text-lg font-semibold text-gray-900"><?php echo htmlspecialchars($hakim['nama_hakim']); ?></p>
            <p class="text-sm text-gray-500 mt-2">Asal Pengadilan</p>
            <p class="text-md font-medium text-gray-800"><?php echo htmlspecialchars($hakim['nama_pengadilan']); ?></p>
        </div>
        <?php if (!empty($usul_message)): ?>
            <div class="mb-6 p-4 rounded-md text-sm bg-red-100 text-red-800"><?php echo htmlspecialchars($usul_message); ?></div>
        <?php endif; ?>

        <form action="usul.php?id=<?php echo $hakim_id; ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <div>
                <label for="tanggal_usul" class="block text-sm font-medium text-gray-700">Tanggal Usul</label>
                <input type="date" name="tanggal_usul" id="tanggal_usul" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="no_surat" class="block text-sm font-medium text-gray-700">No. Surat</label>
                    <input type="text" name="no_surat" id="no_surat" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="tanggal_surat" class="block text-sm font-medium text-gray-700">Tanggal Surat</label>
                    <input type="date" name="tanggal_surat" id="tanggal_surat" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>
            </div>
            <div>
                <label for="tujuan_usul_text" class="block text-sm font-medium text-gray-700">Tujuan Usul (Ketik Nama PN)</label>
                <input type="text" name="tujuan_usul_text" id="tujuan_usul_text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" placeholder="Contoh: PN Jakarta Pusat">
            </div>
            <div>
                <label for="alasan_pindah" class="block text-sm font-medium text-gray-700">Perihal / Alasan Usulan</label>
                <textarea name="alasan_pindah" id="alasan_pindah" rows="4" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm"></textarea>
            </div>
            <div>
                <label for="berkas_usulan" class="block text-sm font-medium text-gray-700">Upload Berkas Pendukung (Opsional)</label>
                <input type="file" name="berkas_usulan" id="berkas_usulan" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>
            <div class="flex items-center justify-end space-x-4 pt-4 border-t">
                <a href="perikanan_db.php" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md font-semibold hover:bg-gray-300">Kembali</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md font-semibold hover:bg-blue-700">Kirim Usulan</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>