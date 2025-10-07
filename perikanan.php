<?php
// Data dummy untuk hakim perikanan, sesuai dengan gambar yang diberikan.
$data_perikanan = [
    ["no" => 1, "keterangan" => "PN JAKARTA UTARA", "hk_ad_hoc" => 3, "rata_rata" => 5, "ideal" => 3],
    ["no" => 2, "keterangan" => "PN MEDAN", "hk_ad_hoc" => 5, "rata_rata" => 11, "ideal" => 3],
    ["no" => 3, "keterangan" => "PN TANJUNG PINANG", "hk_ad_hoc" => 7, "rata_rata" => 33, "ideal" => 4],
    ["no" => 4, "keterangan" => "PN RANAI", "hk_ad_hoc" => 5, "rata_rata" => 20, "ideal" => 3],
    ["no" => 5, "keterangan" => "PN PONTIANAK", "hk_ad_hoc" => 5, "rata_rata" => 18, "ideal" => 3],
    ["no" => 6, "keterangan" => "PN BITUNG", "hk_ad_hoc" => 4, "rata_rata" => 17, "ideal" => 3],
    ["no" => 7, "keterangan" => "PN TUAL", "hk_ad_hoc" => 3, "rata_rata" => 1, "ideal" => 3],
    ["no" => 8, "keterangan" => "PN AMBON", "hk_ad_hoc" => 3, "rata_rata" => 1, "ideal" => 3],
    ["no" => 9, "keterangan" => "PN SORONG", "hk_ad_hoc" => 3, "rata_rata" => 2, "ideal" => 3],
    ["no" => 10, "keterangan" => "PN MERAUKE", "hk_ad_hoc" => 3, "rata_rata" => 1, "ideal" => 3],
];

// Menghitung total
$total_hk_ad_hoc = array_sum(array_column($data_perikanan, 'hk_ad_hoc'));
$total_rata_rata = array_sum(array_column($data_perikanan, 'rata_rata'));
$total_ideal = array_sum(array_column($data_perikanan, 'ideal'));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Hakim Perikanan 2025</title>
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
            
            <!-- Header Halaman -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 border-b pb-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Data Hakim Perikanan 2025</h1>
                    <p class="text-gray-500 mt-1">Detail data kebutuhan Hakim Ad Hoc Perikanan</p>
                </div>
                <!-- Tombol kembali ke dashboard -->
                <a href="index.php" class="mt-4 sm:mt-0 bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-700 transition text-center">
                    Kembali ke Dashboard
                </a>
            </div>

            <!-- Tabel Data -->
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                    <thead class="bg-gray-50 text-center">
                        <tr>
                            <th class="whitespace-nowrap px-4 py-3 font-bold text-gray-900">NO.</th>
                            <th class="whitespace-nowrap px-4 py-3 font-bold text-gray-900 text-left">KETERANGAN</th>
                            <th class="whitespace-nowrap px-4 py-3 font-bold text-gray-900">HK AD HOC</th>
                            <th class="whitespace-nowrap px-4 py-3 font-bold text-gray-900">RATA - RATA PERKARA 3 TAHUN</th>
                            <th class="whitespace-nowrap px-4 py-3 font-bold text-gray-900">Ideal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($data_perikanan as $data): ?>
                            <tr class="text-center">
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-gray-900"><?php echo $data['no']; ?></td>
                                <td class="whitespace-nowrap px-4 py-3 text-gray-700 text-left"><?php echo htmlspecialchars($data['keterangan']); ?></td>
                                <td class="whitespace-nowrap px-4 py-3 text-gray-700"><?php echo $data['hk_ad_hoc']; ?></td>
                                <td class="whitespace-nowrap px-4 py-3 text-gray-700"><?php echo $data['rata_rata']; ?></td>
                                <td class="whitespace-nowrap px-4 py-3 text-gray-700"><?php echo $data['ideal']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="bg-gray-100 font-bold">
                        <tr class="text-center">
                            <td class="whitespace-nowrap px-4 py-3 text-gray-900" colspan="2">JUMLAH</td>
                            <td class="whitespace-nowrap px-4 py-3 text-gray-900"><?php echo $total_hk_ad_hoc; ?></td>
                            <td class="whitespace-nowrap px-4 py-3 text-gray-900"><?php echo $total_rata_rata; ?></td>
                            <td class="whitespace-nowrap px-4 py-3 text-gray-900"><?php echo $total_ideal; ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </div>

</body>
</html>
