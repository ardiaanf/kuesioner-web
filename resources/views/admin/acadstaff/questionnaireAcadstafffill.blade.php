<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kuesioner</title>
    <script src="https://cdn.tailwindcss.com"></script>

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
                        <h1 class="text-2xl font-bold mb-4">Hasil Kuesioner Tenaga Kependidikan</h1>
                        <p class="text-gray-600 mb-4">Halaman ini menampilkan hasil kuesioner yang diisi oleh Tenaga Kependidikan, termasuk informasi pribadi dan jawaban mereka terhadap pertanyaan yang diajukan.</p>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-2 px-4 border-b border-r">No</th>
                                        <th class="py-2 px-4 border-b">Detail Kuesioner</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="py-2 px-4 border-b border-r">1</td>
                                        <td class="py-2 px-4 border-b">
                                            <strong>Nama Tenaga Kependidikan:</strong> Aris Yusuf Budiman S.Psi<br>
                                            <strong>Kuesioner:</strong> Kuesioner civitas akademika Tenaga kependidikan<br>
                                            <strong>Jawaban:</strong>
                                            <ul>
                                                <li><strong>Visi Misi:</strong> Rencana materi dan tujuan mata kuliah diberikan di awal perkuliahan - Jawaban: 3</li>
                                                <li><strong>Visi Misi Strategi:</strong> Tenaga kependidikan datang tepat waktu & mengajar sesuai waktu yang terjadwal - Jawaban: 1</li>
                                                <li><strong>Visi Misi Strategi:</strong> Diadakan diskusi & tanya jawab - Jawaban: 3</li>
                                                <li><strong>Visi Misi Strategi:</strong> Manfaat soal latihan dalam menambah pemahaman mata kuliah ini - Jawaban: 1</li>
                                                <li><strong>Visi Misi Strategi:</strong> Kesesuaian evaluasi (tugas dan Quiz) dengan materi yang diajarkan - Jawaban: 2</li>
                                                <li><strong>Pelatihan:</strong> Pelaksanaan praktikum tepat waktu dan sesuai dengan waktu yang terjadwal - Jawaban: 1</li>
                                                <li><strong>Pelatihan:</strong> Praktikum menambah pemahaman teori dan ketrampilan waktu yang terjadwal - Jawaban: 2</li>
                                                <li><strong>Pelatihan:</strong> Setiap percobaan/praktikum sinergi dengan materi yang diajarkan saat teori - Jawaban: 1</li>
                                                <li><strong>Pelatihan:</strong> Tenaga kependidikan selalu datang setiap praktikum - Jawaban: 3</li>
                                                <li><strong>Pelatihan:</strong> Tenaga kependidikan menjelaskan arah dan tujuan dalam setiap percobaan - Jawaban: 2</li>
                                            </ul>
                                        </td>
                                    </tr>
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
