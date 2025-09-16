<?php
namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\CourseModel;

class Admin extends BaseController
{
    public function dashboard()
    {
        $studentCount = (new StudentModel())->countAllResults();
        $courseCount  = (new CourseModel())->countAllResults();

        return view('admin/dashboard', [
            'studentCount' => $studentCount,
            'courseCount'  => $courseCount,
        ]);
    }
}