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
                        <h1 class="text-2xl font-bold mb-4">Data Elemen Kuesioner Dosen</h1>
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
            <h2 class="text-xl text-gray-600 hover:border-gray-300 font-bold mb-4">Tambah Elemen Kuesioner</h2>
            <label class="block mb-2">Nama Elemen</label> <!-- Tambahkan label -->
            <input type="text" id="elementName" class="border border-gray-300 p-2 w-full mb-4" placeholder="Nama elemen" />
            <label class="block mb-2">Deskripsi</label> <!-- Tambahkan label -->
            <input type="text" id="elementDescription" class="border border-gray-300 p-2 w-full mb-4" placeholder="Deskripsi" />
            <label class="block mb-2">Kuesioner Dosen</label> <!-- Tambahkan label -->
            <select id="lecturerQuestionnaireId" class="border border-gray-300 p-2 w-full mb-4" aria-label="Kuesioner Dosen"> <!-- Tambahkan aria-label -->
                <option value="">Pilih Kuesioner Dosen</option>
                <!-- Opsi kuesioner akan diisi melalui JavaScript -->
            </select>
            <div class="flex justify-between">
                <button id="saveElement" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="saveElement()">
                    Simpan
                </button>
                <button id="closeModal" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 absolute bottom-2 right-2" onclick="closeModal()">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    <!-- Tambahkan modal untuk form input ubah data -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-1/3 relative">
            <h2 class="text-xl text-gray-600 hover:border-gray-300 font-bold mb-4">Ubah Elemen Kuesioner</h2>
            <input type="hidden" id="editElementId" /> <!-- Input tersembunyi untuk ID -->
            <label class="block mb-2">Nama Elemen</label> <!-- Tambahkan label -->
            <input type="text" id="editElementName" class="border border-gray-300 p-2 w-full mb-4" placeholder="Nama elemen" />
            <label class="block mb-2">Deskripsi</label> <!-- Tambahkan label -->
            <input type="text" id="editElementDescription" class="border border-gray-300 p-2 w-full mb-4" placeholder="Deskripsi" />
            <label class="block mb-2">Kuesioner Dosen</label> <!-- Tambahkan label -->
            <select id="editLecturerQuestionnaireId" class="border border-gray-300 p-2 w-full mb-4" aria-label="Kuesioner Dosen">
                <option value="">Pilih Kuesioner Dosen</option>
                <!-- Opsi kuesioner akan diisi melalui JavaScript -->
            </select>
            <div class="flex justify-between">
                <button id="updateElement" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600" onclick="updateElement()">
                    Ubah Data
                </button>
                <button id="closeEditModal" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 absolute bottom-2 right-2" onclick="closeEditModal()">
                    Tutup
                </button>
            </div>
            
        </div>
    </div>

    <!-- Modal untuk menampilkan detail -->
    <div id="detailModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-1/3 relative max-h-3/4 overflow-y-auto"> <!-- Tambahkan max-h-3/4 dan overflow-y-auto -->
            <h2 class="text-xl font-bold mb-4">Detail Elemen Kuesioner</h2>
            <div id="detailContent"></div>
            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 mt-4" onclick="closeDetailModal()">
                Tutup
            </button>
        </div>
    </div>

    <script>
        const BASE_URL = 'http://127.0.0.1:8000';
        const token = localStorage.getItem('access_token');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Ambil token CSRF

        // Definisikan fungsi closeModal
        function closeModal() {
            document.getElementById('modal').classList.add('hidden'); // Menyembunyikan modal
        }

        // Definisikan fungsi closeEditModal
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden'); // Menyembunyikan modal edit
        }

        async function fetchlecturerElements() {
            const response = await fetch(`${BASE_URL}/api/admin/lecturer-elements`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                const tableBody = document.querySelector('#lecturerElementsTable tbody');
                tableBody.innerHTML = ''; // Clear existing data

                data.data.forEach((element, index) => {
                    const row = `
                        <tr>
                            <td class="py-2 px-4 border-b border-r">${index + 1}</td>
                            <td class="py-2 px-4 border-b border-r">${element.name}</td>
                            <td class="py-2 px-4 border-b">
                                <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600" onclick="openEditModal(${element.id}, '${element.name}', '${element.description}', ${element.lecturer_questionnaire_id})">
                                    Ubah
                                </button>
                                <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 ml-2" onclick="deleteElement(${element.id})">
                                    Hapus
                                </button>
                                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 ml-2" onclick="showDetail(${element.id})">
                                    Detail
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
                const response = await fetch(`${BASE_URL}/api/admin/lecturer-elements/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken // Tambahkan token CSRF ke header
                    }
                });

                if (response.ok) {
                    alert('Data berhasil dihapus.');
                    fetchlecturerElements(); // Refresh the table
                } else {
                    alert('Gagal menghapus data.');
                }
            }
        }

        async function fetchlecturerQuestionnaires() {
            const response = await fetch(`${BASE_URL}/api/admin/lecturer-questionnaires`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                const select = document.getElementById('lecturerQuestionnaireId');
                const editSelect = document.getElementById('editLecturerQuestionnaireId');
                select.innerHTML = '<option value="">Pilih Kuesioner Dosen</option>'; // Clear existing options
                editSelect.innerHTML = '<option value="">Pilih Kuesioner Dosen</option>'; // Clear existing options

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

        function openEditModal(id, name, description, lecturerQuestionnaireId) {
            document.getElementById('editElementId').value = id; // Set ID ke input tersembunyi
            document.getElementById('editElementName').value = name;
            document.getElementById('editElementDescription').value = description;

            // Ambil data kuesioner dan set nilai select
            fetchlecturerQuestionnaires().then(() => {
                const editSelect = document.getElementById('editLecturerQuestionnaireId');
                editSelect.value = lecturerQuestionnaireId; // Set value untuk select

                // Cek apakah value yang di-set ada dalam opsi
                const optionExists = Array.from(editSelect.options).some(option => option.value == lecturerQuestionnaireId);
                if (!optionExists) {
                    console.error(`Kuesioner Dosen dengan ID ${lecturerQuestionnaireId} tidak ditemukan dalam opsi.`);
                    alert('Kuesioner Dosen yang dipilih tidak valid.');
                }
           

                for (let option of editSelect.options) {
                    if (option.value == lecturerQuestionnaireId) {
                        option.selected = true;
                        break;
                    }
                }
            });

            document.getElementById('editModal').classList.remove('hidden'); // Menampilkan modal
        }

        async function updateElement() {
            const id = document.getElementById('editElementId').value; // Ambil ID dari input tersembunyi
            const name = document.getElementById('editElementName').value;
            const description = document.getElementById('editElementDescription').value;
            const lecturerQuestionnaireId = document.getElementById('editLecturerQuestionnaireId').value;

            // Tambahkan validasi untuk lecturerQuestionnaireId
            if (!lecturerQuestionnaireId) {
                alert('Kuesioner Dosen harus dipilih');
                return;
            }

            const response = await fetch(`${BASE_URL}/api/admin/lecturer-elements/${id}`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${token}`,
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
                alert('Data berhasil diubah.');
                fetchlecturerElements(); // Refresh the table
                closeEditModal(); // Close the modal
            } else {
                const errorData = await response.json(); // Ambil detail error
                console.error('Error Data:', errorData); // Log error data
                alert(`Gagal mengubah data: ${errorData.message || 'Tidak ada pesan error.'}`); // Tampilkan pesan error
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
            closeEditModal(); // Panggil fungsi untuk menutup modal edit
        };

        document.addEventListener('DOMContentLoaded', () => {
            fetchlecturerElements();
            fetchlecturerQuestionnaires(); // Fetch questionnaires when the page loads
        });

        // Pastikan fungsi saveElement didefinisikan
        async function saveElement() {
            const token = localStorage.getItem('access_token');
            if (!token) {
                alert('Anda belum login. Silakan login terlebih dahulu.');
                window.location.href = `${BASE_URL}/auth/admin`;
                return;
            }

            const name = document.getElementById('elementName').value;
            const description = document.getElementById('elementDescription').value;
            const lecturerQuestionnaireId = document.getElementById('lecturerQuestionnaireId').value;

            if (!name) {
                alert('Nama elemen harus diisi');
                return;
            }

            // Tambahkan validasi untuk lecturerQuestionnaireId
            if (!lecturerQuestionnaireId) {
                alert('Kuesioner Dosen harus dipilih');
                return;
            }

            try {
                const response = await fetch(`${BASE_URL}/api/admin/lecturer-elements`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        name,
                        description,
                        lecturer_questionnaire_id: lecturerQuestionnaireId
                    })
                });

                console.log('Response:', response); // Tambahkan log untuk melihat respons

                if (response.ok) {
                    alert('Data berhasil ditambahkan.');
                    fetchlecturerElements(); // Refresh the table
                    closeModal(); // Close the modal
                } else {
                    const errorData = await response.json(); // Tambahkan ini untuk mendapatkan detail error
                    console.error('Error Data:', errorData); // Log error data
                    alert(`Gagal menambahkan data: ${errorData.message || 'Tidak ada pesan error.'}`); // Tampilkan pesan error
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menambahkan data.');
            }
        }

        async function showDetail(id) {
            const response = await fetch(`${BASE_URL}/api/admin/lecturer-elements/${id}/relations`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                displayDetail(data.data); // Panggil fungsi untuk menampilkan detail
            } else {
                alert('Gagal mengambil detail elemen.');
            }
        }

        async function displayDetail(element) {
            const detailModal = document.getElementById('detailModal');
            const detailContent = document.getElementById('detailContent');

            detailContent.innerHTML = `
                <p><strong>Nama elemen :</strong> ${element.name}</p>
                <p><strong>Deskripsi:</strong> ${element.description || 'Tidak ada deskripsi'}</p>
                <h3 class="font-bold">Pertanyaan:</h3>
                <ul>
                    ${Array.isArray(element.lecturer_questions) && element.lecturer_questions.length > 0
                        ? element.lecturer_questions.map(question => `
                            <li>
                                <strong>${question.question}</strong><br>
                                ${question.label.join(', ')}
                            </li>
                        `).join('')
                        : '<li>Tidak ada pertanyaan tersedia.</li>'}
                </ul>
            `;

            detailModal.classList.remove('hidden'); // Tampilkan modal detail
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden'); // Menyembunyikan modal detail
        }
    </script>
</body>

</html>