<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<?php helper('form'); ?>

<?php
$isEdit   = isset($student);
$action   = $isEdit ? "/admin/students/{$student->student_id}" : "/admin/students";
$btnLabel = $isEdit ? 'Simpan' : 'Tambah';
?>

<h2 class="text-xl font-semibold mb-4"><?= $isEdit ? 'Edit' : 'Tambah' ?> Student</h2>

<?php if ($errs = session()->getFlashdata('errors')): ?>
  <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-red-700">
    <ul class="list-disc list-inside">
      <?php foreach ($errs as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<form method="post" action="<?= $action ?>">
  <?= csrf_field() ?>

  <div class="grid sm:grid-cols-2 gap-4 mb-4">
    <div>
      <label class="block text-sm mb-1">Nama Lengkap</label>
      <input name="full_name" class="w-full border rounded px-3 py-2"
             value="<?= esc(old('full_name', $isEdit ? $student->full_name : '')) ?>" required>
    </div>
    <div>
      <label class="block text-sm mb-1">Email</label>
      <input type="email" name="email" class="w-full border rounded px-3 py-2"
             value="<?= esc(old('email', $isEdit ? $student->email : '')) ?>" required>
    </div>

    <div>
      <label class="block text-sm mb-1">Username</label>
      <input name="username" class="w-full border rounded px-3 py-2"
             value="<?= esc(old('username', $isEdit ? $student->username : '')) ?>" required>
      <p class="text-xs text-gray-500 mt-1">Unik, huruf/angka/garis-.</p>
    </div>
    <div>
      <label class="block text-sm mb-1">NIM</label>
      <input name="nim" class="w-full border rounded px-3 py-2"
             value="<?= esc(old('nim', $isEdit ? $student->nim : '')) ?>" required>
    </div>

    <div>
      <label class="block text-sm mb-1">Angkatan</label>
      <input name="entry_year" type="number" min="2000" max="2100"
             class="w-full border rounded px-3 py-2"
             value="<?= esc(old('entry_year', $isEdit ? $student->entry_year : date('Y'))) ?>" required>
    </div>

    <div>
      <label class="block text-sm mb-1">Jurusan</label>
      <input name="major" class="w-full border rounded px-3 py-2"
             placeholder="contoh: Teknik Informatika"
             value="<?= esc(old('major', $isEdit ? $student->major : '')) ?>" required>
    </div>
  </div>

  <div class="grid sm:grid-cols-2 gap-4 mb-6">
    <div>
      <label class="block text-sm mb-1"><?= $isEdit ? 'Password (opsional)' : 'Password' ?></label>
      <input type="password" name="password" class="w-full border rounded px-3 py-2" <?= $isEdit ? '' : 'required' ?>>
    </div>
    <div>
      <label class="block text-sm mb-1"><?= $isEdit ? 'Konfirmasi Password (opsional)' : 'Konfirmasi Password' ?></label>
      <input type="password" name="password_confirm" class="w-full border rounded px-3 py-2" <?= $isEdit ? '' : 'required' ?>>
    </div>
  </div>

  <div class="flex gap-2">
    <button class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700"><?= $btnLabel ?></button>
    <a href="/admin/students" class="px-4 py-2 rounded border">Batal</a>
  </div>
</form>

<?= $this->endSection() ?>
