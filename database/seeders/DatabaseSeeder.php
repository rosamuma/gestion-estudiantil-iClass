<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            ['name' => 'Admin Principal',     'email' => 'admin@edu.com',    'role' => 'admin',   'password' => Hash::make('password123'), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dr. Carlos García',   'email' => 'garcia@edu.com',   'role' => 'teacher', 'password' => Hash::make('password123'), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dra. Ana López',      'email' => 'lopez@edu.com',    'role' => 'teacher', 'password' => Hash::make('password123'), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ing. Jorge Martínez', 'email' => 'martinez@edu.com', 'role' => 'teacher', 'password' => Hash::make('password123'), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ana Torres',          'email' => 'ana@edu.com',      'role' => 'student', 'password' => Hash::make('password123'), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Luis Martínez',       'email' => 'luis@edu.com',     'role' => 'student', 'password' => Hash::make('password123'), 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('programs')->insert([
            ['name' => 'Ingeniería de Sistemas', 'code' => 'ISI', 'duration_semesters' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Medicina',               'code' => 'MED', 'duration_semesters' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Derecho',                'code' => 'DER', 'duration_semesters' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Administración',         'code' => 'ADM', 'duration_semesters' => 8,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Psicología',             'code' => 'PSI', 'duration_semesters' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ingeniería Civil',       'code' => 'ICI', 'duration_semesters' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Contaduría Pública',     'code' => 'CNT', 'duration_semesters' => 8,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Física',                 'code' => 'FIS', 'duration_semesters' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Humanidades',            'code' => 'HUM', 'duration_semesters' => 8,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Matemáticas',            'code' => 'MAT', 'duration_semesters' => 10, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('teachers')->insert([
            ['name' => 'Dr. Carlos García',    'email' => 'garcia_t@edu.com',    'specialty' => 'Matemáticas',    'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dra. Ana López',       'email' => 'lopez_t@edu.com',     'specialty' => 'Física',         'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lic. Jorge Martínez',  'email' => 'martinez_t@edu.com',  'specialty' => 'Historia',       'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ing. Sofía Rodríguez', 'email' => 'rodriguez_t@edu.com', 'specialty' => 'Programación',   'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dra. Carmen Pérez',    'email' => 'perez_t@edu.com',     'specialty' => 'Química',        'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dr. Miguel Sánchez',   'email' => 'sanchez_t@edu.com',   'specialty' => 'Cálculo',        'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ing. Laura Torres',    'email' => 'torres_t@edu.com',    'specialty' => 'Bases de Datos', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('courses')->insert([
            ['name' => 'Matemáticas II',      'code' => 'MAT-201', 'teacher_id' => 1, 'program_id' => 1,  'credits' => 4, 'status' => 'active',   'description' => 'Álgebra lineal y cálculo multivariable.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Física Cuántica',     'code' => 'FIS-301', 'teacher_id' => 2, 'program_id' => 8,  'credits' => 3, 'status' => 'active',   'description' => 'Introducción a la mecánica cuántica.',    'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Historia Universal',  'code' => 'HIS-101', 'teacher_id' => 3, 'program_id' => 9,  'credits' => 2, 'status' => 'active',   'description' => 'Historia desde la antigüedad.',           'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Programación Web',    'code' => 'PRG-202', 'teacher_id' => 4, 'program_id' => 1,  'credits' => 4, 'status' => 'active',   'description' => 'HTML, CSS, JS y frameworks modernos.',    'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Química Orgánica',    'code' => 'QUI-201', 'teacher_id' => 5, 'program_id' => 2,  'credits' => 3, 'status' => 'pending',  'description' => 'Compuestos orgánicos y reacciones.',       'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cálculo Diferencial', 'code' => 'MAT-101', 'teacher_id' => 6, 'program_id' => 10, 'credits' => 4, 'status' => 'finished', 'description' => 'Derivadas e integrales.',                  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bases de Datos',      'code' => 'BD-301',  'teacher_id' => 7, 'program_id' => 1,  'credits' => 3, 'status' => 'active',   'description' => 'SQL, diseño relacional y NoSQL.',          'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('students')->insert([
            ['name' => 'Ana Torres',     'email' => 'ana@edu.com',     'student_code' => '2024-001', 'semester' => 3, 'status' => 'active',   'program_id' => 1, 'enrollment_date' => '2024-01-15', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Luis Martínez',  'email' => 'luis@edu.com',    'student_code' => '2024-002', 'semester' => 1, 'status' => 'active',   'program_id' => 2, 'enrollment_date' => '2024-01-15', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sara Gómez',     'email' => 'sara@edu.com',    'student_code' => '2023-015', 'semester' => 5, 'status' => 'active',   'program_id' => 3, 'enrollment_date' => '2023-01-15', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pedro Ramírez',  'email' => 'pedro@edu.com',   'student_code' => '2022-033', 'semester' => 7, 'status' => 'inactive', 'program_id' => 4, 'enrollment_date' => '2022-01-15', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Laura Díaz',     'email' => 'laura@edu.com',   'student_code' => '2024-008', 'semester' => 2, 'status' => 'active',   'program_id' => 5, 'enrollment_date' => '2024-01-15', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Carlos Ruiz',    'email' => 'carlos@edu.com',  'student_code' => '2023-041', 'semester' => 4, 'status' => 'active',   'program_id' => 6, 'enrollment_date' => '2023-01-15', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Valeria Castro', 'email' => 'valeria@edu.com', 'student_code' => '2024-012', 'semester' => 1, 'status' => 'active',   'program_id' => 7, 'enrollment_date' => '2024-01-15', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Miguel Herrera', 'email' => 'miguel@edu.com',  'student_code' => '2023-019', 'semester' => 5, 'status' => 'active',   'program_id' => 1, 'enrollment_date' => '2023-01-15', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Daniela Mora',   'email' => 'daniela@edu.com', 'student_code' => '2024-021', 'semester' => 2, 'status' => 'active',   'program_id' => 8, 'enrollment_date' => '2024-01-15', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Felipe Ortega',  'email' => 'felipe@edu.com',  'student_code' => '2022-055', 'semester' => 8, 'status' => 'active',   'program_id' => 9, 'enrollment_date' => '2022-01-15', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('course_student')->insert([
            ['course_id' => 1, 'student_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['course_id' => 1, 'student_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['course_id' => 1, 'student_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['course_id' => 2, 'student_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['course_id' => 2, 'student_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['course_id' => 3, 'student_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['course_id' => 3, 'student_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['course_id' => 4, 'student_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['course_id' => 4, 'student_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['course_id' => 7, 'student_id' => 8, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('grades')->insert([
            ['student_id' => 1, 'course_id' => 1, 'period' => '2024-1', 'grade_1' => 9.5, 'grade_2' => 8.8, 'grade_3' => 9.0,  'average' => 9.1, 'created_at' => now(), 'updated_at' => now()],
            ['student_id' => 6, 'course_id' => 1, 'period' => '2024-1', 'grade_1' => 7.0, 'grade_2' => 6.5, 'grade_3' => 7.5,  'average' => 7.0, 'created_at' => now(), 'updated_at' => now()],
            ['student_id' => 8, 'course_id' => 1, 'period' => '2024-1', 'grade_1' => 8.0, 'grade_2' => 8.5, 'grade_3' => 9.0,  'average' => 8.5, 'created_at' => now(), 'updated_at' => now()],
            ['student_id' => 2, 'course_id' => 2, 'period' => '2024-1', 'grade_1' => 7.0, 'grade_2' => 8.0, 'grade_3' => 8.5,  'average' => 7.8, 'created_at' => now(), 'updated_at' => now()],
            ['student_id' => 3, 'course_id' => 3, 'period' => '2024-1', 'grade_1' => 8.5, 'grade_2' => 8.0, 'grade_3' => 9.0,  'average' => 8.5, 'created_at' => now(), 'updated_at' => now()],
            ['student_id' => 4, 'course_id' => 3, 'period' => '2024-1', 'grade_1' => 4.5, 'grade_2' => 6.0, 'grade_3' => 7.0,  'average' => 5.8, 'created_at' => now(), 'updated_at' => now()],
            ['student_id' => 5, 'course_id' => 4, 'period' => '2024-1', 'grade_1' => 9.8, 'grade_2' => 9.5, 'grade_3' => 10.0, 'average' => 9.8, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $rows = [];
        foreach (range(0, 4) as $d) {
            $date = Carbon::today()->subDays($d)->format('Y-m-d');
            foreach ([[1,1,'present'],[6,1,'absent'],[8,1,'present'],[2,2,'present'],[9,2,'justified'],[3,3,'present'],[4,3,'absent'],[5,4,'present']] as [$sid,$cid,$status]) {
                $rows[] = ['student_id'=>$sid,'course_id'=>$cid,'date'=>$date,'status'=>$status,'notes'=>null,'created_at'=>now(),'updated_at'=>now()];
            }
        }
        DB::table('attendances')->insert($rows);

        $this->command->info('');
        $this->command->info('✅  EduPlatform seeded!');
        $this->command->info('   admin@edu.com  / password123  →  Administrador');
        $this->command->info('   garcia@edu.com / password123  →  Docente');
        $this->command->info('   ana@edu.com    / password123  →  Estudiante');
    }
}
