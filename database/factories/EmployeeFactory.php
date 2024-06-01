<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $employeeHistory = [];
        for ($i = 0; $i < $this->faker->numberBetween(1, 3); $i++) {
            $employeeHistory[] = [
                'name_of_company' => $this->faker->company,
                'prev_position' => $this->faker->jobTitle,
                'start_date' => $this->faker->date('Y-m-d', '-2 years'),
                'end_date' => $this->faker->date('Y-m-d', 'now'),
            ];
        }

        for ($i = 0; $i < $this->faker->numberBetween(1, 3); $i++) {
            $collegeids[] = $this->faker->numberBetween(1, 17);
        }

        for ($i = 0; $i < $this->faker->numberBetween(1, 3); $i++) {
            $departmentids[] = $this->faker->numberBetween(1, 62);
        }

        $is_college_head = [];
        for ($i = 0; $i < count($collegeids); $i++) {
            if(in_array(1, $is_college_head) == False){
                array_push($is_college_head, $this->faker->numberBetween(0, 1));
            } else {
                array_push($is_college_head, 0);
            }
        }

        $is_department_head = [];
        for ($i = 0; $i < count($departmentids); $i++) {
            if(in_array(1, $is_department_head) == False){
                array_push($is_department_head, $this->faker->numberBetween(0, 1));
            } else {
                array_push($is_department_head, 0);
            }
        }
        
        return [
            'employee_id' => '2024' . $this->faker->unique()->numberBetween(10000, 99999),
            'job_id' => $this->faker->numberBetween(1, 100),
            'employee_type' => $this->faker->word,
            'school_email' => $this->faker->unique()->safeEmail,
            'religion' => $this->faker->randomElement(['Christianity', 'Islam', 'Hinduism', 'Buddhism', 'None']),
            'civil_status' => $this->faker->randomElement(['Single', 'Married', 'Divorced', 'Widowed']),
            'college_id' => $collegeids,
            'department_id' => $departmentids,
            'is_department_head' => $is_department_head,
            'is_college_head' =>  $is_college_head,
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'age' => $this->faker->numberBetween(20, 65),
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Would Rather Not say']),
            'personal_email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'birth_date' => $this->faker->date(),
            'address' => $this->faker->address,
            'start_of_employment' => $this->faker->date(),
            'end_of_employment' => $this->faker->optional()->date(),
            'employee_history' => json_encode($employeeHistory),
            'vacation_credits' => $this->faker->optional()->randomFloat(2, 0, 30),
            'sick_credits' => $this->faker->optional()->randomFloat(2, 0, 30),
            'study_available_units' => $this->faker->optional()->numberBetween(0, 12),
            'teach_available_units' => $this->faker->optional()->numberBetween(0, 12),
            'current_position' => $this->faker->jobTitle,
            'is_faculty' => $this->faker->boolean,
            'salary' => $this->faker->randomFloat(2, 30000, 200000),
            'cto' => $this->faker->randomFloat(2, 0, 100),
            'active' => $this->faker->boolean,
            
            // Documents
            // 'emp_image' => $this->faker->optional()->imageUrl(),
            'emp_diploma' => $this->faker->boolean ? 1 : 0,
            'emp_tor' => $this->faker->boolean ? 1 : 0,
            'emp_cert_of_trainings_seminars' => $this->faker->boolean ? 1 : 0,
            'emp_auth_copy_of_csc_or_prc' => $this->faker->boolean ? 1 : 0,
            'emp_auth_copy_of_prc_board_rating' => $this->faker->boolean ? 1 : 0,
            'emp_med_certif' => $this->faker->boolean ? 1 : 0,
            'emp_nbi_clearance' => $this->faker->boolean ? 1 : 0,
            'emp_psa_birth_certif' => $this->faker->boolean ? 1 : 0,
            'emp_psa_marriage_certif' => $this->faker->boolean ? 1 : 0,
            'emp_service_record_from_other_govt_agency' => $this->faker->boolean ? 1 : 0,
            'emp_approved_clearance_prev_employer' => $this->faker->boolean ? 1 : 0,
            'other_documents' => $this->faker->boolean ? 1 : 0,
        ];
    }
}
