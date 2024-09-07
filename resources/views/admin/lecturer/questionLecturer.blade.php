<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kuesioner</title>
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
                        <h1 class="text-2xl font-bold mb-4">Data pertanyaan kuesioner dosen</h1>
                        <p class="text-gray-600 mb-4">Ini adalah daftar pertanyaan kuesioner yang dapat Anda edit atau hapus. Gunakan tombol 'Tambah Data' untuk menambahkan pertanyaan baru.</p>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300" id="questionsTable">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-2 px-4 border-b border-r">No</th>
                                        <th class="py-2 px-4 border-b border-r">Nama pertanyaan</th>
                                        <th class="py-2 px-4 border-b">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan dimuat di sini -->
                                </tbody>
                            </table>
                        </div>
                        <div class="my-4">
                            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="openAddModal()">
                                Tambah Data
                            </button>
                        </div>
                        <!-- Modal untuk form input -->
                        <div id="addModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                            <div class="bg-white rounded-lg p-6 w-1/3">
                                <h2 class="text-xl font-bold mb-4">Tambah Pertanyaan</h2>
                                <label for="questionInput" class="block text-sm font-medium text-gray-700">Nama Pertanyaan</label>
                                <input type="text" id="questionInput" class="border border-gray-300 p-2 w-full mb-4" placeholder="Nama pertanyaan" required>
                                <label for="minRangeInput" class="block text-sm font-medium text-gray-700">Rentang Minimum</label>
                                <input type="number" id="minRangeInput" class="border border-gray-300 p-2 w-full mb-4" placeholder="Min Range" required>
                                <label for="maxRangeInput" class="block text-sm font-medium text-gray-700">Rentang Maksimum</label>
                                <input type="number" id="maxRangeInput" class="border border-gray-300 p-2 w-full mb-4" placeholder="Max Range" required>
                                <label for="labelInput" class="block text-sm font-medium text-gray-700">Label</label>
                                <input type="text" id="labelInput" class="border border-gray-300 p-2 w-full mb-4" placeholder="Label" required>
                                <label for="lecturerQuestionId" class="block text-sm font-medium text-gray-700">Nama Elemen</label>
                                <select id="lecturerQuestionId" class="border border-gray-300 p-2 w-full mb-4" required>
                                    <!-- Options akan dimuat di sini -->
                                </select>
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

                        <!-- Modal untuk form ubah -->
                        <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                            <div class="bg-white rounded-lg p-6 w-1/3">
                                <h2 class="text-xl font-bold mb-4">Ubah Pertanyaan</h2>
                                <label for="editQuestionInput" class="block text-sm font-medium text-gray-700">Nama Pertanyaan</label>
                                <input type="text" id="editQuestionInput" class="border border-gray-300 p-2 w-full mb-4" placeholder="Nama pertanyaan" required>
                                <label for="editMinRangeInput" class="block text-sm font-medium text-gray-700">Rentang Minimum</label>
                                <input type="number" id="editMinRangeInput" class="border border-gray-300 p-2 w-full mb-4" placeholder="Min Range" required>
                                <label for="editMaxRangeInput" class="block text-sm font-medium text-gray-700">Rentang Maksimum</label>
                                <input type="number" id="editMaxRangeInput" class="border border-gray-300 p-2 w-full mb-4" placeholder="Max Range" required>
                                <label for="editLabelInput" class="block text-sm font-medium text-gray-700">Label</label>
                                <input type="text" id="editLabelInput" class="border border-gray-300 p-2 w-full mb-4" placeholder="Label" required>
                                <label for="editLecturerQuestionId" class="block text-sm font-medium text-gray-700">Nama Elemen</label>
                                <select id="editLecturerQuestionId" class="border border-gray-300 p-2 w-full mb-4" required>
                                    <!-- Options akan dimuat di sini -->
                                </select>
                                <div class="flex justify-between">
                                    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="updateQuestion()">
                                        Simpan
                                    </button>
                                    <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="closeEditModal()">
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
        const BASE_URL = 'http://127.0.0.1:8000';
        const token = localStorage.getItem('access_token');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Ambil CSRF token

        let currentQuestionId = null; // Variabel untuk menyimpan ID pertanyaan yang sedang diedit

        function openModal(question) {
            currentQuestionId = question.id; // Simpan ID pertanyaan yang sedang diedit
            document.getElementById('editQuestionInput').value = question.question;
            document.getElementById('editMinRangeInput').value = question.min_range;
            document.getElementById('editMaxRangeInput').value = question.max_range;
            document.getElementById('editLabelInput').value = question.label.split(',').join(', '); // Pisahkan label dengan koma
            document.getElementById('editLecturerQuestionId').value = question.lecturer_element_id; // Set ID elemen dosen

            document.getElementById('editModal').classList.remove('hidden'); // Tampilkan modal
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden'); // Sembunyikan modal
        }

        async function updateQuestion() {
            const questionInput = document.getElementById('editQuestionInput').value;
            const minRangeInput = document.getElementById('editMinRangeInput').value;
            const maxRangeInput = document.getElementById('editMaxRangeInput').value;
            const labelInput = document.getElementById('editLabelInput').value.split(','); // Misalkan label dipisahkan dengan koma
            const lecturerQuestionId = document.getElementById('editLecturerQuestionId').value;

            // Validasi jumlah label
            const range = parseInt(maxRangeInput) - parseInt(minRangeInput) + 1;
            if (labelInput.length !== range) {
                alert('Jumlah label harus sama dengan rentang yang ditentukan.');
                return; // Hentikan eksekusi jika validasi gagal
            }

            const response = await fetch(`${BASE_URL}/api/admin/lecturer-questions/${currentQuestionId}`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Tambahkan CSRF token ke header
                },
                body: JSON.stringify({
                    question: questionInput,
                    min_range: minRangeInput,
                    max_range: maxRangeInput,
                    label: labelInput,
                    lecturer_element_id: lecturerQuestionId
                })
            });

            if (response.ok) {
                alert('Pertanyaan berhasil diperbarui!');
                closeEditModal(); // Tutup modal setelah menyimpan
                fetchQuestions(); // Muat ulang pertanyaan
            } else {
                const errorData = await response.json();
                alert('Gagal memperbarui pertanyaan: ' + errorData.message); // Pastikan pesan kesalahan dalam bahasa Indonesia
            }
        }

        async function fetchQuestions() {
            const response = await fetch(`${BASE_URL}/api/admin/lecturer-questions`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                const questionsTable = document.getElementById('questionsTable').getElementsByTagName('tbody')[0];
                questionsTable.innerHTML = ''; // Clear existing rows

                data.data.forEach((question, index) => {
                    const row = questionsTable.insertRow();
                    row.innerHTML = `
                        <td class="py-2 px-4 border-b border-r">${index + 1}</td>
                        <td class="py-2 px-4 border-b border-r">${question.question}</td>
                        <td class="py-2 px-4 border-b">
                            <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600" onclick="openModal(${JSON.stringify(question)})">
                                Ubah
                            </button>
                            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 ml-2" onclick="deleteQuestion(${question.id})">
                                Hapus
                            </button>
                        </td>
                    `;
                });
            } else {
                console.error('Failed to fetch questions:', response.statusText);
            }
        }

        async function fetchElements() {
            const response = await fetch(`${BASE_URL}/api/admin/lecturer-elements`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                const lecturerQuestionId = document.getElementById('lecturerQuestionId');
                lecturerQuestionId.innerHTML = ''; // Clear existing options

                data.data.forEach(element => {
                    const option = document.createElement('option');
                    option.value = element.id; // Ganti dengan ID yang sesuai
                    option.textContent = element.name; // Ganti dengan nama yang sesuai
                    lecturerQuestionId.appendChild(option);
                });
            } else {
                console.error('Failed to fetch elements:', response.statusText);
                alert('Gagal memuat elemen: ' + response.status + ' ' + response.statusText); // Menampilkan pesan kesalahan
            }
        }

        async function saveNewQuestion() {
            const questionInput = document.getElementById('questionInput').value;
            const minRangeInput = document.getElementById('minRangeInput').value;
            const maxRangeInput = document.getElementById('maxRangeInput').value;
            const labelInput = document.getElementById('labelInput').value.split(','); // Misalkan label dipisahkan dengan koma
            const lecturerQuestionId = document.getElementById('lecturerQuestionId').value;

            // Validasi jumlah label
            const range = parseInt(maxRangeInput) - parseInt(minRangeInput) + 1;
            if (labelInput.length !== range) {
                alert('Jumlah label harus sama dengan rentang yang ditentukan.');
                return; // Hentikan eksekusi jika validasi gagal
            }

            const response = await fetch(`${BASE_URL}/api/admin/lecturer-questions`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Tambahkan CSRF token ke header
                },
                body: JSON.stringify({
                    question: questionInput,
                    min_range: minRangeInput,
                    max_range: maxRangeInput,
                    label: labelInput,
                    lecturer_element_id: lecturerQuestionId
                })
            });

            if (response.ok) {
                alert('Pertanyaan berhasil disimpan!');
                closeAddModal(); // Tutup modal setelah menyimpan
                fetchQuestions(); // Muat ulang pertanyaan
            } else {
                const errorData = await response.json();
                alert('Gagal menyimpan pertanyaan: ' + errorData.message); // Pastikan pesan kesalahan dalam bahasa Indonesia
            }
        }

        async function deleteQuestion(id) {
            // Konfirmasi sebelum menghapus
            const confirmed = confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?');
            if (!confirmed) {
                return; // Hentikan eksekusi jika pengguna tidak mengonfirmasi
            }

            const response = await fetch(`${BASE_URL}/api/admin/lecturer-questions/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Tambahkan CSRF token ke header
                }
            });

            if (response.ok) {
                alert('Pertanyaan berhasil dihapus!');
                fetchQuestions(); // Muat ulang pertanyaan setelah penghapusan
            } else {
                const errorData = await response.json();
                alert('Gagal menghapus pertanyaan: ' + errorData.message); // Pastikan pesan kesalahan dalam bahasa Indonesia
            }
        }

        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchQuestions();
            fetchElements(); // Memanggil fungsi untuk mengambil data elemen
        });
    </script>
</body>
</html>
