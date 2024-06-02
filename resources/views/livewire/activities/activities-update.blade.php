<div>
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 rtl:space-x-reverse">
        <li class="inline-flex items-center">
            <a href="{{route('dashboard')}}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
            <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
            </svg>
            Home
            </a>
        </li>
        <li>
            <div class="flex items-center">
            <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
            </svg>
            <a href="{{route('ActivitiesGallery')}}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Activity</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
            <svg class="w-3 h-3 text-gray-600 mx-1 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
            </svg>
            <span class="ms-1 text-sm font-semibold text-gray-900 md:ms-2 dark:text-gray-400">Update</span>
            </div>
        </li>
        </ol>
    </nav> 
    <h2 class="mb-4 text-3xl  font-bold leading-none tracking-tight text-gray-900 md:text-3xl dark:text-white">Update an Activity</h2>
   
    <section class="bg-white  dark:bg-gray-900 pb-24 px-8  rounded-lg">
        <form wire:submit.prevent="submit" method="POST">
            @csrf
        <div class=" px-1 mx-auto pt-8">
            <h2><b>Activity Form</b></h2>
            <div class="grid grid-cols-1 gap-4  p-6 mt-5 bg-white border border-gray-200 rounded-lg shadow  dark:bg-gray-800 dark:border-gray-700">
                {{-- <div>
                <h2><b>Activity Details</b></h2>
                </div> --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type<span class="text-red-600">*</span></label>
                        <select  size="1" id="type" name="type" wire:model.blur="type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="Announcement">Announcement</option>
                            <option value="Event">Event</option>
                            <option value="Seminar">Seminar</option>
                            <option value="Training">Training</option>
                            <option value="Others">Others</option>
                        </select>
                        @error('type')
                            <div class="transition transform alert alert-danger"
                                    x-init="$el.closest('form').scrollIntoView()">
                                <span class="text-red-500 text-xs xl:whitespace-nowrap">{{$message }}</span>
                            </div> 
                        @enderror
                    </div>
                    <div>
                        <label for="title" class="block mb-2 text-sm whitespace-nowrap font-medium text-gray-900 dark:text-white">Title<span class="text-red-600">*</span></label>
                        <input type="text"  id="title" name="title" wire:model.blur="title" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></input>
                        @error('title')
                            <div class="transition transform alert alert-danger"
                                    x-init="$el.closest('form').scrollIntoView()">
                                <span class="text-red-500 text-xs xl:whitespace-nowrap">{{$message }}</span>
                            </div> 
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Poster and Details --}}
            <div class="grid grid-cols-1  p-4 gap-4 bg-white border border-gray-200 rounded-lg shadow  dark:bg-gray-800 dark:border-gray-700 ">
                <label for="poster"
                class="block text-base font-medium text-gray-900 dark:text-white">Poster <span class="text-red-600">*</span></label>
                <div class="grid grid-cols-1 items-center justify-center w-full">
                    <label for="poster" class="relative p-1 flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    @if($poster)
                            @if(is_string($poster) == True)
                                @php
                                    $poster = $this->getPoster();
                                @endphp
                                <img src="data:image/gif;base64,{{ base64_encode($poster) }}" alt="Image Description" class="w-full h-full object-contain"> 
                            @else
                                <img src="{{ $poster->temporaryUrl() }}" class="w-full h-full object-contain" alt="Uploaded Image">
                            @endif
                            <input id="poster" type="file" class="hidden" wire:model.live="poster">

                            <button type="button" wire:click="removeImage('poster')" class="absolute top-0 right-0 m-2 text-red-600 py-1  rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                    @else
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-4 h-4 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="mb-2 text-xs text-center text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                                <p class="text-xs text-center text-gray-500 dark:text-gray-400">PNG, JPG, or PDF file (Max: 5 MB size)</p>
                            </div>
                            <input id="poster" type="file" class="hidden" wire:model.blur="poster" />
                    @endif
                    </label>
                    @error('poster')
                        <div class="transition transform alert alert-danger"
                                x-init="$el.closest('label').scrollIntoView()">
                            <span class="text-red-500 text-xs xl:whitespace-nowrap">{{$message }}</span>
                        </div> 
                    @enderror
                </div>
               
            </div>
            
            {{-- Schedule --}}
            <div class="grid grid-cols-2 gap-4  p-6 mt-5 bg-white border border-gray-200 rounded-lg shadow  dark:bg-gray-800 dark:border-gray-700">
                <div class="grid min-[1000px]:grid-cols-3 gap-4  col-span-3  ">
                    <div class="w-full">
                        <label for="date"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date of Event<span class="text-red-600">*</span></label>
                        <input type="date" wire:model="date" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                             required >
                        @error('date')
                             <div class="transition transform alert alert-danger"
                                     x-init="$el.closest('label').scrollIntoView()">
                                 <span class="text-red-500 text-xs xl:whitespace-nowrap">{{$message }}</span>
                             </div> 
                         @enderror
                    </div>
                    <div class="w-full">
                        <label for="start"
                            class="block  mb-2 text-sm font-medium text-gray-900 dark:text-white ">Start Time <span class="text-red-600">*</span></label>
                        <input type="time" name="start" id="start" wire:model.blur="start" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                             required="" >
                        @error('start')
                            <div class="transition transform alert alert-danger"
                                    x-init="$el.closest('form').scrollIntoView()">
                                <span class="text-red-500 text-xs xl:whitespace-nowrap">{{$message }}</span>
                            </div> 
                        @enderror   
                    </div>
                    <div class="w-full">
                        <label for="end"
                            class="block  mb-2 text-sm font-medium text-gray-900 dark:text-white">End Time <span class="text-red-600">*</span></label>
                        <input type="time" name="end" id="end" wire:model.blur="end"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                           required="">
                        @error('end')   
                            <div class="transition transform alert alert-danger text-sm "
                            x-init="$el.closest('label').scrollIntoView()">
                            <span class="text-red-500 text-xs xl:whitespace-nowrap">{{ $message }}</span>
                            </div> 
                         @enderror
                    </div>
                </div>
            </div>

            {{-- Host and visible to list --}}
            <div class="grid grid-cols-2 gap-4  p-6 mt-5 bg-white border border-gray-200 rounded-lg shadow  dark:bg-gray-800 dark:border-gray-700">
                <div>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Host<span class="text-red-600">*</span></label>
                        <select id="host" name="host" wire:model.blur="host"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @foreach ($colleges as $college){
                                <option value="{{$college}}">{{$college}}</option>
                            }
                            @endforeach
                            @foreach ($departments as $department){
                                <option value="{{$department}}">{{$department}}</option>
                            }
                            @endforeach                  
                        </select>
                        @error('host')
                            <div class="transition transform alert alert-danger"
                                    x-init="$el.closest('form').scrollIntoView()">
                                <span class="text-red-500 text-xs xl:whitespace-nowrap">{{$message }}</span>
                            </div> 
                        @enderror
                    </div>
                    <div class="items-center">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="is_featured" class="sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Featured?</span>
                        </label>
                        @error('is_featured')
                            <div class="transition transform alert alert-danger"
                                    x-init="$el.closest('form').scrollIntoView()">
                                <span class="text-red-500 text-xs xl:whitespace-nowrap">{{$message }}</span>
                            </div> 
                        @enderror
                    </div>
                </div>
                <div >
                    <div class="col-span-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Visible To List<span class="text-red-600">*</span></label>
                        <select multiple id="visible_to_list" name="visible_to_list" wire:model.blur="visible_to_list"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @foreach ($colleges as $college){
                                <option value="{{$college}}">{{$college}}</option>
                            }
                            @endforeach
                            @foreach ($departments as $department){
                                <option value="{{$department}}">{{$department}}</option>
                            }
                            @endforeach                   
                        </select>
                        @error('visible_to_list')
                            <div class="transition transform alert alert-danger"
                                    x-init="$el.closest('form').scrollIntoView()">
                                <span class="text-red-500 text-xs xl:whitespace-nowrap">{{$message }}</span>
                            </div> 
                        @enderror
                    </div>
                   
                </div>
            </div>
        </div>
        <button type="submit"  class="inline-flex items-center float-right px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
            Update Activity
        </button>
        </form>
    </section>
    
    </div>
</div>