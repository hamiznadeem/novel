<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}
$error = '';
if (isset($_GET['error'])){
    $error = $_GET['error'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Mehmal's Diary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        .bg-teal-main { background-color: #588B8B; }
        .text-teal-main { color: #588B8B; }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        darkblue: '#588B8B',
                        primary: '#ffffffff',
                        carddark: '#1E293B'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100">

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-lg">
            <div class="flex items-center gap-3 mb-8 justify-center">
                <div class="bg-darkblue p-2.5 rounded-xl shadow-lg shadow-darkblue/20">
                    <i data-lucide="book-open" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h1 class="font-extrabold text-2xl tracking-tight leading-none text-darkblue">Mehmal's Diary</h1>
                    <p class="text-[9px] font-semibold text-gray-400 uppercase tracking-widest">Admin Panel</p>
                </div>
            </div>

            <?php if(!empty($error)): ?>
                <div class="mb-4 text-center rounded-lg bg-red-100 text-red-700 py-3 px-4 border border-red-200 text-sm">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST" class="space-y-6">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" id="username" name="username" placeholder="e.g., admin" required class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-darkblue/20 outline-none transition">
                </div>
                
                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-darkblue/20 outline-none transition">
                    <button type="button" onclick="togglePassword()" class="absolute right-4 top-9 text-gray-400 hover:text-darkblue">
                        <i id="eye-icon" data-lucide="eye" class="w-5 h-5"></i>
                    </button>
                </div>

                <button type="submit" class="w-full bg-darkblue text-white font-bold py-3 px-4 rounded-xl hover:bg-opacity-90 transition-all shadow-lg shadow-darkblue/20">Login</button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                passwordInput.type = 'password';
                eyeIcon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }
        lucide.createIcons();
    </script>
</body>
</html>