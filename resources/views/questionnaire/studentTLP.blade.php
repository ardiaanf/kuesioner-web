<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Tambahkan meta tag untuk CSRF token -->
</head>

<body class="bg-gray-100 p-6">
    @include('questionnaire.components.navbarStudent')
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-1">Kuesioner Proses Belajar Mengajar Mahasiswa</h2>
        <p class="mb-6 text-gray-600">deskripsi</p>
        
        <div id="selection-container" class="mb-4">
            <label for="major" class="block mb-1">Jurusan:</label>
            <select id="major" class="mb-4 w-1/2 p-1 border rounded">
                <option value="">Pilih...</option>
            </select>

            <label for="study_program" class="block mb-1">Program Studi:</label>
            <select id="study_program" class="mb-4 w-1/2 p-1 border rounded">
                <option value="">Pilih...</option>
            </select>

            <label for="class" class="block mb-1">Kelas:</label>
            <select id="class" class="mb-4 w-1/2 p-1 border rounded">
                <option value="">Pilih...</option>
            </select>

            <label for="course" class="block mb-1">Mata Kuliah:</label>
            <select id="course" class="mb-4 w-1/2 p-1 border rounded">
                <option value="">Pilih...</option>
            </select>

            <label for="lecturer" class="block mb-1">Dosen:</label>
            <select id="lecturer" class="mb-4 w-1/2 p-1 border rounded">
                <option value="">Pilih...</option>
            </select>
        </div>

        <div id="questionnaire-container" class="flex flex-col space-y-4"></div>
        
        <button id="submit-button" type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">Submit</button>
    </div>

    <script>
        const BASE_URL = 'http://127.0.0.1:8000';
        const questionnaireId = new URLSearchParams(window.location.search).get('id');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Ambil CSRF token

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

        async function fetchOptions() {
            try {
                const [majors, studyPrograms, classes, courses, lecturers] = await Promise.all([
                    fetch(`${BASE_URL}/api/student/majors`).then(res => res.json()),
                    fetch(`${BASE_URL}/api/student/study-programs`).then(res => res.json()),
                    fetch(`${BASE_URL}/api/student/class`).then(res => res.json()),
                    fetch(`${BASE_URL}/api/student/course`).then(res => res.json()),
                    fetch(`${BASE_URL}/api/student/lecturer-get`).then(res => res.json())
                ]);

                populateSelectOptions('major', majors.data);
                populateSelectOptions('study_program', studyPrograms.data);
                populateSelectOptions('class', classes.data);
                populateSelectOptions('course', courses.data);
                populateSelectOptions('lecturer', lecturers.data);
            } catch (error) {
                console.error('Error fetching options:', error);
            }
        }

        function populateSelectOptions(selectId, options) {
            const selectElement = document.getElementById(selectId);
            selectElement.innerHTML = '<option value="">Pilih...</option>'; // Tambahkan opsi default
            options.forEach(option => {
                const opt = document.createElement('option');
                opt.value = option.id; // Sesuaikan dengan ID yang sesuai
                opt.textContent = option.name; // Sesuaikan dengan nama yang sesuai
                selectElement.appendChild(opt);
            });
        }

        function displayQuestions(questionnaire) {
            const container = document.getElementById('questionnaire-container');
            container.innerHTML = '';

            questionnaire.student_elements.forEach(element => {
                const elementDiv = document.createElement('div');
                elementDiv.className = 'flex flex-col mb-4';

                const elementTitle = document.createElement('span');
                elementTitle.className = 'font-semibold mb-1';
                elementTitle.textContent = `${element.name}`;
                elementDiv.appendChild(elementTitle);

                if (element.description) {
                    const elementDescription = document.createElement('p');
                    elementDescription.className = 'text-gray-500 mb-2';
                    elementDescription.textContent = element.description;
                    elementDiv.appendChild(elementDescription);
                }

                container.appendChild(elementDiv);

                element.student_questions.forEach(question => {
                    const questionDiv = document.createElement('div');
                    questionDiv.className = 'flex items-center mb-2';
                    const questionLabel = document.createElement('span');
                    questionLabel.className = 'mr-2';
                    questionLabel.textContent = question.question;
                    questionDiv.appendChild(questionLabel);

                    const radioContainer = document.createElement('div');
                    radioContainer.className = 'flex flex-wrap ml-auto';

                    question.range_labels.forEach((label, index) => {
                        const radioLabel = document.createElement('label');
                        radioLabel.className = 'block flex items-center mr-4';
                        const input = document.createElement('input');
                        input.type = 'radio';
                        input.name = `question${question.id}`;
                        input.value = label.key;
                        input.className = 'mr-2';
                        radioLabel.appendChild(input);
                        radioLabel.appendChild(document.createTextNode(label.value));
                        radioContainer.appendChild(radioLabel);

                        if ((index + 1) % 2 === 0) {
                            radioContainer.appendChild(document.createElement('br'));
                        }
                    });

                    questionDiv.appendChild(radioContainer);
                    container.appendChild(questionDiv);
                });
            });
        }

        // Tambahkan event listener untuk jurusan
        document.getElementById('major').addEventListener('change', async (event) => {
            const majorId = event.target.value;
            console.log(`Selected Major ID: ${majorId}`);
            const studyPrograms = await fetch(`${BASE_URL}/api/student/study-programs?major_id=${majorId}`).then(res => res.json());
            console.log('Study Programs:', studyPrograms);
            populateSelectOptions('study_program', studyPrograms.data.filter(program => program.major_id == majorId)); // Filter berdasarkan major_id
            resetSelectOptions(['class', 'course', 'lecturer']);
        });

        // Tambahkan event listener untuk program studi
        document.getElementById('study_program').addEventListener('change', async (event) => {
            const studyProgramId = event.target.value;
            console.log(`Selected Study Program ID: ${studyProgramId}`);
            const classes = await fetch(`${BASE_URL}/api/student/class?study_program_id=${studyProgramId}`).then(res => res.json());
            console.log('Classes:', classes);
            populateSelectOptions('class', classes.data.filter(cls => cls.study_program_id == studyProgramId)); // Filter berdasarkan study_program_id
            resetSelectOptions(['course', 'lecturer']);
        });

        // Tambahkan event listener untuk kelas
        document.getElementById('class').addEventListener('change', async (event) => {
            const classId = event.target.value;
            console.log(`Selected Class ID: ${classId}`);
            const courses = await fetch(`${BASE_URL}/api/student/course?class_id=${classId}`).then(res => res.json());
            console.log('Courses:', courses);
            // Filter courses based on the selected study program
            const studyProgramId = document.getElementById('study_program').value;
            const filteredCourses = courses.data.filter(course => course.study_program_id == studyProgramId);
            populateSelectOptions('course', filteredCourses);
            resetSelectOptions(['lecturer']);
        });

        // Tambahkan event listener untuk mata kuliah
        document.getElementById('course').addEventListener('change', async (event) => {
            const courseId = event.target.value;
            console.log(`Selected Course ID: ${courseId}`);
            
            // Ambil dosen berdasarkan course_id
            const lecturers = await fetch(`${BASE_URL}/api/student/lecturer-get?course_id=${courseId}`).then(res => res.json());
            console.log('Lecturers:', lecturers);
            
            // Pastikan data dosen ada sebelum mengisi dropdown
            if (lecturers.data && lecturers.data.length > 0) {
                populateSelectOptions('lecturer', lecturers.data);
            } else {
                // Jika tidak ada dosen, tampilkan opsi default
                document.getElementById('lecturer').innerHTML = '<option value="">Tidak ada dosen tersedia</option>';
            }
        });

        function resetSelectOptions(selectIds) {
            selectIds.forEach(selectId => {
                const selectElement = document.getElementById(selectId);
                selectElement.innerHTML = '<option value="">Pilih...</option>'; // Reset opsi
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchQuestionnaire();
            fetchOptions();
        });

        // Tambahkan event listener untuk tombol submit
        document.getElementById('submit-button').addEventListener('click', async () => {
            const majorId = document.getElementById('major').value;
            const studyProgramId = document.getElementById('study_program').value;
            const classId = document.getElementById('class').value;
            const courseId = document.getElementById('course').value;
            const lecturerId = document.getElementById('lecturer').value;

            // Ambil pertanyaan dari questionnaire-container
            const studentElements = [];
            const questions = document.querySelectorAll('#questionnaire-container > div');

            questions.forEach((elementDiv, index) => {
                const studentElementId = index + 1; // Sesuaikan dengan ID elemen
                const studentQuestions = {
                    id: [],
                    answer: []
                };

                const questionDivs = elementDiv.querySelectorAll('.flex.items-center');
                questionDivs.forEach(questionDiv => {
                    const questionId = questionDiv.querySelector('input').name.replace('question', '');
                    const answer = questionDiv.querySelector('input:checked')?.value; // Ambil nilai yang dipilih
                    if (questionId && answer) {
                        studentQuestions.id.push(parseInt(questionId)); // Pastikan ID valid
                        studentQuestions.answer.push(parseInt(answer)); // Pastikan jawaban valid
                    }
                });

                // Pastikan studentQuestions.id dan studentQuestions.answer tidak kosong
                if (studentQuestions.id.length > 0 && studentQuestions.answer.length > 0) {
                    studentElements.push({
                        id: studentElementId,
                        student_question: studentQuestions
                    });
                }
            });

            const requestData = {
                major_id: parseInt(majorId),
                study_program_id: parseInt(studyProgramId),
                student_class_id: parseInt(classId),
                course_id: parseInt(courseId),
                lecturer_id: parseInt(lecturerId),
                student_questionnaire: {
                    id: 1, // Ganti dengan ID kuesioner yang sesuai
                    student_elements: studentElements
                }
            };

            console.log(requestData); // Debug: lihat data yang akan dikirim

            try {
                const response = await fetch(`${BASE_URL}/api/student/student-questionnaires-tlp`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
                        'X-CSRF-TOKEN': csrfToken // Sertakan CSRF token di header
                    },
                    body: JSON.stringify(requestData)
                });

                const result = await response.json();
                if (response.ok) {
                    console.log('Questionnaire submitted successfully:', result);
                    // Tampilkan pesan sukses atau lakukan tindakan lain
                } else {
                    console.error('Error submitting questionnaire:', result);
                    // Tampilkan pesan kesalahan
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    </script>
</body>

</html>
