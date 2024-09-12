<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- @vite('resources/css/app.css') --}}
</head>

<body class="bg-gray-100">
    @include('questionnaire.components.navbarLecturer')
    <div class="container mx-auto px-4 ">
        <div class="max-w-3xl mx-auto px-4 py-8 ">
            <h1 class="text-2xl font-bold mb-6 text-center">Pilih Jenis Kuesioner Dosen</h1>
            <div id="kuesioner-container" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Kuesioner akan ditampilkan di sini -->
            </div>
        </div>
    </div>

    <script>
        const BASE_URL = 'http://127.0.0.1:8000';
        const token = localStorage.getItem('access_token');

        async function fetchKuesioner() {
            try {
                const response = await fetch(`${BASE_URL}/api/lecturer/lecturer-questionnaires`, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                });
                const data = await response.json();
                return data.data;
            } catch (error) {
                console.error('Error:', error);
                return [];
            }
        }

        function createKuesionerElement(kuesioner) {
            return `
                <div class="bg-white rounded-lg shadow-md p-6 cursor-pointer hover:bg-blue-50 transition duration-300">
                    <h2 class="text-lg font-semibold mb-2">${kuesioner.name}</h2>
                    <p class="text-sm text-gray-600">${kuesioner.description || 'Tidak ada deskripsi'}</p>
                    <button onclick="mulaiKuesioner(${kuesioner.id})" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Mulai Kuesioner</button>
                </div>
            `;
        }

        async function displayKuesioner() {
            const kuesionerList = await fetchKuesioner();
            const container = document.getElementById('kuesioner-container');
            container.innerHTML = kuesionerList.map(createKuesionerElement).join('');
        }

        function mulaiKuesioner(id) {
            // Mengarahkan ke halaman kuesioner dengan ID yang sesuai
            window.location.href = `/questionnaire/ac-lecturer?id=${id}`;
        }

        // Panggil fungsi untuk menampilkan kuesioner saat halaman dimuat
        displayKuesioner();
    </script>
</body>

</html>
