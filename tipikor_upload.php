<?php
// Inisialisasi variabel
$uploadMessage = '';
$uploadStatus = ''; // 'success' or 'error'
$data_preview = [];
$targetFile = 'data_tipikor_preview.csv'; // File khusus untuk preview halaman ini

// --- LOGIKA UNTUK MENANGANI UPLOAD FILE CSV ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['csvfile']) && $_FILES['csvfile']['error'] == UPLOAD_ERR_OK) {
        
        $fileType = strtolower(pathinfo($_FILES['csvfile']['name'], PATHINFO_EXTENSION));

        if ($fileType != 'csv') {
            $uploadMessage = "Error: File yang diunggah harus berformat CSV.";
            $uploadStatus = 'error';
        } else {
            if (move_uploaded_file($_FILES['csvfile']['tmp_name'], $targetFile)) {
                $uploadMessage = "Sukses: File CSV berhasil diunggah. Berikut adalah preview datanya.";
                $uploadStatus = 'success';
            } else {
                $uploadMessage = "Error: Gagal memindahkan file yang diunggah.";
                $uploadStatus = 'error';
            }
        }
    } elseif (isset($_FILES['csvfile']) && $_FILES['csvfile']['error'] != UPLOAD_ERR_NO_FILE) {
        $uploadMessage = "Error: Terjadi masalah saat mengunggah file. Kode Error: " . $_FILES['csvfile']['error'];
        $uploadStatus = 'error';
    }
}

// --- LOGIKA UNTUK MEMBACA DAN MENAMPILKAN DATA DARI CSV ---
if (file_exists($targetFile) && is_readable($targetFile)) {
    if (($handle = fopen($targetFile, "r")) !== FALSE) {
        fgetcsv($handle, 1000, ","); // Lewati baris header
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Pastikan baris memiliki 6 kolom
            if (count($data) == 6) {
                $data_preview[] = [
                    "no" => $data[0],
                    "satker" => $data[1],
                    "klas" => $data[2],
                    "jumlah_ad_hoc" => $data[3],
                    "ideal_ad_hoc" => $data[4],
                    "kebutuhan_ad_hoc" => $data[5]
                ];
            }
        }
        fclose($handle);
    }
}

// Menghitung total
$total_jumlah_ad_hoc = array_sum(array_column($data_preview, 'jumlah_ad_hoc'));
$total_ideal_ad_hoc = array_sum(array_column($data_preview, 'ideal_ad_hoc'));
$total_kebutuhan_ad_hoc = array_sum(array_column($data_preview, 'kebutuhan_ad_hoc'));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Data Hakim Tipikor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <div class="bg-white p-8 md:p-12 rounded-xl shadow-lg">
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Upload Data Tipikor</h1>
                    <p class="text-gray-500 mt-1">Unggah file CSV untuk melihat preview data.</p>
                </div>
                <a href="index.php" class="mt-4 sm:mt-0 bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-700 transition text-center">
                    Kembali ke Dashboard
                </a>
            </div>

            <!-- Form Upload -->
            <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-lg mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Upload File `data_tipikor.csv`</h2>
                <p class="text-sm text-gray-600 mb-4">Pilih file CSV dengan format yang sesuai. Data akan ditampilkan di bawah setelah diunggah.</p>
                
                <form action="tipikor_upload.php" method="post" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-center gap-4">
                    <input type="file" name="csvfile" accept=".csv" required class="flex-grow w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-green-100 file:text-green-700
                        hover:file:bg-green-200"/>
                    <button type="submit" class="w-full sm:w-auto bg-green-500 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-green-600 transition">
                        Upload & Preview
                    </button>
                </form>

                <?php if (!empty($uploadMessage)): ?>
                    <div class="mt-4 p-3 rounded-md text-sm <?php echo $uploadStatus == 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                        <?php echo htmlspecialchars($uploadMessage); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Hasil Upload (Tabel Preview) -->
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Hasil Upload</h3>
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                    <thead class="bg-gray-50 text-center">
                        <tr>
                            <th class="whitespace-nowrap px-4 py-3 font-bold text-gray-900">NO</th>
                            <th class="whitespace-nowrap px-4 py-3 font-bold text-gray-900 text-left">SATKER</th>
                            <th class="whitespace-nowrap px-4 py-3 font-bold text-gray-900">KLAS</th>
                            <th class="whitespace-nowrap px-4 py-3 font-bold text-gray-900">JUMLAH AD HOC</th>
                            <th class="whitespace-nowrap px-4 py-3 font-bold text-gray-900">IDEAL AD HOC</th>
                            <th class="whitespace-nowrap px-4 py-3 font-bold text-gray-900">KEBUTUHAN AD HOC</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if (empty($data_preview)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-10 text-gray-500">
                                    Belum ada data untuk ditampilkan. Silakan unggah file CSV di atas.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($data_preview as $data): ?>
                                <tr class="text-center">
                                    <td class="whitespace-nowrap px-4 py-3 font-medium text-gray-900"><?php echo htmlspecialchars($data['no']); ?></td>
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-700 text-left"><?php echo htmlspecialchars($data['satker']); ?></td>
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-700"><?php echo htmlspecialchars($data['klas']); ?></td>
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-700"><?php echo htmlspecialchars($data['jumlah_ad_hoc']); ?></td>
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-700"><?php echo htmlspecialchars($data['ideal_ad_hoc']); ?></td>
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-700"><?php echo htmlspecialchars($data['kebutuhan_ad_hoc']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <?php if (!empty($data_preview)): ?>
                    <tfoot class="bg-gray-100 font-bold">
                        <tr class="text-center">
                            <td class="whitespace-nowrap px-4 py-3 text-gray-900" colspan="3">JUMLAH</td>
                            <td class="whitespace-nowrap px-4 py-3 text-gray-900"><?php echo $total_jumlah_ad_hoc; ?></td>
                            <td class="whitespace-nowrap px-4 py-3 text-gray-900"><?php echo $total_ideal_ad_hoc; ?></td>
                            <td class="whitespace-nowrap px-4 py-3 text-gray-900"><?php echo $total_kebutuhan_ad_hoc; ?></td>
                        </tr>
                    </tfoot>
                    <?php endif; ?>
                </table>
            </div>
            
        </div>
    </div>

</body>
</html>
