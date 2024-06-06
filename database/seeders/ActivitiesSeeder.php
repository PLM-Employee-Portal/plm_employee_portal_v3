<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Training;
use App\Models\Activities;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imageContent = file_get_contents(public_path('storage\photos\demofiles\Events\another welcome.jpg'));
        $destinationPath1 = base64_encode($imageContent);
        // Storage::disk('public')->put($destinationPath1, $imageContent);

        $imageContent = file_get_contents(public_path('storage\photos\demofiles\Events\CISTM.jpg'));
        $destinationPath2 =  base64_encode($imageContent);

        $imageContent = file_get_contents(public_path('storage\photos\demofiles\Events\inaguaration mass.jpg'));
        $destinationPath3 =  base64_encode($imageContent);

        $imageContent = file_get_contents(public_path('storage\photos\demofiles\Events\warm welcome.jpg'));
        $destinationPath4 =  base64_encode($imageContent);

        $imageContent = file_get_contents(public_path('storage\photos\demofiles\Events\Mam vhie.jpg'));
        $destinationPath5 =  base64_encode($imageContent);
        
        Activities::create([
            'activity_id' => rand(231839, 32839),
            'type' => 'Event',
            'title' => 'Lorem Ipsum',
            'poster' => $destinationPath1,
            'description' => 'Ex consectetur sunt',
            'date' => Carbon::createFromDate(2022, 4, 9),
            'start' => Carbon::createFromTime(2, 1, 0),
            'end' => Carbon::createFromTime(2, 1, 0),
            'is_featured' => 1,
            'host' => 'College of Engineering',
            'visible_to_list' => ["College of Engineering", "College of Sciences", "Legal Department"]
        ]);   

        Activities::create([
            'activity_id' => rand(231839, 32839),
            'type' => 'Event',
            'title' => 'Lorem Ipsum',
            'poster' => $destinationPath2,
            'description' => 'Ex consectetur sunt',
            'date' => Carbon::createFromDate(2022, 4, 9),
            'start' => Carbon::createFromTime(2, 1, 0),
            'end' => Carbon::createFromTime(2, 1, 0),
            'is_featured' => 1,
            'host' => 'College of Engineering',
            'visible_to_list' => ["College of Engineering", "College of Sciences", "Legal Department"]
        ]);   

        Activities::create([
            'activity_id' => rand(231839, 32839),
            'type' => 'Event',
            'title' => 'Lorem Ipsum',
            'poster' => $destinationPath3,
            'description' => 'Ex consectetur sunt',
            'date' => Carbon::createFromDate(2022, 4, 9),
            'start' => Carbon::createFromTime(2, 1, 0),
            'end' => Carbon::createFromTime(2, 1, 0),
            'is_featured' => 1,
            'host' => 'College of Engineering',
            'visible_to_list' => ["College of Engineering", "College of Sciences", "Legal Department"]
        ]);   

        Activities::create([
            'activity_id' => rand(231839, 32839),
            'type' => 'Event',
            'title' => 'Lorem Ipsum',
            'poster' => $destinationPath4,
            'description' => 'Ex consectetur sunt',
            'date' => Carbon::createFromDate(2022, 4, 9),
            'start' => Carbon::createFromTime(2, 1, 0),
            'end' => Carbon::createFromTime(2, 1, 0),
            'is_featured' => 1,
            'host' => 'College of Engineering',
            'visible_to_list' => ["College of Engineering", "College of Sciences", "Legal Department"]
        ]);   

        Activities::create([
            'activity_id' => rand(231839, 32839),
            'type' => 'Event',
            'title' => 'Lorem Ipsum',
            'poster' => $destinationPath5,
            'description' => 'Ex consectetur sunt',
            'date' => Carbon::createFromDate(2022, 4, 9),
            'start' => Carbon::createFromTime(2, 1, 0),
            'end' => Carbon::createFromTime(2, 1, 0),
            'is_featured' => 1,
            'host' => 'College of Engineering',
            'visible_to_list' => ["College of Engineering", "College of Sciences", "Legal Department"]
        ]);   

        $imageContent = file_get_contents(public_path('storage\photos\demofiles\Training picture\coding.webp'));
        $destinationPath6 =  base64_encode($imageContent);
        // Storage::disk('public')->put($destinationPath6, $imageContent);
        
        $imageContent = file_get_contents(public_path('storage\photos\demofiles\Training picture\trainingpic.png'));
        $destinationPath7 =  base64_encode($imageContent);
        // Storage::disk('public')->put($destinationPath7, $imageContent);

        Training::create([
            'training_id' => rand(231839, 32839),
            'training_title' => 'Event',
            'start_date' => Carbon::create(2022, 4, 9, 10, 30, 0),
            'end_date' => Carbon::create(2022, 19, 2, 10, 30, 0),
            'location' => 'lorem ipsum',
            'training_information' => 'Lorem Ipsum',
            'training_photo' => $destinationPath6,
            'is_featured' => 1,
            'host' => 'College of Engineering',
            'visible_to_list' => ["College of Engineering", "College of Sciences", "Legal Department"]
        ]);   

        Training::create([
            'training_id' => rand(231839, 32839),
            'start_date' => Carbon::create(2022, 4, 9, 10, 30, 0),
            'end_date' => Carbon::create(2022, 19, 2, 10, 30, 0),
            'location' => 'lorem ipsum',
            'training_title' => 'Event',
            'training_information' => 'Lorem Ipsum',
            'training_photo' => $destinationPath7,
            'is_featured' => 1,
            'host' => 'College of Engineering',
            'visible_to_list' => ["College of Engineering", "College of Sciences", "Legal Department"]
        ]);   
    }
}
