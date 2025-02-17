<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <h1 class="text-2xl font-semibold text-gray-800">Dashboard</h1>
                <form method="POST" action="{{ url('/logout') }}">
                    @csrf
                    <button type="submit"
                            class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-200">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto mt-10 px-4">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Hello World</h2>
            <div class="flex items-center">
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <div class="text-2xl font-medium text-gray-800">Welcome back, {{ $userData->name }}</div>
                                <div class="flex items-center gap-2">
                                    <div class="text-sm font-medium text-gray-500">{{ $userData->email }}</div>
                                    <x-role-badge :role="$userData->role" />
                                </div>
                            </div>
                        </div>
                    </div>
            <p class="text-gray-600">You are successfully logged in!</p>
        </div>
    </main>
</body>
</html>
