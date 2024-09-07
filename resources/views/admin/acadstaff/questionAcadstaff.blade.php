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
        @include('admin.component.sidebar')
        <div class="flex-1 flex flex-col overflow-hidden p-4 ml-64">
            @include('admin.component.header')
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-6 py-8">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h1 class="text-2xl font-bold mb-4">Data pertanyaan kuesioner tenaga kependidikan</h1>
                        <p class="text-gray-600 mb-4">Ini adalah daftar pertanyaan kuesioner yang dapat Anda edit atau hapus. Gunakan tombol 'Tambah Data' untuk menambahkan pertanyaan baru.</p>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300" id="questionsTable">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-2 px-4 border-b border-r">No</th>
                                        <th class="py-2 px-4 border-b border-r">Nama Pertanyaan</th>
                                        <th class="py-2 px-4 border-b">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan ditambahkan di sini -->
                                </tbody>
                            </table>
                        </div>
                        <div class="my-4">
                            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="openAddModal()">
                                Tambah Data
                            </button>
                        </div>
                        <!-- Modal untuk menambahkan pertanyaan baru -->
                        <div id="addModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                            <div class="bg-white rounded-lg p-6 w-1/3">
                                <h2 class="text-xl font-bold mb-4">Tambah Pertanyaan</h2>
                                <label for="newQuestionInput" class="block mb-2">Nama Pertanyaan</label>
                                <input type="text" id="newQuestionInput" class="border border-gray-300 p-2 w-full mb-4" placeholder="Nama pertanyaan">
                                <label for="minRangeInput" class="block mb-2">Rentang Minimal</label>
                                <input type="number" id="minRangeInput" class="border border-gray-300 p-2 w-full mb-4" placeholder="Min Range">
                                <label for="maxRangeInput" class="block mb-2">Rentang Maksimal</label>
                                <input type="number" id="maxRangeInput" class="border border-gray-300 p-2 w-full mb-4" placeholder="Max Range">
                                <label for="labelInput" class="block mb-2">Label</label>
                                <input type="text" id="labelInput" class="border border-gray-300 p-2 w-full mb-4" placeholder="Label (pisahkan dengan koma)">
                                <label for="acadStaffElementSelect" class="block mb-2">Pilih Elemen Tenaga Kependidikan:</label>
                                <select id="acadStaffElementSelect" class="border border-gray-300 p-2 w-full mb-4">
                                    <!-- Opsi akan diisi dengan data dari API -->
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
                        <!-- Modal untuk mengubah pertanyaan -->
                        <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                            <div class="bg-white rounded-lg p-6 w-1/3">
                                <h2 class="text-xl font-bold mb-4">Ubah Pertanyaan</h2>
                                <label for="editQuestionInput" class="block mb-2">Nama Pertanyaan</label>
                                <input type="text" id="editQuestionInput" class="border border-gray-300 p-2 w-full mb-4" placeholder="Nama pertanyaan">
                                <label for="editMinRangeInput" class="block mb-2">Rentang Minimal</label>
                                <input type="number" id="editMinRangeInput" class="border border-gray-300 p-2 w-full mb-4" placeholder="Min Range">
                                <label for="editMaxRangeInput" class="block mb-2">Rentang Maksimal</label>
                                <input type="number" id="editMaxRangeInput" class="border border-gray-300 p-2 w-full mb-4" placeholder="Max Range">
                                <label for="editLabelInput" class="block mb-2">Label</label>
                                <input type="text" id="editLabelInput" class="border border-gray-300 p-2 w-full mb-4" placeholder="Label (pisahkan dengan koma)">
                                <div class="flex justify-between">
                                    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="updateQuestion()">
                                        Simpan Perubahan
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
        let currentQuestionId = null; // Variabel untuk menyimpan ID pertanyaan yang sedang diedit

        async function fetchQuestions() {
            const token = localStorage.getItem('access_token');
            const response = await fetch('/api/admin/acadstaff-questions', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                const questionsTable = document.getElementById('questionsTable').getElementsByTagName('tbody')[0];
                questionsTable.innerHTML = ''; // Kosongkan tabel sebelum menambahkan data

                data.data.forEach((question, index) => {
                    const row = questionsTable.insertRow();
                    row.innerHTML = `
                        <td class="py-2 px-4 border-b border-r">${index + 1}</td>
                        <td class="py-2 px-4 border-b border-r">${question.question}</td>
                        <td class="py-2 px-4 border-b">
                            <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600" onclick="openEditModal(${JSON.stringify(question)})">
                                Ubah
                            </button>
                            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 ml-2" onclick="confirmDelete(${question.id})">
                                Hapus
                            </button>
                        </td>
                    `;
                });
            } else {
                console.error('Gagal mengambil data:', response.statusText);
            }
        }

        async function fetchAcadStaffElements() {
            const token = localStorage.getItem('access_token');
            const response = await fetch('/api/admin/acadstaff-elements', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                const select = document.getElementById('acadStaffElementSelect');
                select.innerHTML = ''; // Kosongkan select sebelum menambahkan data

                data.data.forEach(element => {
                    const option = document.createElement('option');
                    option.value = element.id;
                    option.textContent = element.name; // Ganti 'name' dengan field yang sesuai
                    select.appendChild(option);
                });
            } else {
                console.error('Gagal mengambil data elemen:', response.statusText);
            }
        }

        window.onload = async () => {
            await fetchQuestions();
            await fetchAcadStaffElements();
        };

        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        async function saveNewQuestion() {
            const token = localStorage.getItem('access_token');
            const question = document.getElementById('newQuestionInput').value;
            const minRange = parseInt(document.getElementById('minRangeInput').value);
            const maxRange = parseInt(document.getElementById('maxRangeInput').value);
            const label = document.getElementById('labelInput').value.split(',').map(item => item.trim());
            const acadStaffElementId = document.getElementById('acadStaffElementSelect').value;

            // Validasi rentang dan label
            const expectedLabelCount = maxRange - minRange + 1; // Hitung jumlah label yang diharapkan
            if (label.length !== expectedLabelCount) {
                alert(`Jumlah label harus sama dengan rentang (${expectedLabelCount}).`);
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Ambil CSRF token

            const response = await fetch('/api/admin/acadstaff-questions', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Sertakan CSRF token
                },
                body: JSON.stringify({
                    question,
                    min_range: minRange,
                    max_range: maxRange,
                    label,
                    acad_staff_element_id: acadStaffElementId
                })
            });

            if (response.ok) {
                alert('Pertanyaan Berhasil Ditambahkan!'); // Ganti Swal.fire dengan alert
                closeAddModal();
                fetchQuestions(); // Refresh data
            } else {
                const errorData = await response.json();
                alert('Gagal Menambahkan Pertanyaan: ' + errorData.message); // Ganti Swal.fire dengan alert
            }
        }

        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')) {
                deleteQuestion(id);
            }
        }

        async function deleteQuestion(id) {
            const token = localStorage.getItem('access_token');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Ambil CSRF token

            const response = await fetch(`/api/admin/acadstaff-questions/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Sertakan CSRF token
                }
            });

            if (response.ok) {
                alert('Pertanyaan berhasil dihapus!'); // Ganti Swal.fire dengan alert
                fetchQuestions(); // Refresh data
            } else {
                const errorData = await response.json();
                alert('Gagal menghapus pertanyaan: ' + errorData.message); // Ganti Swal.fire dengan alert
            }
        }

        function openEditModal(question) {
            currentQuestionId = question.id; // Simpan ID pertanyaan
            document.getElementById('editQuestionInput').value = question.question;
            document.getElementById('editMinRangeInput').value = question.min_range;
            document.getElementById('editMaxRangeInput').value = question.max_range;
            document.getElementById('editLabelInput').value = question.label.join(', '); // Gabungkan label menjadi string
            document.getElementById('editModal').classList.remove('hidden'); // Tampilkan modal
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden'); // Sembunyikan modal
        }

        async function updateQuestion() {
            const token = localStorage.getItem('access_token');
            const question = document.getElementById('editQuestionInput').value;
            const minRange = parseInt(document.getElementById('editMinRangeInput').value);
            const maxRange = parseInt(document.getElementById('editMaxRangeInput').value);
            const label = document.getElementById('editLabelInput').value.split(',').map(item => item.trim());

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Ambil CSRF token

            const response = await fetch(`/api/admin/acadstaff-questions/${currentQuestionId}`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Sertakan CSRF token
                },
                body: JSON.stringify({
                    question,
                    min_range: minRange,
                    max_range: maxRange,
                    label
                })
            });

            if (response.ok) {
                alert('Pertanyaan Berhasil Diperbarui!'); // Ganti Swal.fire dengan alert
                closeEditModal();
                fetchQuestions(); // Refresh data
            } else {
                const errorData = await response.json();
                alert('Gagal Memperbarui Pertanyaan: ' + errorData.message); // Ganti Swal.fire dengan alert
            }
        }
    </script>
</body>
</html>
