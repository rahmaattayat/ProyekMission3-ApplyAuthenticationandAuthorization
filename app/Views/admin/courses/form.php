<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php
$isEdit = isset($course);
$action = $isEdit ? "/admin/courses/{$course->course_id}" : "/admin/courses";
?>

<h2 class="text-xl font-semibold mb-4"><?= $isEdit ? 'Edit' : 'Tambah' ?> Course</h2>

<?php if (session()->getFlashdata('errors')): ?>
  <ul class="mb-4 list-disc list-inside text-red-600">
    <?php foreach(session()->getFlashdata('errors') as $e): ?>
      <li><?= esc($e) ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<form method="post" action="<?= $action ?>" class="max-w-lg space-y-4">
  <?= csrf_field() ?>
  <div>
    <label class="block text-sm mb-1">Course Code</label>
    <input name="course_code" value="<?= old('course_code', $course->course_code ?? '') ?>" class="w-full border rounded px-3 py-2">
  </div>
  <div>
    <label class="block text-sm mb-1">Course Name</label>
    <input name="course_name" value="<?= old('course_name', $course->course_name ?? '') ?>" class="w-full border rounded px-3 py-2">
  </div>
  <div>
    <label class="block text-sm mb-1">Credits</label>
    <input type="number" name="credits" value="<?= old('credits', $course->credits ?? 2) ?>" class="w-full border rounded px-3 py-2">
  </div>

  <div class="flex gap-2">
    <button class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700"><?= $isEdit ? 'Simpan' : 'Tambah' ?></button>
    <a href="/admin/courses" class="px-4 py-2 rounded border">Batal</a>
  </div>
</form>

<?= $this->endSection() ?>
