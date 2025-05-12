<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'photo',
        'nid',
        'salary',
        'joining_date',	
    ];
    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

}
