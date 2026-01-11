<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mehmal's Diary- Premium Novel Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        .bg-teal-main { background-color: #588B8B; }
        .text-teal-main { color: #588B8B; }
        .bg-hero { background-color: #EBF3F2; }
        .glass-card {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }
        .curved-banner {
            border-radius: 40px;
        }
        @media (min-width: 1024px) {
            .curved-banner { border-radius: 60px; }
        }
        /* Mobile Menu Animation */
        #mobile-menu {
            transition: all 0.3s ease-in-out;
            transform: translateY(-100%);
            opacity: 0;
            pointer-events: none;
        }
        #mobile-menu.active {
            transform: translateY(0);
            opacity: 1;
            pointer-events: auto;
        }
    </style>
</head>
<body class="bg-white text-[#1A1A1A]">

    <!-- Navigation Bar -->
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="container mx-auto px-4 lg:px-12 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-teal-main p-2 rounded-xl shadow-lg shadow-teal-700/20">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                </div>
                <div>
                    <h1 class="font-extrabold text-xl lg:text-2xl tracking-tight leading-none">Mehmal's Diary</h1>
                    <p class="hidden sm:block text-[9px] font-semibold text-gray-400 uppercase tracking-widest">Novel Store Website</p>
                </div>
            </div>
            
            <nav class="hidden lg:flex items-center gap-10 text-[15px] font-semibold text-gray-500">
                <a href="index.php" class="text-teal-main hover:text-teal-800 transition-colors">Home</a>
                <a href="islamic.php" class="text-teal-main hover:text-teal-800 transition-colors">Islamic</a>
                <a href="fictional.php" class="text-teal-main hover:text-teal-800 transition-colors">Fictional</a>
                <a href="premium.php" class="text-teal-main hover:text-teal-800 transition-colors">Premium</a>
                <a href="contact-us.php" class="text-teal-main hover:text-teal-800 transition-colors">Contact</a>
            </nav>

            <div class="flex items-center gap-4 lg:gap-6">
                <!-- Mobile Menu Button -->
                <button id="menu-btn" class="lg:hidden text-gray-700 focus:outline-none">
                    <svg id="menu-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation Overlay -->
    <div id="mobile-menu" class="fixed inset-0 z-40 bg-white pt-24 px-6 lg:hidden">
        <nav class="flex flex-col gap-8 text-2xl font-bold text-gray-800">
            <a href="index.php" class="text-teal-main">Home</a>
            <a href="islamic.php">Islamic</a>
            <a href="fictional.php">Fictional</a>
            <a href="premium.php">Premium</a>
            <a href="contact-us.php">Contact</a>
        </nav>
    </div>