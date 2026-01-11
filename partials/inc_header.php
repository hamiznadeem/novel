<?php
include 'database/db_conn.php';
// current page filename to highlight active nav link
$current_page = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Mehmal's Diary</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

                /* Custom Scrollbar Styling */
        .overflow-x-auto::-webkit-scrollbar {
            height: 3px;
            background-color: transparent;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background-color: #f1f5f9;
            border-radius: 10px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background-color: #04216bff;
            border-radius: 10px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background-color: #0a1e5f;
        }

        /* Firefox */
        .overflow-x-auto {
            scrollbar-color: #04216bff #f1f5f9;
            scrollbar-width: thin;
        }
        
        /* Sidebar Transition */
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
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
<body class="bg-slate-50 text-slate-800 ">

    <!-- Mobile Header -->
    <div class="lg:hidden fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
        <a href="dashboard.php" class="text-darkblue text-xl font-bold tracking-tight">Mehmal's Diary Admin</a>
        <button onclick="toggleSidebar()" class="text-slate-600 focus:outline-none">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
    </div>

    <!-- Main Wrapper -->
    <div class="min-h-screen pt-16 lg:pt-0">

        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar fixed inset-y-0 left-0 z-[60] w-64 bg-darkblue text-white transform -translate-x-full lg:translate-x-0 overflow-y-auto no-scrollbar flex flex-col justify-between transition-transform duration-300 ease-in-out">
            <div>
                <!-- Brand -->
                <div class="p-8">
                    <a href="dashboard.php" class="text-2xl font-bold tracking-wide flex items-center gap-2">
                        <i data-lucide="book-open" class="w-8 h-8 text-primary"></i>
                        Mehmal's Diary
                    </a>
                    <div class="text-xs text-white mt-1 uppercase tracking-wider font-semibold">Admin Panel</div>
                </div>

                <!-- Navigation -->
                <nav class="px-4 space-y-2">
                    <a href="dashboard.php" class="<?php echo $current_page === 'dashboard.php' ? 'flex items-center gap-3 px-4 py-3 bg-primary/10 text-primary rounded-xl font-medium transition' : 'flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-white/5 hover:text-white rounded-xl font-medium transition'; ?>">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dashboard
                    </a>
                    <a href="novel_add.php" class="<?php echo $current_page === 'novel_add.php' ? 'flex items-center gap-3 px-4 py-3 bg-primary/10 text-primary rounded-xl font-medium transition' : 'flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-white/5 hover:text-white rounded-xl font-medium transition'; ?>">
                        <i data-lucide="plus-square" class="w-5 h-5"></i> Add Novel
                    </a>
                    <a href="index.php" target="_blank" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-white/5 hover:text-white rounded-xl font-medium transition">
                        <i data-lucide="external-link" class="w-5 h-5"></i> View Site
                    </a>
                </nav>
            </div>

            <!-- Profile / Logout -->
            <div class="p-4 border-t border-white/10">
                <a href="logout.php" class="flex items-center gap-3 px-4 py-3 text-white hover:bg-red-500/10 rounded-xl font-medium transition">
                    <i data-lucide="log-out" class="w-5 h-5"></i> Logout
                </a>
            </div>
        </aside>

        <!-- Overlay for Mobile Sidebar -->
        <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-[55] hidden lg:hidden"></div>

        <script>
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }
        </script>
