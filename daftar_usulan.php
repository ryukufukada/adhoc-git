<?php
// --- PASTIKAN BARIS INI ADA DI PALING ATAS ---
require_once 'koneksi.php'; // Ini akan memanggil file koneksi dan membuat variabel $conn tersedia

// Mengambil data usulan dari database
$sql = "SELECT u.id, u.tanggal_usul, u.no_surat, u.tanggal_surat, u.status, u.keterangan_status, u.alasan, u.tujuan_usul_text, u.nama_berkas, h.nama_hakim, p_asal.nama_pengadilan AS nama_pengadilan_asal, p_tujuan.nama_pengadilan AS nama_pengadilan_tujuan
        FROM usulan_pindah u
        JOIN hakim_perikanan h ON u.id_hakim = h.id
        JOIN pengadilan p_asal ON u.id_pengadilan_asal = p_asal.id
        LEFT JOIN pengadilan p_tujuan ON u.id_pengadilan_tujuan = p_tujuan.id
        ORDER BY u.id DESC";
// Baris 12 yang error sekarang akan berfungsi karena $conn sudah didefinisikan dari koneksi.php
$result_usulan = $conn->query($sql);

$conn->close(); // Menutup koneksi setelah query selesai
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Usulan Pindah Hakim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-100">
<div class="container mx-auto p-4 sm:p-6 lg:p-8">
    <div class="bg-white p-8 rounded-xl shadow-lg">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Usulan Pindah Hakim</h1>
            <a href="perikanan_db.php" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md font-semibold hover:bg-gray-300 transition-colors">Kembali</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y-2 divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-bold text-gray-900">Detail Usulan</th>
                        <th class="px-4 py-3 text-left font-bold text-gray-900">Nama Hakim & Alasan</th>
                        <th class="px-4 py-3 text-left font-bold text-gray-900">PN Asal</th>
                        <th class="px-4 py-3 text-left font-bold text-gray-900">Usulan Tujuan</th>
                        <th class="px-4 py-3 text-left font-bold text-gray-900">Status & Keterangan</th>
                        <th class="px-4 py-3 text-left font-bold text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if ($result_usulan && $result_usulan->num_rows > 0): while($usul = $result_usulan->fetch_assoc()): ?>
                        <tr>
                            <td class="px-4 py-3 align-top">
                                <p><b>Tgl Usul:</b> <?php echo date('d M Y', strtotime($usul['tanggal_usul'])); ?></p>
                                <p class="text-xs text-gray-600"><b>No. Surat:</b> <?php echo htmlspecialchars($usul['no_surat'] ?? 'N/A'); ?></p>
                                <p class="text-xs text-gray-600"><b>Tgl Surat:</b> <?php echo !empty($usul['tanggal_surat']) ? date('d M Y', strtotime($usul['tanggal_surat'])) : 'N/A'; ?></p>
                                <?php if (!empty($usul['nama_berkas'])): ?>
                                    <p class="text-xs mt-2"><b>Berkas:</b> <a href="uploads/<?php echo htmlspecialchars($usul['nama_berkas']); ?>" target="_blank" class="text-blue-600 hover:underline">Lihat</a></p>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 align-top">
                                <p class="font-semibold"><?php echo htmlspecialchars($usul['nama_hakim']); ?></p>
                                <p class="text-xs text-gray-500 mt-1 max-w-xs whitespace-normal"><b>Alasan:</b> <?php echo htmlspecialchars($usul['alasan']); ?></p>
                            </td>
                            <td class="px-4 py-3 align-top"><?php echo htmlspecialchars($usul['nama_pengadilan_asal']); ?></td>
                            <td class="px-4 py-3 align-top font-semibold"><?php echo htmlspecialchars($usul['tujuan_usul_text'] ?? 'N/A'); ?></td>
                            <td class="px-4 py-3 align-top">
                                <?php 
                                $status_color = 'bg-yellow-100 text-yellow-800';
                                if ($usul['status'] == 'Disetujui') $status_color = 'bg-green-100 text-green-800';
                                if ($usul['status'] == 'Ditolak') $status_color = 'bg-red-100 text-red-800';
                                ?>
                                <span class="px-2 py-1 font-semibold leading-tight rounded-full text-xs <?php echo $status_color; ?>"><?php echo htmlspecialchars($usul['status']); ?></span>
                                <?php if($usul['status'] == 'Disetujui'): ?>
                                    <p class="text-xs text-green-700 mt-2"><b>Tujuan Final:</b> <?php echo htmlspecialchars($usul['nama_pengadilan_tujuan'] ?? 'N/A'); ?></p>
                                <?php endif; ?>
                                <?php if (!empty($usul['keterangan_status'])): ?>
                                    <p class="text-xs text-gray-500 mt-2 max-w-xs whitespace-normal"><b>Ket:</b> <?php echo htmlspecialchars($usul['keterangan_status']); ?></p>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 align-top">
                                <?php if($usul['status'] == 'Diajukan'): ?>
                                    <a href="proses_usulan.php?id=<?php echo $usul['id']; ?>" class="text-blue-600 hover:underline font-bold">Proses</a>
                                <?php else: ?>
                                    <span class="text-gray-500 text-xs">Selesai</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; else: ?>
                        <tr><td colspan="6" class="text-center py-10 text-gray-500">Belum ada data usulan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>