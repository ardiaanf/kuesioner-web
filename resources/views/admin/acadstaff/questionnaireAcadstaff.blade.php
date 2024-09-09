<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kuesioner</title>
    @vite('resources/css/app.css')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
     <!-- Tambahkan meta tag untuk CSRF token -->
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
                        <h1 class="text-2xl font-bold mb-4">Jenis Kuesioner Tenaga kependidikan</h1>
                        <p class="text-gray-600 mb-4">Data ini digunakan untuk mengumpulkan data jenis kuesioner tenaga kependidikan.</p>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-2 px-4 border-b border-r">No</th>
                                        <th class="py-2 px-4 border-b border-r">Nama Kuesioner</th>
                                        <th class="py-2 px-4 border-b">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="questionnaire-table-body">
                                    <!-- Data akan diisi oleh JavaScript -->
                                </tbody>
                            </table>
                            <div class="mt-4">
                                <button class="bg-blue-500 text-white px-4 py-2 rounded" onclick="openModal()">Tambah Data</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Tambah Data -->
    <div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-1/3">
            <h2 class="text-xl font-bold mb-4">Tambah Kuesioner</h2>
            <label class="block mb-2">Nama Kuesioner</label>
            <input type="text" id="add-nama" class="border border-gray-300 rounded w-full mb-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400" placeholder="Masukkan nama kuesioner">

            <label class="block mb-2">Deskripsi Kuesioner</label>
            <textarea id="add-description" class="border border-gray-300 rounded w-full mb-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400" rows="3" placeholder="Masukkan deskripsi kuesioner"></textarea>

            <div class="flex justify-between">
                <button class="bg-blue-500 text-white px-4 py-2 rounded" onclick="addQuestionnaire()">Simpan</button>
                <button class="bg-red-500 text-white px-4 py-2 rounded" onclick="closeModal()">Tutup</button>
            </div>
        </div>
    </div>

     <!-- Modal Ubah Data -->
    <div id="edit-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-1/3">
            <h2 class="text-xl font-bold mb-4">Ubah Kuesioner</h2>
            <input type="hidden" id="edit-id">
            <label class="block mb-2">Nama Kuesioner</label>
            <input type="text" id="edit-nama" class="border border-gray-300 rounded w-full mb-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400">

            <label class="block mb-2">Deskripsi Kuesioner</label>
            <textarea id="edit-description" class="border border-gray-300 rounded w-full mb-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400" rows="3"></textarea>

            <div class="flex justify-between">
                <button class="bg-green-500 text-white px-4 py-2 rounded" onclick="updateQuestionnaire()">Ubah</button>
                <button class="bg-red-500 text-white px-4 py-2 rounded" onclick="closeEditModal()">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal Detail Kuesioner -->
    <div id="detail-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-2/3 max-h-3/4 overflow-y-auto"> <!-- Ubah lebar modal menjadi w-2/3 -->
            <h2 class="text-xl font-bold mb-4">Detail Kuesioner</h2>
            <p id="detail-nama" class="mb-2"></p>
            <p id="detail-deskripsi" class="mb-2"></p>
            <div id="detail-elements" class="mb-2"></div> <!-- Tambahkan elemen untuk menampilkan acadstaff_elements -->
            <button class="bg-red-500 text-white px-4 py-2 rounded" onclick="closeDetailModal()">Tutup</button>
        </div>
        
    </div>

    <!-- Tambahkan script untuk mengontrol modal -->
    <script>
        const BASE_URL = 'http://127.0.0.1:8000';

        // Fungsi untuk mengambil data kuesioner
        async function fetchQuestionnaires() {
            const token = localStorage.getItem('access_token');
            if (!token) {
                alert('Anda belum login. Silakan login terlebih dahulu.');
                window.location.href = `${BASE_URL}/auth/admin`;
                return;
            }

            try {
                const response = await fetch(`${BASE_URL}/api/admin/acadstaff-questionnaires`, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Gagal mengambil data kuesioner');
                }

                const data = await response.json();
                return data.data;
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengambil data kuesioner');
            }
        }

        // Fungsi untuk menampilkan data kuesioner
        function displayQuestionnaires(questionnaires) {
            const tableBody = document.getElementById('questionnaire-table-body');
            tableBody.innerHTML = '';

            questionnaires.forEach((questionnaire, index) => {
                const row = `
                    <tr>
                        <td class="py-2 px-4 border-b border-r">${index + 1}</td>
                        <td class="py-2 px-4 border-b border-r">${questionnaire.name}</td>
                        <td class="py-2 px-4 border-b">
                            <button class="bg-yellow-500 text-white px-4 py-2 rounded" onclick="openEditModal('${questionnaire.id}', '${questionnaire.name}', '${questionnaire.description || ''}', '${questionnaire.type}')">Ubah</button>
                            <button class="bg-red-500 text-white px-4 py-2 rounded" onclick="deleteQuestionnaire(${questionnaire.id})">Hapus</button>
                            <button class="bg-green-500 text-white px-4 py-2 rounded" onclick="showDetails('${questionnaire.id}')">Detail</button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        }

        // Panggil fungsi untuk mengambil dan menampilkan data saat halaman dimuat
        window.onload = async function() {
            const questionnaires = await fetchQuestionnaires();
            if (questionnaires) {
                displayQuestionnaires(questionnaires);
            }
        };

        // Fungsi untuk menambahkan kuesioner baru
        async function addQuestionnaire() {
            const token = localStorage.getItem('access_token');

            if (!token) {
                alert('Anda belum login. Silakan login terlebih dahulu.');
                window.location.href = `${BASE_URL}/auth/admin`;
                return;
            }

            const name = document.getElementById('add-nama').value;
            const description = document.getElementById('add-description').value;

            if (!name ) {
                alert('Nama kuesioner harus diisi');
                return;
            }

            try {
                const response = await fetch(`${BASE_URL}/api/admin/acadstaff-questionnaires`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ name, description })
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Gagal menambahkan kuesioner');
                }

                const result = await response.json();
                alert('Kuesioner berhasil ditambahkan');
                closeModal();
                const questionnaires = await fetchQuestionnaires();
                if (questionnaires) {
                    displayQuestionnaires(questionnaires);
                }
            } catch (error) {
                console.error('Error:', error);
                alert(error.message || 'Terjadi kesalahan saat menambahkan kuesioner');
            }
        }

        // Fungsi untuk membuka modal tambah data
        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('add-nama').value = '';
            document.getElementById('add-description').value = '';
        }

         // Fungsi untuk menutup modal tambah data
        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        // Fungsi untuk membuka modal ubah data
        function openEditModal(id, name, description, type) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-nama').value = name;
            document.getElementById('edit-description').value = description;
            document.getElementById('edit-modal').classList.remove('hidden');
        }

         // Tambahkan fungsi closeEditModal
        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }

        // Fungsi untuk mengubah data kuesioner
        async function updateQuestionnaire() {
            const token = localStorage.getItem('access_token');
            if (!token) {
                alert('Anda belum login. Silakan login terlebih dahulu.');
                window.location.href = `${BASE_URL}/auth/admin`;
                return;
            }

            const id = document.getElementById('edit-id').value;
            const name = document.getElementById('edit-nama').value;
            const description = document.getElementById('edit-description').value;

            if (!name) {
                alert('Nama kuesioner harus diisi');
                return;
            }

            try {
                const response = await fetch(`${BASE_URL}/api/admin/acadstaff-questionnaires/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ name, description })
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Gagal mengubah kuesioner');
                }

                const result = await response.json();
                alert('Kuesioner berhasil diubah');
                closeEditModal();
                const questionnaires = await fetchQuestionnaires();
                if (questionnaires) {
                    displayQuestionnaires(questionnaires);
                }
            } catch (error) {
                console.error('Error:', error);
                alert(error.message || 'Terjadi kesalahan saat mengubah kuesioner');
            }
        }

        // Fungsi untuk menampilkan data kuesioner
        function displayQuestionnaires(questionnaires) {
            const tableBody = document.getElementById('questionnaire-table-body');
            tableBody.innerHTML = '';

            questionnaires.forEach((questionnaire, index) => {
                const row = `
                    <tr>
                        <td class="py-2 px-4 border-b border-r">${index + 1}</td>
                        <td class="py-2 px-4 border-b border-r">${questionnaire.name}</td>
                        <td class="py-2 px-4 border-b">
                            <button class="bg-yellow-500 text-white px-4 py-2 rounded" onclick="openEditModal('${questionnaire.id}', '${questionnaire.name}', '${questionnaire.description || ''}', '${questionnaire.type}')">Ubah</button>
                            <button class="bg-red-500 text-white px-4 py-2 rounded" onclick="deleteQuestionnaire(${questionnaire.id})">Hapus</button>
                            <button class="bg-green-500 text-white px-4 py-2 rounded" onclick="showDetails('${questionnaire.id}')">Detail</button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        }

        // Fungsi untuk menampilkan detail kuesioner
        async function showDetails(id) {
            const token = localStorage.getItem('access_token');
            if (!token) {
                alert('Anda belum login. Silakan login terlebih dahulu.');
                window.location.href = `${BASE_URL}/auth/admin`;
                return;
            }

            try {
                const response = await fetch(`${BASE_URL}/api/admin/acadstaff-questionnaires/${id}/relations`, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Gagal mengambil detail kuesioner');
                }

                const questionnaire = await response.json();
                document.getElementById('detail-nama').innerText = `Nama: ${questionnaire.data.name}`;
                document.getElementById('detail-deskripsi').innerText = `Deskripsi: ${questionnaire.data.description || 'Tidak ada deskripsi'}`;

                // Menampilkan acadstaff_elements dan pertanyaan
                const elementsContainer = document.getElementById('detail-elements');
                elementsContainer.innerHTML = ''; // Kosongkan sebelumnya
                if (questionnaire.data.acadstaff_elements) { // Tambahkan pengecekan ini
                    questionnaire.data.acadstaff_elements.forEach(element => {
                        const elementHTML = `<strong>Elemen: ${element.name}</strong><br>`;
                        const questionsHTML = element.acadstaff_questions.map(question => `
                            <div>
                                <p><strong>Soal:</strong> ${question.question}</p>
                                <p><strong>Label:</strong> ${question.label.join(', ')}</p>
                            </div>
                        `).join('');
                        elementsContainer.innerHTML += elementHTML + questionsHTML + '<br>';
                    });
                } else {
                    elementsContainer.innerHTML = '<p>Tidak ada elemen yang tersedia.</p>'; // Tambahkan pesan jika tidak ada elemen
                }

                document.getElementById('detail-modal').classList.remove('hidden');
            } catch (error) {
                console.error('Error:', error);
                alert(error.message || 'Terjadi kesalahan saat mengambil detail kuesioner');
            }
        }

        // Fungsi untuk menutup modal detail
        function closeDetailModal() {
            document.getElementById('detail-modal').classList.add('hidden');
        }

        // Fungsi untuk menghapus kuesioner
        async function deleteQuestionnaire(id) {
            const token = localStorage.getItem('access_token');
            if (!token) {
                alert('Anda belum login. Silakan login terlebih dahulu.');
                window.location.href = `${BASE_URL}/auth/admin`;
                return;
            }

            if (!confirm('Apakah Anda yakin ingin menghapus kuesioner ini?')) {
                return;
            }

            try {
                const response = await fetch(`${BASE_URL}/api/admin/acadstaff-questionnaires/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Gagal menghapus kuesioner');
                }

                alert('Kuesioner berhasil dihapus');
                const questionnaires = await fetchQuestionnaires();
                if (questionnaires) {
                    displayQuestionnaires(questionnaires);
                }
            } catch (error) {
                console.error('Error:', error);
                alert(error.message || 'Terjadi kesalahan saat menghapus kuesioner');
            }
        }

    </script>
</body>
</html>
