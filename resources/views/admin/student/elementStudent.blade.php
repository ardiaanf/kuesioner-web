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
                        <h1 class="text-2xl font-bold mb-4">Data Elemen Kuesioner Mahasiswa</h1>
                        <p class="text-gray-600 mb-4">Ini adalah daftar elemen kuesioner yang dapat Anda edit atau hapus. Gunakan tombol 'Tambah Data' untuk menambahkan elemen baru.</p>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300" id="studentElementsTable">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-2 px-4 border-b border-r">No</th>
                                        <th class="py-2 px-4 border-b border-r">Nama elemen</th>
                                        <th class="py-2 px-4 border-b">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan diisi melalui JavaScript -->
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
            <h2 class="text-xl text-gray-600 hover:border-gray-300 font-bold mb-4">Tambah Elemen Kuesioner</h2>
            <input type="text" id="elementName" class="border border-gray-300 p-2 w-full mb-4" placeholder="Nama elemen" />
            <input type="text" id="elementDescription" class="border border-gray-300 p-2 w-full mb-4" placeholder="Deskripsi" />
            <select id="studentQuestionnaireId" class="border border-gray-300 p-2 w-full mb-4">
                <option value="">Pilih Kuesioner Mahasiswa</option>
                <!-- Opsi kuesioner akan diisi melalui JavaScript -->
            </select>
            <button id="saveElement" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="saveElement()">
                Simpan
            </button>
        </div>
    </div>
    <!-- Tambahkan modal untuk form input ubah data -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-1/3 relative">
            <button id="closeEditModal" class="absolute top-2 right-2 text-red-500 text-2xl">&times;</button>
            <h2 class="text-xl text-gray-600 hover:border-gray-300 font-bold mb-4">Ubah Elemen Kuesioner</h2>
            <input type="hidden" id="editElementId" /> <!-- Input tersembunyi untuk ID -->
            <input type="text" id="editElementName" class="border border-gray-300 p-2 w-full mb-4" placeholder="Nama elemen" />
            <input type="text" id="editElementDescription" class="border border-gray-300 p-2 w-full mb-4" placeholder="Deskripsi" />
            <select id="editStudentQuestionnaireId" class="border border-gray-300 p-2 w-full mb-4">
                <option value="">Pilih Kuesioner Mahasiswa</option>
                <!-- Opsi kuesioner akan diisi melalui JavaScript -->
            </select>
            <button id="updateElement" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600" onclick="updateElement()">
                Ubah Data
            </button>
        </div>
    </div>

    <script>
        const BASE_URL = 'http://127.0.0.1:8000';
        const token = localStorage.getItem('access_token');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Ambil token CSRF

        async function fetchStudentElements() {
            const response = await fetch(`${BASE_URL}/api/admin/student-elements`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                const tableBody = document.querySelector('#studentElementsTable tbody');
                tableBody.innerHTML = ''; // Clear existing data

                data.data.forEach((element, index) => {
                    const row = `
                        <tr>
                            <td class="py-2 px-4 border-b border-r">${index + 1}</td>
                            <td class="py-2 px-4 border-b border-r">${element.name}</td>
                            <td class="py-2 px-4 border-b">
                                <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600" onclick="openEditModal(${element.id}, '${element.name}', '${element.description}', ${element.student_questionnaire_id})">
                                    Ubah
                                </button>
                                <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 ml-2" onclick="deleteElement(${element.id})">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            } else {
                alert('Gagal mengambil data elemen.');
            }
        }

        async function deleteElement(id) {
            if (confirm('Apakah Anda yakin ingin menghapus elemen ini?')) {
                const response = await fetch(`${BASE_URL}/api/admin/student-elements/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken // Tambahkan token CSRF ke header
                    }
                });

                if (response.ok) {
                    alert('Data berhasil dihapus.');
                    fetchStudentElements(); // Refresh the table
                } else {
                    alert('Gagal menghapus data.');
                }
            }
        }

        async function fetchStudentQuestionnaires() {
            const response = await fetch(`${BASE_URL}/api/admin/student-questionnaires`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                const select = document.getElementById('studentQuestionnaireId');
                const editSelect = document.getElementById('editStudentQuestionnaireId');
                select.innerHTML = '<option value="">Pilih Kuesioner Mahasiswa</option>'; // Clear existing options
                editSelect.innerHTML = '<option value="">Pilih Kuesioner Mahasiswa</option>'; // Clear existing options

                data.data.forEach(questionnaire => {
                    const option = document.createElement('option');
                    option.value = questionnaire.id;
                    option.textContent = questionnaire.name; // Ganti dengan nama yang sesuai
                    select.appendChild(option);
                    const editOption = option.cloneNode(true); // Clone option for edit select
                    editSelect.appendChild(editOption);
                });
            } else {
                alert('Gagal mengambil data kuesioner.');
            }
        }

        function openEditModal(id, name, description, studentQuestionnaireId) {
            document.getElementById('editElementId').value = id; // Set ID ke input tersembunyi
            document.getElementById('editElementName').value = name;
            document.getElementById('editElementDescription').value = description;

            // Ambil data kuesioner dan set nilai select
            fetchStudentQuestionnaires().then(() => {
                const editSelect = document.getElementById('editStudentQuestionnaireId');
                editSelect.value = studentQuestionnaireId; // Set value untuk select
            });

            document.getElementById('editModal').classList.remove('hidden'); // Menampilkan modal
        }

        async function updateElement() {
            const id = document.getElementById('editElementId').value; // Ambil ID dari input tersembunyi
            const name = document.getElementById('editElementName').value;
            const description = document.getElementById('editElementDescription').value;
            const studentQuestionnaireId = document.getElementById('editStudentQuestionnaireId').value;

            const response = await fetch(`${BASE_URL}/api/admin/student-elements/${id}`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Tambahkan token CSRF ke header
                },
                body: JSON.stringify({
                    name,
                    description,
                    student_questionnaire_id: studentQuestionnaireId
                })
            });

            if (response.ok) {
                alert('Data berhasil diubah.');
                fetchStudentElements(); // Refresh the table
                document.getElementById('editModal').classList.add('hidden'); // Close the modal
                document.getElementById('editElementName').value = ''; // Clear input
                document.getElementById('editElementDescription').value = ''; // Clear input
                document.getElementById('editStudentQuestionnaireId').value = ''; // Clear input
            } else {
                alert('Gagal mengubah data.');
            }
        }

        // Menambahkan event listener untuk tombol "Tambah Data"
        document.getElementById('openModal').onclick = function() {
            document.getElementById('modal').classList.remove('hidden'); // Menampilkan modal
        };

        // Menambahkan event listener untuk tombol tutup modal
        document.getElementById('closeModal').onclick = function() {
            document.getElementById('modal').classList.add('hidden'); // Menyembunyikan modal
        };

        // Menambahkan event listener untuk tombol tutup modal edit
        document.getElementById('closeEditModal').onclick = function() {
            document.getElementById('editModal').classList.add('hidden'); // Menyembunyikan modal edit
        };

        document.addEventListener('DOMContentLoaded', () => {
            fetchStudentElements();
            fetchStudentQuestionnaires(); // Fetch questionnaires when the page loads
        });
    </script>
</body>
</html>
