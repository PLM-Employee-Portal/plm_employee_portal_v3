<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CollegesDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colleges = ['College of Architecture and Urban Planning',
        'College of Education',
        'College of Engineering',
        'College of Information System and Technology Management',  
        'College of Humanities, Arts and Social Sciences',
        'College of Medicine',
        'College of Nursing',
        'College of Physical Therapy',
        'College of Science', 
        'Graduate School of Law',
        'College of Law',
        'PLM Business School', 
        'School of Government',
        'School of Public Health',];

        foreach ($colleges as $college) {
            DB::table('colleges')->insert([
                'college_name' => $college,
            ]);
        }

        $departments = [
            'Computer Science',
            'Infomration Technology',
            'Computer Engineering',
        ];

        foreach ($colleges as $college) {
            DB::table('departments')->insert([
                'college_name' => $college,
            ]);
        }
    }
}
