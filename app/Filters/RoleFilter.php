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
            if (! in_array($role, $arguments, true)) {
                return ($role === 'admin')
                    ? redirect()->to('/admin/dashboard')->with('error', 'Tidak punya akses.')
                    : redirect()->to('/student/dashboard')->with('error', 'Tidak punya akses.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // nothing
    }
}
