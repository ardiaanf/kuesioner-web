<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    {{-- Ubah link ke file lokal --}}
    <script src="{{ asset('js/axios.min.js') }}"></script>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
    @include('questionnaire.components.navbarStudent')
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto px-4 py-8">
            <h1 class="text-2xl font-bold mb-6 text-center">Pilih Jenis Kuesioner Mahasiswa</h1>
            <div id="kuesioner-container" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Data kuesioner akan ditampilkan di sini -->
            </div>
        </div>
    </div>

    <script>
        const BASE_URL = 'http://127.0.0.1:8000';
        const token = localStorage.getItem('access_token');

        async function fetchQuestionnaires() {
            try {
                const response = await axios.get(`${BASE_URL}/api/student/student-questionnaires`, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });
                const questionnaires = response.data.data;
                displayQuestionnaires(questionnaires);
            } catch (error) {
                console.error('Error fetching questionnaires:', error);
                alert('Gagal mengambil data kuesioner');
            }
        }

        function displayQuestionnaires(questionnaires) {
            const container = document.getElementById('kuesioner-container');
            container.innerHTML = '';

            questionnaires.forEach(questionnaire => {
                const element = document.createElement('div');
                element.className = 'bg-white rounded-lg shadow-md p-6 cursor-pointer hover:bg-blue-50 transition duration-300';
                element.innerHTML = `
                    <h2 class="text-lg font-semibold mb-2">${questionnaire.name}</h2>
                    <p class="text-sm text-gray-600">${questionnaire.description || 'Tidak ada deskripsi'}</p>
                    <button onclick="startQuestionnaire(${questionnaire.id})" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Mulai Kuesioner</button>
                `;
                container.appendChild(element);
            });
        }

        function startQuestionnaire(id) {
            alert(`Memulai kuesioner dengan ID: ${id}`);
        }

        // Panggil fungsi fetchQuestionnaires saat halaman dimuat
        document.addEventListener('DOMContentLoaded', fetchQuestionnaires);
    </script>
</body>

</html>
