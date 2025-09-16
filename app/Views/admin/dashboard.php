<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h1 class="text-2xl font-semibold mb-4">Dashboard Admin</h1>
<p class="mb-6 text-gray-600">Selamat datang, Administrator!</p>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
  <div class="bg-white border rounded-xl p-4">
    <div class="text-sm text-gray-500">Total Students</div>
    <div class="text-3xl font-semibold mt-1"><?= esc($studentCount) ?></div>
  </div>

  <div class="bg-white border rounded-xl p-4">
    <div class="text-sm text-gray-500">Total Courses</div>
    <div class="text-3xl font-semibold mt-1"><?= esc($courseCount) ?></div>
  </div>
</div>

<a href="/admin/courses"
   class="inline-flex items-center gap-2 px-4 py-3 bg-white border rounded-xl hover:bg-gray-50">
  Kelola Courses →
</a>

<?= $this->endSection() ?>
