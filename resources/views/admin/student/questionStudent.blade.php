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
                        <h1 class="text-2xl font-bold mb-4">Data Pertanyaan Kuesioner Mahasiswa</h1>
                        <p class="text-gray-600 mb-4">Ini adalah daftar elemen kuesioner yang dapat Anda edit atau hapus. Gunakan tombol 'Tambah Data' untuk menambahkan elemen baru.</p>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-2 px-4 border-b border-r">No</th>
                                        <th class="py-2 px-4 border-b border-r">Nama pertanyaan</th>
                                        <th class="py-2 px-4 border-b">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="py-2 px-4 border-b border-r">1</td>
                                        <td class="py-2 px-4 border-b border-r">Apa pendapat Anda tentang layanan kami?</td>
                                        <td class="py-2 px-4 border-b">
                                            <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600" onclick="openEditModal('Apa pendapat Anda tentang layanan kami?')">
                                                Ubah
                                            </button>
                                            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 ml-2">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Tambahkan baris pertanyaan lainnya di sini -->
                                </tbody>
                            </table>
                        </div>
                        <!-- Tambahkan button untuk menambahkan data -->
                        <div class="my-4">
                            <button id="openModal" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Tambah Data
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- Tambahkan modal untuk form input -->
    <div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-1/3 relative">
            <button id="closeModal" class="absolute top-2 right-2 text-red-500 text-2xl">&times;</button>
            <h2 class="text-xl text-gray-600 hover:border-gray-300 font-bold mb-4">Tambah Pertanyaan Kuesioner</h2>
            <input type="text" id="elementName" class="border border-gray-300 p-2 w-full mb-4" placeholder="Nama pertanyaan" />
            <button id="saveElement" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Simpan
            </button>
        </div>
    </div>
    <!-- Tambahkan modal untuk form input ubah data -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-1/3 relative">
            <button id="closeEditModal" class="absolute top-2 right-2 text-red-500 text-2xl">&times;</button>
            <h2 class="text-xl text-gray-600 hover:border-gray-300 font-bold mb-4">Ubah Pertanyaan Kuesioner</h2>
            <input type="text" id="editElementName" class="border border-gray-300 p-2 w-full mb-4" placeholder="Nama elemen" />
            <button id="updateElement" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                Ubah Data
            </button>
        </div>
    </div>

    <script>
        document.getElementById('openModal').onclick = function() {
            document.getElementById('modal').classList.remove('hidden');
        };
        document.getElementById('closeModal').onclick = function() {
            document.getElementById('modal').classList.add('hidden');
        };
        function openEditModal(elementName) {
            document.getElementById('editElementName').value = elementName;
            document.getElementById('editModal').classList.remove('hidden');
        }
        document.getElementById('closeEditModal').onclick = function() {
            document.getElementById('editModal').classList.add('hidden');
        };
    </script>
</body>
</html>
