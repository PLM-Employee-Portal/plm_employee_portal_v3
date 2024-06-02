<?php

namespace App\Livewire\Trainings;

use Livewire\Component;
use App\Models\Training;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TrainingUpdate extends Component
{
    use WithFileUploads;
    
    public $preTest = [];
    public $postTest = [];
    public $training_title;
    public $training_information;
    public $training_photo;
    public $pre_test_title;
    public $post_test_title;
    public $pre_test_description;
    public $post_test_description;
    public $pre_test_questions;
    public $post_test_questions;
    public $pre_test_rating;
    public $post_test_rating;
    public $host;
    public $is_featured;
    public $visible_to_list;

    public $index;

    public $start_date;
    public $end_date;

    public $location;

    public $dateToday;

    
    public $colleges;

    public $departments;


    public function mount($index){
        $this->index = $index;
        $trainingdata = Training::findOrFail($index);
        $this->training_title = $trainingdata->training_title;
        $this->training_information = $trainingdata->training_information;
        $this->training_photo = $trainingdata->training_photo ? " " : null;
        $this->start_date = $trainingdata->start_date;
        $this->end_date = $trainingdata->end_date;
        $this->location = $trainingdata->location;

        $this->colleges = DB::table('colleges')->orderBy('college_name', 'asc')->pluck('college_name');
        $this->departments = DB::table('departments')->orderBy('department_name', 'asc')->pluck('department_name');

        // $this->pre_test_title = $trainingdata->pre_test_title;
        // $this->post_test_title = $trainingdata->post_test_title;
        // $this->pre_test_description = $trainingdata->pre_test_description;
        // $this->post_test_description = $trainingdata->post_test_description;
        $this->host = $trainingdata->host;
        $this->is_featured = ( $trainingdata->is_featured == 1) ? true : false;
        $this->visible_to_list = $trainingdata->visible_to_list;
        // $this->preTest = json_decode($trainingdata->pre_test_questions, true);
        // $this->postTest = json_decode($trainingdata->post_test_questions, true);


        // $this->preTest = [
        //     ['question' => '', 'answer' => '']
        // ];
        // $this->postTest = [
        //     ['question' => '', 'answer' => '']
        // ];
    }

    // public function addPreTestQuestion(){
    //     $this->preTest[] = ['question' => '', 'answer' => ''];
    //     ;
    // }

    // public function addPostTestQuestion(){
    //         $this->postTest[] = ['question' => '', 'answer' => ''];
    // }

    // public function removePreTestQuestion($index){
    //     unset($this->preTest[$index]);
    //     // $this->preTest = array_values($this->preTest);
    // }

    // public function removePostTestQuestion($index){
    //     unset($this->postTest[$index]);
    //     // $this->postTest = array_values($this->postTest);
    // }

    public function getTrainingPhoto(){
        $trainingdata = Training::findOrFail($this->index);
        return $trainingdata->training_photo;
    }

    protected $rules = [
        'training_title' => 'required|max:150',
        'training_information' => 'required|max:1024',
        // 'pre_test_title' => 'required|max:150',
        // 'post_test_title' => 'required|max:150',
        // 'preTest' => 'required|array|min:1|max:100',
        // 'preTest.*.question'  => 'required|required_with:preTest.*.answer|min:5|max:1024',
        // 'preTest.*.answer'  => 'required|required_with:preTest.*.question|min:5|max:1024',
        // 'postTest' => 'required|array|min:1|max:100',
        // 'postTest.*.question'  => 'required|required_with:postTest.*.answer|min:5|max:1024',
        // 'postTest.*.answer'  => 'required|required_with:postTest.*.question|min:5|max:1024',
        // 'pre_test_description' => 'required|max:1024',
        // 'post_test_description' => 'required|max:1024',
        'start_date' => 'required|before:end_date|after_or_equal:dateToday',
        'end_date' => 'required|after:start_date|after:dateToday',
        'location' => 'required|min:5|max:500',
        'is_featured' => 'required|boolean',
        'visible_to_list' => 'required|array',
        'visible_to_list.*' => 'required',
    ];

    // protected $validationAttributes = [
    //     'preTest.*.question' => 'Pre-Test Question',
    //     'preTest.*.answer' => 'Pre-Test Answer',
    //     'postTest.*.question' => 'Post-Test Question',
    //     'postest.*.answer' => 'Post-Test Answer',
    // ];

    public function removeImage($item){
        $this->$item = null;
    }

    public function submit(){
        // if($this->host){
        //     $this->host = "College of Information System and Technology Management";
        // }
        $this->validate();

        $trainingdata = Training::findOrFail($this->index);

        $trainingdata->training_title = $this->training_title;
        $trainingdata->training_information = $this->training_information;
        $trainingdata->host = $this->host;
        $trainingdata->is_featured = $this->is_featured;
        $trainingdata->visible_to_list = $this->visible_to_list;

        if(is_string($this->training_photo) ){

        } else{
            $this->validate(['training_photo' => 'required|mimes:jpg,png|extensions:jpg,png']);
            $trainingdata->training_photo = file_get_contents($this->training_photo->getRealPath());
        }

        $updateData = [
            'training_title' => $trainingdata->training_title,
            'training_information' => $trainingdata->training_information,
            'host' => $trainingdata->host,
            'training_photo' => $trainingdata->training_photo,
            'is_featured' =>  $trainingdata->is_featured ,
            'visible_to_list' => $trainingdata->visible_to_list ,
            'start_date' => $this->start_date ?? $trainingdata->start_date,
            'end_date' =>  $this->end_date ?? $trainingdata->end_date, 
            'location' => $this->location ?? $trainingdata->location,
            'updated_at' => now(),
          ];
        
        Training::where('training_id', $this->index)
                               ->update($updateData);

         // $trainingdata->pre_test_title = $this->pre_test_title;
        // $trainingdata->post_test_title = $this->post_test_title;
        // $trainingdata->pre_test_description = $this->pre_test_description;
        // $trainingdata->post_test_description = $this->post_test_description;
        
        // foreach($this->preTest as $data){
        //     $jsonPreTestData[] = [
        //         'question' => $data['question'],
        //         'answer' => $data['answer'],
        //     ];
        // }

        // foreach($this->postTest as $data){
        //     $jsonPostTestData[] = [
        //         'question' => $data['question'],
        //         'answer' => $data['answer'],
        //     ];
        // }

        // $jsonPreTestData = json_encode($jsonPreTestData);
        // $jsonPostTestData = json_encode($jsonPostTestData);


        // $trainingdata->pre_test_questions = $jsonPreTestData;
        // $trainingdata->post_test_questions = $jsonPostTestData;

        // if(is_string($this->training_photo) == False){
        //     $this->validate(['training_photo' => 'required|mimes:jpg,png|extensions:jpg,png']);
        //     $trainingdata->training_photo = $this->training_photo->store('photos/trainings/training_photos', 'public');
        // }

        // $trainingdata->save();

        $this->js("alert('Training Updated!')"); 


        return redirect()->to(route('TrainingGallery'));
    }

    public function render()
    {
        return view('livewire.trainings.training-update')->extends('components.layouts.app');
    }
}
