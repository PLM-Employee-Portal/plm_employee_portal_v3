<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Roles;
use App\Models\Employee;
use Illuminate\Http\File;
use App\Models\Dailytimerecord;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 

        $employee = new Employee();
        $employee->employee_id = '202132321';
        $employee->employee_type = 'Casual';
        // $employee->department_name = 'College of Engineering';
        // $employee->employee_role = 2;
        $employee->job_id = 1;
        $employee->cto = 2;

        $employee->department_id = [1, 2, 3, 4];
        $employee->college_id = [1, 2, 3];
        $employee->is_department_head = [0];
        $employee->is_college_head = [0];
        $employee->first_name = 'Juan';
        $employee->middle_name = 'Dela';
        $employee->last_name = 'Cruz';
        $employee->age = 25;
        $employee->gender = 'Male';
        $employee->personal_email = 'juandelacruz@gmail';
        $employee->phone = '09323123232';
        $employee->birth_date = '2023-12-06';
        $employee->address = 'Sampaloc, Manila';
        $employee->current_position = 'Part-time';
        $employee->salary = 510;
        $employee->start_of_employment = Carbon::createFromDate(2022, 4, 9);
        $employee->end_of_employment = Carbon::createFromDate(2024, 4, 9);
        $employee->is_faculty = true;
        $employee->study_available_units = 20;
        $employee->teach_available_units = 10;
        $employee->vacation_credits = 20;
        $employee->sick_credits = 20;
        $employee->school_email = 'comsci@plm.edu.ph'; 
        $employee->active = 1;

        $employeeHistory = [
            [
            'name_of_company' => 'Accenture',
            'prev_position' => 'Software Engineer',
            'start_date' =>  "2024-03-02",
            'end_date' =>  "2024-03-02",
            ],
            ];
        foreach($employeeHistory as $load){
            $jsonEmployeeHistory[] = [
                'name_of_company' => $load['name_of_company'],
                'prev_position' => $load['prev_position'],
                'start_date' => $load['start_date'],
                'end_date' => $load['end_date'],
            ];
        }

        $employee->employee_history = json_encode($jsonEmployeeHistory);

        // $employee->employee_history = "[{\"end_date\": \"2024-03-02\", \"start_date\": \"2024-03-02\", \"prev_position\": \"Software Engineer\", \"name_of_company\": "Accenture"}, {"end_date": "2023-03-02", "start_date": "2022-03-02", "prev_position": "Junior Developer", "name_of_company": "IBM"}, {"end_date": "2022-03-02", "start_date": "2021-02-07", "prev_position": "Intern Developer", "name_of_company": "EasyPC"}]';
        
        // Emp Image
        $imageContent = file_get_contents(public_path('storage/photos/demofiles/Picture.webp'));
        $destinationPath = 'photos/avatar/Picture.webp';
        Storage::disk('public')->put($destinationPath, $imageContent);
        $employee->emp_image = $destinationPath;

       // Emp Image 
    //    $path = Storage::putFile('photos/avatar', new File('public\storage\photos\demofiles\Picture.webp'), 'public');
    //    $employee->emp_image = $path;

       // Diploma
       // $path = Storage::putFile('photos/diploma', new File('public\storage\photos\demofiles\diploma.png'), 'private');
       $path = file_get_contents(public_path('storage\photos\demofiles\diploma.png'));
       
      //  $employee_diploma[] = base64_encode($path);   
      //  $path = file_get_contents(public_path('storage\photos\demofiles\Training picture\coding.webp'));
      //  $employee_diploma[] = base64_encode($path);   
      //  $employee->emp_diploma = json_encode($employee_diploma, true);
       $employee->emp_diploma = 1;
      // $path = Storage::putFile('photos/diploma', new File('public\storage\photos\demofiles\Training picture\coding.webp'), 'private');


       // Tor
      //  $path = file_get_contents(public_path('storage\photos\demofiles\tor.jfif'));
      // //  $path = Storage::putFile('photos/tor', new File('public\storage\photos\demofiles\tor.jfif'), 'private');
      //  $emp_tor[] = base64_encode($path);     
      //  $employee->emp_tor = json_encode($emp_tor, true);
       $employee->emp_tor = 1;



       // Certificate
    //    $path = Storage::putFile('photos/cert_of_trainings_seminars', new File(''), 'private');
      //  $path = file_get_contents(public_path('storage\photos\demofiles\certif.jpg'));

      //  $emp_cert_of_trainings_seminars[] = base64_encode($path);   
      //  $employee->emp_cert_of_trainings_seminars =  json_encode($emp_cert_of_trainings_seminars, true);
       $employee->emp_cert_of_trainings_seminars =  1;

       // PRC License
    //    $path = Storage::putFile('photos/auth_copy_of_csc_or_prc', new File('public\storage\photos\demofiles\prc license.jfif'), 'private');
      //  $path = file_get_contents(public_path('storage\photos\demofiles\prc license.jfif'));

      //  $emp_auth_copy_of_csc_or_prc[] = base64_encode($path);   
      //  $employee->emp_auth_copy_of_csc_or_prc = json_encode($emp_auth_copy_of_csc_or_prc, true);
       $employee->emp_auth_copy_of_csc_or_prc = 1;

       
       // PRC Board Rating
    //    $path = Storage::putFile('photos/auth_copy_of_prc_board_rating', new File('public\storage\photos\demofiles\prc board rating.JPG'), 'private');\
      //  $path = file_get_contents(public_path('storage\photos\demofiles\prc board rating.JPG'));
      //  $emp_auth_copy_of_prc_board_rating[] = base64_encode($path);   
       $employee->emp_auth_copy_of_prc_board_rating = 1;

       // Medical Certificate
    //    $path = Storage::putFile('photos/med_certif', new File('public\storage\photos\demofiles\Medical Certificate.jpg'), 'private');
      //  $path = file_get_contents(public_path('storage\photos\demofiles\Medical Certificate.jpg'));

      //  $emp_med_certif[] = base64_encode($path);   
      //  $employee->emp_med_certif = json_encode($emp_med_certif, true);
       $employee->emp_med_certif = 1;


       // NBI Clearance
    //    $path = Storage::putFile('photos/nbi_clearance', new File('public\storage\photos\demofiles\NBI Clearance.png'), 'private');
      //  $path = file_get_contents(public_path('storage\photos\demofiles\NBI Clearance.png'));

      //  $emp_nbi_clearance[] = base64_encode($path);   
      //  $employee->emp_nbi_clearance = json_encode($emp_nbi_clearance, true);
       $employee->emp_nbi_clearance = 1;


       // PSA
    //    $path = Storage::putFile('photos/psa', new File('public\storage\photos\demofiles\psa.png'), 'private');
      //  $path = file_get_contents(public_path('storage\photos\demofiles\psa.png'));

      //  $emp_psa_birth_certif[] = base64_encode($path);   
      //  $employee->emp_psa_birth_certif = json_encode($emp_psa_birth_certif, true);
       $employee->emp_psa_birth_certif = 1;


       // PSA Marriage
    //    $path = Storage::putFile('photos/psa_marriage', new File('public\storage\photos\demofiles\psa marriage.jpg'), 'private');
      //  $path = file_get_contents(public_path('storage\photos\demofiles\psa marriage.jpg'));

      //  $emp_psa_marriage_certif[] = base64_encode($path);   
      //  $employee->emp_psa_marriage_certif = json_encode($emp_psa_marriage_certif, true);
       $employee->emp_psa_marriage_certif = 1;

       // Service Record
    //    $path = Storage::putFile('photos/service_record', new File('public\storage\photos\demofiles\service record.png'), 'private');
      //  $path = file_get_contents(public_path('storage\photos\demofiles\service record.png'));

      //  $emp_service_record_from_other_govt_agency[] = base64_encode($path);   
       $employee->emp_service_record_from_other_govt_agency = 1;

       // Approved Clearance
    //    $path = Storage::putFile('photos/approved_clearance', new File('public\storage\photos\demofiles\Approved Clearance.jpg'), 'private');
      //  $path = file_get_contents(public_path('storage\photos\demofiles\Approved Clearance.jpg'));

      //  $emp_approved_clearance_prev_employer[] = base64_encode($path);   
      //  $employee->emp_approved_clearance_prev_employer = json_encode($emp_approved_clearance_prev_employer, true);
       $employee->emp_approved_clearance_prev_employer = 1;


        $employee->save();


        // $employee = new Employee();
        // $employee->employee_id = '202151232';
        // $employee->employee_type = 'Casual';
        // $employee->department_name = 'College of Engineering';
        // $employee->employee_role = 2;
        // $employee->department_id = ['1,3'];
        // $employee->dean_id = ['0,1'];
        // $employee->first_name = 'Juan';
        // $employee->middle_name = 'Dela';
        // $employee->last_name = 'Cruz';
        // $employee->age = 25;
        // $employee->gender = 'Male';
        // $employee->personal_email = 'juandelacruz@gmail\.com';
        // $employee->phone = '09323123232';
        // $employee->birth_date = '2023-12-06';
        // $employee->address = 'Sampaloc, Manila';
        // $employee->current_position = 'Part-time';
        // $employee->salary = 510;
        // $employee->start_of_employment = Carbon::createFromDate(2022, 4, 9);
        // $employee->end_of_employment = Carbon::createFromDate(2024, 4, 9);
        // $employee->faculty_or_not = true;
        // $employee->faculty_or_not = true;
        // $employee->school_email = 'comsci@plm.edu.ph';
        // $employee->save();

        // $employee = new Employee();
        // $employee->employee_id = '202189212';
        // $employee->employee_type = 'Permanent';
        // $employee->department_name = 'College of Information System and Technology Management';
        // $employee->employee_role = 2;
        // $employee->department_id = ['0,1'];
        // $employee->dean_id = ['1,3'];
        // $employee->first_name = 'Department';
        // $employee->middle_name = 'Head';
        // $employee->last_name = '3';
        // $employee->age = 25;
        // $employee->gender = 'Male';
        // $employee->personal_email = 'juandelacruz@gmail\.com';
        // $employee->phone = '09323123232';
        // $employee->birth_date = '2023-12-06';
        // $employee->address = 'Sampaloc, Manila';
        // $employee->current_position = 'Part-time';
        // $employee->salary = 510;
        // $employee->start_of_employment = Carbon::createFromDate(2022, 4, 9);
        // $employee->end_of_employment = Carbon::createFromDate(2024, 4, 9);
        // $employee->faculty_or_not = true;
        // $employee->faculty_or_not = true;
        // $employee->school_email = 'comsci@plm.edu.ph';
        // $employee->save();

        
      

        $employee = new Employee();
        $employee->employee_id = '200000001';
        $employee->employee_type = 'Casual';
        // $employee->department_name = 'College of Information System and Technology Management';
        // $employee->employee_role = 1;
        $employee->job_id = 1;
        $employee->cto = 2;

        $employee->department_id = [1];
        $employee->college_id = [1];
        $employee->is_department_head = [1];
        $employee->is_college_head = [1];
        $employee->first_name = 'Admin';
        $employee->middle_name = 'Admin';
        $employee->last_name = 'Admin';
        $employee->age = 1;
        $employee->gender = 'Male';
        $employee->personal_email = 'admin@gmail.com';
        $employee->phone = '00000000000';
        $employee->birth_date = '2000-01-01';
        $employee->address = 'PLM';
        $employee->current_position = 'Permanent';
        $employee->salary = 0;
        $employee->study_available_units = 20;
        $employee->teach_available_units = 10;
        $employee->vacation_credits = 20;
        $employee->sick_credits = 20;
        $employee->start_of_employment = Carbon::createFromDate(2022, 4, 9);
        $employee->is_faculty = false;
        $employee->school_email = 'admin@plm.edu.ph';
        $employee->active = 1;

        $employee->save();

        // User::create([
        //     'name'     => 'Don',
        //     'email'    => 'donfelipe@plm.edu.ph',
        //     'password' => bcrypt('donfelipe'),
        //     'employee_id' => '202151232',
        // ]);

        User::create([
            'email'    => 'departmentHead@plm.edu.ph',
            'password' => bcrypt('depthead'),
            'employee_id' => '202189212',
            'role_id' => 1,
        ]);

        User::create([
            'email'    => 'employee@plm.edu.ph',
            'password' => bcrypt('secret'),
            'employee_id' => '202132321',
            'role_id' => 1,
        ]);

        User::create([
            'email'    => 'admin@plm.edu.ph',
            'password' => bcrypt('admin'),
            'employee_id' => '200000001',
            'role_id' => 0,
        ]);
    }
}
