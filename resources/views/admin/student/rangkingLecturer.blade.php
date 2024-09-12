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
                        <h1 class="text-2xl font-bold mb-4">Hasil Peringkat Kinerja Dosen </h1>

                        <label for="program-studi" class="block text-sm font-medium text-gray-700 mb-2">Progam studi</label>
                        <select id="program-studi" class="block w-1/2 p-1 border border-gray-300 hover:border-gray-300 rounded-md mb-4">
                            <option value="1">Program Studi A</option>
                            <option value="2">Program Studi B</option>
                            <option value="3">Program Studi C</option>
                        </select>
                        <button id="submit-ranking" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 mb-4">Submit</button>

                        <label for="student-element" class="block text-sm font-medium text-gray-700 mb-2">Elemen kuesioner</label>
                        <select id="student-element" class="block w-1/2 p-1 border border-gray-300 hover:border-gray-300 rounded-md mb-4">
                            <option value="1">Teori</option>
                            <option value="2">Praktikum</option>
                        </select>
                        <button id="submit-element-ranking" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 mb-4">Sort</button>

                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-2 px-4 border-b border-r">No</th>
                                        <th class="py-2 px-4 border-b border-r">Nama Dosen</th>
                                        <th class="py-2 px-4 border-b border-r">Nomor induk</th>
                                        <th class="py-2 px-4 border-b border-r">Rata - rata teori</th>
                                        <th class="py-2 px-4 border-b border-r">Rata - rata praktikum</th>
                                        <th class="py-2 px-4 border-b border-r">Rata - rata total</th>
                                    </tr>
                                </thead>
                                <tbody id="lecturer-ranking-body">
                                    <tr>
                                        <td class="py-2 px-4 border-b border-r">1</td>
                                        <td class="py-2 px-4 border-b border-r">Dosen A</td>
                                        <td class="py-2 px-4 border-b border-r">123456</td>
                                        <td class="py-2 px-4 border-b border-r">85</td>
                                        <td class="py-2 px-4 border-b border-r">75</td>
                                        <td class="py-2 px-4 border-b border-r">80</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 px-4 border-b border-r">2</td>
                                        <td class="py-2 px-4 border-b border-r">Dosen B</td>
                                        <td class="py-2 px-4 border-b border-r">654321</td>
                                        <td class="py-2 px-4 border-b border-r">90</td>
                                        <td class="py-2 px-4 border-b border-r">80</td>
                                        <td class="py-2 px-4 border-b border-r">85</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 px-4 border-b border-r">3</td>
                                        <td class="py-2 px-4 border-b border-r">Dosen C</td>
                                        <td class="py-2 px-4 border-b border-r">789012</td>
                                        <td class="py-2 px-4 border-b border-r">70</td>
                                        <td class="py-2 px-4 border-b border-r">65</td>
                                        <td class="py-2 px-4 border-b border-r">67.5</td>
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
