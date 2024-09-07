<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kuesioner</title>
    @vite('resources/css/app.css')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('access_token');

            console.log('Fetching data...');

            fetch('/api/admin/filled-lecturer-questionnaires', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Data received:', data); // Tampilkan data di konsol
                const tbody = document.getElementById('questionnaire-body');
                tbody.innerHTML = ''; // Kosongkan tbody sebelum menambahkan data

                // Periksa apakah data.data adalah array
                if (Array.isArray(data.data)) {
                    data.data.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="py-2 px-4 border-b border-r">${index + 1}</td>
                            <td class="py-2 px-4 border-b">
                                <strong>Nama Dosen:</strong> ${item.lecturer_name || 'N/A'}<br>
                                <strong>Kuesioner:</strong> ${item.answers.length > 0 ? item.answers[0].lecturer_questionnaire : 'N/A'}<br>
                                <strong>Jawaban:</strong>
                                <ul>
                                    ${item.answers && Array.isArray(item.answers) ? item.answers.map(answer => `
                                        <li>
                                            <strong>Pertanyaan:</strong> ${answer.lecturer_question || 'N/A'}<br>
                                            <strong>${answer.lecturer_element || 'N/A'}:</strong> ${answer.answer || 'N/A'}
                                        </li>
                                    `).join('') : '<li>Tidak ada jawaban.</li>'}
                                </ul>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="2" class="py-2 px-4 border-b">Tidak ada data yang tersedia.</td></tr>';
                }
            })
            .catch(error => console.error('Error:', error));
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
                        <h1 class="text-2xl font-bold mb-4">Hasil Kuesioner Dosen</h1>
                        <p class="text-gray-600 mb-4">Halaman ini menampilkan hasil kuesioner yang diisi oleh Dosen, termasuk informasi pribadi dan jawaban mereka terhadap pertanyaan yang diajukan.</p>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-2 px-4 border-b border-r">No</th>
                                        <th class="py-2 px-4 border-b">Detail Kuesioner</th>
                                    </tr>
                                </thead>
                                <tbody id="questionnaire-body">
                                    <!-- Data akan ditambahkan di sini -->
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
