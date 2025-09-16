<?php
namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\StudentModel;
use App\Models\TakeModel;

class Enroll extends BaseController
{
    /**
     * Halaman daftar course untuk student.
     * Menyediakan: semua courses, id courses yang sudah diambil, dan daftar course detail yang sudah diambil.
     */
    public function index()
    {
        $userId  = session()->get('user_id');
        $student = (new StudentModel())->where('user_id', $userId)->first();
        if (!$student) {
            return redirect()->to('/login')->with('error', 'Data student tidak ditemukan.');
        }

        $courseM = new CourseModel();
        $takeM   = new TakeModel();

        // semua course
        $courses = $courseM->orderBy('course_code')->findAll();

        // id course yang sudah diambil
        $takenIds = $takeM->select('course_id')
                          ->where('student_id', $student->student_id)
                          ->findColumn('course_id') ?? [];

        // daftar course yang sudah diambil (untuk tabel bawah)
        $takenCourses = !empty($takenIds)
            ? $courseM->whereIn('course_id', $takenIds)->orderBy('course_code')->findAll()
            : [];

        return view('students/enroll', [
            'student'      => $student,
            'courses'      => $courses,
            'takenIds'     => $takenIds,     // array of int
            'takenCourses' => $takenCourses, // array of objects
        ]);
    }

    /**
     * Ambil course
     */
    public function store($course_id)
    {
        $userId  = session()->get('user_id');
        $student = (new StudentModel())->where('user_id', $userId)->first();
        if (!$student) {
            return redirect()->back()->with('error', 'Data student tidak ditemukan.');
        }

        // validasi course
        if (!(new CourseModel())->find($course_id)) {
            return redirect()->back()->with('error', 'Course tidak ditemukan.');
        }

        $takeM = new TakeModel();

        // anti-duplikat
        $exists = $takeM->where([
            'student_id' => $student->student_id,
            'course_id'  => $course_id,
        ])->countAllResults();

        if ($exists) {
            return redirect()->to('/student/enroll')->with('info', 'Course ini sudah kamu ambil.');
        }

        $takeM->insert([
            'student_id'  => $student->student_id,
            'course_id'   => $course_id,
            'enroll_date' => date('Y-m-d'),
            'status'      => 'active',
        ]);

        return redirect()->to('/student/enroll')->with('success', 'Course berhasil diambil.');
    }

    /**
     * Batalkan course yang sudah diambil
     */
    public function drop($course_id)
    {
        $userId  = session()->get('user_id');
        $student = (new StudentModel())->where('user_id', $userId)->first();
        if (!$student) {
            return redirect()->back()->with('error', 'Data student tidak ditemukan.');
        }

        (new TakeModel())
            ->where('student_id', $student->student_id)
            ->where('course_id',  $course_id)
            ->delete();

        return redirect()->to('/student/enroll')->with('success', 'Course dibatalkan.');
    }
}