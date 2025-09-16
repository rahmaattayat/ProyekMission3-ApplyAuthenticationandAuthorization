<?= $this->extend('layouts/student') ?>
<?= $this->section('content') ?>

<h1 class="text-2xl font-semibold mb-4">Enroll Courses</h1>

<?php foreach (['error'=>'red','success'=>'emerald','info'=>'sky'] as $k=>$c): ?>
  <?php if ($m = session()->getFlashdata($k)): ?>
    <div class="mb-4 px-3 py-2 rounded border border-<?= $c ?>-300 bg-<?= $c ?>-50 text-<?= $c ?>-800">
      <?= esc($m) ?>
    </div>
  <?php endif ?>
<?php endforeach; ?>

<!-- Tabel semua course -->
<div class="bg-white rounded-xl border overflow-x-auto mb-8">
  <table class="min-w-full text-sm">
    <thead class="bg-gray-50">
      <tr>
        <th class="px-3 py-2 text-left">Code</th>
        <th class="px-3 py-2 text-left">Name</th>
        <th class="px-3 py-2 text-center">Credits</th>
        <th class="px-3 py-2 text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($courses as $c): ?>
      <?php $already = in_array($c->course_id, $takenIds ?? []); ?>
      <tr class="border-t">
        <td class="px-3 py-2"><?= esc($c->course_code) ?></td>
        <td class="px-3 py-2"><?= esc($c->course_name) ?></td>
        <td class="px-3 py-2 text-center">
          <span class="inline-block px-2 py-0.5 rounded bg-slate-100"><?= esc($c->credits) ?></span>
        </td>
        <td class="px-3 py-2 text-center">
          <?php if ($already): ?>
            <span class="px-2 py-1 rounded bg-gray-100 text-gray-500 italic">Sudah Enroll</span>
          <?php else: ?>
            <form method="post" action="/student/enroll/<?= $c->course_id ?>" class="inline">
              <?= csrf_field() ?>
              <button class="px-3 py-1 rounded bg-blue-600 text-white hover:bg-blue-700">Enroll</button>
            </form>
          <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if (empty($courses)): ?>
        <tr><td colspan="4" class="px-3 py-4 text-center text-gray-500">Belum ada course.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- Tabel course yang sudah diambil -->
<h2 class="text-xl font-semibold mb-4">Courses yang sudah diambil</h2>
<div class="bg-white rounded-xl border overflow-x-auto">
  <table class="min-w-full text-sm">
    <thead class="bg-gray-50">
      <tr>
        <th class="px-3 py-2 text-left">Code</th>
        <th class="px-3 py-2 text-left">Name</th>
        <th class="px-3 py-2 text-center">Credits</th>
        <th class="px-3 py-2 text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($takenCourses)): ?>
        <?php foreach ($takenCourses as $tc): ?>
        <tr class="border-t">
          <td class="px-3 py-2"><?= esc($tc->course_code) ?></td>
          <td class="px-3 py-2"><?= esc($tc->course_name) ?></td>
          <td class="px-3 py-2 text-center"><?= esc($tc->credits) ?></td>
          <td class="px-3 py-2 text-center">
            <form method="post" action="/student/enroll/<?= $tc->course_id ?>/drop" onsubmit="return confirm('Batalkan course ini?');" class="inline">
              <?= csrf_field() ?>
              <button class="px-3 py-1 rounded bg-red-600 text-white hover:bg-red-700">Drop</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="4" class="px-3 py-4 text-center text-gray-500">Kamu belum mengambil course apa pun.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
