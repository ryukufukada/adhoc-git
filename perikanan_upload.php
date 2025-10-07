<?php
// --- SETUP ---
// Data hakim dipecah berdasarkan Pengadilan Negeri (PN) penempatannya,
// lengkap dengan keterangan perpanjangan masa tugas.
$hakim_per_pn = [
    "PN AMBON" => [
        ["nama" => "ABDUL AZIS, S.H., M.H.", "perpanjangan" => "Perpanjangan 2X 2025"],
        ["nama" => "GUNAWAN, S.Pi., S.H.", "perpanjangan" => "Perpanjangan 2X DES 2025"]
    ],
    "PN BITUNG" => [
        ["nama" => "Dr. SLAMET SURIPTO, S.H., M.Hum.", "perpanjangan" => "Perpanjangan 2X 2025"],
        ["nama" => "LENDRIATY JANIS, S.H., M.H.", "perpanjangan" => "Perpanjangan 2X 2025"],
        ["nama" => "Muhammad Ramli, S.H., M.H.", "perpanjangan" => "Perpanjangan 2X DES 2025"]
    ],
    "PN JAKARTA UTARA" => [
        ["nama" => "Hendra Adi Pramono, S.H., M.H.", "perpanjangan" => "Perpanjangan 2X"],
        ["nama" => "Dr. H. Bachtiar, S.H, M.H.", "perpanjangan" => "Perpanjangan 2X DES 2025"],
        ["nama" => "Umar, S.H., M.H.", "perpanjangan" => "Perpanjangan 2X DES 2025"]
    ],
    "PN MEDAN" => [
        ["nama" => "SONIADY DRAJAT SADARISMAN, S.H., M.H.", "perpanjangan" => "Perpanjangan 2X DES 2025"],
        ["nama" => "Dr. JUMAINI, S.H., M.H.", "perpanjangan" => "Perpanjangan 2X DES 2025"],
        ["nama" => "HALIMAH, S.H., M.H.", "perpanjangan" => "Perpanjangan 2X DES 2025"]
    ],
    "PN MERAUKE" => [
        ["nama" => "MARIANUS, S.H.", "perpanjangan" => "Perpanjangan 2X 2025"]
    ],
    "PN PONTIANAK" => [
        ["nama" => "DOMINGGUSMANTO, S.H.", "perpanjangan" => "Perpanjangan 2X DES 2025"],
        ["nama" => "Ir. A. WIDIMARIANTO", "perpanjangan" => "Habis 2020"],
        ["nama" => "JOKO TRIBOWO, S.Pi", "perpanjangan" => "Habis 2020"],
        ["nama" => "Ir. ISNAINI, S.H., M.H.", "perpanjangan" => "Perpanjangan 2X DES 2025"]
    ],
    "PN RANAI" => [
        ["nama" => "GATOT AMRIOKO, S.H.", "perpanjangan" => "Perpanjangan 2X 2025"],
        ["nama" => "Dr. NURHAYATI, S.Pi, S.H., M.Si.", "perpanjangan" => "Perpanjangan 2X"]
    ],
    "PN SORONG" => [
        ["nama" => "RUSDI, S.H.", "perpanjangan" => "Perpanjangan 2X 2025"],
        ["nama" => "AGUS HARIADI, S.H., M.H.", "perpanjangan" => "Perpanjangan 2X 2025"]
    ],
    "PN TANJUNG PINANG" => [
        ["nama" => "EMELDA, S.H.", "perpanjangan" => "Perpanjangan 2X DES 2025"]
    ],
    "PN TUAL" => [
        ["nama" => "SUWARDI, S.H., M.H.", "perpanjangan" => "Perpanjangan 2X DES 2025"],
        ["nama" => "AMINUDDIN, S.H., M.H.", "perpanjangan" => "Perpanjangan 2X DES 2025"]
    ],
];

// Inisialisasi variabel
$uploadMessage = '';
$uploadStatus = ''; // 'success' or 'error'
$data_preview = [];
$previewFile = 'data_perikanan_preview.csv'; // File khusus untuk preview halaman ini


// --- LOGIKA UPLOAD ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['csvfile']) && $_FILES['csvfile']['error'] == UPLOAD_ERR_OK) {
        $fileType = strtolower(pathinfo($_FILES['csvfile']['name'], PATHINFO_EXTENSION));

        if ($fileType != 'csv') {
            $uploadMessage = "Error: File harus berformat .csv";
            $uploadStatus = 'error';
        } else {
            if (move_uploaded_file($_FILES['csvfile']['tmp_name'], $previewFile)) {
                $uploadMessage = "Sukses: File CSV berhasil diunggah. Berikut adalah preview datanya.";
                $uploadStatus = 'success';
            } else {
                $uploadMessage = "Error: Gagal menyimpan file yang diunggah. Periksa izin folder di server.";
                $uploadStatus = 'error';
            }
        }
    } elseif (isset($_FILES['csvfile']) && $_FILES['csvfile']['error'] != UPLOAD_ERR_NO_FILE) {
        $uploadMessage = "Error: Terjadi masalah saat mengunggah. Kode Error: " . $_FILES['csvfile']['error'];
        $uploadStatus = 'error';
    }
}


// --- LOGIKA BACA CSV & TAMPILKAN DATA ---
if (file_exists($previewFile) && is_readable($previewFile)) {
    if (($handle = fopen($previewFile, "r")) !== FALSE) {
        fgetcsv($handle, 1000, ","); // Lewati baris header
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (count($data) == 5) { // Pastikan baris memiliki 5 kolom
                $data_preview[] = [
                    "no" => $data[0], "keterangan" => $data[1], "hk_ad_hoc" => $data[2],
                    "rata_rata" => $data[3], "ideal" => $data[4]
                ];
            }
        }
        fclose($handle);
    }
    // Jika file berhasil diunggah tapi tidak ada data yang valid terbaca
    if ($uploadStatus == 'success' && empty($data_preview)) {
        $uploadMessage .= "<br>Peringatan: Tidak ada baris data yang valid ditemukan. Pastikan file CSV memiliki 5 kolom: no, keterangan, hk_ad_hoc, rata_rata, ideal.";
        $uploadStatus = 'error';
    }
}

