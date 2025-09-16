<?php
// segmen aktif (support /index.php/... juga)
$uri    = service('uri');
$active = ($uri->getSegment(1) === 'index.php') ? $uri->getSegment(3) : $uri->getSegment(2);

// ambil nama user dari session (array/obj)
$user     = session()->get('user') ?? [];
$fullName = is_array($user) ? ($user['full_name'] ?? 'Student') : ($user->full_name ?? 'Student');
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Kampus App</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">

  <!-- TOPBAR (sama pola dengan admin) -->
  <header class="w-full bg-white border-b">
    <div class="px-6 py-3 flex items-center justify-between">
      <div class="font-semibold">Kampus App</div>
      <div class="text-sm">
        <span class="mr-3"><?= esc($fullName) ?> <span class="text-gray-500">(student)</span></span>
        <a href="/logout" class="px-3 py-1 rounded bg-red-600 text-white hover:bg-red-700">Logout</a>
      </div>
    </div>
  </header>

  <!-- BODY: sidebar kiri nempel + konten kanan -->
  <div class="min-h-[calc(100vh-56px)] flex"> <!-- tinggi layar - tinggi topbar -->
    <!-- SIDEBAR KIRI (menempel ke tepi kiri layar) -->
    <aside class="w-64 bg-white border-r">
      <div class="px-4 py-4 font-semibold">Menu</div>
      <nav class="px-2 pb-6 text-sm">
        <a href="/student/dashboard"
           class="block px-3 py-2 rounded mb-1 <?= $active==='dashboard' ? 'bg-indigo-50 text-indigo-700 font-medium' : 'hover:bg-gray-50' ?>">
          Dashboard
        </a>
        <a href="/student/enroll"
           class="block px-3 py-2 rounded mb-1 <?= $active==='enroll' ? 'bg-indigo-50 text-indigo-700 font-medium' : 'hover:bg-gray-50' ?>">
          Enroll Courses
        </a>
      </nav>
    </aside>

    <!-- KONTEN KANAN -->
    <main class="flex-1">
      <div class="px-6 py-6">
        <div class="bg-white border rounded-xl p-6">
          <?= $this->renderSection('content') ?>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
