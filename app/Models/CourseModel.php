<?php
namespace App\Models;
use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table      = 'courses';
    protected $primaryKey = 'course_id';
    protected $returnType = 'object';
    protected $allowedFields = ['course_code','course_name','credits','created_at','updated_at'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $validationRules = [
        'course_code' => 'required|min_length[2]|max_length[20]',
        'course_name' => 'required|min_length[3]',
        'credits'     => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[10]',
    ];
}
