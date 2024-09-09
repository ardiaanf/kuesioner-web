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
                        <h1 class="text-2xl font-bold mb-4">Data Pertanyaan Kuesioner Tenaga Kependidikan</h1>
                        <p class="text-gray-600 mb-4">Ini adalah daftar pertanyaan kuesioner yang dapat Anda edit atau hapus. Gunakan tombol 'Tambah Data' untuk menambahkan pertanyaan baru.</p>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-2 px-4 border-b border-r">No</th>
                                        <th class="py-2 px-4 border-b border-r">Nama pertanyaan</th>
                                        <th class="py-2 px-4 border-b">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="questionList">
                                    <!-- Data pertanyaan akan ditampilkan di sini -->
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
            <h2 class="text-xl text-gray-600 hover:border-gray-300 font-bold mb-4">Tambah Pertanyaan Kuesioner</h2>
            <label for="elementName" class="block text-sm font-medium text-gray-700">Nama Pertanyaan</label>
            <input type="text" id="elementName" class="border border-gray-300 p-2 w-full mb-4" placeholder="Nama pertanyaan" />

            <label for="minRange" class="block text-sm font-medium text-gray-700">Rentang Minimum</label>
            <input type="number" id="minRange" class="border border-gray-300 p-2 w-full mb-4" placeholder="Rentang Minimum" />

            <label for="maxRange" class="block text-sm font-medium text-gray-700">Rentang Maksimum</label>
            <input type="number" id="maxRange" class="border border-gray-300 p-2 w-full mb-4" placeholder="Rentang Maksimum" />

            <label for="label" class="block text-sm font-medium text-gray-700">Label (pisahkan dengan koma)</label>
            <input type="text" id="label" class="border border-gray-300 p-2 w-full mb-4" placeholder="Label (pisahkan dengan koma)" />

            <label for="acadstaffElementId" class="block text-sm font-medium text-gray-700">Elemen Tenaga Kependidikan</label>
            <select id="acadstaffElementId" class="border border-gray-300 p-2 w-full mb-4">
                <!-- Options akan diisi dengan JavaScript -->
            </select>

            <div class="flex justify-between mt-4">
                <button id="saveElement" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Simpan
                </button>
                <button id="closeModal" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    <!-- Tambahkan modal untuk form input ubah data -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-1/3 relative">
            <h2 class="text-xl text-gray-600 hover:border-gray-300 font-bold mb-4">Ubah Pertanyaan Kuesioner</h2>
            <label for="editElementName" class="block text-sm font-medium text-gray-700">Nama Pertanyaan</label>
            <input type="text" id="editElementName" class="border border-gray-300 p-2 w-full mb-4" placeholder="Nama pertanyaan" />

            <label for="editMinRange" class="block text-sm font-medium text-gray-700">Rentang Minimum</label>
            <input type="number" id="editMinRange" class="border border-gray-300 p-2 w-full mb-4" placeholder="Rentang Minimum" />

            <label for="editMaxRange" class="block text-sm font-medium text-gray-700">Rentang Maksimum</label>
            <input type="number" id="editMaxRange" class="border border-gray-300 p-2 w-full mb-4" placeholder="Rentang Maksimum" />

            <label for="editLabel" class="block text-sm font-medium text-gray-700">Label (pisahkan dengan koma)</label>
            <input type="text" id="editLabel" class="border border-gray-300 p-2 w-full mb-4" placeholder="Label (pisahkan dengan koma)" />

            <label for="editAcadstaffElementId" class="block text-sm font-medium text-gray-700">Elemen Tenaga Kependidikan</label>
            <select id="editAcadstaffElementId" class="border border-gray-300 p-2 w-full mb-4">
                <!-- Options akan diisi dengan JavaScript -->
            </select>

            <div class="flex justify-between mt-4">
                <button id="updateElement" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Ubah Data
                </button>
                <button id="closeEditModal" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Tambahkan modal untuk menampilkan detail pertanyaan -->
    <div id="detailModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-1/3 relative">
            <h2 class="text-xl text-gray-600 font-bold mb-4">Detail Pertanyaan Kuesioner</h2>
            <div id="detailContent">
                <!-- Konten detail akan diisi dengan JavaScript -->
            </div>
            <button id="closeDetailModal" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 mt-4">
                Tutup
            </button>
        </div>
    </div>

    <script>
        const BASE_URL = 'http://127.0.0.1:8000';

        // Fungsi untuk menghapus pertanyaan
        async function deleteQuestion(id) {
            const confirmation = confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?'); // Konfirmasi penghapusan
            if (!confirmation) {
                return; // Jika tidak, keluar dari fungsi
            }
            
            const token = localStorage.getItem('access_token');
            const response = await fetch(`${BASE_URL}/api/admin/acadstaff-questions/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Menambahkan token CSRF
                }
            });

            if (response.ok) {
                alert('Pertanyaan berhasil dihapus');
                fetchQuestions(); // Refresh data pertanyaan
            } else {
                alert('Gagal menghapus pertanyaan');
            }
        }

        // Fungsi untuk mengambil data pertanyaan
        async function fetchQuestions() {
            const token = localStorage.getItem('access_token');
            const response = await fetch(`${BASE_URL}/api/admin/acadstaff-questions`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                const questionList = document.getElementById('questionList');
                questionList.innerHTML = ''; // Kosongkan daftar sebelum menambahkan data baru
                data.data.forEach((question, index) => {
                    questionList.innerHTML += `
                        <tr data-id="${question.id}" data-min-range="${question.min_range}" data-max-range="${question.max_range}" data-label="${question.label.join(',')}">
                            <td class="py-2 px-4 border-b border-r">${index + 1}</td>
                            <td class="py-2 px-4 border-b border-r">${question.question}</td>
                            <td class="py-2 px-4 border-b">
                                <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600" onclick="openEditModal(${question.id})">
                                    Ubah
                                </button>
                                <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 ml-2" onclick="deleteQuestion(${question.id})">
                                    Hapus
                                </button>
                                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 ml-2" onclick="showDetail(${question.id})">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                alert('Gagal mengambil data pertanyaan');
            }
        }

        // Fungsi untuk mengambil education personal elements
        async function fetchAcadstaffElements() {
            const token = localStorage.getItem('access_token');
            const response = await fetch(`${BASE_URL}/api/admin/acadstaff-elements`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                const acadstaffElementSelect = document.getElementById('acadstaffElementId');
                const editAcadstaffElementSelect = document.getElementById('editAcadstaffElementId');
                acadstaffElementSelect.innerHTML = ''; // Kosongkan opsi sebelumnya
                editAcadstaffElementSelect.innerHTML = ''; // Kosongkan opsi sebelumnya
                data.data.forEach(element => {
                    acadstaffElementSelect.innerHTML += `<option value="${element.id}">${element.name}</option>`;
                    editAcadstaffElementSelect.innerHTML += `<option value="${element.id}">${element.name}</option>`;
                });
            } else {
                alert('Gagal mengambil data elemen tenaga kependidikan');
            }
        }

        // Fungsi untuk menyimpan elemen baru
        document.getElementById('saveElement').onclick = async function() {
            const token = localStorage.getItem('access_token');
            const question = document.getElementById('elementName').value.trim(); // Trim untuk menghapus spasi
            const minRange = parseFloat(document.getElementById('minRange').value);
            const maxRange = parseFloat(document.getElementById('maxRange').value);
            const label = document.getElementById('label').value.split(',').map(item => item.trim());

            // Validasi input
            if (!question) {
                alert('Nama pertanyaan tidak boleh kosong.');
                return;
            }
            if (minRange < 1 || maxRange < 1) {
                alert('Rentang minimum dan maksimum harus minimal 1.');
                return;
            }
            if (minRange > maxRange) {
                alert('Rentang maksimum tidak boleh lebih kecil dari rentang minimum.');
                return;
            }
            if (label.length < minRange || label.length > maxRange) {
                alert(`Label harus terdiri dari antara ${minRange} dan ${maxRange} elemen.`);
                return;
            }

            const response = await fetch(`${BASE_URL}/api/admin/acadstaff-questions`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Menambahkan token CSRF
                },
                body: JSON.stringify({
                    question,
                    min_range: minRange,
                    max_range: maxRange,
                    label,
                    acad_staff_element_id: document.getElementById('acadstaffElementId').value // Pastikan ini diisi
                })
            });

            if (response.ok) {
                alert('Pertanyaan berhasil ditambahkan');
                fetchQuestions(); // Refresh data pertanyaan
                document.getElementById('modal').classList.add('hidden'); // Tutup modal
            } else {
                const errorData = await response.json(); // Ambil data error dari response
                alert(`Gagal menambahkan pertanyaan: ${errorData.message || 'Terjadi kesalahan'}`);
            }
        };

        // Fungsi untuk membuka modal ubah data
        function openEditModal(id) {
            currentQuestionId = id; // Simpan ID pertanyaan yang sedang diedit
            const questionRow = document.querySelector(`#questionList tr[data-id="${id}"]`);

            if (!questionRow) {
                alert('Data pertanyaan tidak ditemukan.');
                return; // Keluar dari fungsi jika baris tidak ditemukan
            }

            const question = questionRow.children[1].innerText; // Ambil nama pertanyaan
            document.getElementById('editElementName').value = question;

            // Ambil data rentang dan label
            const minRange = questionRow.getAttribute('data-min-range'); // Ambil rentang minimum dari atribut data
            const maxRange = questionRow.getAttribute('data-max-range'); // Ambil rentang maksimum dari atribut data
            const label = questionRow.getAttribute('data-label'); // Ambil label dari atribut data

            document.getElementById('editMinRange').value = minRange; // Tampilkan rentang minimum
            document.getElementById('editMaxRange').value = maxRange; // Tampilkan rentang maksimum
            document.getElementById('editLabel').value = label; // Tampilkan label

            document.getElementById('editModal').classList.remove('hidden'); // Tampilkan modal ubah
        }

        // Fungsi untuk mengupdate data
        document.getElementById('updateElement').onclick = async function() {
            const token = localStorage.getItem('access_token');
            const question = document.getElementById('editElementName').value;
            const minRange = document.getElementById('editMinRange').value;
            const maxRange = document.getElementById('editMaxRange').value;
            const label = document.getElementById('editLabel').value.split(',').map(item => item.trim());
            const acadstaffElementId = document.getElementById('editAcadstaffElementId').value;

            const response = await fetch(`${BASE_URL}/api/admin/acadstaff-questions/${currentQuestionId}`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Menambahkan token CSRF
                },
                body: JSON.stringify({
                    question,
                    min_range: minRange,
                    max_range: maxRange,
                    label,
                    acad_staff_element_id: acadstaffElementId
                })
            });

            if (response.ok) {
                alert('Pertanyaan berhasil diubah');
                fetchQuestions(); // Refresh data pertanyaan
                document.getElementById('editModal').classList.add('hidden'); // Tutup modal
            } else {
                alert('Gagal mengubah pertanyaan');
            }
        };

        // Event listener untuk membuka modal
        document.getElementById('openModal').onclick = function() {
            document.getElementById('modal').classList.remove('hidden'); // Tampilkan modal
        };

        // Event listener untuk menutup modal
        document.getElementById('closeModal').onclick = function() {
            document.getElementById('modal').classList.add('hidden'); // Sembunyikan modal
        };

        // Event listener untuk menutup modal edit
        document.getElementById('closeEditModal').onclick = function() {
            document.getElementById('editModal').classList.add('hidden'); // Sembunyikan modal edit
        };

        // Panggil fungsi fetchQuestions dan fetchAcadstaffElements saat halaman dimuat
        document.addEventListener('DOMContentLoaded', async () => {
            await fetchQuestions();
            await fetchAcadstaffElements();
        });

         // Fungsi untuk menampilkan detail pertanyaan
    async function showDetail(id) {
        const token = localStorage.getItem('access_token');
        const response = await fetch(`${BASE_URL}/api/admin/acadstaff-questions/${id}`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json'
            }
        });

        if (response.ok) {
            const data = await response.json();
            const detailData = data.data;

            // Tampilkan detail dalam modal
            const detailContent = `
                <p><strong>Pertanyaan:</strong> ${detailData.question}</p>
                <p><strong>Rentang Minimum:</strong> ${detailData.min_range}</p>
                <p><strong>Rentang Maksimum:</strong> ${detailData.max_range}</p>
                <p><strong>Label:</strong> ${detailData.label.join(', ')}</p>
                <p><strong>Dibuat pada:</strong> ${detailData.created_at}</p>
                <p><strong>Diubah pada:</strong> ${detailData.updated_at}</p>
            `;
            document.getElementById('detailContent').innerHTML = detailContent;
            document.getElementById('detailModal').classList.remove('hidden'); // Tampilkan modal detail
        } else {
            alert('Gagal mengambil detail pertanyaan');
        }
    }

    // Event listener untuk menutup modal detail
    document.getElementById('closeDetailModal').onclick = function() {
        document.getElementById('detailModal').classList.add('hidden'); // Sembunyikan modal detail
    };
    </script>
</body>
</html>
