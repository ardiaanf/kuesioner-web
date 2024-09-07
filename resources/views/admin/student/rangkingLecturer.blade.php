<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kuesioner</title>
    @vite('resources/css/app.css')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}

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
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h1 class="text-2xl font-bold mb-4">Hasil Peringkat Kinerja Dosen </h1>

                        <label for="filter" class="block text-sm font-medium text-gray-700 mb-2">Progam studi</label>
                        <select id="filter" class="block w-1/4 p-1 border border-gray-300 hover:border-gray-300 rounded-md mb-4">
                            <option value="">TI</option>
                            <option value="baik">AGB</option>
                        </select>

                        <label for="filter" class="block text-sm font-medium text-gray-700 mb-2">Jenis kuesioner</label>
                        <select id="filter" class="block w-1/4 p-1 border border-gray-300 hover:border-gray-300 rounded-md mb-4">
                            <option value="">PBM</option>
                            <option value="baik">Civitas</option>
                        </select>


                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-2 px-4 border-b border-r">No</th>
                                        <th class="py-2 px-4 border-b border-r">Nama Dosen</th>
                                        <th class="py-2 px-4 border-b border-r">Nomor induk</th>
                                        <th class="py-2 px-4 border-b border-r">Rata - rata teori</th>
                                        <th class="py-2 px-4 border-b border-r">Rata - rata praktikum</th>
                                        <th class="py-2 px-4 border-b border-r">Rata - rata teori praktikum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="py-2 px-4 border-b border-r">1</td>
                                        <td class="py-2 px-4 border-b border-r">rini</td>
                                        <td class="py-2 px-4 border-b border-r">365200</td>
                                        <td class="py-2 px-4 border-b border-r">3.55</td>
                                        <td class="py-2 px-4 border-b border-r">4.5</td>
                                        <td class="py-2 px-4 border-b border-r">4</td>
                                    </tr>
                                    <!-- Tambahkan baris pertanyaan lainnya di sini -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
