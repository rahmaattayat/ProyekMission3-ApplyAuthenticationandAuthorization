<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'user_id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'username','email','password_hash','full_name','role','is_active','created_at','updated_at'
    ];
}
