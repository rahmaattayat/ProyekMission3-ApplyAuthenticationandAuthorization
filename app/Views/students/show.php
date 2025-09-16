<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h2 class="text-xl font-semibold mb-4">Detail Student</h2>

<div class="bg-white rounded-xl border p-4 text-sm mb-6">
  <div class="grid sm:grid-cols-2 gap-x-8 gap-y-3">
    <div><span class="text-gray-500">NIM</span><div class="font-medium"><?= esc($student->nim) ?></div></div>
    <div><span class="text-gray-500">Username</span><div class="font-medium"><?= esc($student->username) ?></div></div>
    <div><span class="text-gray-500">Nama</span><div class="font-medium"><?= esc($student->full_name) ?></div></div>
    <div><span class="text-gray-500">Email</span><div class="font-medium"><?= esc($student->email) ?></div></div>
    <div><span class="text-gray-500">Jurusan</span><div class="font-medium"><?= esc($student->major) ?></div></div>
    <div><span class="text-gray-500">Angkatan</span><div class="font-medium"><?= esc($student->entry_year) ?></div></div>
  </div>
</div>

<h3 class="text-lg font-semibold mb-3">Courses yang diambil</h3>

<div class="bg-white rounded-xl border overflow-x-auto">
  <table class="min-w-full text-sm">
    <thead class="bg-gray-50">
      <tr>
        <th class="px-3 py-2 text-left">Code</th>
        <th class="px-3 py-2 text-left">Name</th>
        <th class="px-3 py-2 text-center">Credits</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($courses)): ?>
        <?php foreach ($courses as $c): ?>
          <tr class="border-t">
            <td class="px-3 py-2"><?= esc($c->course_code) ?></td>
            <td class="px-3 py-2"><?= esc($c->course_name) ?></td>
            <td class="px-3 py-2 text-center"><?= esc($c->credits) ?></td>
          </tr>
        <?php endforeach; ?>
        <tr class="border-t font-medium">
          <td class="px-3 py-2" colspan="2">Total Credits</td>
          <td class="px-3 py-2 text-center"><?= esc($totalCredits) ?></td>
        </tr>
      <?php else: ?>
        <tr><td class="px-3 py-4 text-center text-gray-500" colspan="3">Belum mengambil course.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<div class="mt-6 flex gap-2">
  <a class="px-3 py-2 rounded border" href="/admin/students">Kembali</a>
  <a class="px-3 py-2 rounded bg-blue-600 text-white hover:bg-blue-700"
     href="/admin/students/<?= $student->student_id ?>/edit">Edit</a>
</div>

<?= $this->endSection() ?>
