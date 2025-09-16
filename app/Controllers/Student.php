<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\StudentModel;
use App\Models\TakeModel; 

class Student extends BaseController
{
    public function index()
    {
        $m = new StudentModel();
        return view('students/index', [
            'students' => $m->withUser()->orderBy('nim')->findAll(),
        ]);
    }

    public function show($id)
    {
        $m = new StudentModel();
        $student = $m->withUser()->where('student_id', $id)->first();
        if (! $student) {
            return redirect()->to('/admin/students')->with('error', 'Student tidak ditemukan.');
        }

        $takeM   = new TakeModel();
        $courses = $takeM->byStudentWithCourse((int)$id);

        $totalCredits = 0;
        foreach ($courses as $c) {
            $totalCredits += (int)($c->credits ?? 0);
        }

        return view('students/show', [
            'student'      => $student,
            'courses'      => $courses,
            'totalCredits' => $totalCredits,
        ]);
    }

    public function new()
    {
        return view('students/form');
    }

    public function create()
    {
        $fullName = trim($this->request->getPost('full_name') ?? '');
        $email    = trim($this->request->getPost('email') ?? '');
        $username = trim($this->request->getPost('username') ?? '');
        $nim      = trim($this->request->getPost('nim') ?? '');
        $entry    = (int) ($this->request->getPost('entry_year') ?? date('Y'));
        $major    = trim($this->request->getPost('major') ?? '');
        $pass     = $this->request->getPost('password');
        $pass2    = $this->request->getPost('password_confirm');

        $rules = [
            'full_name'        => 'required|min_length[3]',
            'email'            => 'required|valid_email',
            'username'         => 'required|alpha_dash|min_length[3]|is_unique[users.username]',
            'nim'              => 'required|numeric|is_unique[students.nim]',
            'entry_year'       => 'required|integer',
            'major'            => 'required|min_length[2]',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $userM = new UserModel();
        $userId = $userM->insert([
            'username'      => $username,
            'email'         => $email,
            'password_hash' => password_hash($pass, PASSWORD_DEFAULT),
            'full_name'     => $fullName,
            'role'          => 'student',
            'is_active'     => 1,
        ], true);

        if (! $userId) {
            return redirect()->back()->with('error', 'Gagal membuat akun pengguna.')->withInput();
        }

        $studM = new StudentModel();
        if (! $studM->insert([
            'user_id'    => $userId,
            'nim'        => $nim,
            'entry_year' => $entry,
            'major'      => $major,
        ])) {
            $userM->delete($userId);
            return redirect()->back()->with('errors', $studM->errors())->withInput();
        }

        return redirect()->to('/admin/students')
            ->with('success', 'Student ditambahkan. Akun login dibuat dengan username yang ditentukan.');
    }

    public function edit($id)
    {
        $m = new StudentModel();
        $student = $m->withUser()->where('student_id', $id)->first();
        if (! $student) {
            return redirect()->to('/admin/students')->with('error', 'Student tidak ditemukan.');
        }
        return view('students/form', ['student' => $student]);
    }

    public function update($id)
    {
        $studM   = new StudentModel();
        $student = $studM->withUser()->where('student_id', $id)->first();
        if (! $student) {
            return redirect()->to('/admin/students')->with('error', 'Student tidak ditemukan.');
        }

        $fullName = trim($this->request->getPost('full_name') ?? '');
        $email    = trim($this->request->getPost('email') ?? '');
        $username = trim($this->request->getPost('username') ?? '');
        $nim      = trim($this->request->getPost('nim') ?? '');
        $entry    = (int) ($this->request->getPost('entry_year') ?? date('Y'));
        $major    = trim($this->request->getPost('major') ?? '');
        $pass     = $this->request->getPost('password');
        $pass2    = $this->request->getPost('password_confirm');

        $rules = [
            'full_name'  => 'required|min_length[3]',
            'email'      => 'required|valid_email',
            'username'   => "required|alpha_dash|min_length[3]|is_unique[users.username,user_id,{$student->user_id}]",
            'nim'        => "required|numeric|is_unique[students.nim,student_id,{$id}]",
            'entry_year' => 'required|integer',
            'major'      => 'required|min_length[2]',
        ];
        if ($pass || $pass2) {
            $rules['password'] = 'required|min_length[6]';
            $rules['password_confirm'] = 'required|matches[password]';
        }
        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $userM = new UserModel();
        $userData = [
            'user_id'   => $student->user_id,
            'full_name' => $fullName,
            'email'     => $email,
            'username'  => $username,
        ];
        if ($pass) {
            $userData['password_hash'] = password_hash($pass, PASSWORD_DEFAULT);
        }
        if (! $userM->save($userData)) {
            return redirect()->back()->with('errors', $userM->errors())->withInput();
        }

        if (! $studM->save([
            'student_id' => $id,
            'nim'        => $nim,
            'entry_year' => $entry,
            'major'      => $major,
        ])) {
            return redirect()->back()->with('errors', $studM->errors())->withInput();
        }

        return redirect()->to('/admin/students')->with('success', 'Student diupdate.');
    }

    public function delete($id)
    {
        (new StudentModel())->delete($id);
        return redirect()->to('/admin/students')->with('success', 'Student dihapus.');
    }
}
