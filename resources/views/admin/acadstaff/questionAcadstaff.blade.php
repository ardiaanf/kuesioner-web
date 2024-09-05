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
                        <h1 class="text-2xl font-bold mb-4">Data pertanyaan kuesioner tenaga kependidikan</h1>
                        <p class="text-gray-600 mb-4">Ini adalah daftar pertanyaan kuesioner yang dapat Anda edit atau hapus. Gunakan tombol 'Tambah Data' untuk menambahkan pertanyaan baru.</p>
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
                                            <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600" onclick="openModal()">
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
                            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="openAddModal()">
                                Tambah Data
                            </button>
                        </div>
                        <!-- Tambahkan modal untuk form input -->
                        <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                            <div class="bg-white rounded-lg p-6 w-1/3">
                                <h2 class="text-xl font-bold mb-4">Ubah Pertanyaan</h2>
                                <input type="text" id="questionInput" class="border border-gray-300 p-2 w-full mb-4" placeholder="Nama pertanyaan">
                                <div class="flex justify-between">
                                    <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600" onclick="saveChanges()">
                                        Ubah
                                    </button>
                                    <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="closeModal()">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Tambahkan modal untuk menambahkan pertanyaan baru -->
                        <div id="addModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                            <div class="bg-white rounded-lg p-6 w-1/3">
                                <h2 class="text-xl font-bold mb-4">Tambah Pertanyaan</h2>
                                <input type="text" id="newQuestionInput" class="border border-gray-300 p-2 w-full mb-4" placeholder="Nama pertanyaan">
                                <div class="flex justify-between">
                                    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="saveNewQuestion()">
                                        Simpan
                                    </button>
                                    <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="closeAddModal()">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        function openModal() {
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function saveChanges() {
            // Logika untuk menyimpan perubahan
            closeModal();
        }

        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        function saveNewQuestion() {
            // Logika untuk menyimpan pertanyaan baru
            closeAddModal();
        }
    </script>
</body>
</html>
