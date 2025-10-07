<?php
require_once 'koneksi.php';

$usul_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($usul_id === 0) { die("Error: ID tidak valid."); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $keterangan = $_POST['keterangan_status'] ?? '';
    $status_baru = $_POST['status_baru'] ?? '';
    $id_pengadilan_tujuan = ($status_baru == 'Disetujui') ? ($_POST['id_pengadilan_tujuan'] ?? null) : null;
    $tanggal_diproses = date('Y-m-d H:i:s');
    if ($status_baru == 'Disetujui' && empty($id_pengadilan_tujuan)) { die("Error: Jika usulan disetujui, pengadilan tujuan harus dipilih."); }
    
    $usul_data_stmt = $conn->prepare("SELECT id_hakim FROM usulan_pindah WHERE id = ?");
    $usul_data_stmt->bind_param("i", $usul_id);
    $usul_data_stmt->execute();
    $usul_data = $usul_data_stmt->get_result()->fetch_assoc();
    $usul_data_stmt->close();
    
    if($usul_data) {
        $conn->begin_transaction();
        try {
            $stmt_update = $conn->prepare("UPDATE usulan_pindah SET status = ?, keterangan_status = ?, tanggal_diproses = ?, id_pengadilan_tujuan = ? WHERE id = ?");
            $stmt_update->bind_param("sssii", $status_baru, $keterangan, $tanggal_diproses, $id_pengadilan_tujuan, $usul_id);
            $stmt_update->execute();
            $stmt_update->close();
            if ($status_baru == 'Disetujui') {
                $stmt_pindah = $conn->prepare("UPDATE hakim_perikanan SET id_pengadilan = ? WHERE id = ?");
                $stmt_pindah->bind_param("ii", $id_pengadilan_tujuan, $usul_data['id_hakim']);
                $stmt_pindah->execute();
                $stmt_pindah->close();
            }
            $conn->commit();
            header("Location: daftar_usulan.php");
            exit();
        } catch (mysqli_sql_exception $e) { $conn->rollback(); die("Error: Gagal memproses usulan. " . $e->getMessage()); }
    }
}

$stmt = $conn->prepare("SELECT h.nama_hakim, p.nama_pengadilan as nama_pengadilan_asal, p.id as id_pengadilan_asal, u.tujuan_usul_text FROM usulan_pindah u JOIN hakim_perikanan h ON u.id_hakim = h.id JOIN pengadilan p ON u.id_pengadilan_asal = p.id WHERE u.id = ?");
$stmt->bind_param("i", $usul_id);
$stmt->execute();
$usul = $stmt->get_result()->fetch_assoc();
if (!$usul) { die("Error: Usulan tidak ditemukan."); }
$stmt->close();

$pengadilan_list = $conn->query("SELECT id, nama_pengadilan FROM pengadilan ORDER BY nama_pengadilan ASC");
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Proses Usulan</title><script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="container mx-auto p-4 sm:p-6 lg:p-8">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-lg">
        <h1 class="text-2xl font-bold text-gray-800 border-b pb-4">Proses Usulan Pindah</h1>
        <div class="my-6">
            <p class="text-sm text-gray-600">Hakim:</p>
            <p class="text-lg font-semibold text-gray-900"><?php echo htmlspecialchars($usul['nama_hakim']); ?></p>
            <p class="text-sm text-gray-500">Dari: <?php echo htmlspecialchars($usul['nama_pengadilan_asal']); ?></p>
            <?php if(!empty($usul['tujuan_usul_text'])): ?>
                <p class="text-sm text-blue-600 mt-1">Usulan Awal Pindah ke: <b><?php echo htmlspecialchars($usul['tujuan_usul_text']); ?></b></p>
            <?php endif; ?>
        </div>
        <form method="POST" action="proses_usulan.php?id=<?php echo $usul_id; ?>">
            <div class="space-y-6">
                <div>
                    <label for="status_baru" class="block text-sm font-medium text-gray-700">Aksi</label>
                    <select name="status_baru" id="status_baru" required class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm">
                        <option value="Disetujui">Setujui Usulan</option>
                        <option value="Ditolak">Tolak Usulan</option>
                    </select>
                </div>
                <div id="tujuan_div">
                    <label for="id_pengadilan_tujuan" class="block text-sm font-medium text-gray-700">Pindahkan Ke Pengadilan Tujuan (Final)</label>
                    <select name="id_pengadilan_tujuan" id="id_pengadilan_tujuan" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm">
                        <option value="">-- Pilih Pengadilan Tujuan --</option>
                         <?php while($p = $pengadilan_list->fetch_assoc()): if ($p['id'] !== $usul['id_pengadilan_asal']): ?>
                            <option value="<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['nama_pengadilan']); ?></option>
                        <?php endif; endwhile; ?>
                    </select>
                </div>
                <div>
                    <label for="keterangan_status" class="block text-sm font-medium text-gray-700">Keterangan / Catatan</label>
                    <textarea name="keterangan_status" id="keterangan_status" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm"></textarea>
                </div>
            </div>
            <div class="flex items-center justify-end space-x-4 pt-6 mt-6 border-t">
                <a href="daftar_usulan.php" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md font-semibold hover:bg-gray-300">Batal</a>
                <button type="submit" class="text-white px-4 py-2 rounded-md font-semibold bg-blue-600 hover:bg-blue-700">Simpan Keputusan</button>
            </div>
        </form>
    </div>
</div>
<script>
    const statusSelect = document.getElementById('status_baru'), tujuanDiv = document.getElementById('tujuan_div'), tujuanSelect = document.getElementById('id_pengadilan_tujuan');
    statusSelect.addEventListener('change', function() {
        if (this.value === 'Disetujui') {
            tujuanDiv.style.display = 'block';
            tujuanSelect.required = true;
        } else {
            tujuanDiv.style.display = 'none';
            tujuanSelect.required = false;
        }
    });
    statusSelect.dispatchEvent(new Event('change'));
</script>
</body>
</html>