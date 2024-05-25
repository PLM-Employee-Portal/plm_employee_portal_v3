<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Employee;
use App\Models\Documentrequest;
use Illuminate\Auth\Access\Response;
use PhpParser\Node\Expr\Cast\String_;

class DocumentRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // return 
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Documentrequest $documentrequest): bool
    {
        return $user->employee_id == $documentrequest->employee_id || $user->is_admin == True;
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
    public function update(User $user, Documentrequest $documentrequest, $type = Null): bool
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
                    ->where('employee_id', $documentrequest->employee_id)
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
            return $user->employee_id == $documentrequest->employee_id || $user->is_admin == True;

        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Documentrequest $documentrequest): bool
    {
        return $user->employee_id == $documentrequest->employee_id || $user->is_admin == True;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Documentrequest $documentrequest): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Documentrequest $documentrequest): bool
    {
        //
    }
}
