<?php
namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if (session()->get('role') === 'admin') {
            return redirect()->to('/admin/dashboard');
        }

        if (session()->get('role') === 'student') {
            return redirect()->to('/student/enroll');
        }

        return redirect()->to('/login');
    }
}
