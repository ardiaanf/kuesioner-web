<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kuesioner</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Tambahkan ini -->
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
                            <table class="min-w-full bg-white border border-gray-300" id="questionnaire-table">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-2 px-4 border-b border-r">No</th>
                                        <th class="py-2 px-4 border-b border-r">Nama Kuesioner</th>
                                        <th class="py-2 px-4 border-b">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan diisi di sini -->
                                </tbody>
                            </table>
                            <div class="mt-4">
                                <button class="bg-blue-500 text-white px-4 py-2 rounded" onclick="openAddModal()">Tambah Data</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal untuk Tambah Data -->
    <div id="add-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-1/3">
            <h2 class="text-xl font-bold mb-4">Tambah Kuesioner</h2>
            <label class="block mb-2">Nama Kuesioner</label>
            <input type="text" id="add-name" class="border border-gray-300 rounded w-full mb-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400" placeholder="Masukkan nama kuesioner">
            <label class="block mb-2">Deskripsi</label>
            <textarea id="add-description" class="border border-gray-300 rounded w-full mb-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400" placeholder="Masukkan deskripsi kuesioner"></textarea>
            <div class="flex justify-between">
                <button class="bg-blue-500 text-white px-4 py-2 rounded" onclick="addQuestionnaire()">Simpan</button>
                <button class="bg-red-500 text-white px-4 py-2 rounded" onclick="closeAddModal()">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal untuk Ubah Data -->
    <div id="edit-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-1/3">
            <h2 class="text-xl font-bold mb-4">Ubah Kuesioner</h2>
            <label class="block mb-2">Nama Kuesioner</label>
            <input type="text" id="edit-name" class="border border-gray-300 rounded w-full mb-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400">
            <label class="block mb-2">Deskripsi</label>
            <textarea id="edit-description" class="border border-gray-300 rounded w-full mb-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400"></textarea>
            <div class="flex justify-between">
                <button class="bg-green-500 text-white px-4 py-2 rounded" onclick="updateQuestionnaire()">Ubah</button>
                <button class="bg-red-500 text-white px-4 py-2 rounded" onclick="closeEditModal()">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        const BASE_URL = 'http://127.0.0.1:8000';
        const token = localStorage.getItem('access_token');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Ambil token CSRF
        let currentQuestionnaireId = null; // Untuk menyimpan ID kuesioner yang sedang diedit

        async function fetchQuestionnaires() {
            const response = await fetch(`${BASE_URL}/api/admin/lecturer-questionnaires`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                const tbody = document.querySelector('#questionnaire-table tbody');
                tbody.innerHTML = ''; // Clear existing data

                data.data.forEach((item, index) => {
                    const row = `
                        <tr>
                            <td class="py-2 px-4 border-b border-r">${index + 1}</td>
                            <td class="py-2 px-4 border-b border-r">${item.name}</td>
                            <td class="py-2 px-4 border-b">
                                <button class="bg-yellow-500 text-white px-4 py-2 rounded" onclick="openEditModal('${item.id}', '${item.name}', '${item.description}')">Ubah</button>
                                <button class="bg-red-500 text-white px-4 py-2 rounded" onclick="deleteQuestionnaire('${item.id}')">Hapus</button>
                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });
            } else {
                console.error('Failed to fetch questionnaires:', response.statusText);
            }
        }

        async function addQuestionnaire() {
            const name = document.getElementById('add-name').value;
            const description = document.getElementById('add-description').value;

            const response = await fetch(`${BASE_URL}/api/admin/lecturer-questionnaires`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Sertakan token CSRF
                },
                body: JSON.stringify({ name, description })
            });

            if (response.ok) {
                alert('Kuesioner berhasil ditambahkan!'); // Tambahkan alert berhasil
                closeAddModal();
                fetchQuestionnaires(); // Refresh the list
            } else {
                console.error('Failed to add questionnaire:', response.statusText);
            }
        }

        async function deleteQuestionnaire(id) {
            if (confirm('Apakah Anda yakin ingin menghapus kuesioner ini?')) {
                const response = await fetch(`${BASE_URL}/api/admin/lecturer-questionnaires/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken // Sertakan token CSRF
                    }
                });

                if (response.ok) {
                    alert('Kuesioner berhasil dihapus!'); // Tambahkan alert berhasil
                    fetchQuestionnaires(); // Refresh the list
                } else {
                    console.error('Failed to delete questionnaire:', response.statusText);
                }
            }
        }

        function openEditModal(id, name, description) {
            currentQuestionnaireId = id; // Simpan ID kuesioner yang akan diedit
            document.getElementById('edit-name').value = name; // Isi nama kuesioner
            document.getElementById('edit-description').value = description; // Isi deskripsi kuesioner
            document.getElementById('edit-modal').classList.remove('hidden'); // Tampilkan modal
        }

        async function updateQuestionnaire() {
            const name = document.getElementById('edit-name').value;
            const description = document.getElementById('edit-description').value;

            const response = await fetch(`${BASE_URL}/api/admin/lecturer-questionnaires/${currentQuestionnaireId}`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Sertakan token CSRF
                },
                body: JSON.stringify({ name, description })
            });

            if (response.ok) {
                alert('Kuesioner berhasil diubah!'); // Tambahkan alert berhasil
                closeEditModal();
                fetchQuestionnaires(); // Refresh the list
            } else {
                console.error('Failed to update questionnaire:', response.statusText);
            }
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
            document.getElementById('edit-name').value = ''; // Clear input
            document.getElementById('edit-description').value = ''; // Clear input
        }

        function openAddModal() {
            document.getElementById('add-modal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('add-modal').classList.add('hidden');
            document.getElementById('add-name').value = ''; // Clear input
            document.getElementById('add-description').value = ''; // Clear input
        }

        // Fetch questionnaires on page load
        fetchQuestionnaires();
    </script>
</body>
</html>
