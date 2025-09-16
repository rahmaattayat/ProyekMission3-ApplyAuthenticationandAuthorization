<?php
namespace App\Models;
use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table         = 'students';
    protected $primaryKey    = 'student_id';
    protected $returnType    = 'object';
    protected $allowedFields = ['user_id','nim','entry_year','major'];

    protected $validationRules = [
        'user_id'    => 'required|is_natural_no_zero',
        'nim'        => 'required|min_length[5]|max_length[30]|is_unique[students.nim,student_id,{student_id}]',
        'entry_year' => 'required|integer|greater_than_equal_to[2000]|less_than_equal_to[2100]',
        'major'      => 'required|min_length[2]|max_length[100]',
    ];

    public function withUser()
    {
        return $this->select('students.*, users.full_name, users.username, users.email')
                    ->join('users', 'users.user_id = students.user_id', 'left');
    }
}
