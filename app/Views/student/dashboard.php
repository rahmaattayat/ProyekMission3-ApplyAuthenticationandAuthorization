<?= $this->extend('layouts/student') ?>
<?= $this->section('content') ?>

<h1 class="text-2xl font-semibold mb-4">Dashboard</h1>

<div class="grid sm:grid-cols-3 gap-4 mb-6">
  <div class="border rounded-xl p-4">
    <div class="text-gray-500 text-sm">Total SKS Diambil</div>
    <div class="text-3xl font-semibold mt-1"><?= (int)$totalCredits ?></div>
  </div>
  <div class="border rounded-xl p-4">
    <div class="text-gray-500 text-sm">Sisa Kuota SKS</div>
    <div class="text-3xl font-semibold mt-1"><?= (int)$remainCredits ?></div>
    <div class="text-xs text-gray-500 mt-1">Maks: <?= (int)$maxCredits ?> SKS</div>
  </div>
  <div class="border rounded-xl p-4">
    <div class="text-gray-500 text-sm">Angkatan</div>
    <div class="text-3xl font-semibold mt-1"><?= esc($student->entry_year) ?></div>
  </div>
</div>

<p class="text-sm text-gray-600">Halo, <b><?= esc($student->full_name) ?></b>! Silakan daftar mata kuliah di menu “Enroll Courses”.</p>

<?= $this->endSection() ?>
