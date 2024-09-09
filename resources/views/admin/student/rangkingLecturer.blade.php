<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kuesioner</title>
    @vite('resources/css/app.css')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mengambil data program studi
            fetch('/api/admin/study-programs') // Ganti dengan URL API yang sesuai
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById('program-studi');
                    data.data.forEach(program => {
                        const option = document.createElement('option');
                        option.value = program.id;
                        option.textContent = program.name;
                        select.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching study programs:', error));

            // Mengambil data elemen kuesioner
            fetch('/api/admin/student-elements') // Ganti dengan URL API yang sesuai
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById('student-element');
                    data.data.forEach(element => {
                        // Hanya menambahkan opsi untuk "Teori" dan "Praktikum"
                        if (element.name === 'Teori' || element.name === 'Praktikum') {
                            const option = document.createElement('option');
                            option.value = element.id;
                            option.textContent = element.name;
                            select.appendChild(option);
                        }
                    });
                })
                .catch(error => console.error('Error fetching student elements:', error));

            // Fungsi untuk mendapatkan peringkat dosen awal
            function getLecturerRanking() {
                fetch('/api/admin/lecturer-ranking')
                    .then(response => response.json())
                    .then(data => {
                        const tbody = document.getElementById('lecturer-ranking-body');
                        tbody.innerHTML = ''; // Clear existing rows

                        data.data.forEach((lecturer, index) => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td class="py-2 px-4 border-b border-r">${index + 1}</td>
                                <td class="py-2 px-4 border-b border-r">${lecturer.name}</td>
                                <td class="py-2 px-4 border-b border-r">${lecturer.reg_number}</td>
                                <td class="py-2 px-4 border-b border-r">${lecturer.average_theory || 'N/A'}</td>
                                <td class="py-2 px-4 border-b border-r">${lecturer.average_practicum || 'N/A'}</td>
                                <td class="py-2 px-4 border-b border-r">${lecturer.total_average || 'N/A'}</td>
                            `;
                            tbody.appendChild(row);
                        });
                    })
                    .catch(error => console.error('Error fetching lecturer rankings:', error));
            }

            // Event listener untuk tombol submit program studi
            document.getElementById('submit-ranking').addEventListener('click', function() {
                const programId = document.getElementById('program-studi').value;
                const elementId = document.getElementById('student-element').value;

                fetch(`/api/admin/lecturer-ranking?study_program_id=${programId}&student_element_id=${elementId}`)
                    .then(response => response.json())
                    .then(data => {
                        const tbody = document.getElementById('lecturer-ranking-body');
                        tbody.innerHTML = ''; // Clear existing rows

                        data.data.forEach((lecturer, index) => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td class="py-2 px-4 border-b border-r">${index + 1}</td>
                                <td class="py-2 px-4 border-b border-r">${lecturer.name}</td>
                                <td class="py-2 px-4 border-b border-r">${lecturer.reg_number}</td>
                                <td class="py-2 px-4 border-b border-r">${lecturer.average_theory || 'N/A'}</td>
                                <td class="py-2 px-4 border-b border-r">${lecturer.average_practicum || 'N/A'}</td>
                                <td class="py-2 px-4 border-b border-r">${lecturer.total_average || 'N/A'}</td>
                            `;
                            tbody.appendChild(row);
                        });
                    })
                    .catch(error => console.error('Error fetching lecturer rankings:', error));
            });

            // Event listener untuk tombol submit elemen kuesioner
            document.getElementById('submit-element-ranking').addEventListener('click', function() {
                const programId = document.getElementById('program-studi').value;
                const elementId = document.getElementById('student-element').value;

                fetch(`/api/admin/lecturer-ranking-by-study-program-id-and-sort?study_program_id=${programId}&student_element_id=${elementId}`)
                    .then(response => response.json())
                    .then(data => {
                        const tbody = document.getElementById('lecturer-ranking-body');
                        tbody.innerHTML = ''; // Clear existing rows

                        data.data.forEach((lecturer, index) => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td class="py-2 px-4 border-b border-r">${index + 1}</td>
                                <td class="py-2 px-4 border-b border-r">${lecturer.name}</td>
                                <td class="py-2 px-4 border-b border-r">${lecturer.reg_number}</td>
                                <td class="py-2 px-4 border-b border-r">${lecturer.average_theory || 'N/A'}</td>
                                <td class="py-2 px-4 border-b border-r">${lecturer.average_practicum || 'N/A'}</td>
                                <td class="py-2 px-4 border-b border-r">${lecturer.total_average || 'N/A'}</td>
                            `;
                            tbody.appendChild(row);
                        });
                    })
                    .catch(error => console.error('Error fetching lecturer rankings by sort:', error));
            });

            // Menampilkan peringkat dosen awal saat halaman dimuat
            getLecturerRanking();
        });
    </script>
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
                        <h1 class="text-2xl font-bold mb-4">Hasil Peringkat Kinerja Dosen </h1>

                        <label for="program-studi" class="block text-sm font-medium text-gray-700 mb-2">Progam studi</label>
                        <select id="program-studi" class="block w-1/2 p-1 border border-gray-300 hover:border-gray-300 rounded-md mb-4">
                            <!-- Opsi akan diisi oleh JavaScript -->
                        </select>
                        <button id="submit-ranking" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 mb-4">Submit</button>

                        <label for="student-element" class="block text-sm font-medium text-gray-700 mb-2">Elemen kuesioner</label>
                        <select id="student-element" class="block w-1/2 p-1 border border-gray-300 hover:border-gray-300 rounded-md mb-4">
                            <!-- Opsi akan diisi oleh JavaScript -->
                        </select>
                        <button id="submit-element-ranking" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 mb-4">Sort</button>

                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-2 px-4 border-b border-r">No</th>
                                        <th class="py-2 px-4 border-b border-r">Nama Dosen</th>
                                        <th class="py-2 px-4 border-b border-r">Nomor induk</th>
                                        <th class="py-2 px-4 border-b border-r">Rata - rata teori</th>
                                        <th class="py-2 px-4 border-b border-r">Rata - rata praktikum</th>
                                        <th class="py-2 px-4 border-b border-r">Rata - rata total</th>
                                    </tr>
                                </thead>
                                <tbody id="lecturer-ranking-body">
                                    <!-- Data peringkat dosen akan diisi di sini -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
