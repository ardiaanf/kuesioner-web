<aside class="w-64 bg-white text-gray-800 p-4 h-screen fixed overflow-y-auto">
    <h2 class="text-2xl font-bold mb-4 pt-5">Halaman Admin</h2>
    <nav class="overflow-x-hidden">
        <ul>
            <li class="mb-2 pt-8">
                <a href="#" class="block p-2 hover:bg-gray-300 rounded" onclick="toggleSubmenu(event)">Kuesioner</a>
                <ul class="ml-4 hidden">
                    <li class="mb-2">
                        <a href="#" class="block p-2 hover:bg-gray-300 rounded" onclick="toggleSubmenu(event)">Jenis Kuesioner</a>
                        <ul class="ml-4 hidden">
                            <li class="mb-2"><a href="{{ route('admin.student.questionnaire') }}" class="block p-2 hover:bg-gray-300 rounded">Jenis kuesioner mahasiswa</a></li>
                            <li class="mb-2"><a href="{{ route('admin.lecturer.questionnaire') }}" class="block p-2 hover:bg-gray-300 rounded">Jenis kuesioner dosen</a></li>
                            <li class="mb-2"><a href="{{ route('admin.acadstaff.questionnaire') }}" class="block p-2 hover:bg-gray-300 rounded">Jenis kuesioner tenaga kependidikan</a></li>
                        </ul>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="block p-2 hover:bg-gray-300 rounded" onclick="toggleSubmenu(event)">Elemen Kuesioner</a>
                        <ul class="ml-4 hidden">
                            <li class="mb-2"><a href="{{ route('admin.student.element') }}" class="block p-2 hover:bg-gray-300 rounded">Elemen kuesioner mahasiswa</a></li>
                            <li class="mb-2"><a href="{{ route('admin.lecturer.element') }}" class="block p-2 hover:bg-gray-300 rounded">Elemen kuesioner dosen</a></li>
                            <li class="mb-2"><a href="{{ route('admin.acadstaff.element') }}" class="block p-2 hover:bg-gray-300 rounded">Elemen kuesioner tenaga kependidikan</a></li>
                        </ul>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="block p-2 hover:bg-gray-300 rounded" onclick="toggleSubmenu(event)">Pertanyaan Kuesioner</a>
                        <ul class="ml-4 hidden">
                            <li class="mb-2"><a href="{{ route('admin.student.question') }}" class="block p-2 hover:bg-gray-300 rounded">Pertanyaan kuesioner mahasiswa</a></li>
                            <li class="mb-2"><a href="{{ route('admin.lecturer.question') }}" class="block p-2 hover:bg-gray-300 rounded">Pertanyaan kuesioner dosen</a></li>
                            <li class="mb-2"><a href="{{ route('admin.acadstaff.question') }}" class="block p-2 hover:bg-gray-300 rounded">Pertanyaan kuesioner tenaga kependidikan</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="mb-2">
                <a href="#" class="block p-2 hover:bg-gray-300 rounded" onclick="toggleSubmenu(event)">Hasil Kuesioner</a>
                <ul class="ml-4 hidden">
                    <li class="mb-2"><a href="{{ route('admin.student.questionnairefill') }}" class="block p-2 hover:bg-gray-300 rounded">Hasil Kuesioner mahasiswa</a></li>
                    <li class="mb-2"><a href="{{ route('admin.lecturer.questionnairefill') }}" class="block p-2 hover:bg-gray-300 rounded">Hasil Kuesioner dosen</a></li>
                    <li class="mb-2"><a href="{{ route('admin.acadstaff.questionnairefill') }}" class="block p-2 hover:bg-gray-300 rounded">Hasil Kuesioner tenaga kependidikan</a></li>
                </ul>
            </li>
            <li class="mb-2"><a href="{{ route('admin.student.rangking') }}" class="block p-2 hover:bg-gray-300 rounded">Peringkat kinerja dosen</a></li>
            <li class="mb-2"><a href="#" class="block p-2 hover:bg-gray-300 rounded">Laporan</a></li>
            <li class="mb-2">
                <a href="#" class="block p-2 hover:bg-gray-300 rounded" onclick="toggleSubmenu(event)">Mengelola Pengguna</a>
                <ul class="ml-4 hidden">
                    <li class="mb-2"><a href="{{ route('admin.manage.admin') }}" class="block p-2 hover:bg-gray-300 rounded">Mengelola admin</a></li>
                    <li class="mb-2"><a href="{{ route('admin.manage.student') }}" class="block p-2 hover:bg-gray-300 rounded">Mengelola mahasiswa</a></li>
                    <li class="mb-2"><a href="{{ route('admin.manage.lecturer') }}" class="block p-2 hover:bg-gray-300 rounded">Mengelola dosen</a></li>
                    <li class="mb-2"><a href="{{ route('admin.manage.acadstaff') }}" class="block p-2 hover:bg-gray-300 rounded">Mengelola tenaga kependidikan</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>

<script>
    function toggleSubmenu(event) {
        event.preventDefault();
        const submenu = event.target.nextElementSibling;
        submenu.classList.toggle('hidden');
    }
</script>
