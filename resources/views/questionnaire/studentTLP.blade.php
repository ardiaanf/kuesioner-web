<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                <!-- Tambahkan opsi jurusan di sini -->
            </select>

            <label for="study_program" class="block mb-1">Program Studi:</label>
            <select id="study_program" class="mb-4 w-1/2 p-1 border rounded">
                <option value="">Pilih...</option>
                <!-- Tambahkan opsi program studi di sini -->
            </select>

            <label for="class" class="block mb-1">Kelas:</label>
            <select id="class" class="mb-4 w-1/2 p-1 border rounded">
                <option value="">Pilih...</option>
                <!-- Tambahkan opsi kelas di sini -->
            </select>

            <label for="course" class="block mb-1">Mata Kuliah:</label>
            <select id="course" class="mb-4 w-1/2 p-1 border rounded">
                <option value="">Pilih...</option>
                <!-- Tambahkan opsi mata kuliah di sini -->
            </select>

            <label for="lecturer" class="block mb-1">Dosen:</label>
            <select id="lecturer" class="mb-4 w-1/2 p-1 border rounded">
                <option value="">Pilih...</option>
                <!-- Tambahkan opsi dosen di sini -->
            </select>
        </div>

        <div id="questionnaire-container" class="flex flex-col space-y-4">
            <!-- Tambahkan pertanyaan di sini -->
            <div class="flex flex-col mb-4">
                <span class="font-semibold mb-1">Pertanyaan 1</span>
                <p class="text-gray-500 mb-2">Deskripsi pertanyaan 1</p>
                <div class="flex items-center mb-2">
                    <span class="mr-2">Pertanyaan 1:</span>
                    <div class="flex flex-wrap ml-auto">
                        <label class="block flex items-center mr-4">
                            <input type="radio" name="question1" value="1" class="mr-2"> 1
                        </label>
                        <label class="block flex items-center mr-4">
                            <input type="radio" name="question1" value="2" class="mr-2"> 2
                        </label>
                        <label class="block flex items-center mr-4">
                            <input type="radio" name="question1" value="3" class="mr-2"> 3
                        </label>
                    </div>
                </div>
            </div>
            <!-- Tambahkan pertanyaan lainnya di sini -->
        </div>
        
        <button id="submit-button" type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">Submit</button>
    </div>

    <!-- Hapus script JavaScript untuk tampilan normal -->
</body>

</html>
