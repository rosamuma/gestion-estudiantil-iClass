<?php

namespace App\Models\Education;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $table    = 'grades';
    protected $fillable = ['student_id','course_id','period','grade_1','grade_2','grade_3','grade_4','average','notes'];
    protected $casts    = ['grade_1'=>'float','grade_2'=>'float','grade_3'=>'float','grade_4'=>'float','average'=>'float'];

    public function student() { return $this->belongsTo(Student::class); }
    public function course()  { return $this->belongsTo(Course::class); }
}
