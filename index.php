<?php
require_once 'config/Database.php';
require_once 'classes/Category.php';
require_once 'classes/Routine.php';
require_once 'classes/RoutineLog.php';

$database = new Database();
$db = $database->getConnection();

$routineObj = new Routine($db);
$logObj = new RoutineLog($db);
$categoryObj = new Category($db);

$morningRoutines = $routineObj->readByCategory(1);
$nightRoutines = $routineObj->readByCategory(2);
$logs = $logObj->readAll();

include 'views/header.php';
?>

<!-- Hero Header Dual Mood -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Morning Hero Card -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-500/20 via-orange-500/10 to-slate-900 border border-amber-500/30 p-6 shadow-xl">
        <div class="flex items-center gap-4 mb-3">
            <div class="p-3 bg-amber-500/20 rounded-xl text-amber-400 border border-amber-500/30">
                <i class="fa-solid fa-sun text-2xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-amber-300">Morning Routine</h2>
                <p class="text-xs text-slate-400">Bangkitkan energi & fokus positif awal hari</p>
            </div>
        </div>
        <p class="text-sm text-slate-300 mb-4">Mulai dari cold face dip, olahraga harian bervariasi, hingga sarapan bergizi.</p>
        <a href="routines.php" class="inline-flex items-center text-xs font-semibold text-amber-400 hover:text-amber-300">Kelola Kegiatan Pagi <i class="fa-solid fa-arrow-right ml-1"></i></a>
    </div>

    <!-- Night Hero Card -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-500/20 via-purple-500/10 to-slate-900 border border-indigo-500/30 p-6 shadow-xl">
        <div class="flex items-center gap-4 mb-3">
            <div class="p-3 bg-indigo-500/20 rounded-xl text-indigo-400 border border-indigo-500/30">
                <i class="fa-solid fa-moon text-2xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-indigo-300">Night Routine</h2>
                <p class="text-xs text-slate-400">Pembersihan diri & evaluasi mental sebelum istirahat</p>
            </div>
        </div>
        <p class="text-sm text-slate-300 mb-4">Skincare, refleksi jurnal harian, dan membaca buku untuk self-upgrade.</p>
        <a href="routines.php" class="inline-flex items-center text-xs font-semibold text-indigo-400 hover:text-indigo-300">Kelola Kegiatan Malam <i class="fa-solid fa-arrow-right ml-1"></i></a>
    </div>
</div>

<!-- Routine Overview Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Morning Routines Card List -->
    <div class="bg-slate-800/60 rounded-2xl border border-slate-700/60 p-6 backdrop-blur-sm">
        <h3 class="text-lg font-bold text-slate-100 mb-4 flex items-center justify-between">
            <span class="flex items-center gap-2"><i class="fa-solid fa-mug-hot text-amber-400"></i> Routine Pagi Utama</span>
            <a href="routines.php?action=add" class="text-xs bg-amber-500/20 hover:bg-amber-500/30 text-amber-300 px-3 py-1.5 rounded-lg border border-amber-500/30 transition">+ Tambah</a>
        </h3>
        <div class="space-y-3">
            <?php if ($morningRoutines->num_rows > 0): ?>
                <?php while ($row = $morningRoutines->fetch_assoc()): ?>
                    <div class="p-4 rounded-xl bg-slate-900/80 border border-slate-700/40 hover:border-amber-500/40 transition">
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="font-semibold text-slate-200"><?= htmlspecialchars($row['title']); ?></h4>
                            <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 border border-amber-500/30"><?= htmlspecialchars($row['day_of_week']); ?></span>
                        </div>
                        <p class="text-xs text-slate-400 mb-2"><?= htmlspecialchars($row['description']); ?></p>
                        <div class="flex items-center gap-2 text-xs text-amber-400/80 font-medium">
                            <i class="fa-regular fa-clock"></i> Target: <?= $row['target_duration_minutes']; ?> Menit
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-sm text-slate-500 italic">Belum ada rutinitas pagi.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Night Routines Card List -->
    <div class="bg-slate-800/60 rounded-2xl border border-slate-700/60 p-6 backdrop-blur-sm">
        <h3 class="text-lg font-bold text-slate-100 mb-4 flex items-center justify-between">
            <span class="flex items-center gap-2"><i class="fa-solid fa-bed text-indigo-400"></i> Routine Malam Utama</span>
            <a href="routines.php?action=add" class="text-xs bg-indigo-500/20 hover:bg-indigo-500/30 text-indigo-300 px-3 py-1.5 rounded-lg border border-indigo-500/30 transition">+ Tambah</a>
        </h3>
        <div class="space-y-3">
            <?php if ($nightRoutines->num_rows > 0): ?>
                <?php while ($row = $nightRoutines->fetch_assoc()): ?>
                    <div class="p-4 rounded-xl bg-slate-900/80 border border-slate-700/40 hover:border-indigo-500/40 transition">
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="font-semibold text-slate-200"><?= htmlspecialchars($row['title']); ?></h4>
                            <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded bg-indigo-500/20 text-indigo-300 border border-indigo-500/30"><?= htmlspecialchars($row['day_of_week']); ?></span>
                        </div>
                        <p class="text-xs text-slate-400 mb-2"><?= htmlspecialchars($row['description']); ?></p>
                        <div class="flex items-center gap-2 text-xs text-indigo-400/80 font-medium">
                            <i class="fa-regular fa-clock"></i> Target: <?= $row['target_duration_minutes']; ?> Menit
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-sm text-slate-500 italic">Belum ada rutinitas malam.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'views/footer.php'; ?>
