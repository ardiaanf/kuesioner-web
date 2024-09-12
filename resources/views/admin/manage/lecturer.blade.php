<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kuesioner</title>
    @vite('resources/css/app.css')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
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
                    <div class="bg-white p-6 rounded-lg shadow-md"> <!-- Tambahkan kotak putih dengan jarak -->
                        <h2 class="text-xl font-bold mb-4">Daftar Mahasiswa</h2>
                        <table class="min-w-full bg-white border border-gray-300"> <!-- Tambahkan border pada tabel -->
                            <thead>
                                <tr class="w-full bg-gray-200">
                                    <th class="py-2 px-4 border">Nama</th> <!-- Tambahkan border pada header -->
                                    <th class="py-2 px-4 border">Email</th> <!-- Tambahkan border pada header -->
                                    <th class="py-2 px-4 border">Aksi</th> <!-- Tambahkan border pada header -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data siswa akan ditampilkan di sini -->
                            </tbody>
                        </table>
                        <div id="error-message" class="text-red-500 mt-2 hidden"></div> <!-- Tempat untuk menampilkan pesan error -->
                        <!-- Tambahkan button untuk tambah siswa -->
                        <div class="flex justify-between mb-4">
                            <button id="btnTambah" class="bg-blue-500 text-white px-4 py-2 rounded my-4" onclick="toggleModal()">Tambah Siswa</button>
                        </div>
                        <!-- Modal untuk input siswa -->
                        <div id="modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
                            <div class="bg-white p-6 rounded-lg shadow-md w-96 max-h-[80vh] overflow-y-auto"> <!-- Ubah lebar modal dan tambahkan max height -->
                                <h2 class="text-xl font-bold mb-4">Tambah Siswa</h2>
                                <form id="add-student-form">
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Nama</label>
                                        <input type="text" id="student-name" class="border rounded w-full py-2 px-3" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Nomor Registrasi</label>
                                        <input type="text" id="student-reg-number" class="border rounded w-full py-2 px-3" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Email</label>
                                        <input type="email" id="student-email" class="border rounded w-full py-2 px-3" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Password</label>
                                        <input type="password" id="student-password" class="border rounded w-full py-2 px-3" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Jenis Kelamin</label>
                                        <select id="student-gender" class="border rounded w-full py-2 px-3" required>
                                            <option value="male">Laki-laki</option>
                                            <option value="female">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Semester</label>
                                        <input type="text" id="student-semester" class="border rounded w-full py-2 px-3" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Major</label>
                                        <select id="student-major" class="border rounded w-full py-2 px-3" required>
                                            <option value="">Pilih Major</option>
                                            <!-- Options akan diisi oleh JavaScript -->
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Program Studi</label>
                                        <select id="student-study-program" class="border rounded w-full py-2 px-3" required>
                                            <option value="">Pilih Program Studi</option>
                                            <!-- Options akan diisi oleh JavaScript -->
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Kelas Siswa</label>
                                        <select id="student-class" class="border rounded w-full py-2 px-3" required>
                                            <option value="">Pilih Kelas</option>
                                            <!-- Options akan diisi oleh JavaScript -->
                                        </select>
                                    </div>
                                    <div class="flex justify-between">
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
                                        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded" onclick="toggleModal()">Tutup</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div> <!-- Akhir kotak putih -->
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchDropdownData();
        });
    </script>

    <script>
        function toggleModal() {
            const modal = document.getElementById('modal');
            modal.classList.toggle('hidden');
        }

        async function fetchStudentData() {
            const token = localStorage.getItem('access_token');
            try {
                const response = await fetch('http://127.0.0.1:8000/api/admin/students', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                });
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();
                // console.log(data); // Tambahkan log untuk memeriksa data
                if (data.message === 'Students retrieved successfully.') { // Perbaikan kondisi
                    displayStudentData(data.data); // Pastikan data.data berisi array siswa
                    document.getElementById('error-message').classList.add('hidden'); // Sembunyikan pesan error jika berhasil
                } else {
                    showError(data.message || 'Gagal mengambil data siswa'); // Menangani kesalahan
                }
            } catch (error) {
                console.error('Fetch error:', error); // Log error
                showError('Terjadi kesalahan saat mengambil data siswa');
            }
        }

        function displayStudentData(students) {
            const tbody = document.querySelector('tbody');
            tbody.innerHTML = ''; // Clear existing data
            if (!Array.isArray(students) || students.length === 0) {
                tbody.innerHTML = '<tr><td colspan="3" class="text-center">Tidak ada data siswa</td></tr>'; // Menampilkan pesan jika tidak ada data
            } else {
                students.forEach(student => {
                    const row = `
                        <tr class="border-b">
                            <td class="py-2 px-4 border">${student.name}</td>
                            <td class="py-2 px-4 border">${student.email}</td>
                            <td class="py-2 px-4 border">
                                <button class="bg-red-500 text-white px-2 py-1 rounded" onclick="deleteStudent(${student.id})">Hapus</button>
                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });
            }
        }

        function showError(message) {
            const errorMessageDiv = document.getElementById('error-message');
            errorMessageDiv.textContent = message;
            errorMessageDiv.classList.remove('hidden'); // Tampilkan pesan error
        }

        async function deleteStudent(id) {
            const token = localStorage.getItem('access_token');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Ambil CSRF token
            const confirmation = confirm('Apakah Anda yakin ingin menghapus siswa ini?'); // Konfirmasi hapus
            if (confirmation) {
                try {
                    const response = await fetch(`http://127.0.0.1:8000/api/admin/students/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken // Tambahkan CSRF token ke header
                        }
                    });
                    if (response.ok) {
                        alert('Siswa berhasil dihapus.'); // Alert setelah berhasil menghapus
                        fetchStudentData(); // Refresh data setelah penghapusan
                    } else {
                        showError('Gagal menghapus siswa.'); // Tampilkan pesan error
                    }
                } catch (error) {
                    console.error('Delete error:', error);
                    showError('Terjadi kesalahan saat menghapus siswa.'); // Tampilkan pesan error
                }
            }
        }

        // Hapus alert yang tidak perlu saat halaman dimuat
        document.addEventListener('DOMContentLoaded', fetchStudentData); // Fetch data on page load

        function toggleEditModal() {
            const modal = document.getElementById('edit-modal');
            modal.classList.toggle('hidden');
        }

        document.getElementById('add-student-form').addEventListener('submit', async function(event) {
            event.preventDefault(); // Mencegah reload halaman
            const name = document.getElementById('student-name').value;
            const regNumber = document.getElementById('student-reg-number').value;
            const email = document.getElementById('student-email').value;
            const password = document.getElementById('student-password').value;
            const gender = document.getElementById('student-gender').value;
            const semester = document.getElementById('student-semester').value;
            const majorId = document.getElementById('student-major').value;
            const studyProgramId = document.getElementById('student-study-program').value;
            const studentClassId = document.getElementById('student-class').value;
            console.log(name, regNumber, email, password, gender, semester, majorId, studyProgramId, studentClassId); // Tambahkan log untuk memeriksa data

            const token = localStorage.getItem('access_token');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Ambil CSRF token
            try {
                const response = await fetch('http://127.0.0.1:8000/api/admin/students', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken // Tambahkan CSRF token ke header
                    },
                    body: JSON.stringify({
                        name,
                        reg_number: regNumber,
                        email,
                        password,
                        gender,
                        semester,
                        major_id: majorId,
                        study_program_id: studyProgramId,
                        student_class_id: studentClassId
                    })
                });

                if (response.ok) {
                    alert('Siswa berhasil ditambahkan.'); // Alert setelah berhasil menambahkan
                    fetchStudentData(); // Refresh data setelah penambahan
                    toggleModal(); // Tutup modal
                } else {
                    const errorData = await response.json();
                    if (errorData.errors) {
                        // Jika ada kesalahan validasi, tampilkan pesan kesalahan
                        showError(Object.values(errorData.errors).flat().join(', '));
                    } else {
                        showError(errorData.message || 'Gagal menambahkan siswa.'); // Tampilkan pesan error
                    }
                }
            } catch (error) {
                console.error('Error adding student:', error);
                showError('Terjadi kesalahan saat menambahkan siswa.');
            }
        });

        document.getElementById('edit-student-form').addEventListener('submit', async function(event) {
            event.preventDefault(); // Mencegah reload halaman
            const name = document.getElementById('edit-name').value;
            const email = document.getElementById('edit-email').value;
            const password = document.getElementById('edit-password').value; // Ambil password

            const token = localStorage.getItem('access_token');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Ambil CSRF token

            // Siapkan data untuk dikirim
            const dataToUpdate = {
                name,
                email,
            };

            // Jika password diisi, tambahkan ke data yang akan dikirim
            if (password) {
                dataToUpdate.password = password; // Tambahkan password baru
            } else {
                dataToUpdate.password = existingPassword; // Gunakan password yang ada
            }

            try {
                const response = await fetch(`http://127.0.0.1:8000/api/admin/students/${currentStudentId}`, {
                    method: 'PUT', // Gunakan PUT untuk mengupdate data
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken // Tambahkan CSRF token ke header
                    },
                    body: JSON.stringify(dataToUpdate) // Kirim data yang diperbarui
                });

                if (response.ok) {
                    alert('Siswa berhasil diubah.'); // Alert setelah berhasil mengubah
                    fetchStudentData(); // Refresh data setelah pengubahan
                    toggleEditModal(); // Tutup modal
                } else {
                    const errorData = await response.json();
                    if (errorData.errors) {
                        // Jika ada kesalahan validasi, tampilkan pesan kesalahan
                        showError(Object.values(errorData.errors).flat().join(', '));
                    } else {
                        showError(errorData.message || 'Gagal mengubah siswa.'); // Tampilkan pesan error
                    }
                }
            } catch (error) {
                console.error('Error updating student:', error);
                showError('Terjadi kesalahan saat mengubah siswa.');
            }
        });

        async function fetchDropdownData() {
            const token = localStorage.getItem('access_token');
            try {
                const [majorsResponse, studyProgramsResponse, studentClassesResponse] = await Promise.all([
                    fetch('http://127.0.0.1:8000/api/admin/majors', {
                        method: 'GET',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Content-Type': 'application/json'
                        }
                    }),
                    fetch('http://127.0.0.1:8000/api/admin/study-programs', {
                        method: 'GET',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Content-Type': 'application/json'
                        }
                    }),
                    fetch('http://127.0.0.1:8000/api/admin/class', {
                        method: 'GET',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Content-Type': 'application/json'
                        }
                    })
                ]);

                const majors = await majorsResponse.json();
                const studyPrograms = await studyProgramsResponse.json();
                const studentClasses = await studentClassesResponse.json();
                console.log(majors, studyPrograms, studentClasses); // Tambahkan log untuk memeriksa data
                populateDropdowns(majors.data, studyPrograms.data, studentClasses.data);
            } catch (error) {
                console.error('Error fetching dropdown data:', error);
            }
        }

        function populateDropdowns(majors, studyPrograms, studentClasses) {
            const majorSelect = document.getElementById('student-major');
            const studyProgramSelect = document.getElementById('student-study-program');
            const studentClassSelect = document.getElementById('student-class');

            majors.forEach(major => {
                const option = document.createElement('option');
                option.value = major.id;
                option.textContent = major.name;
                majorSelect.appendChild(option);
            });

            studyPrograms.forEach(program => {
                const option = document.createElement('option');
                option.value = program.id;
                option.textContent = program.name;
                studyProgramSelect.appendChild(option);
            });

            studentClasses.forEach(studentClass => {
                const option = document.createElement('option');
                option.value = studentClass.id;
                option.textContent = studentClass.name;
                studentClassSelect.appendChild(option);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            fetchStudentData(); // Fetch data siswa
            // fetchDropdownData(); // Fetch dropdown data
        });
    </script>
</body>

</html>