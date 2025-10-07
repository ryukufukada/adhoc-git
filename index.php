<?php
// Data dummy untuk hakim. Di aplikasi nyata, data ini akan diambil dari database.
$data_hakim = [
    [
        "nama" => "Fulan FUlan, S.H., M.H.",
        "nip" => "197508172000031002",
        "sertifikat" => "Hakim Tipikor"
    ],
    
];

// Data dummy untuk daftar sertifikasi
$daftar_sertifikasi = [
    "Sertifikasi Hakim Tindak Pidana Korupsi (Tipikor)",
    "Sertifikasi Hakim Hubungan Industrial",
    "Sertifikasi Hakim Perikanan",
    "Sertifikasi Hakim Niaga",
    "Sertifikasi Hakim Pajak",
    "Sertifikasi Hakim Anak",
    "Sertifikasi Mediator",
    "Sertifikasi Ekonomi Syariah",
    "Sertifikasi Lingkungan Hidup"
];

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Pengecekan Sertifikasi</title>
    <!-- Memuat Tailwind CSS untuk styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Memuat Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Menggunakan font Inter sebagai default */
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <div class="bg-white p-8 md:p-12 rounded-xl shadow-lg">
            
            <!-- Header Dashboard -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 border-b pb-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Dashboard Admin</h1>
                    <p class="text-gray-500 mt-1">Manajemen Sertifikasi Hakim Karir</p>
                </div>
                <div class="flex items-center space-x-4 mt-4 sm:mt-0">
                    <!-- Tombol Cek Sertifikat -->
                    <a href="detail.php" class="bg-blue-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-600 transition text-center">
                        Cek Sertifikat
                    </a>
                    <a href="drp_perikanan.ph.p" class="bg-green-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-600 transition text-center">
    Lihat DRP Hakim Ad Hoc Perikanan
</a>
                    <!-- Tombol logout akan mengarahkan kembali ke halaman login -->
                    <a href="index.html" class="bg-red-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-600 transition text-center">
                        Logout
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Kolom Utama: Tabel Hakim -->
                <div class="lg:col-span-2">
                    
                    <!-- Navigasi Tab -->
                    <div class="mb-6">
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-6" aria-label="Tabs">
                                <a href="#" class="whitespace-nowrap py-3 px-1 border-b-2 border-blue-500 font-semibold text-sm text-blue-600" aria-current="page">
                                    Semua Hakim
                                </a>
                                <a href="perikanan_db.php" class="whitespace-nowrap py-3 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                    Hakim Perikanan 2025
                                </a>
                                <a href="perikanan_upload.php" class="whitespace-nowrap py-3 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                    Perikanan Upload
                                </a>
                                <a href="#" class="whitespace-nowrap py-3 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                    Hakim Korupsi 2025
                                </a>
                                <a href="tipikor_upload.php" class="whitespace-nowrap py-3 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                    Tipikor Upload
                                </a>
                            </nav>
                        </div>
                    </div>

                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Daftar Hakim Bersertifikasi</h2>
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-3 text-left font-medium text-gray-900">Nama Hakim</th>
                                    <th class="whitespace-nowrap px-4 py-3 text-left font-medium text-gray-900">NIP</th>
                                    <th class="whitespace-nowrap px-4 py-3 text-left font-medium text-gray-900">Sertifikat</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($data_hakim as $hakim): ?>
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-3 font-medium text-gray-900"><?php echo htmlspecialchars($hakim['nama']); ?></td>
                                        <td class="whitespace-nowrap px-4 py-3 text-gray-700"><?php echo htmlspecialchars($hakim['nip']); ?></td>
                                        <td class="whitespace-nowrap px-4 py-3 text-gray-700"><?php echo htmlspecialchars($hakim['sertifikat']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Kolom Samping: Pencarian dan List Sertifikasi -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Master Sertifikasi</h2>
                    
                    <!-- Kolom Pencarian -->
                    <div class="mb-6">
                        <label for="searchSertifikat" class="block text-sm font-medium text-gray-700 mb-2">Cari Sertifikasi</label>
                        <input type="text" id="searchSertifikat" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Ketik untuk mencari...">
                    </div>

                    <!-- Daftar Sertifikasi -->
                    <div class="h-96 overflow-y-auto pr-2 border rounded-lg p-4 bg-gray-50">
                        <ul id="sertifikatList" class="space-y-3">
                            <?php foreach ($daftar_sertifikasi as $sertifikat): ?>
                                <li class="p-3 bg-white rounded-md flex items-center shadow-sm">
                                    <span class="font-medium text-gray-800 text-sm"><?php echo htmlspecialchars($sertifikat); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // --- Event Listener untuk Pencarian Sertifikat ---
        const searchInput = document.getElementById('searchSertifikat');
        const sertifikatList = document.getElementById('sertifikatList').getElementsByTagName('li');

        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();
            
            for (let i = 0; i < sertifikatList.length; i++) {
                const item = sertifikatList[i];
                const text = item.textContent || item.innerText;
                if (text.toLowerCase().indexOf(filter) > -1) {
                    item.style.display = "";
                } else {
                    item.style.display = "none";
                }
            }
        });
    </script>

</body>
</html>

