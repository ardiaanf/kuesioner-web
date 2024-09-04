<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- <link href="{{ asset('resources/css/app.css') }}" rel="stylesheet"> <!-- Menggunakan file CSS lokal --> --}}
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="bg-white border border-gray-300 p-6 rounded-lg shadow-md w-80">
        <h2 class="text-lg font-semibold text-center mb-4">Login sebagai Dosen</h2> <!-- Judul yang lebih jelas -->
        <form action="" method="POST">
            @csrf
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500">
            <label for="password" class="block text-sm font-medium text-gray-700 mt-4">Password</label>
            <input type="password" name="password" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500">
            <button type="submit" class="mt-4 w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">Login</button>
        </form>
    </div>
</body>
</html>
