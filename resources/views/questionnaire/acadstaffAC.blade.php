<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Tambahkan ini -->
     {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
     @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 p-6"> <!-- Tambahkan padding untuk jarak kanan kiri -->
    @include('questionnaire.components.navbarAcadstaff')
    <div class="bg-white p-6 rounded shadow"> <!-- Container utama dibungkus kotak putih -->
        <h2 class="text-lg font-semibold mb-1">Kuesioner Proses Belajar Mengajar Mahasiswa</h2>
        <p class="mb-6 text-gray-600">deskripsi</p>

        <div id="questionnaire-container" class="flex flex-col space-y-4"> <!-- Mengatur pertanyaan dan jawaban secara vertikal -->
            <!-- Pertanyaan akan diisi di sini melalui JavaScript -->
        </div>
        
        <div class="mt-4"> <!-- Tambahkan jarak atas untuk tombol submit -->
            <button id="submit-button" type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">Submit</button>
        </div>
    </div>

    <script>
        const BASE_URL = 'http://127.0.0.1:8000';
        const questionnaireId = new URLSearchParams(window.location.search).get('id');

        let elementId; // Deklarasikan variabel untuk menyimpan ID elemen
        let questionnaire; // Deklarasikan variabel untuk menyimpan data questionnaire

        async function fetchQuestionnaire() {
            try {
                const response = await fetch(`${BASE_URL}/api/acad-staff/acad-staff-questionnaires/${questionnaireId}`, { // Perbaiki URL di sini
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('access_token')}`
                    }
                });
                const data = await response.json();
                console.log('API Response:', data); // Tambahkan log untuk memeriksa respons API
                questionnaire = data.data; // Simpan data questionnaire ke variabel global
                displayQuestions(questionnaire);
            } catch (error) {
                console.error('Error fetching questionnaire:', error);
            }
        }

        function displayQuestions(questionnaire) {
            const container = document.getElementById('questionnaire-container');
            container.innerHTML = '';

            // Tambahkan pemeriksaan untuk memastikan acad_staff_elements ada
            if (!questionnaire || !questionnaire.acad_staff_elements || !Array.isArray(questionnaire.acad_staff_elements)) {
                console.error('Acad staff elements not found or not an array');
                return; // Keluar dari fungsi jika tidak ada elemen
            }

            questionnaire.acad_staff_elements.forEach(element => {
                elementId = element.id; // Simpan ID elemen
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

                element.acad_staff_questions.forEach(question => { // Ganti lecturer_questions dengan acad_staff_questions
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
                        input.name = `question${question.id}`; // Pastikan ini benar
                        input.value = index + 1; // Menggunakan index + 1 sebagai nilai
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

        document.getElementById('submit-button').addEventListener('click', async () => {
            const allAnswered = questionnaire.acad_staff_elements.every(element => {
                return element.acad_staff_questions.every(question => {
                    const inputs = document.querySelectorAll(`input[name="question${question.id}"]`);
                    return [...inputs].some(input => input.checked);
                });
            });

            if (!allAnswered) {
                alert('Silakan isi semua pertanyaan sebelum mengirim.');
                return;
            }

            // Cek token sebelum mengirim
            const token = localStorage.getItem('access_token');
            console.log('Token:', token); // Tambahkan log untuk memeriksa token
            if (!token) {
                alert('Token tidak ditemukan. Silakan login kembali.');
                window.location.href = '/auth/acadstaff'; // Arahkan ke halaman login
                return;
            }

            // Panggil fungsi untuk mengisi kuesioner
            await fillQuestionAC(token); // Pass token as an argument
        });

        async function fillQuestionAC(token) { // Add token as a parameter
            const acadStaffElements = questionnaire.acad_staff_elements.map(element => {
                const answers = {
                    id: [],
                    answer: []
                };

                element.acad_staff_questions.forEach(question => {
                    const input = document.querySelector(`input[name="question${question.id}"]:checked`);
                    if (input) {
                        answers.id.push(question.id);
                        answers.answer.push(Number(input.value));
                    }
                });

                console.log(`Element ID: ${element.id}, Answers:`, answers);

                return {
                    id: element.id,
                    acad_staff_question: answers
                };
            });

            console.log('Acad Staff Elements:', acadStaffElements);

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Kirim data ke server
            const response = await fetch(`${BASE_URL}/api/acad-staff/acad-staff-questionnaires-ac`, { // Perbaiki URL di sini
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`, // Use the token passed as an argument
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    acad_staff_questionnaire: {
                        id: questionnaireId,
                        acad_staff_elements: acadStaffElements
                    }
                })
            });

            const result = await response.json();
            console.log(result);
            if (response.ok) {
                alert('Kuesioner berhasil diisi!');
                window.location.href = `${BASE_URL}/questionnaire/select-acadstaff`;
            } else {
                alert('Terjadi kesalahan: ' + result.message);
            }
        }
    </script>
</body>

</html>
