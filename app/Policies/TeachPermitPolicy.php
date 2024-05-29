<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Employee;
use App\Models\Teachpermit;
use Illuminate\Auth\Access\Response;

class TeachPermitPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Teachpermit $teachpermit, $type = Null): bool
    {
        if($type == "Approved"){
            $loggedInUser = Employee::select('department_id', 'dean_id', 'is_department_head_or_dean')
                ->where('employee_id', $user->employee_id)
                ->first();
            $head = explode(',', $loggedInUser->is_department_head_or_dean[0] ?? ' ');

            return $head[0] == 1 || $head[1] == 1 || $user->is_admin; 
       } else {
            return $user->employee_id == $teachpermit->employee_id || $user->is_admin == True;
       }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Teachpermit $teachpermit, $type = Null): bool
    {
        if($type == "Approve"){
            $loggedInEmployeeData = Employee::where('employee_id', $user->employee_id)->first();

            $dept_head_id = "Denied";
            foreach($loggedInEmployeeData->is_department_head as $index => $department_id){
                if($department_id == 1){
                    $dept_head_id = $index;
                }
            }
    
            $college_head_id = "Denied";
            foreach($loggedInEmployeeData->is_college_head as $index => $college_id){
                if($college_id == 1){
                    $college_head_id = $index;
                }
            }

            $ownerData = Employee::select('department_id', 'college_id' )
                    ->where('employee_id', $teachpermit->employee_id)
                    ->first();

            if($dept_head_id != "Denied" || $college_head_id != "Denied"){
                $departmentHeadId = $loggedInEmployeeData->department_id[$dept_head_id];
                if(in_array($departmentHeadId, $ownerData->department_id) || in_array($college_head_id, $ownerData->college_id)){       
                    return true;
                } else {
                    return false;
                } 
            }
            else {
                return false;
            }
           
        } else {
            return $user->employee_id == $teachpermit->employee_id || $user->is_admin == True;

        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Teachpermit $teachpermit): bool
    {
        return $user->employee_id == $teachpermit->employee_id || $user->is_admin == True;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Teachpermit $teachpermit): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Teachpermit $teachpermit): bool
    {
        //
    }
}
