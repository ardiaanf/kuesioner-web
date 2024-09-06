<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kuesioner</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <h1 class="text-2xl font-bold mb-4">Jenis Kuesioner Tenaga Kependidikan</h1>
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
            <textarea id="add-description" class="border border-gray-300 rounded w-full mb-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400" placeholder="Masukkan deskripsi"></textarea>

            <div class="flex justify-between">
                <button class="bg-blue-500 text-white px-4 py-2 rounded" onclick="addQuestionnaire()">Simpan</button>
                <button class="bg-red-500 text-white px-4 py-2 rounded" onclick="closeAddModal()">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal untuk Edit Data -->
    <div id="edit-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-1/3">
            <h2 class="text-xl font-bold mb-4">Ubah Kuesioner</h2>
            <label class="block mb-2">Nama Kuesioner</label>
            <input type="text" id="edit-name" class="border border-gray-300 rounded w-full mb-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400">
            <label class="block mb-2">Deskripsi</label>
            <textarea id="edit-description" class="border border-gray-300 rounded w-full mb-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400"></textarea>

            <div class="flex justify-between">
                <button class="bg-blue-500 text-white px-4 py-2 rounded" onclick="updateQuestionnaire()">Ubah</button>
                <button class="bg-red-500 text-white px-4 py-2 rounded" onclick="closeEditModal()">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        const BASE_URL = 'http://127.0.0.1:8000';
        const token = localStorage.getItem('access_token');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let currentQuestionnaireId = null; // Variable to hold the current questionnaire ID

        async function fetchQuestionnaires() {
            const response = await fetch(`${BASE_URL}/api/admin/acadstaff-questionnaires`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                const tableBody = document.querySelector('#questionnaire-table tbody');
                tableBody.innerHTML = ''; // Clear existing rows

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
                    tableBody.innerHTML += row;
                });
            } else {
                console.error('Failed to fetch questionnaires:', response.statusText);
            }
        }

        function openAddModal() {
            document.getElementById('add-modal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('add-modal').classList.add('hidden');
            document.getElementById('add-name').value = ''; // Clear input
            document.getElementById('add-description').value = ''; // Clear input
        }

        function openEditModal(id, name, description) {
            currentQuestionnaireId = id; // Set the current questionnaire ID
            document.getElementById('edit-name').value = name; // Set the name in the edit modal
            document.getElementById('edit-description').value = description; // Set the description in the edit modal
            document.getElementById('edit-modal').classList.remove('hidden'); // Show the edit modal
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
            currentQuestionnaireId = null; // Clear the current questionnaire ID
            document.getElementById('edit-name').value = ''; // Clear input
            document.getElementById('edit-description').value = ''; // Clear input
        }

        async function addQuestionnaire() {
            const name = document.getElementById('add-name').value;
            const description = document.getElementById('add-description').value;

            const response = await fetch(`${BASE_URL}/api/admin/acadstaff-questionnaires`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Include CSRF token
                },
                body: JSON.stringify({ name, description })
            });

            if (response.ok) {
                alert('Kuesioner berhasil ditambahkan!'); // Alert on success
                closeAddModal();
                fetchQuestionnaires(); // Refresh the table
            } else {
                console.error('Failed to add questionnaire:', response.statusText);
            }
        }

        async function updateQuestionnaire() {
            const name = document.getElementById('edit-name').value;
            const description = document.getElementById('edit-description').value;

            const response = await fetch(`${BASE_URL}/api/admin/acadstaff-questionnaires/${currentQuestionnaireId}`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Include CSRF token
                },
                body: JSON.stringify({ name, description })
            });

            if (response.ok) {
                alert('Kuesioner berhasil diubah!'); // Alert on success
                closeEditModal();
                fetchQuestionnaires(); // Refresh the table
            } else {
                console.error('Failed to update questionnaire:', response.statusText);
            }
        }

        async function deleteQuestionnaire(id) {
            if (confirm('Apakah Anda yakin ingin menghapus kuesioner ini?')) {
                const response = await fetch(`${BASE_URL}/api/admin/acadstaff-questionnaires/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken // Include CSRF token
                    }
                });

                if (response.ok) {
                    alert('Kuesioner berhasil dihapus!'); // Alert on success
                    fetchQuestionnaires(); // Refresh the table
                } else {
                    console.error('Failed to delete questionnaire:', response.statusText);
                }
            }
        }

        // Fetch questionnaires on page load
        document.addEventListener('DOMContentLoaded', fetchQuestionnaires);
    </script>
</body>
</html>
