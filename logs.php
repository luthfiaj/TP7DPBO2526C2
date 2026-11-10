<?php
require_once 'config/Database.php';
require_once 'classes/RoutineLog.php';
require_once 'classes/Routine.php';

$database = new Database();
$db = $database->getConnection();
$logObj = new RoutineLog($db);
$routineObj = new Routine($db);

$action = isset($_GET['action']) ? $_GET['action'] : 'read';

if (isset($_POST['submit_create'])) {
    $logObj->create($_POST['routine_id'], $_POST['log_date'], $_POST['status'], $_POST['notes']);
    header("Location: logs.php");
    exit();
}

if (isset($_POST['submit_update'])) {
    $logObj->update($_POST['id'], $_POST['routine_id'], $_POST['log_date'], $_POST['status'], $_POST['notes']);
    header("Location: logs.php");
    exit();
}

if (isset($_GET['delete'])) {
    $logObj->delete($_GET['delete']);
    header("Location: logs.php");
    exit();
}

include 'views/header.php';
?>

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-100">Log & Riwayat Aktivitas Harian</h2>
        <p class="text-xs text-slate-400">Tracking progres pelaksanaan morning & night routine harianmu</p>
    </div>
    <a href="logs.php?action=add" class="bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-semibold px-4 py-2 rounded-xl text-sm transition shadow-lg shadow-emerald-500/20">+ Tambah Log Aktivitas</a>
</div>

<?php if ($action == 'add' || $action == 'edit'): 
    $editData = null;
    if ($action == 'edit' && isset($_GET['id'])) {
        $editData = $logObj->readOne($_GET['id']);
    }
    $routines = $routineObj->readAll();
?>
    <div class="bg-slate-800/80 border border-slate-700/80 rounded-2xl p-6 max-w-xl mx-auto mb-8 shadow-xl">
        <h3 class="text-lg font-bold text-slate-200 mb-4"><?= $action == 'edit' ? 'Edit Log Aktivitas' : 'Catat Aktivitas Baru'; ?></h3>
        <form action="logs.php" method="POST" class="space-y-4">
            <?php if ($action == 'edit'): ?>
                <input type="hidden" name="id" value="<?= $editData['id']; ?>">
            <?php endif; ?>
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Pilih Rutinitas</label>
                <select name="routine_id" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-100 focus:outline-none focus:border-emerald-500">
                    <?php while($r = $routines->fetch_assoc()): ?>
                        <option value="<?= $r['id']; ?>" <?= (isset($editData['routine_id']) && $editData['routine_id'] == $r['id']) ? 'selected' : ''; ?>>
                            [<?= $r['category_name']; ?>] <?= $r['title']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Tanggal</label>
                    <input type="date" name="log_date" required value="<?= $editData['log_date'] ?? date('Y-m-d'); ?>" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-100 focus:outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Status Pengerjaan</label>
                    <select name="status" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-100 focus:outline-none focus:border-emerald-500">
                        <?php foreach(['Completed', 'Pending', 'Skipped'] as $st): ?>
                            <option value="<?= $st; ?>" <?= (isset($editData['status']) && $editData['status'] == $st) ? 'selected' : ''; ?>><?= $st; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Catatan / Jurnal Refleksi</label>
                <textarea name="notes" rows="3" placeholder="Tuliskan catatan singkat atau hasil refleksi kegiatan..." class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-100 focus:outline-none focus:border-emerald-500"><?= $editData['notes'] ?? ''; ?></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <a href="logs.php" class="px-4 py-2 rounded-xl text-sm bg-slate-700 hover:bg-slate-600 text-slate-200 transition">Batal</a>
                <button type="submit" name="<?= $action == 'edit' ? 'submit_update' : 'submit_create'; ?>" class="px-5 py-2 rounded-xl text-sm bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-bold transition">Simpan</button>
            </div>
        </form>
    </div>
<?php endif; ?>

<div class="bg-slate-800/60 border border-slate-700/60 rounded-2xl overflow-hidden shadow-xl">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-700 bg-slate-900/50 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                    <th class="p-4">Tanggal</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4">Kegiatan Routine</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Catatan / Refleksi</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700/50 text-sm">
                <?php $result = $logObj->readAll(); while ($row = $result->fetch_assoc()): ?>
                <tr class="hover:bg-slate-700/20 transition">
                    <td class="p-4 font-mono text-xs text-slate-300"><?= $row['log_date']; ?></td>
                    <td class="p-4"><span class="px-2.5 py-1 rounded text-xs font-bold bg-<?= $row['theme_color']; ?>-500/20 text-<?= $row['theme_color']; ?>-300 border border-<?= $row['theme_color']; ?>-500/30"><?= $row['category_name']; ?></span></td>
                    <td class="p-4 font-semibold text-slate-200"><?= htmlspecialchars($row['routine_title']); ?></td>
                    <td class="p-4">
                        <?php 
                            $badgeColor = 'bg-slate-700 text-slate-300';
                            if ($row['status'] == 'Completed') $badgeColor = 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30';
                            elseif ($row['status'] == 'Pending') $badgeColor = 'bg-amber-500/20 text-amber-300 border border-amber-500/30';
                            elseif ($row['status'] == 'Skipped') $badgeColor = 'bg-rose-500/20 text-rose-300 border border-rose-500/30';
                        ?>
                        <span class="px-2.5 py-1 rounded text-xs font-bold <?= $badgeColor; ?>"><?= $row['status']; ?></span>
                    </td>
                    <td class="p-4 text-xs text-slate-400 italic"><?= htmlspecialchars($row['notes'] ?: '-'); ?></td>
                    <td class="p-4 text-center space-x-2">
                        <a href="logs.php?action=edit&id=<?= $row['id']; ?>" class="text-sky-400 hover:text-sky-300 text-xs font-semibold px-2.5 py-1.5 rounded-lg bg-sky-500/10 border border-sky-500/20">Edit</a>
                        <a href="logs.php?delete=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus log ini?')" class="text-rose-400 hover:text-rose-300 text-xs font-semibold px-2.5 py-1.5 rounded-lg bg-rose-500/10 border border-rose-500/20">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'views/footer.php'; ?>
