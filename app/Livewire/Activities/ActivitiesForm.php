<?php

namespace App\Livewire\Activities;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Activities;
use Database\Seeders\ActivitiesSeeder;
use Livewire\WithFileUploads;

class ActivitiesForm extends Component
{
    use WithFileUploads;

    public $type;
    public $title;
    public $description;
    public $poster;
    public $date;
    public $start;
    public $end;
    public $host;
    public $is_featured;
    public $visible_to_list;

    protected $rules = [
        'type' => 'required|in:Announcement,Event,Seminar,Training,Others',
        'title' => 'required|min:2|max:150',
        'poster' => 'required|mimes:jpg,png|extensions:jpg,png',
        'description' => 'required|min:2|max:1024',
        'start' => 'required|before_or_equal:end',
        'end' => 'required|after_or_equal:start',
        'is_featured' => 'required|boolean',
        'host' => 'required|in:College of Information System and Technology Management,College of Engineering,College of Business Administration,College of Liberal Arts,College of Sciences,College of Education,Finance Department,Human Resources Department,Information Technology Department,Legal Department',
        'visible_to_list' => 'required|array|min:1',
        'visible_to_list.*' => 'required|in:College of Information System and Technology Management,College of Engineering,College of Business Administration,College of Liberal Arts,College of Sciences,College of Education,Finance Department,Human Resources Department,Information Technology Department,Legal Department'
        
    ];

    private function generateRefNumber(){
        // Generate a random number
         $characters = '0123456789';
         $randomNumber = '';
         for ($i = 0; $i < rand(5, 6); $i++) {
             $randomNumber .= $characters[rand(0, strlen($characters) - 1)];
         }
 
         // Get the current year
         $currentYear = date('Y');
 
         // Concatenate the date and random number
         $result = $currentYear . $randomNumber;
 
         return $result;
     }



    public function submit(){
       
        foreach($this->rules as $rule => $validationRule){
            $this->validate([$rule => $validationRule]);
            $this->resetValidation();
        }   

        $dateToday = Carbon::now()->toDateString();;
        $this->validate(['date' => 'required|after_or_equal:'.$dateToday]);

        $randomNumber = 0;
        while(True) {
            $randomNumber = $this->generateRefNumber();
            $existingRecord = Activities::where('activity_id', $randomNumber)->first();
            if(!$existingRecord){
                break;
            }
         
        }

        $activitydata = new Activities();

        $activitydata->type = $this->type;
        $activitydata->activity_id = $randomNumber;
        $activitydata->title = $this->title;
        $activitydata->description = $this->description;
        // if($this->type == "Announcement"){
        //     $activitydata->poster = $this->poster->store('photos/activities/announcement', 'public');
        // }
        // else if($this->type == "Event"){
        //     $activitydata->poster = $this->poster->store('photos/activities/event', 'public');
        // }
        // else if($this->type == "Seminar"){
        //     $activitydata->poster = $this->poster->store('photos/activities/seminar', 'public');
        // }
        // else if($this->type == "Training"){
        //     $activitydata->poster = $this->poster->store('photos/activities/training', 'public');
        // }
        // else if($this->type == "Others"){
        //     $activitydata->poster = $this->poster->store('photos/activities/others', 'public');
        // }
        $imageData = file_get_contents($this->poster->getRealPath());
        $activitydata->poster = $imageData;
        $activitydata->date = $this->date;
        $activitydata->start = $this->start;
        $activitydata->end = $this->end;
        $activitydata->host = $this->host;
        $activitydata->is_featured = $this->is_featured;
        $activitydata->visible_to_list = $this->visible_to_list;

        $this->js("alert('Activity Created!')"); 
        $activitydata->save();
        return redirect()->to(route('ActivitiesGallery'));
    }

  
    public function render()
    {
        return view('livewire.activities.activities-form')->extends('components.layouts.app');
    }
}
