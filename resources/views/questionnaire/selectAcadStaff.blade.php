<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @vite('resources/css/app.css')
    <script src="{{ asset('js/axios.min.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> --}}
</head>

<body class="bg-gray-100">
    @include('questionnaire.components.navbarAcadstaff')
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto px-4 py-8">
            <h1 class="text-2xl font-bold mb-6 text-center">Pilih Jenis Kuesioner Tenaga Kependidikan</h1>
            <div id="questionnaire-list" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Kuesioner akan ditampilkan di sini -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('access_token');
            if (!token) {
                window.location.href = '/auth/acadstaff';
                return;
            }

            axios.get('/api/acad-staff/acad-staff-questionnaires', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(function (response) {
                const questionnaires = response.data.data;
                const questionnaireList = document.getElementById('questionnaire-list');

                questionnaires.forEach(questionnaire => {
                    const questionnaireElement = document.createElement('div');
                    questionnaireElement.className = 'bg-white rounded-lg shadow-md p-6 cursor-pointer hover:bg-blue-50 transition duration-300';
                    questionnaireElement.innerHTML = `
                        <h2 class="text-lg font-semibold mb-2">${questionnaire.name}</h2>
                        <p class="text-sm text-gray-600">${questionnaire.description || 'Tidak ada deskripsi'}</p>
                        <button class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600" onclick="startQuestionnaire(${questionnaire.id})">Mulai Kuesioner</button>
                    `;
                    questionnaireList.appendChild(questionnaireElement);
                });
            })
            .catch(function (error) {
                console.error('Error fetching questionnaires:', error);
            });
        });

        function startQuestionnaire(id) {
            // Arahkan ke halaman kuesioner berdasarkan ID
            window.location.href = `/questionnaire/ac-acadstaff?id=${id}`; // Ganti dengan URL yang sesuai
        }
    </script>
</body>

</html>
