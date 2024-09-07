<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
     @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 p-6"> <!-- Tambahkan padding untuk jarak kanan kiri -->
    @include('questionnaire.components.navbarAcadstaff')
    <div class="bg-white p-6 rounded shadow"> <!-- Container utama dibungkus kotak putih -->
        <h2 class="text-lg font-semibold mb-1">Kuesioner Civitas Akademika Tenaga Kependidikan</h2>
        <p class="mb-4 text-gray-600">deskripsi</p>
        <div class="flex flex-col space-y-4"> <!-- Mengatur pertanyaan dan jawaban secara vertikal -->
            <div class="flex">
                <span class="mr-2">Pertanyaan 1:</span>
                <div class="flex flex-col ml-4"> <!-- Container untuk radio button -->
                    <label class="block flex items-center">
                        <input type="radio" name="question1" value="1" class="mr-2">
                        <span>Opsi 1</span>
                    </label>
                    <label class="block flex items-center">
                        <input type="radio" name="question1" value="2" class="mr-2">
                        <span>Opsi 2</span>
                    </label>
                    <label class="block flex items-center">
                        <input type="radio" name="question1" value="3" class="mr-2">
                        <span>Opsi 3</span>
                    </label>
                    <label class="block flex items-center">
                        <input type="radio" name="question1" value="4" class="mr-2">
                        <span>Opsi 4</span>
                    </label>
                </div>
            </div>
            <div class="flex">
                <span class="mr-2">Pertanyaan 2:</span>
                <div class="flex flex-col ml-4"> <!-- Container untuk radio button -->
                    <label class="block flex items-center">
                        <input type="radio" name="question2" value="1" class="mr-2">
                        <span>Opsi 1</span>
                    </label>
                    <label class="block flex items-center">
                        <input type="radio" name="question2" value="2" class="mr-2">
                        <span>Opsi 2</span>
                    </label>
                    <label class="block flex items-center">
                        <input type="radio" name="question2" value="3" class="mr-2">
                        <span>Opsi 3</span>
                    </label>
                    <label class="block flex items-center">
                        <input type="radio" name="question2" value="4" class="mr-2">
                        <span>Opsi 4</span>
                    </label>
                </div>
            </div>
            <div class="flex">
                <span class="mr-2">Pertanyaan 3:</span>
                <div class="flex flex-col ml-4"> <!-- Container untuk radio button -->
                    <label class="block flex items-center">
                        <input type="radio" name="question3" value="1" class="mr-2">
                        <span>Opsi 1</span>
                    </label>
                    <label class="block flex items-center">
                        <input type="radio" name="question3" value="2" class="mr-2">
                        <span>Opsi 2</span>
                    </label>
                    <label class="block flex items-center">
                        <input type="radio" name="question3" value="3" class="mr-2">
                        <span>Opsi 3</span>
                    </label>
                    <label class="block flex items-center">
                        <input type="radio" name="question3" value="4" class="mr-2">
                        <span>Opsi 4</span>
                    </label>
                </div>
            </div>
            <div class="flex">
                <span class="mr-2">Pertanyaan 4:</span>
                <div class="flex flex-col ml-4"> <!-- Container untuk radio button -->
                    <label class="block flex items-center">
                        <input type="radio" name="question4" value="1" class="mr-2">
                        <span>Opsi 1</span>
                    </label>
                    <label class="block flex items-center">
                        <input type="radio" name="question4" value="2" class="mr-2">
                        <span>Opsi 2</span>
                    </label>
                    <label class="block flex items-center">
                        <input type="radio" name="question4" value="3" class="mr-2">
                        <span>Opsi 3</span>
                    </label>
                    <label class="block flex items-center">
                        <input type="radio" name="question4" value="4" class="mr-2">
                        <span>Opsi 4</span>
                    </label>
                </div>
            </div>
        </div>
        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">Submit</button>
    </div>
</body>

</html>
