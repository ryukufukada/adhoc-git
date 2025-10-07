<?php
// --- SETUP KONEKSI DATABASE ---
// --- Panggil file koneksi terpusat ---
require_once 'koneksi.php';

$hakim_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($hakim_id === 0) { die("Error: ID Hakim tidak valid."); }

// --- LOGIKA UNTUK MEMINDAHKAN HAKIM ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pengadilan_tujuan = $_POST['id_pengadilan_tujuan'] ?? 0;
    if (!empty($id_pengadilan_tujuan)) {
        $stmt_pindah = $conn->prepare("UPDATE hakim_perikanan SET id_pengadilan = ? WHERE id = ?");
        $stmt_pindah->bind_param("ii", $id_pengadilan_tujuan, $hakim_id);
        if ($stmt_pindah->execute()) {
            // Redirect kembali ke halaman utama dengan pesan sukses
            header("Location: perikanan_db.php?status=mutasi_sukses");
            exit();
        } else {
            $error_message = "Gagal memindahkan hakim.";
        }
        $stmt_pindah->close();
    } else {
        $error_message = "Anda harus memilih pengadilan tujuan.";
    }
}

// Ambil data hakim & daftar PN untuk ditampilkan di form
$stmt_hakim = $conn->prepare("SELECT h.nama_hakim, p.nama_pengadilan, p.id as id_pengadilan_asal FROM hakim_perikanan h JOIN pengadilan p ON h.id_pengadilan = p.id WHERE h.id = ?");
$stmt_hakim->bind_param("i", $hakim_id);
$stmt_hakim->execute();
$hakim = $stmt_hakim->get_result()->fetch_assoc();
if (!$hakim) { die("Hakim tidak ditemukan."); }
$stmt_hakim->close();

$pengadilan_list = $conn->query("SELECT id, nama_pengadilan FROM pengadilan ORDER BY nama_pengadilan ASC");
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Mutasi Langsung Hakim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="container mx-auto p-4 sm:p-6 lg:p-8">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-lg">
        <h1 class="text-2xl font-bold text-gray-800 border-b pb-4">Mutasi Langsung Hakim</h1>
        <div class="my-6">
            <p class="text-sm text-gray-600">Anda akan memindahkan hakim:</p>
            <p class="text-lg font-semibold text-gray-900"><?php echo htmlspecialchars($hakim['nama_hakim']); ?></p>
            <p class="text-sm text-gray-500">dari <?php echo htmlspecialchars($hakim['nama_pengadilan']); ?></p>
        </div>
        <?php if (!empty($error_message)): ?>
            <div class="mb-4 p-3 text-sm bg-red-100 text-red-800 rounded-md"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST" action="mutasi.php?id=<?php echo $hakim_id; ?>">
            <div>
                <label for="id_pengadilan_tujuan" class="block text-sm font-medium text-gray-700">Pindahkan Ke Pengadilan Tujuan</label>
                <select name="id_pengadilan_tujuan" id="id_pengadilan_tujuan" required class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm">
                    <option value="">-- Pilih Pengadilan Tujuan --</option>
                    <?php while($p = $pengadilan_list->fetch_assoc()): if ($p['id'] !== $hakim['id_pengadilan_asal']): ?>
                        <option value="<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['nama_pengadilan']); ?></option>
                    <?php endif; endwhile; ?>
                </select>
            </div>
            <div class="flex items-center justify-end space-x-4 pt-6 mt-4 border-t">
                <a href="perikanan_db.php" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md font-semibold hover:bg-gray-300">Batal</a>
                <button type="submit" class="text-white px-4 py-2 rounded-md font-semibold bg-green-600 hover:bg-green-700">
                    Pindahkan Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>