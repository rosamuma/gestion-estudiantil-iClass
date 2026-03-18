<?php

namespace App\Models\Education;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $table    = 'courses';
    protected $fillable = ['name','code','teacher_id','program_id','credits','status','description'];

    public function teacher()     { return $this->belongsTo(Teacher::class); }
    public function program()     { return $this->belongsTo(Program::class); }
    public function grades()      { return $this->hasMany(Grade::class); }
    public function attendances() { return $this->hasMany(Attendance::class); }
    public function students()    { return $this->belongsToMany(Student::class, 'course_student')->withTimestamps(); }
}
