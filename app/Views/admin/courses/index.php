<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="flex items-center justify-between mb-4">
  <h2 class="text-xl font-semibold">Daftar Courses</h2>
  <a href="/admin/courses/new" class="px-3 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Tambah</a>
</div>

<div class="bg-white rounded-xl border overflow-x-auto">
  <table class="min-w-full text-sm">
    <thead class="bg-gray-50">
      <tr>
        <th class="px-3 py-2 text-left">Code</th>
        <th class="px-3 py-2 text-left">Name</th>
        <th class="px-3 py-2 text-left">Credits</th>
        <th class="px-3 py-2">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($courses as $c): ?>
      <tr class="border-t">
        <td class="px-3 py-2"><?= esc($c->course_code) ?></td>
        <td class="px-3 py-2"><?= esc($c->course_name) ?></td>
        <td class="px-3 py-2 text-center"><?= esc($c->credits) ?></td>
        <td class="px-3 py-2 text-center space-x-2">
          <a class="text-blue-600 hover:underline" href="/admin/courses/<?= $c->course_id ?>/edit">Edit</a>
          <a class="text-red-600 hover:underline" href="/admin/courses/<?= $c->course_id ?>/delete" onclick="return confirm('Hapus course ini?')">Hapus</a>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if (empty($courses)): ?>
      <tr><td colspan="4" class="px-3 py-4 text-center text-gray-500">Belum ada data.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<?= $this->endSection() ?>
