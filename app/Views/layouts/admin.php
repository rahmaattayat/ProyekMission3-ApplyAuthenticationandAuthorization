<?php
$role   = session()->get('role');
$uri    = service('uri')->getPath(); // contoh: "admin/courses"

// helper kelas aktif untuk sidebar
if (!function_exists('nav_active')) {
  function nav_active(string $prefix, string $uri): string {
    return str_starts_with($uri, $prefix)
      ? 'bg-white text-rose-700 shadow-sm'
      : 'text-rose-900/80 hover:bg-rose-50 hover:text-rose-800';
  }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title><?= esc($title ?? 'Kampus App') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Tailwind via CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">

  <!-- Topbar -->
  <nav class="fixed top-0 left-0 right-0 bg-white border-b z-40">
    <div class="max-w-[1200px] mx-auto px-4 py-3 flex items-center justify-between">
      <a href="<?= $role==='admin' ? '/admin/dashboard' : '/' ?>" class="font-semibold">
        Kampus App
      </a>

      <div class="flex items-center gap-4">
        <?php if ($role === 'student'): ?>
          <a class="hover:underline" href="/student/enroll">Enroll</a>
        <?php endif; ?>
        <span class="text-sm text-gray-500">
          <?= esc(session()->get('full_name')) ?> (<?= esc($role ?: '-') ?>)
        </span>
        <a href="/logout" class="px-3 py-1.5 rounded bg-red-500 text-white hover:bg-red-600">Logout</a>
      </div>
    </div>
  </nav>

  <div class="pt-[56px]"><!-- spacer setinggi topbar --></div>

  <?php $isAdmin = ($role === 'admin'); ?>

  <!-- Sidebar kiri (admin only) -->
  <?php if ($isAdmin): ?>
<aside
  class="fixed left-0 top-[56px] bottom-0 w-60 bg-white border-r border-gray-200 z-30 overflow-y-auto">
  <nav class="p-2 space-y-1">
    <!-- Beranda -->
    <a href="/admin/dashboard"
       class="block px-3 py-2 rounded-md <?= nav_active('admin/dashboard', $uri) ?>">
      Beranda
    </a>

    <!-- Students -->
    <a href="/admin/students"
       class="block px-3 py-2 rounded-md <?= nav_active('admin/students', $uri) ?>">
      Students
    </a>

    <!-- Kelola Courses -->
    <a href="/admin/courses"
       class="block px-3 py-2 rounded-md <?= nav_active('admin/courses', $uri) ?>">
      Kelola Courses
    </a>
  </nav>
</aside>
<?php endif; ?>

  <!-- Konten -->
  <main class="<?= $isAdmin ? 'pl-60' : '' ?> px-4 py-6 max-w-[1200px] mx-auto">
    <?php if (session()->getFlashdata('error')): ?>
      <div class="mb-4 rounded border border-red-300 bg-red-50 px-3 py-2 text-red-700">
        <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
      <div class="mb-4 rounded border border-emerald-300 bg-emerald-50 px-3 py-2 text-emerald-700">
        <?= session()->getFlashdata('success') ?>
      </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('info')): ?>
      <div class="mb-4 rounded border border-sky-300 bg-sky-50 px-3 py-2 text-sky-800">
        <?= session()->getFlashdata('info') ?>
      </div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
  </main>

</body>
</html>