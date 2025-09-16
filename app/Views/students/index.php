<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-4">
  <h2 class="text-xl font-semibold">Daftar Students</h2>
  <a href="/admin/students/new" class="px-3 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Tambah</a>
</div>

<div class="bg-white rounded-xl border overflow-x-auto">
  <table class="min-w-full text-sm">
    <thead class="bg-gray-50">
      <tr>
        <th class="px-3 py-2 text-left">NIM</th>
        <th class="px-3 py-2 text-left">Nama</th>
        <th class="px-3 py-2 text-left">Email</th>
        <th class="px-3 py-2 text-left">Jurusan</th>
        <th class="px-3 py-2 text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($students as $s): ?>
      <tr class="border-t">
        <td class="px-3 py-2"><?= esc($s->nim) ?></td>
        <td class="px-3 py-2"><?= esc($s->full_name) ?></td>
        <td class="px-3 py-2"><?= esc($s->email) ?></td>
        <td class="px-3 py-2"><?= esc($s->major) ?></td>
        <td class="px-3 py-2 text-center space-x-3">
          <a class="text-green-800 hover:underline" href="/admin/students/<?= $s->student_id ?>">Detail</a>
          <a class="text-blue-600 hover:underline" href="/admin/students/<?= $s->student_id ?>/edit">Edit</a>
          <a class="text-red-600 hover:underline" href="/admin/students/<?= $s->student_id ?>/delete"
             onclick="return confirm('Hapus student ini?')">Hapus</a>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if (empty($students)): ?>
      <tr><td colspan="5" class="px-3 py-4 text-center text-gray-500">Belum ada data.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
