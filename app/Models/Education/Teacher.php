<?php

namespace App\Models\Education;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $table    = 'teachers';
    protected $fillable = ['name','email','specialty','status'];

    public function courses() { return $this->hasMany(Course::class); }
}
