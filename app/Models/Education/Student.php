<?php

namespace App\Models\Education;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $table    = 'students';
    protected $fillable = ['name','email','student_code','semester','status','program_id','enrollment_date','notes'];
    protected $casts    = ['enrollment_date' => 'date'];

    public function program()     { return $this->belongsTo(Program::class); }
    public function grades()      { return $this->hasMany(Grade::class); }
    public function attendances() { return $this->hasMany(Attendance::class); }
    public function courses()     { return $this->belongsToMany(Course::class, 'course_student')->withTimestamps(); }

    public function getAverageAttribute(): ?float
    {
        $avg = $this->grades()->whereNotNull('average')->avg('average');
        return $avg ? round((float) $avg, 1) : null;
    }
}
