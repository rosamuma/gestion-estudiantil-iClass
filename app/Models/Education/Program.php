<?php

namespace App\Models\Education;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $table    = 'programs';
    protected $fillable = ['name','code','description','duration_semesters'];

    public function students() { return $this->hasMany(Student::class); }
    public function courses()  { return $this->hasMany(Course::class); }
}
