<!-- Navbar baru -->
<nav class="bg-white shadow-md">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <div class="text-xl font-bold text-gray-800">Kuesioner</div>
            <form method="POST" action="{{ route('lecturer.logout') }}">
                @csrf
                <button  type="submit"  class="bg-gray-700 text-white py-2 px-4 rounded hover:bg-gray-800 transition duration-300">
                    Keluar
                </button>

            </form>
        </div>
    </div>
</nav>
