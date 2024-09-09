<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kuesioner</title>
    @vite('resources/css/app.css')
    
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
                        <h1 class="text-2xl font-bold mb-4">Hasil Kuesioner Mahasiswa</h1>
                        <p class="text-gray-600 mb-4">Halaman ini menampilkan hasil kuesioner yang diisi oleh mahasiswa, termasuk informasi pribadi dan jawaban mereka terhadap pertanyaan yang diajukan.</p>

                        <!-- Select Option -->
                        <select onchange="toggleQuestionnaire(this.value)" class="mb-4 border-transparent focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="">Pilih Jenis Kuesioner</option>
                            <option value="TLP">Proses Belajar Mengajar</option>
                            <option value="AC">Civitas Akademika</option>
                        </select>

                        <!-- Questionnaire Details -->
                        <div id="questionnaire-details"></div>

                        <!-- TLP Questionnaire -->
                        <div id="tlp" style="display:none;">
                            <!-- Data TLP akan ditampilkan di sini -->
                        </div>

                        <!-- AC Questionnaire -->
                        <div id="ac" style="display:none;">
                            <!-- Data AC akan ditampilkan di sini -->
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        async function toggleQuestionnaire(value) {
            if (value === 'TLP') {
                await fetchQuestionnaireData('TLP');
            } else if (value === 'AC') {
                await fetchQuestionnaireData('AC');
            }
        }

        async function fetchQuestionnaireData(type) {
            const response = await fetch(`/api/admin/filled-student-questionnaires?type=${type}`);
            if (response.ok) {
                const data = await response.json();
                if (!data.error) {
                    displayQuestionnaireData(data.data);
                } else {
                    alert(data.message); // Menampilkan pesan kesalahan jika ada
                }
            } else {
                alert(`Data ${type} tidak ditemukan.`); // Menangani kesalahan 404
            }
            document.getElementById('tlp').style.display = type === 'TLP' ? 'block' : 'none';
            document.getElementById('ac').style.display = type === 'AC' ? 'block' : 'none';
        }

        function displayQuestionnaireData(data) {
            // Clear previous data
            const container = document.getElementById('questionnaire-details');
            if (data) {
                container.innerHTML = `
                    
                    <table class="border-collapse border border-gray-300">
                        <thead>
                            <tr>
                                <th class="border border-gray-300">No</th>
                                <th class="border border-gray-300">Detail Kuesioner</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.answers && Array.isArray(data.answers) ? data.answers.map((answer, index) => `
                                <tr>
                                    <td class="border border-gray-300">${index + 1}</td>
                                    <td class="border border-gray-300">
                                        <h2>${data.course}</h2>
                                        <p><strong>Nama:</strong> ${data.name}</p>
                                        <p><strong>Nomor Induk:</strong> ${data.reg_number}</p>
                                        <p><strong>Email:</strong> ${data.email}</p>
                                        <p><strong>Jurusan:</strong> ${data.major}</p>
                                        <p><strong>Program Studi:</strong> ${data.study_program}</p>
                                        <p><strong>Kelas:</strong> ${data.student_class}</p>
                                        <p><strong>Dosen:</strong> ${data.lecturer}</p>
                                        <p><strong>Tanggal:</strong> ${new Date(data.created_at).toLocaleDateString()}</p>
                                        <p><strong>Pertanyaan:</strong> ${answer.question}</p>
                                        <p><strong>Jawaban:</strong> ${answer.answer}</p>
                                    </td>
                                </tr>
                            `).join('') : '<tr><td colspan="2" class="border border-gray-300">Tidak ada jawaban untuk ditampilkan.</td></tr>'}
                        </tbody>
                    </table>
                `;
            } else {
                container.innerHTML = '<p>Tidak ada data untuk ditampilkan.</p>'; // Menangani jika data tidak ada
            }
        }
    </script>
</body>
</html>
