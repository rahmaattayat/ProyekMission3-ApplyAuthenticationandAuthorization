<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $isLoggedIn = session()->get('isLoggedIn') === true;
        $role       = session()->get('role');

        if (! $isLoggedIn) {
            return redirect()->to('/login')->with('error', 'Silakan login dulu.');
        }

        if (! empty($arguments) && is_array($arguments)) {
            // contoh: ['admin'] atau ['student']
            if (! in_array($role, $arguments, true)) {
                // role tidak sesuai, kembalikan ke tempat yang benar
                return ($role === 'admin')
                    ? redirect()->to('/admin/dashboard')->with('error', 'Tidak punya akses.')
                    : redirect()->to('/student/dashboard')->with('error', 'Tidak punya akses.');
            }
        }
        // allow
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // nothing
    }
}
