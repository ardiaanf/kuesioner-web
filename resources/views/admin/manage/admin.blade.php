<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kuesioner</title>
    @vite('resources/css/app.css')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
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
                        <!-- Tambahkan button untuk tambah admin -->
                        <div class="flex justify-between mb-4">
                            <button class="bg-blue-500 text-white px-4 py-2 rounded my-4" onclick="toggleModal()">Tambah Admin</button>
                        </div>
                        <!-- Modal untuk input admin -->
                        <div id="modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
                            <div class="bg-white p-6 rounded-lg shadow-md w-96"> <!-- Ubah lebar modal -->
                                <h2 class="text-xl font-bold mb-4">Tambah Admin</h2>
                                <form>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Nama</label>
                                        <input type="text" class="border rounded w-full py-2 px-3" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Email</label>
                                        <input type="email" class="border rounded w-full py-2 px-3" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Password</label>
                                        <input type="password" class="border rounded w-full py-2 px-3" required>
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
                                <form>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Nama</label>
                                        <input type="text" id="edit-name" class="border rounded w-full py-2 px-3" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Email</label>
                                        <input type="email" id="edit-email" class="border rounded w-full py-2 px-3" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Password</label>
                                        <input type="password" class="border rounded w-full py-2 px-3" required>
                                    </div>
                                    <div class="flex justify-between">
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Ubah Data</button>
                                        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded" onclick="toggleEditModal()">Tutup</button> <!-- Perbaikan fungsi -->
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

        function openEditModal(name, email) {
            const modal = document.getElementById('edit-modal');
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-email').value = email;
            modal.classList.remove('hidden');
        }

        async function fetchAdminData() {
            const token = localStorage.getItem('access_token');
            console.log("Token:", token); // Debugging token
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
                console.log("Data:", data); // Debugging data
                if (data.success) {
                    displayAdminData(data.data); // Pastikan data.data berisi array admin
                } else {
                    alert(data.message || 'Gagal mengambil data admin'); // Menangani kesalahan
                }
            } catch (error) {
                console.error('Fetch error:', error); // Log error
                alert('Terjadi kesalahan saat mengambil data admin');
            }
        }

        function displayAdminData(admins) {
            const tbody = document.querySelector('tbody');
            tbody.innerHTML = ''; // Clear existing data
            if (admins.length === 0) {
                tbody.innerHTML = '<tr><td colspan="3" class="text-center">Tidak ada data admin</td></tr>'; // Menampilkan pesan jika tidak ada data
            } else {
                admins.forEach(admin => {
                    const row = `
                        <tr class="border-b">
                            <td class="py-2 px-4 border">${admin.name}</td>
                            <td class="py-2 px-4 border">${admin.email}</td>
                            <td class="py-2 px-4 border">
                                <button class="bg-yellow-500 text-white px-2 py-1 rounded" onclick="openEditModal('${admin.name}', '${admin.email}')">Edit</button>
                                <button class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });
            }
        }

        document.addEventListener('DOMContentLoaded', fetchAdminData); // Fetch data on page load

        function toggleEditModal() {
            const modal = document.getElementById('edit-modal');
            modal.classList.toggle('hidden');
        }
    </script>
</body>
</html>
