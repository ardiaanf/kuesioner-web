<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kuesioner</title>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @vite('resources/css/app.css')
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
                        <h1 class="text-2xl font-bold mb-4">Data elemen kuesioner dosen</h1>
                        <p class="text-gray-600 mb-4">Ini adalah daftar elemen kuesioner yang dapat Anda edit atau hapus. Gunakan tombol 'Tambah Data' untuk menambahkan elemen baru.</p>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300" id="lecturerElementsTable">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-2 px-4 border-b border-r">No</th>
                                        <th class="py-2 px-4 border-b border-r">Nama elemen</th>
                                        <th class="py-2 px-4 border-b">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan ditambahkan di sini -->
                                </tbody>
                            </table>
                        </div>
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

    <!-- Modal untuk Tambah Data -->
    <div id="modal" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg">
            <h2 class="text-xl font-bold mb-4">Tambah Elemen Kuesioner</h2>
            <label for="elementName" class="block text-sm font-medium text-gray-700">Nama Elemen</label>
            <input type="text" id="elementName" placeholder="Nama elemen" class="border border-gray-300 p-2 mb-4 w-full" />
            <label for="elementDescription" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <input type="text" id="elementDescription" placeholder="Deskripsi" class="border border-gray-300 p-2 mb-4 w-full" />
            <label for="lecturerQuestionnaireId" class="block text-sm font-medium text-gray-700">Kuesioner Dosen</label>
            <select id="lecturerQuestionnaireId" class="border border-gray-300 p-2 mb-4 w-full">
                <!-- Opsi akan diisi di sini -->
            </select>
            <div class="flex justify-between">
                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="addLecturerElement()">
                    Simpan
                </button>
                <button onclick="toggleModal()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Modal untuk Ubah Data -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg">
            <h2 class="text-xl font-bold mb-4">Ubah Elemen Kuesioner</h2>
            <input type="hidden" id="editElementId" />
            <label for="editElementName" class="block text-sm font-medium text-gray-700">Nama Elemen</label>
            <input type="text" id="editElementName" placeholder="Nama elemen" class="border border-gray-300 p-2 mb-4 w-full" />
            <label for="editElementDescription" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <input type="text" id="editElementDescription" placeholder="Deskripsi" class="border border-gray-300 p-2 mb-4 w-full" />
            <label for="editLecturerQuestionnaireId" class="block text-sm font-medium text-gray-700">Kuesioner Dosen</label>
            <select id="editLecturerQuestionnaireId" class="border border-gray-300 p-2 mb-4 w-full">
                <!-- Opsi akan diisi di sini -->
            </select>
            <div class="flex justify-between">
                <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600" onclick="updateLecturerElement()">
                    Ubah
                </button>
                <button onclick="toggleEditModal()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        const BASE_URL = 'http://127.0.0.1:8000';
        const accessToken = localStorage.getItem('access_token');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Ambil token CSRF

        async function fetchLecturerElements() {
            const response = await fetch(`${BASE_URL}/api/admin/lecturer-elements`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                const tableBody = document.querySelector('#lecturerElementsTable tbody');
                tableBody.innerHTML = ''; // Clear existing rows

                data.data.forEach((element, index) => {
                    const row = `
                        <tr>
                            <td class="py-2 px-4 border-b border-r">${index + 1}</td>
                            <td class="py-2 px-4 border-b border-r">${element.name}</td>
                            <td class="py-2 px-4 border-b">
                                <button onclick="openEditModal(${element.id}, '${element.name}', '${element.description}', ${element.lecturer_questionnaire_id})" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                                    Ubah
                                </button>
                                <button onclick="deleteLecturerElement(${element.id})" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 ml-2">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            } else {
                alert('Gagal mengambil data elemen dosen.');
            }
        }

        async function deleteLecturerElement(id) {
            if (confirm('Apakah Anda yakin ingin menghapus elemen ini?')) {
                const response = await fetch(`${BASE_URL}/api/admin/lecturer-elements/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken // Tambahkan token CSRF ke header
                    }
                });

                if (response.ok) {
                    alert('Elemen kuesioner berhasil dihapus.');
                    fetchLecturerElements(); // Refresh the table
                } else {
                    const errorData = await response.json();
                    alert('Gagal menghapus elemen kuesioner: ' + (errorData.message || 'Terjadi kesalahan.'));
                }
            }
        }

        async function fetchLecturerQuestionnaires() {
            const response = await fetch(`${BASE_URL}/api/admin/lecturer-questionnaires`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                const select = document.getElementById('lecturerQuestionnaireId');
                const editSelect = document.getElementById('editLecturerQuestionnaireId');
                select.innerHTML = ''; // Clear existing options
                editSelect.innerHTML = ''; // Clear existing options

                data.data.forEach(questionnaire => {
                    const option = document.createElement('option');
                    option.value = questionnaire.id;
                    option.textContent = questionnaire.name; // Ganti dengan nama yang sesuai
                    select.appendChild(option);

                    const editOption = document.createElement('option');
                    editOption.value = questionnaire.id;
                    editOption.textContent = questionnaire.name; // Ganti dengan nama yang sesuai
                    editSelect.appendChild(editOption);
                });
            } else {
                alert('Gagal mengambil data kuesioner dosen.');
            }
        }

        async function addLecturerElement() {
            const name = document.getElementById('elementName').value;
            const description = document.getElementById('elementDescription').value;
            const lecturerQuestionnaireId = document.getElementById('lecturerQuestionnaireId').value;

            const response = await fetch(`${BASE_URL}/api/admin/lecturer-elements`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Tambahkan token CSRF ke header
                },
                body: JSON.stringify({
                    name,
                    description,
                    lecturer_questionnaire_id: lecturerQuestionnaireId
                })
            });

            if (response.ok) {
                alert('Elemen kuesioner berhasil ditambahkan.');
                toggleModal();
                fetchLecturerElements(); // Refresh the table
            } else {
                const errorData = await response.json();
                alert('Gagal menambahkan elemen kuesioner: ' + (errorData.message || 'Terjadi kesalahan.'));
            }
        }

        function toggleModal() {
            const modal = document.getElementById('modal');
            modal.classList.toggle('hidden');
            if (!modal.classList.contains('hidden')) {
                fetchLecturerQuestionnaires(); // Fetch questionnaires when modal is opened
            }
        }

        function toggleEditModal() {
            const editModal = document.getElementById('editModal');
            editModal.classList.toggle('hidden');
        }

        function openEditModal(id, name, description, lecturerQuestionnaireId) {
            document.getElementById('editElementId').value = id;
            document.getElementById('editElementName').value = name;
            document.getElementById('editElementDescription').value = description;
            document.getElementById('editLecturerQuestionnaireId').value = lecturerQuestionnaireId;
            toggleEditModal();
            fetchLecturerQuestionnaires(); // Fetch questionnaires when edit modal is opened
        }

        async function updateLecturerElement() {
            const id = document.getElementById('editElementId').value;
            const name = document.getElementById('editElementName').value;
            const description = document.getElementById('editElementDescription').value;
            const lecturerQuestionnaireId = document.getElementById('editLecturerQuestionnaireId').value;

            const response = await fetch(`${BASE_URL}/api/admin/lecturer-elements/${id}`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Tambahkan token CSRF ke header
                },
                body: JSON.stringify({
                    name,
                    description,
                    lecturer_questionnaire_id: lecturerQuestionnaireId
                })
            });

            if (response.ok) {
                alert('Elemen kuesioner berhasil diubah.');
                toggleEditModal();
                fetchLecturerElements(); // Refresh the table
            } else {
                const errorData = await response.json();
                alert('Gagal mengubah elemen kuesioner: ' + (errorData.message || 'Terjadi kesalahan.'));
            }
        }

        // Panggil fungsi untuk mengambil data saat halaman dimuat
        document.addEventListener('DOMContentLoaded', fetchLecturerElements);
    </script>
</body>
</html>
