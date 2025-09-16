<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-slate-100">
  <div class="w-full max-w-md bg-white p-6 rounded-xl shadow">
    <h1 class="text-2xl font-semibold mb-4">Login Kampus App</h1>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="mb-3 rounded border border-red-300 bg-red-50 px-3 py-2 text-red-700">
        <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <form method="post" action="/login" class="space-y-4">
      <?= csrf_field() ?>
      <div>
        <label class="block text-sm mb-1">Username</label>
        <input name="username" value="<?= old('username') ?>" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" required>
      </div>
      <div>
        <label class="block text-sm mb-1">Password</label>
        <input type="password" name="password" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" required>
      </div>
      <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Masuk</button>
    </form>
  </div>
</body>
</html>