// Menghitung total
$total_hk_ad_hoc = array_sum(array_column($data_preview, 'hk_ad_hoc'));
$total_rata_rata = array_sum(array_column($data_preview, 'rata_rata'));
$total_ideal = array_sum(array_column($data_preview, 'ideal'));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Data Hakim Perikanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <div class="bg-white p-8 md:p-12 rounded-xl shadow-lg">
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Upload Data Perikanan</h1>
                    <p class="text-gray-500 mt-1">Unggah, unduh, dan kelola data hakim perikanan.</p>
                </div>
                <a href="index.php" class="mt-4 sm:mt-0 bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-700 transition text-center">
                    Kembali ke Dashboard
                </a>
            </div>

            <!-- Form Upload & Download -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Manajemen File `data_perikanan.csv`</h2>
                
                <!-- Tombol Download -->
                <div class="mb-6">
                    <p class="text-sm text-gray-600 mb-2">Unduh file CSV template untuk memastikan formatnya benar sebelum diisi.</p>
                     <a href="data_perikanan.csv" download class="inline-flex items-center gap-2 bg-white text-blue-700 px-4 py-2 rounded-lg font-semibold hover:bg-gray-50 transition border border-blue-300 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg>
                        Unduh Template CSV
                    </a>
                </div>

                <!-- Form Upload -->
                <div class="pt-6 border-t border-blue-200">
                     <p class="text-sm text-gray-600 mb-4">Pilih file CSV baru untuk ditampilkan. Data akan muncul di tabel preview di bawah.</p>
                    <form action="perikanan_upload.php" method="post" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-center gap-4">
                        <input type="file" name="csvfile" accept=".csv" required class="flex-grow w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200"/>
                        <button type="submit" class="w-full sm:w-auto bg-blue-500 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-blue-600 transition">
                            Upload & Preview
                        </button>
                    </form>
                </div>

                <?php if (!empty($uploadMessage)): ?>
                    <div class="mt-4 p-3 rounded-md text-sm <?php echo $uploadStatus == 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                        <?php echo $uploadMessage; // Tidak perlu htmlspecialchars karena pesan error tidak mengandung input user ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Hasil Upload -->
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Tabel Preview dan Alokasi Hakim</h3>
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                    <thead class="bg-gray-50 text-center">
                        <tr>
                            <th class="whitespace-nowrap px-4 py-3 font-bold text-gray-900">NO.</th>
                            <th class="whitespace-nowrap px-4 py-3 font-bold text-gray-900 text-left">KETERANGAN & NAMA HAKIM</th>
                            <th class="whitespace-nowrap px-4 py-3 font-bold text-gray-900">HK AD HOC</th>
                            <th class="whitespace-nowrap px-4 py-3 font-bold text-gray-900">RATA-RATA</th>
                            <th class="whitespace-nowrap px-4 py-3 font-bold text-gray-900">IDEAL</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if (empty($data_preview)): ?>
                            <tr><td colspan="5" class="text-center py-10 text-gray-500">Belum ada data. Silakan unggah file CSV.</td></tr>
                        <?php else: ?>
                            <?php foreach ($data_preview as $data): ?>
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-3 font-medium text-gray-900 align-top text-center"><?php echo htmlspecialchars($data['no']); ?></td>
                                    <td class="px-4 py-3 text-gray-700 text-left align-top">
                                        <div class="font-medium text-gray-900"><?php echo htmlspecialchars($data['keterangan']); ?></div>
                                        <?php
                                        $nama_pengadilan = trim($data['keterangan']);
                                        $list_hakim_untuk_pn = isset($hakim_per_pn[$nama_pengadilan]) ? $hakim_per_pn[$nama_pengadilan] : [];

                                        if (!empty($list_hakim_untuk_pn)) {
                                            echo '<ul class="mt-2 space-y-1">';
                                            foreach ($list_hakim_untuk_pn as $hakim) {
                                                echo '<li class="text-xs text-gray-800 list-disc list-inside">' . 
                                                        htmlspecialchars($hakim['nama']) . 
                                                        ' <span class="font-semibold text-blue-600">(' . htmlspecialchars($hakim['perpanjangan']) . ')</span>' .
                                                     '</li>';
                                            }
                                            echo '</ul>';
                                        }
                                        ?>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-700 font-semibold align-top text-center"><?php echo htmlspecialchars($data['hk_ad_hoc']); ?></td>
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-700 align-top text-center"><?php echo htmlspecialchars($data['rata_rata']); ?></td>
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-700 align-top text-center"><?php echo htmlspecialchars($data['ideal']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                     <?php if (!empty($data_preview)): ?>
                    <tfoot class="bg-gray-100 font-bold">
                        <tr class="text-center">
                            <td class="whitespace-nowrap px-4 py-3 text-gray-900" colspan="2">JUMLAH</td>
                            <td class="whitespace-nowrap px-4 py-3 text-gray-900"><?php echo $total_hk_ad_hoc; ?></td>
                            <td class="whitespace-nowrap px-4 py-3 text-gray-900"><?php echo $total_rata_rata; ?></td>
                            <td class="whitespace-nowrap px-4 py-3 text-gray-900"><?php echo $total_ideal; ?></td>
                        </tr>
                    </tfoot>
                    <?php endif; ?>
                </table>
            </div>
            
        </div>
    </div>

</body>
</html>

