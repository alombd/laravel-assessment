<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    public $incrementing = false; // Because we use UUID

    protected $keyType = 'string';

    protected $fillable = [
        'id', 'name', 'email', 'department_id'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function detail()
    {
        return $this->hasOne(EmployeeDetail::class, 'employee_id', 'id');
    }
}

