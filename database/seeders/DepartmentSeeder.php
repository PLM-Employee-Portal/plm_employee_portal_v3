<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
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
        'College of Law',
        'Graduate School of Law',
        'College of Medicine',
        'College of Physical Therapy',
        'College of Nursing',
        'College of Science', 
        'College of Business Administration',
        'College of Public Administration',
        'College of Accountancy',
        'PLM Business School', 
        'School of Government',
        'School of Public Health',];

        $ctr = 0;
        foreach ($colleges as $college) {
            DB::table('colleges')->insert([
                'college_name' => $college,
                // 'college_id' => $ctr
            ]);
            $ctr += 1;

        }

        $departments = [
            'Business Administration',
            'Real Estate Management',
            'Entrepreneurship',
            'Accountancy',
            'Tourism Management',
            'Hospitality Management',
            'Civil Engineering',
            'Mechanical Engineering',
            'Chemical Engineering',
            'Computer Engineering',
            'Electronics Engineering',
            'Manufacturing Engineering',
            'Computer Science',
            'Information Technology',
            'Communications',
            'Social Work',
            'Music',
            'Elementary Education',
            'Early Childhood Education',
            'Special Needs Education',
            'English',
            'Filipino',
            'Mathematics',
            'Sciences',
            'Social Studies',
            'Physical Education',
            'Biological Sciences',
            'Physics',
            'Chemistry',
            'Educational Administration',
            'Nursing',
            'Physical Therapy',
            'Psychology',
            'Biology',
            'Mathematics',
            'Chemistry',
            'Law',
            'Medicine',
            'Government Management',
            'Office for Graduate and Professional Studies',
            'Sports Programs Presidential Committee on Arts, Culture and Sports',
            'Arts and Culture Presidential Committee on Arts, Culture and Sports',
            'Internal Audit Office',
            'University Registrar',
            'Admissions Officer',
            'Office of Guidance and Testing Services',
            'University Library',
            'Office of National Service Training Program',
            'Office of National Service Training Program',
            'Center of University Extension Services',
            'General Services Office',
            'Human Resource Development Office',
            'University Health Services',
            'University Security Office',
            'Information and Communications Technology Office',
            'Property and Supplies Office',
            'Physical Facilities Management Office',
            'Treasurer of the University',
            'Accounting Office',
            'Budget Office',
            'Resource Generation Office',
            'Procurement Office',
        ];

        $ctr = 0;
        foreach ($departments as $department) {
            DB::table('departments')->insert([
                'department_name' => $department,
                'college_id' => $ctr
            ]);
            $ctr += 1;
        }
    }
}
