<?php
require_once 'config/Database.php';
require_once 'classes/Routine.php';
require_once 'classes/Category.php';

$database = new Database();
$db = $database->getConnection();
$routine = new Routine($db);
$categoryObj = new Category($db);

$action = isset($_GET['action']) ? $_GET['action'] : 'read';

if (isset($_POST['submit_create'])) {
    $routine->create($_POST['category_id'], $_POST['title'], $_POST['description'], $_POST['day_of_week'], $_POST['target_duration_minutes']);
    header("Location: routines.php");
    exit();
}

if (isset($_POST['submit_update'])) {
    $routine->update($_POST['id'], $_POST['category_id'], $_POST['title'], $_POST['description'], $_POST['day_of_week'], $_POST['target_duration_minutes']);
    header("Location: routines.php");
    exit();
}

if (isset($_GET['delete'])) {
    $routine->delete($_GET['delete']);
    header("Location: routines.php");
    exit();
}

include 'views/header.php';
?>

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-100">Daftar Rutinitas (Morning & Night)</h2>
        <p class="text-xs text-slate-400">Kelola daftar kegiatan olahraga, skincare, membaca, dan self-upgrade</p>
    </div>
    <a href="routines.php?action=add" class="bg-amber-500 hover:bg-amber-600 text-slate-950 font-semibold px-4 py-2 rounded-xl text-sm transition shadow-lg shadow-amber-500/20">+ Tambah Rutinitas</a>
</div>

<?php if ($action == 'add' || $action == 'edit'): 
    $editData = null;
    if ($action == 'edit' && isset($_GET['id'])) {
        $editData = $routine->readOne($_GET['id']);
    }
    $categories = $categoryObj->readAll();
?>
    <div class="bg-slate-800/80 border border-slate-700/80 rounded-2xl p-6 max-w-xl mx-auto mb-8 shadow-xl">
        <h3 class="text-lg font-bold text-slate-200 mb-4"><?= $action == 'edit' ? 'Edit Rutinitas' : 'Tambah Rutinitas Baru'; ?></h3>
        <form action="routines.php" method="POST" class="space-y-4">
            <?php if ($action == 'edit'): ?>
                <input type="hidden" name="id" value="<?= $editData['id']; ?>">
            <?php endif; ?>
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Kategori Routine</label>
                <select name="category_id" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-100 focus:outline-none focus:border-amber-500">
                    <?php while($cat = $categories->fetch_assoc()): ?>
                        <option value="<?= $cat['id']; ?>" <?= (isset($editData['category_id']) && $editData['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                            <?= $cat['name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Nama Kegiatan (Judul)</label>
                <input type="text" name="title" required value="<?= $editData['title'] ?? ''; ?>" placeholder="Contoh: Olahraga Pagi (Jogging) / Skincare" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-100 focus:outline-none focus:border-amber-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Deskripsi Kegiatan</label>
                <textarea name="description" rows="3" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-100 focus:outline-none focus:border-amber-500"><?= $editData['description'] ?? ''; ?></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Hari Pelaksanaan</label>
                    <select name="day_of_week" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-100 focus:outline-none focus:border-amber-500">
                        <?php foreach(['Everyday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day): ?>
                            <option value="<?= $day; ?>" <?= (isset($editData['day_of_week']) && $editData['day_of_week'] == $day) ? 'selected' : ''; ?>><?= $day; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Target Durasi (Menit)</label>
                    <input type="number" name="target_duration_minutes" value="<?= $editData['target_duration_minutes'] ?? 15; ?>" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-100 focus:outline-none focus:border-amber-500">
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <a href="routines.php" class="px-4 py-2 rounded-xl text-sm bg-slate-700 hover:bg-slate-600 text-slate-200 transition">Batal</a>
                <button type="submit" name="<?= $action == 'edit' ? 'submit_update' : 'submit_create'; ?>" class="px-5 py-2 rounded-xl text-sm bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold transition">Simpan</button>
            </div>
        </form>
    </div>
<?php endif; ?>

<div class="bg-slate-800/60 border border-slate-700/60 rounded-2xl overflow-hidden shadow-xl">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-700 bg-slate-900/50 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                    <th class="p-4">#ID</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4">Kegiatan</th>
                    <th class="p-4">Hari</th>
                    <th class="p-4">Durasi</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700/50 text-sm">
                <?php $result = $routine->readAll(); while ($row = $result->fetch_assoc()): ?>
                <tr class="hover:bg-slate-700/20 transition">
                    <td class="p-4 font-mono text-xs text-slate-400"><?= $row['id']; ?></td>
                    <td class="p-4"><span class="px-2.5 py-1 rounded text-xs font-bold bg-<?= $row['theme_color']; ?>-500/20 text-<?= $row['theme_color']; ?>-300 border border-<?= $row['theme_color']; ?>-500/30"><?= $row['category_name']; ?></span></td>
                    <td class="p-4">
                        <div class="font-semibold text-slate-200"><?= htmlspecialchars($row['title']); ?></div>
                        <div class="text-xs text-slate-400"><?= htmlspecialchars($row['description']); ?></div>
                    </td>
                    <td class="p-4 text-xs font-medium text-slate-300"><?= $row['day_of_week']; ?></td>
                    <td class="p-4 text-xs text-slate-400"><i class="fa-regular fa-clock mr-1"></i> <?= $row['target_duration_minutes']; ?> Menit</td>
                    <td class="p-4 text-center space-x-2">
                        <a href="routines.php?action=edit&id=<?= $row['id']; ?>" class="text-sky-400 hover:text-sky-300 text-xs font-semibold px-2.5 py-1.5 rounded-lg bg-sky-500/10 border border-sky-500/20">Edit</a>
                        <a href="routines.php?delete=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus rutinitas ini?')" class="text-rose-400 hover:text-rose-300 text-xs font-semibold px-2.5 py-1.5 rounded-lg bg-rose-500/10 border border-rose-500/20">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'views/footer.php'; ?>
