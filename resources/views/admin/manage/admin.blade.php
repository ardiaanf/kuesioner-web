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
                        <h2 class="text-xl font-bold mb-4">Daftar Admin</h2>
                        <table class="min-w-full bg-white border border-gray-300"> <!-- Tambahkan border pada tabel -->
                            <thead>
                                <tr class="w-full bg-gray-200">
                                    <th class="py-2 px-4 border">Nama</th> <!-- Tambahkan border pada header -->
                                    <th class="py-2 px-4 border">Email</th> <!-- Tambahkan border pada header -->
                                    <th class="py-2 px-4 border">Aksi</th> <!-- Tambahkan border pada header -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data admin akan ditampilkan di sini -->
                            </tbody>
                        </table>
                        <div id="error-message" class="text-red-500 mt-2 hidden"></div> <!-- Tempat untuk menampilkan pesan error -->
                        <!-- Tambahkan button untuk tambah admin -->
                        <div class="flex justify-between mb-4">
                            <button class="bg-blue-500 text-white px-4 py-2 rounded my-4" onclick="toggleModal()">Tambah Admin</button>
                        </div>
                        <!-- Modal untuk input admin -->
                        <div id="modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
                            <div class="bg-white p-6 rounded-lg shadow-md w-96"> <!-- Ubah lebar modal -->
                                <h2 class="text-xl font-bold mb-4">Tambah Admin</h2>
                                <form id="add-admin-form">
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Nama</label>
                                        <input type="text" id="admin-name" class="border rounded w-full py-2 px-3" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Email</label>
                                        <input type="email" id="admin-email" class="border rounded w-full py-2 px-3" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Password</label>
                                        <input type="password" id="admin-password" class="border rounded w-full py-2 px-3" required>
                                    </div>
                                    <div class="flex justify-between">
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
                                        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded" onclick="toggleModal()">Tutup</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Modal untuk edit admin -->
                        <div id="edit-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
                            <div class="bg-white p-6 rounded-lg shadow-md w-96"> <!-- Ubah lebar modal -->
                                <h2 class="text-xl font-bold mb-4">Edit Admin</h2>
                                <form id="edit-admin-form">
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Nama</label>
                                        <input type="text" id="edit-name" class="border rounded w-full py-2 px-3" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Email</label>
                                        <input type="email" id="edit-email" class="border rounded w-full py-2 px-3" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Password (isi jika ingin mengubah)</label>
                                        <input type="password" id="edit-password" class="border rounded w-full py-2 px-3" placeholder="Isi password baru jika ingin mengubah">
                                    </div>
                                    <div class="flex justify-between">
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Ubah Data</button>
                                        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded" onclick="toggleEditModal()">Tutup</button>
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
        function toggleModal() {
            const modal = document.getElementById('modal');
            modal.classList.toggle('hidden');
        }

        let currentAdminId; // Variabel global untuk menyimpan ID admin yang sedang diedit
        let existingPassword; // Variabel global untuk menyimpan password yang ada

        function openEditModal(id, name, email, password) {
            const modal = document.getElementById('edit-modal');
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-password').value = ''; // Kosongkan input password
            existingPassword = password; // Simpan password yang ada
            currentAdminId = id; // Simpan ID admin yang sedang diedit
            modal.classList.remove('hidden');
        }

        async function fetchAdminData() {
            const token = localStorage.getItem('access_token');
            try {
                const response = await fetch('http://127.0.0.1:8000/api/admin/admins', {
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
                console.log(data); // Tambahkan log untuk memeriksa data
                if (data.message === 'Admins retrieved successfully.') { // Perbaikan kondisi
                    displayAdminData(data.data); // Pastikan data.data berisi array admin
                    document.getElementById('error-message').classList.add('hidden'); // Sembunyikan pesan error jika berhasil
                } else {
                    showError(data.message || 'Gagal mengambil data admin'); // Menangani kesalahan
                }
            } catch (error) {
                console.error('Fetch error:', error); // Log error
                showError('Terjadi kesalahan saat mengambil data admin');
            }
        }

        function displayAdminData(admins) {
            const tbody = document.querySelector('tbody');
            tbody.innerHTML = ''; // Clear existing data
            if (!Array.isArray(admins) || admins.length === 0) {
                tbody.innerHTML = '<tr><td colspan="3" class="text-center">Tidak ada data admin</td></tr>'; // Menampilkan pesan jika tidak ada data
            } else {
                admins.forEach(admin => {
                    const row = `
                        <tr class="border-b">
                            <td class="py-2 px-4 border">${admin.name}</td>
                            <td class="py-2 px-4 border">${admin.email}</td>
                            <td class="py-2 px-4 border">
                                <button class="bg-yellow-500 text-white px-2 py-1 rounded" onclick="openEditModal(${admin.id}, '${admin.name}', '${admin.email}', '${admin.password}')">Edit</button>
                                <button class="bg-red-500 text-white px-2 py-1 rounded" onclick="deleteAdmin(${admin.id})">Hapus</button>
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

        async function deleteAdmin(id) {
            const token = localStorage.getItem('access_token');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Ambil CSRF token
            const confirmation = confirm('Apakah Anda yakin ingin menghapus admin ini?'); // Konfirmasi hapus
            if (confirmation) {
                try {
                    const response = await fetch(`http://127.0.0.1:8000/api/admin/admins/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken // Tambahkan CSRF token ke header
                        }
                    });
                    if (response.ok) {
                        alert('Admin berhasil dihapus.'); // Alert setelah berhasil menghapus
                        fetchAdminData(); // Refresh data setelah penghapusan
                    } else {
                        showError('Gagal menghapus admin.'); // Tampilkan pesan error
                    }
                } catch (error) {
                    console.error('Delete error:', error);
                    showError('Terjadi kesalahan saat menghapus admin.'); // Tampilkan pesan error
                }
            }
        }

        // Hapus alert yang tidak perlu saat halaman dimuat
        document.addEventListener('DOMContentLoaded', fetchAdminData); // Fetch data on page load

        function toggleEditModal() {
            const modal = document.getElementById('edit-modal');
            modal.classList.toggle('hidden');
        }

        document.getElementById('add-admin-form').addEventListener('submit', async function(event) {
            event.preventDefault(); // Mencegah reload halaman
            const name = document.getElementById('admin-name').value;
            const email = document.getElementById('admin-email').value;
            const password = document.getElementById('admin-password').value;

            const token = localStorage.getItem('access_token');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Ambil CSRF token
            try {
                const response = await fetch('http://127.0.0.1:8000/api/admin/admins', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken // Tambahkan CSRF token ke header
                    },
                    body: JSON.stringify({ name, email, password })
                });

                if (response.ok) {
                    alert('Admin berhasil ditambahkan.'); // Alert setelah berhasil menambahkan
                    fetchAdminData(); // Refresh data setelah penambahan
                    toggleModal(); // Tutup modal
                } else {
                    const errorData = await response.json();
                    if (errorData.errors) {
                        // Jika ada kesalahan validasi, tampilkan pesan kesalahan
                        showError(Object.values(errorData.errors).flat().join(', '));
                    } else {
                        showError(errorData.message || 'Gagal menambahkan admin.'); // Tampilkan pesan error
                    }
                }
            } catch (error) {
                console.error('Error adding admin:', error);
                showError('Terjadi kesalahan saat menambahkan admin.');
            }
        });

        document.getElementById('edit-admin-form').addEventListener('submit', async function(event) {
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
                const response = await fetch(`http://127.0.0.1:8000/api/admin/admins/${currentAdminId}`, {
                    method: 'PUT', // Gunakan PUT untuk mengupdate data
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken // Tambahkan CSRF token ke header
                    },
                    body: JSON.stringify(dataToUpdate) // Kirim data yang diperbarui
                });

                if (response.ok) {
                    alert('Admin berhasil diubah.'); // Alert setelah berhasil mengubah
                    fetchAdminData(); // Refresh data setelah pengubahan
                    toggleEditModal(); // Tutup modal
                } else {
                    const errorData = await response.json();
                    if (errorData.errors) {
                        // Jika ada kesalahan validasi, tampilkan pesan kesalahan
                        showError(Object.values(errorData.errors).flat().join(', '));
                    } else {
                        showError(errorData.message || 'Gagal mengubah admin.'); // Tampilkan pesan error
                    }
                }
            } catch (error) {
                console.error('Error updating admin:', error);
                showError('Terjadi kesalahan saat mengubah admin.');
            }
        });
    </script>
</body>
</html>
