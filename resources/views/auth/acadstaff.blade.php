<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="bg-white border border-gray-300 p-6 rounded-lg shadow-md w-80">
        <h2 class="text-lg font-semibold text-center mb-4">Login sebagai Tenaga kependidikan</h2> <!-- Judul yang lebih jelas -->
        <form>
            @csrf
            <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
            <input type="email" name="email" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500">
            <label for="password" class="block text-sm font-medium text-gray-700 mt-4">Password:</label>
            <input type="password" name="password" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500">
            <button id="login" type="button" class="mt-4 w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">Login</button>
        </form>

        <script>
            const BASE_URL = 'http://127.0.0.1:8000';

            document.getElementById('login').addEventListener('click', async () => {
                const email = document.querySelector('input[name="email"]').value;
                const password = document.querySelector('input[name="password"]').value;
                const csrf = document.querySelector('input[name="_token"]').value;

                const onSubmit = await fetch(`${BASE_URL}/api/auth/acadstaff`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    },
                    body: JSON.stringify({
                        email,
                        password
                    })
                });

                const response = await onSubmit.json();
                if (response.error) {
                    alert(response.data.error);
                } else {
                    localStorage.setItem('access_token', response.data.access_token);
                    window.location.href = BASE_URL;
                }
            });
        </script>
    </div>
</body>

</html>