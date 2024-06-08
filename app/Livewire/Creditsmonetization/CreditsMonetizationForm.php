<?php

namespace App\Livewire\Creditsmonetization;

use Livewire\Component;

class CreditsMonetizationForm extends Component
{
    public $first_name;
    public $middle_name;
    public $last_name;
    public $department_name;
    public $employee_type;
    public $current_position;
    public $salary;

    public function render()
    {
        return view('livewire.creditsmonetization.credits-monetization-form');
    }
}
