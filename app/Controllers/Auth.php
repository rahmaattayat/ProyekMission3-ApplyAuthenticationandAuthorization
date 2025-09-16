<?php
namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        // kalau sudah login, langsung lempar sesuai role
        $role = session()->get('role');
        if ($role === 'admin')   return redirect()->to('/admin/dashboard');
        if ($role === 'student') return redirect()->to('/student/dashboard');

        return view('auth/login');    }

    public function attempt()
    {
        $username = trim($this->request->getPost('username') ?? '');
        $password = (string) $this->request->getPost('password');

        if ($username === '' || $password === '') {
            return redirect()->back()->with('error', 'Isi username dan password.')->withInput();
        }

        $userM = new UserModel();

        // login pakai username 
        $user = $userM->where('username', $username)->first();
        if (! $user) {
            // sebagai email 
            $user = $userM->where('email', $username)->first();
        }

        if (! $user || ! password_verify($password, $user->password_hash)) {
            return redirect()->back()->with('error', 'Username atau password salah.')->withInput();
        }

        if (isset($user->is_active) && (int)$user->is_active === 0) {
            return redirect()->back()->with('error', 'Akun dinonaktifkan. Hubungi admin.');
        }

        $sessData = [
            'isLoggedIn' => true,                 
            'user_id'    => (int) $user->user_id,
            'role'       => $user->role,          
            'username'   => $user->username,
            'full_name'  => $user->full_name,
            'user'       => [
                'user_id'   => (int) $user->user_id,
                'full_name' => $user->full_name,
                'role'      => $user->role,
            ],
        ];

        session()->regenerate(true);  
        session()->set($sessData);

        return ($user->role === 'admin')
            ? redirect()->to('/admin/dashboard')
            : redirect()->to('/student/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('info', 'Anda sudah logout.');
    }
}
