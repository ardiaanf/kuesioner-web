<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kuesioner</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleModal() {
            const modal = document.getElementById('modal');
            modal.classList.toggle('hidden');
        }
    </script>
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
                        <h1 class="text-2xl font-bold mb-4">Data elemen kuesioner tenaga kependidikan</h1>
                        <p class="text-gray-600 mb-4">Ini adalah daftar elemen kuesioner yang dapat Anda edit atau hapus. Gunakan tombol 'Tambah Data' untuk menambahkan elemen baru.</p>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-2 px-4 border-b border-r">No</th>
                                        <th class="py-2 px-4 border-b border-r">Nama elemen</th>
                                        <th class="py-2 px-4 border-b">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="py-2 px-4 border-b border-r">1</td>
                                        <td class="py-2 px-4 border-b border-r">Apa pendapat Anda tentang layanan kami?</td>
                                        <td class="py-2 px-4 border-b">
                                            <button onclick="openEditModal('Apa pendapat Anda tentang layanan kami?')" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
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
                            <button onclick="toggleModal()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Tambah Data
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg">
            <h2 class="text-xl font-bold mb-4">Tambah Elemen Kuesioner</h2>
            <input type="text" placeholder="Nama elemen" class="border border-gray-300 p-2 mb-4 w-full" />
            <div class="flex justify-between">
                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Simpan
                </button>
                <button onclick="toggleModal()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg">
            <h2 class="text-xl font-bold mb-4">Ubah Elemen Kuesioner</h2>
            <input type="text" id="editElementName" placeholder="Nama elemen" class="border border-gray-300 p-2 mb-4 w-full" />
            <div class="flex justify-between">
                <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600" onclick="saveEdit()">
                    Ubah
                </button>
                <button onclick="toggleEditModal()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        function openEditModal(elementName) {
            document.getElementById('editElementName').value = elementName;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function toggleEditModal() {
            const editModal = document.getElementById('editModal');
            editModal.classList.toggle('hidden');
        }

        function saveEdit() {
            // Logic to save the edited element
            toggleEditModal();
        }
    </script>
</body>
</html>
