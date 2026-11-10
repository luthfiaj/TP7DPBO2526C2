<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraRoutine - Morning & Night Routine Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="border-b border-slate-800 bg-slate-900/80 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="index.php" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-400 to-indigo-600 flex items-center justify-center text-slate-950 font-bold text-xl shadow-lg shadow-indigo-500/20">
                    <i class="fa-solid me-0.5 fa-sun text-amber-950"></i>
                </div>
                <div>
                    <h1 class="font-bold text-lg leading-none bg-gradient-to-r from-amber-200 via-amber-400 to-indigo-300 bg-clip-text text-transparent">AuraRoutine</h1>
                    <span class="text-xs text-slate-400 font-medium">Self-Upgrade & Life Tracker</span>
                </div>
            </a>
            
            <div class="flex items-center gap-1 md:gap-2">
                <a href="index.php" class="px-3 py-2 rounded-lg text-sm font-medium hover:bg-slate-800 text-slate-300 transition-colors"><i class="fa-solid fa-house text-amber-400 mr-1.5"></i> Dashboard</a>
                <a href="routines.php" class="px-3 py-2 rounded-lg text-sm font-medium hover:bg-slate-800 text-slate-300 transition-colors"><i class="fa-solid fa-list-check text-sky-400 mr-1.5"></i> Routine List</a>
                <a href="categories.php" class="px-3 py-2 rounded-lg text-sm font-medium hover:bg-slate-800 text-slate-300 transition-colors"><i class="fa-solid fa-layer-group text-indigo-400 mr-1.5"></i> Categories</a>
                <a href="logs.php" class="px-3 py-2 rounded-lg text-sm font-medium hover:bg-slate-800 text-slate-300 transition-colors"><i class="fa-solid fa-clock-rotate-left text-emerald-400 mr-1.5"></i> Activity Logs</a>
            </div>
        </div>
    </nav>
    <main class="flex-grow max-w-6xl w-full mx-auto px-4 py-8">
