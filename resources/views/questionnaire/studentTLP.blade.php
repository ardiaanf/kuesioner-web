<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
     @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 p-6"> <!-- Tambahkan padding untuk jarak kanan kiri -->
    @include('questionnaire.components.navbarStudent')
    <div class="bg-white p-6 rounded shadow"> <!-- Container utama dibungkus kotak putih -->
        <h2 class="text-lg font-semibold mb-1">Kuesioner Proses Belajar Mengajar Mahasiswa</h2>
        <p class="mb-6 text-gray-600">deskripsi</p>
        
        <div id="selection-container" class="mb-4"> <!-- Container untuk select options -->
            <label for="major" class="block mb-1">Jurusan:</label>
            <select id="major" class="mb-4 w-1/2 p-1 border rounded"> <!-- Mengubah lebar menjadi setengah -->
                <!-- Options for major will be populated here -->
            </select>

            <label for="study_program" class="block mb-1">Program Studi:</label>
            <select id="study_program" class="mb-4 w-1/2 p-1 border rounded"> <!-- Mengubah lebar menjadi setengah -->
                <!-- Options for study program will be populated here -->
            </select>

            <label for="class" class="block mb-1">Kelas:</label>
            <select id="class" class="mb-4 w-1/2 p-1 border rounded"> <!-- Mengubah lebar menjadi setengah -->
                <!-- Options for class will be populated here -->
            </select>

            <label for="course" class="block mb-1">Mata Kuliah:</label>
            <select id="course" class="mb-4 w-1/2 p-1 border rounded"> <!-- Mengubah lebar menjadi setengah -->
                <!-- Options for course will be populated here -->
            </select>

            <label for="lecturer" class="block mb-1">Dosen:</label>
            <select id="lecturer" class="mb-4 w-1/2 p-1 border rounded"> <!-- Mengubah lebar menjadi setengah -->
                <!-- Options for lecturer will be populated here -->
            </select>
        </div>

        <div id="questionnaire-container" class="flex flex-col space-y-4"> <!-- Mengatur pertanyaan dan jawaban secara vertikal -->
            <!-- Pertanyaan akan diisi di sini melalui JavaScript -->
        </div>
        
        <button id="submit-button" type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">Submit</button>
    </div>

    <script>
        const BASE_URL = 'http://127.0.0.1:8000';
        const questionnaireId = new URLSearchParams(window.location.search).get('id');

        async function fetchQuestionnaire() {
            try {
                const response = await fetch(`${BASE_URL}/api/student/student-questionnaires/${questionnaireId}`, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('access_token')}`
                    }
                });
                const data = await response.json();
                displayQuestions(data.data);
            } catch (error) {
                console.error('Error fetching questionnaire:', error);
            }
        }

        function displayQuestions(questionnaire) {
            const container = document.getElementById('questionnaire-container');
            container.innerHTML = '';

            questionnaire.student_elements.forEach(element => {
                const elementDiv = document.createElement('div');
                elementDiv.className = 'flex flex-col mb-4';

                // Menampilkan ID dan Nama Elemen
                const elementTitle = document.createElement('span');
                elementTitle.className = 'font-semibold mb-1'; // Mengurangi margin bawah
                elementTitle.textContent = `${element.name}`; // Menampilkan Nama Elemen
                elementDiv.appendChild(elementTitle);

                // Menampilkan deskripsi jika ada
                if (element.description) {
                    const elementDescription = document.createElement('p');
                    elementDescription.className = 'text-gray-500 mb-2';
                    elementDescription.textContent = element.description; // Menampilkan deskripsi
                    elementDiv.appendChild(elementDescription);
                }

                // Menambahkan elemen ke container sebelum pertanyaan
                container.appendChild(elementDiv); // Menambahkan elemen ke container

                element.student_questions.forEach(question => {
                    const questionDiv = document.createElement('div');
                    questionDiv.className = 'flex items-center mb-2'; // Menambahkan margin bawah untuk batas
                    const questionLabel = document.createElement('span');
                    questionLabel.className = 'mr-2';
                    questionLabel.textContent = question.question; // Teks pertanyaan
                    questionDiv.appendChild(questionLabel);

                    const radioContainer = document.createElement('div');
                    radioContainer.className = 'flex flex-wrap ml-auto'; // Mengubah flex menjadi horizontal dan mengatur ke kanan

                    // Menggunakan range_labels untuk opsi
                    question.range_labels.forEach((label, index) => {
                        const radioLabel = document.createElement('label');
                        radioLabel.className = 'block flex items-center mr-4'; // Menambahkan margin kanan untuk jarak antar opsi
                        const input = document.createElement('input');
                        input.type = 'radio';
                        input.name = `question${question.id}`; // Menggunakan ID pertanyaan untuk grup
                        input.value = label.key; // Menggunakan key dari range_labels sebagai nilai
                        input.className = 'mr-2'; // Menambahkan margin kanan pada input
                        radioLabel.appendChild(input);
                        radioLabel.appendChild(document.createTextNode(label.value)); // Menampilkan value dari range_labels
                        radioContainer.appendChild(radioLabel);

                        // Menambahkan batas untuk dua kolom
                        if ((index + 1) % 2 === 0) {
                            radioContainer.appendChild(document.createElement('br')); // Menambahkan line break setelah dua opsi
                        }
                    });

                    questionDiv.appendChild(radioContainer);
                    container.appendChild(questionDiv); // Menambahkan pertanyaan ke container
                });
            });
        }

        document.addEventListener('DOMContentLoaded', fetchQuestionnaire);
    </script>
</body>

</html>
