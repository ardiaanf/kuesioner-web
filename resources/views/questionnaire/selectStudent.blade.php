<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- @vite('resources/css/app.css') --}}
</head>

<body class="bg-gray-100">
    @include('questionnaire.components.navbarMahasiswa')
    <div class="container mx-auto px-4 "> <!-- Menambahkan container untuk memberi jarak -->
        <div class="max-w-3xl mx-auto px-4 py-8 ">
            <h1 class="text-2xl font-bold mb-6 text-center">Pilih Jenis Kuesioner Mahasiswa</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4"> <!-- Menambahkan gap untuk jarak antar item -->
                <div id="kuesioner-1" class="bg-white rounded-lg shadow-md p-6 cursor-pointer hover:bg-blue-50 transition duration-300">
                    <h2 class="text-lg font-semibold mb-2">Kuesioner Kepuasan Pelanggan</h2>
                    <p class="text-sm text-gray-600">Mengukur tingkat kepuasan pelanggan terhadap produk atau layanan yang diberikan.</p>

                    <button class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Mulai Kuesioner</button>

                </div>
                <div id="kuesioner-1" class="bg-white rounded-lg shadow-md p-6 cursor-pointer hover:bg-blue-50 transition duration-300">
                    <h2 class="text-lg font-semibold mb-2">Kuesioner Kepuasan Pelanggan</h2>
                    <p class="text-sm text-gray-600">Mengukur tingkat kepuasan pelanggan terhadap produk atau layanan yang diberikan.</p>
                    <button class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Mulai Kuesioner</button>
                </div>
                <div id="kuesioner-1" class="bg-white rounded-lg shadow-md p-6 cursor-pointer hover:bg-blue-50 transition duration-300">
                    <h2 class="text-lg font-semibold mb-2">Kuesioner Kepuasan Pelanggan</h2>
                    <p class="text-sm text-gray-600">Mengukur tingkat kepuasan pelanggan terhadap produk atau layanan yang diberikan.</p>
                    <button class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Mulai Kuesioner</button>
                </div>
                <div id="kuesioner-1" class="bg-white rounded-lg shadow-md p-6 cursor-pointer hover:bg-blue-50 transition duration-300">
                    <h2 class="text-lg font-semibold mb-2">Kuesioner Kepuasan Pelanggan</h2>
                    <p class="text-sm text-gray-600">Mengukur tingkat kepuasan pelanggan terhadap produk atau layanan yang diberikan.</p>
                    <button class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Mulai Kuesioner</button>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
