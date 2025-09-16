<?php
namespace App\Models;

use CodeIgniter\Model;

class TakeModel extends Model
{
    protected $table         = 'takes';
    protected $primaryKey    = 'student_id';
    protected $useAutoIncrement = false;
    protected $returnType    = 'object';
    protected $allowedFields = ['student_id','course_id','enroll_date','status'];

    public function byStudentWithCourse(int $studentId): array
    {
        return $this->select('takes.*, courses.course_code, courses.course_name, courses.credits')
                    ->join('courses', 'courses.course_id = takes.course_id', 'left')
                    ->where('takes.student_id', $studentId)
                    ->orderBy('courses.course_code', 'ASC')
                    ->findAll();
    }
}
