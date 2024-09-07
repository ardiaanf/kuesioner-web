<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kuesioner</title>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                                    <!-- Data akan diisi di sini -->
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

    <!-- Modal Tambah -->
    <div id="modal" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg">
            <h2 class="text-xl font-bold mb-4">Tambah Elemen Kuesioner</h2>
            <label for="newElementName" class="block text-sm font-medium text-gray-700">Nama Elemen</label>
            <input type="text" id="newElementName" placeholder="Nama elemen" class="border border-gray-300 p-2 mb-4 w-full" writingsuggestions="true" />
            <label for="newDescription" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <input type="text" id="newDescription" placeholder="Deskripsi" class="border border-gray-300 p-2 mb-4 w-full" />
            <label for="acadStaffQuestionnaireId" class="block text-sm font-medium text-gray-700">Kuesioner</label>
            <select id="acadStaffQuestionnaireId" class="border border-gray-300 p-2 mb-4 w-full">
                <option value="">Pilih Kuesioner</option>
                <!-- Options akan diisi di sini -->
            </select>
            <div class="flex justify-between">
                <button onclick="saveNewElement()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
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
            <input type="hidden" id="editElementId" /> <!-- Input tersembunyi untuk ID -->
            <label for="editElementName" class="block text-sm font-medium text-gray-700">Nama Elemen</label>
            <input type="text" id="editElementName" placeholder="Nama elemen" class="border border-gray-300 p-2 mb-4 w-full" />
            <label for="editDescription" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <input type="text" id="editDescription" placeholder="Deskripsi" class="border border-gray-300 p-2 mb-4 w-full" />
            <label for="editAcadStaffQuestionnaireId" class="block text-sm font-medium text-gray-700">Kuesioner</label>
            <select id="editAcadStaffQuestionnaireId" class="border border-gray-300 p-2 mb-4 w-full">
                <option value="">Pilih Kuesioner</option>
                <!-- Options akan diisi di sini -->
            </select>
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
        // Modal Functions
        function toggleModal() {
            const modal = document.getElementById('modal');
            modal.classList.toggle('hidden');
            if (!modal.classList.contains('hidden')) {
                fetchAcadStaffQuestionnaires(); // Fetch options when modal is opened
            }
        }

        function toggleEditModal() {
            const editModal = document.getElementById('editModal');
            editModal.classList.toggle('hidden');
        }

        // Set Edit Form Data
        function setEditFormData(element) {
            document.getElementById('editElementId').value = element.id; // Set ID
            document.getElementById('editElementName').value = element.name || ''; // Set nama elemen
            document.getElementById('editDescription').value = element.description || ''; // Set deskripsi
            document.getElementById('editAcadStaffQuestionnaireId').value = element.acad_staff_questionnaire_id || ''; // Set ID kuesioner
        }

        // Fetch Functions
        async function fetchAcadStaffQuestionnaires() {
            const token = localStorage.getItem('access_token');
            const response = await fetch('http://127.0.0.1:8000/api/admin/acadstaff-questionnaires', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                const select = document.getElementById('acadStaffQuestionnaireId');
                const editSelect = document.getElementById('editAcadStaffQuestionnaireId');
                select.innerHTML = '<option value="">Pilih Kuesioner</option>'; // Clear existing options
                editSelect.innerHTML = '<option value="">Pilih Kuesioner</option>'; // Clear existing options for edit
                data.data.forEach(questionnaire => {
                    const option = document.createElement('option');
                    option.value = questionnaire.id; // Assuming the ID is in 'id'
                    option.textContent = questionnaire.name; // Assuming the name is in 'name'
                    select.appendChild(option);

                    const editOption = option.cloneNode(true); // Clone option for edit select
                    editSelect.appendChild(editOption);
                });
            } else {
                alert('Gagal mengambil kuesioner');
            }
        }

        async function fetchAcadStaffElements() {
            const token = localStorage.getItem('access_token');
            const response = await fetch('http://127.0.0.1:8000/api/admin/acadstaff-elements', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                const tbody = document.querySelector('tbody');
                tbody.innerHTML = ''; // Clear existing rows
                if (data.data && Array.isArray(data.data)) { // Check if data.data is an array
                    data.data.forEach((element, index) => {
                        const row = `
                            <tr>
                                <td class="py-2 px-4 border-b border-r">${index + 1}</td>
                                <td class="py-2 px-4 border-b border-r">${element.name || 'N/A'}</td> <!-- Default value if name is missing -->
                                <td class="py-2 px-4 border-b">
                                    <button onclick="openEditModal(${element.id})" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                                        Ubah
                                    </button>
                                    <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 ml-2" onclick="deleteElement(${element.id})">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        `;
                        tbody.innerHTML += row;
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="3" class="text-center">Tidak ada data elemen.</td></tr>'; // Show message if no data
                }
            } else {
                alert('Gagal mengambil data');
            }
        }

        // Event Listeners
        document.addEventListener('DOMContentLoaded', fetchAcadStaffElements);

        // Edit Functions
        async function openEditModal(elementId) {
            const token = localStorage.getItem('access_token');
            const response = await fetch(`http://127.0.0.1:8000/api/admin/acadstaff-elements/${elementId}`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const element = await response.json();
                setEditFormData(element); // Set form data using the new function
                toggleEditModal();
            } else {
                alert('Gagal mengambil data untuk diubah');
            }
        }

        async function saveEdit() {
            const name = document.getElementById('editElementName').value;
            const description = document.getElementById('editDescription').value;
            const acadStaffQuestionnaireId = document.getElementById('editAcadStaffQuestionnaireId').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const elementId = document.getElementById('editElementId').value; // Get the ID from hidden input

            const token = localStorage.getItem('access_token');
            const response = await fetch(`http://127.0.0.1:8000/api/admin/acadstaff-elements/${elementId}`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Include CSRF token
                },
                body: JSON.stringify({
                    name,
                    description,
                    acad_staff_questionnaire_id: acadStaffQuestionnaireId
                })
            });

            if (response.ok) {
                alert('Elemen kuesioner berhasil diubah');
                toggleEditModal(); // Close modal
                fetchAcadStaffElements(); // Refresh the table
            } else {
                alert('Gagal mengubah elemen kuesioner');
            }
        }
    </script>
</body>
</html>
