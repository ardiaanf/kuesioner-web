<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kuesioner</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('admin.component.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden p-4 ml-64">
            <!-- Header -->
            @include('admin.component.header')

            <!-- Main content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-6 py-8">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Dashboard Admin</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Kartu Statistik -->
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Kuesioner</h3>
                            <p class="text-3xl font-bold text-blue-600">13333</p>
                        </div>
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Responden Aktif</h3>
                            <p class="text-3xl font-bold text-green-600">4556</p>
                        </div>
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Kuesioner Selesai</h3>
                            <p class="text-3xl font-bold text-purple-600">98777</p>
                        </div>
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Rata-rata Respons</h3>
                            <p class="text-3xl font-bold text-orange-600">9%</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Grafik Kuesioner Terbaru -->
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Kuesioner Terbaru</h3>
                            <!-- Tambahkan grafik atau tabel di sini -->
                            <p class="text-gray-600">Grafik kuesioner terbaru akan ditampilkan di sini.</p>
                        </div>

                        <!-- Daftar Kuesioner Aktif -->
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Kuesioner Aktif</h3>
                            <ul class="divide-y divide-gray-200">
                                {{-- @foreach($kuesionerAktif as $kuesioner) --}}
                                <li class="py-3">
                                    {{-- <p class="text-gray-800 font-medium">{{ $kuesioner->judul }}</p> --}}
                                    {{-- <p class="text-sm text-gray-600">Berakhir: {{ $kuesioner->tanggal_berakhir }}</p> --}}
                                </li>
                                {{-- @endforeach --}}
                            </ul>
                        </div>
                    </div>
                </div>
            </main>

        </div>
    </div>

</body>
</html>
