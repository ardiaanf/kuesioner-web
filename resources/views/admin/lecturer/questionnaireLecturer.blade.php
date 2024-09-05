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
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h1 class="text-2xl font-bold mb-4">Jenis Kuesioner Dosen</h1>
                        <p class="text-gray-600 mb-4">Data ini digunakan untuk mengumpulkan data jenis kuesioner dosen.</p>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-2 px-4 border-b border-r">No</th>
                                        <th class="py-2 px-4 border-b border-r">Nama Kuesioner</th>
                                        <th class="py-2 px-4 border-b">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="py-2 px-4 border-b border-r">1</td>
                                        <td class="py-2 px-4 border-b border-r">Kuesioner Civitas Akademika</td>
                                        <td class="py-2 px-4 border-b">
                                            <button class="bg-yellow-500 text-white px-4 py-2 rounded" onclick="openEditModal('Kuesioner Civitas Akademika')">Ubah</button>
                                            <button class="bg-red-500 text-white px-4 py-2 rounded">Hapus</button>
                                        </td>
                                    </tr>
                                    <!-- Tambahkan baris pertanyaan lainnya di sini -->
                                </tbody>
                            </table>
                            <div class="mt-4">
                                <button class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Data</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- Tambahkan di dalam <body> sebelum </body> -->
    <div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-1/3">
            <h2 class="text-xl font-bold mb-4">Tambah Kuesioner</h2>
            <label class="block mb-2">Nama Kuesioner</label>
            <input type="text" class="border border-gray-300 rounded w-full mb-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400" placeholder=" Masukkan nama kuesioner">

            <div class="flex justify-between">
                <button class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
                <button class="bg-red-500 text-white px-4 py-2 rounded" onclick="closeModal()">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Tambahkan di dalam <body> sebelum </body> -->
    <div id="edit-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-1/3">
            <h2 class="text-xl font-bold mb-4">Ubah Kuesioner</h2>
            <label class="block mb-2">Nama Kuesioner</label>
            <input type="text" id="edit-nama" class="border border-gray-300 rounded w-full mb-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400">
            <div class="flex justify-between">
                <button class="bg-green-500 text-white px-4 py-2 rounded">Ubah</button>
                <button class="bg-red-500 text-white px-4 py-2 rounded" onclick="closeEditModal()">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Tambahkan script untuk mengontrol modal -->
    <script>
        document.querySelector('.bg-blue-500').addEventListener('click', function() {
            document.getElementById('modal').classList.remove('hidden');
        });

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        function openEditModal(nama, jenis) {
            document.getElementById('edit-nama').value = nama;
            document.getElementById('edit-modal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }
    </script>
</body>
</html>
