<?php
require_once 'config/Database.php';
require_once 'classes/Category.php';

$database = new Database();
$db = $database->getConnection();
$category = new Category($db);

$action = isset($_GET['action']) ? $_GET['action'] : 'read';

if (isset($_POST['submit_create'])) {
    $category->create($_POST['name'], $_POST['description'], $_POST['theme_color']);
    header("Location: categories.php");
    exit();
}

if (isset($_POST['submit_update'])) {
    $category->update($_POST['id'], $_POST['name'], $_POST['description'], $_POST['theme_color']);
    header("Location: categories.php");
    exit();
}

if (isset($_GET['delete'])) {
    $category->delete($_GET['delete']);
    header("Location: categories.php");
    exit();
}

include 'views/header.php';
?>

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-100">Manajemen Kategori Routine</h2>
        <p class="text-xs text-slate-400">Kelola kategori utama (Morning & Night Routine)</p>
    </div>
    <a href="categories.php?action=add" class="bg-amber-500 hover:bg-amber-600 text-slate-950 font-semibold px-4 py-2 rounded-xl text-sm transition shadow-lg shadow-amber-500/20">+ Tambah Kategori</a>
</div>

<?php if ($action == 'add' || $action == 'edit'): 
    $editData = null;
    if ($action == 'edit' && isset($_GET['id'])) {
        $editData = $category->readOne($_GET['id']);
    }
?>
    <div class="bg-slate-800/80 border border-slate-700/80 rounded-2xl p-6 max-w-xl mx-auto mb-8 shadow-xl">
        <h3 class="text-lg font-bold text-slate-200 mb-4"><?= $action == 'edit' ? 'Edit Kategori' : 'Tambah Kategori Baru'; ?></h3>
        <form action="categories.php" method="POST" class="space-y-4">
            <?php if ($action == 'edit'): ?>
                <input type="hidden" name="id" value="<?= $editData['id']; ?>">
            <?php endif; ?>
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Nama Kategori</label>
                <input type="text" name="name" required value="<?= $editData['name'] ?? ''; ?>" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-100 focus:outline-none focus:border-amber-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-100 focus:outline-none focus:border-amber-500"><?= $editData['description'] ?? ''; ?></textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Theme Color</label>
                <select name="theme_color" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-100 focus:outline-none focus:border-amber-500">
                    <option value="amber" <?= (isset($editData['theme_color']) && $editData['theme_color'] == 'amber') ? 'selected' : ''; ?>>Amber (Morning)</option>
                    <option value="indigo" <?= (isset($editData['theme_color']) && $editData['theme_color'] == 'indigo') ? 'selected' : ''; ?>>Indigo (Night)</option>
                </select>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <a href="categories.php" class="px-4 py-2 rounded-xl text-sm bg-slate-700 hover:bg-slate-600 text-slate-200 transition">Batal</a>
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
                    <th class="p-4">Nama Kategori</th>
                    <th class="p-4">Deskripsi</th>
                    <th class="p-4">Theme Color</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700/50 text-sm">
                <?php $result = $category->readAll(); while ($row = $result->fetch_assoc()): ?>
                <tr class="hover:bg-slate-700/20 transition">
                    <td class="p-4 font-mono text-xs text-slate-400"><?= $row['id']; ?></td>
                    <td class="p-4 font-semibold text-slate-200"><?= htmlspecialchars($row['name']); ?></td>
                    <td class="p-4 text-slate-400 text-xs"><?= htmlspecialchars($row['description']); ?></td>
                    <td class="p-4"><span class="px-2 py-1 rounded text-xs uppercase font-bold bg-slate-900 border border-slate-700 text-<?= $row['theme_color']; ?>-400"><?= $row['theme_color']; ?></span></td>
                    <td class="p-4 text-center space-x-2">
                        <a href="categories.php?action=edit&id=<?= $row['id']; ?>" class="text-sky-400 hover:text-sky-300 text-xs font-semibold px-2.5 py-1.5 rounded-lg bg-sky-500/10 border border-sky-500/20">Edit</a>
                        <a href="categories.php?delete=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus kategori ini?')" class="text-rose-400 hover:text-rose-300 text-xs font-semibold px-2.5 py-1.5 rounded-lg bg-rose-500/10 border border-rose-500/20">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'views/footer.php'; ?>
