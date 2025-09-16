<?php
namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\TakeModel;

class StudentArea extends BaseController
{
    private const MAX_CREDITS = 24;

    private function currentUserId(): ?int
    {
        $s = session();
        if ($s->get('user_id')) return (int)$s->get('user_id');
        $u = $s->get('user');
        if (is_array($u) && isset($u['user_id'])) return (int)$u['user_id'];
        if (is_object($u) && isset($u->user_id))   return (int)$u->user_id;
        return null;
    }

    private function currentStudent(): ?object
    {
        $uid = $this->currentUserId();
        if (!$uid) return null;
        return (new StudentModel())->withUser()
            ->where('students.user_id', $uid)->first();
    }

    public function dashboard()
    {
        $student = $this->currentStudent();
        if (!$student) return redirect()->to('/login');

        $takeM   = new TakeModel();
        $courses = $takeM->byStudentWithCourse((int)$student->student_id);

        $total = 0;
        foreach ($courses as $c) $total += (int)($c->credits ?? 0);

        return view('student/dashboard', [
            'student'       => $student,
            'totalCredits'  => $total,
            'remainCredits' => max(0, self::MAX_CREDITS - $total),
            'maxCredits'    => self::MAX_CREDITS,
        ]);
    }
}