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
            <a href="{{route('CreditsMonetizationTable')}}" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Credits of Monetization</a>
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
    <h2 class="mb-4 text-3xl font-bold leading-none tracking-tight text-gray-900 md:text-3xl dark:text-white">Update Credits of Monetization Request</h2>
    <section class="bg-white dark:bg-gray-900 pb-24 px-8  rounded-lg">
        <div class=" px-1 mx-auto pt-8">
            <form wire:submit.prevent="submit" method="POST">
                @csrf
                <div class="grid gap-4 sm:grid-cols-3 sm:gap-6">
                    <div class="block w-full col-span-3 p-6 bg-white border border-gray-200 rounded-lg shadow  dark:bg-gray-800 dark:border-gray-700 ">
                        <div class="grid gap-4 sm:grid-cols-3 sm:gap-6">
                            {{-- Application Date --}}
                            <div class="grid min-[1000px]:grid-cols-2  col-span-3 p-6 bg-white border border-gray-200 rounded-lg shadow  dark:bg-gray-800 dark:border-gray-700">
                                <div class="w-full">
                                    <label for="application_date"
                                        class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Date of Filling<span class="text-red-600">*</span></label>
                                    <input type="datetime-local" value="{{now()}}" 
                                        class="bg-gray-50 border w-auto  border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                         required disabled>
                                </div>
                            </div>

                            {{-- Information field --}}
                            <div class="grid grid-cols-1 w-full col-span-3 gap-4 min-[902px]:grid-cols-3 p-6 bg-white border border-gray-200 rounded-lg shadow  dark:bg-gray-800 dark:border-gray-700 ">
                                <h2><b>Information</b></h2>
                                    <div  class="col-span-3 p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                            <div class="grid grid-cols-1 min-[1000px]:grid-cols-3 gap-4 col-span-3 pb-4">
                                                <div class="w-full ">
                                                    <label for="firstname"
                                                        class="block mb-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">First name <span class="text-red-600">*</span></label>
                                                    <input type="text" name="firstname" id="firstname"  value="{{$first_name}}"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                        placeholder="First name" required="" disabled>
                                                </div>
                                                <div class="w-full ">
                                                    <label for="middlename"
                                                        class="block mb-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">Middle name <span class="text-red-600">*</span></label>
                                                    <input type="text" name="middlename" id="middlename" value="{{$middle_name}}"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                        placeholder="Middle name" required="" disabled>
                                                </div>
                                                <div class="w-full">
                                                    <label for="lastname"
                                                        class="block mb-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">Last name <span class="text-red-600">*</span></label>
                                                    <input type="text" name="lastname" id="lastname"  value="{{$last_name}}"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                        placeholder="Last name" required="" disabled>
                                                </div>
                                                <div class="w-full">
                                                    <label for="department_name"
                                                        class="block mb-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">Department Name <span class="text-red-600">*</span></label>
                                                    <input type="text" name="department_name" id="department_name"  value="{{$department_name}}"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                        disabled>
                                                </div>
                                                <div class="w-full">
                                                    <label for="current_position"
                                                        class="block mb-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">Current Position <span class="text-red-600">*</span></label>
                                                    <input type="text" name="current_position" id="current_position"  value="{{$current_position}}"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                        disabled>
                                                </div>
                                                <div class="w-full">
                                                    <label for="employee_type"
                                                        class="block mb-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">Employee Status <span class="text-red-600">*</span></label>
                                                    <input type="text" name="employee_type" id="employee_type"  value="{{$employee_type}}"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                        disabled>
                                                </div>
                                            </div>
                                            
                                    </div>
                            </div>

                            {{-- Employee    field --}}
                            <div class="grid grid-cols-1 w-full col-span-3 gap-4 min-[902px]:grid-cols-3 p-6 bg-white border border-gray-200 rounded-lg shadow  dark:bg-gray-800 dark:border-gray-700 ">
                                    <div  class="col-span-3">

                                            {{-- <div class="grid grid-cols-1 min-[1000px]:grid-cols-3 gap-4 col-span-3 pb-4"> --}}
                                            <div class="grid grid-cols-1 min-[902px]:grid-cols-3 gap-4">
                                              <div class="grid grid-cols-1 min-[902px]:grid-cols-2 col-span-2 gap-4 p-4 bg-white border border-gray-200 rounded-lg shadow  dark:bg-gray-800 dark:border-gray-700">
                                                
                                                <div class="grid grid-cols-1 p-6 gap-4 col-span-1 pb-4  bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                                    <h2><b>Leave Monetization Details</b></h2>
                                                    <div class="w-full ">
                                                        <label for="requested_vacation_credits"
                                                            class="block mb-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">Vacation Credits <span class="text-red-600">*</span></label>
                                                        <input type="number" name="requested_vacation_credits" id="requested_vacation_credits"  wire:model="requested_vacation_credits"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                            placeholder="{{$vacation_credits}}" required >
                                                    </div>
                                                    <div class="w-full ">
                                                        <label for="requested_sick_credits"
                                                            class="block mb-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">Sick Credits <span class="text-red-600">*</span></label>
                                                        <input type="number" name="requested_sick_credits" id="requested_sick_credits" wire:model="requested_sick_credits"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                            placeholder="{{$sick_credits}}" required >
                                                    </div>
                                                    <div class="w-full">
                                                        <label for="total_requested"
                                                            class="block mb-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">Total Requested<span class="text-red-600">*</span></label>
                                                        <input type="number" name="total_requested" id="total_requested"  wire:model="total_requested"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                            placeholder="{{$total_credits}}" required>
                                                    </div>
                                                </div>
                                                    <div class="grid grid-cols-1 p-6 gap-4 col-span-1 pb-4  bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                                        <h2><b>Purpose</b></h2>
                                                        <div class="w-full items-start relative">
                                                            <label for="purpose"
                                                                class="block mb-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">Total Requested<span class="text-red-600">*</span></label>
                                                            <textarea type="text" rows="10" name="purpose" id="purpose"  wire:model="purpose"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                                placeholder="Type your purpose here" required> </textarea>
                                                        </div>
                                                    </div>
                                              </div>
                                              <div class="grid grid-cols-1 gap-4 p-4 bg-white border border-gray-200 rounded-lg shadow  dark:bg-gray-800 dark:border-gray-700">
                                                <div id="applicant_signature_container" class="grid grid-cols-1  p-4  bg-white border border-gray-200 rounded-lg shadow  dark:bg-gray-800 dark:border-gray-700 ">
                                                    <h2 for="applicant_signature"
                                                    class="block text-base mb-2 font-semibold text-gray-900 dark:text-white">Applicant Signature <span class="text-red-600">*</span></h2>
                                                    <div class="grid grid-cols-1 items-center justify-center w-full">
                                                    <label for="applicant_signature" class="relative flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                                        @if($applicant_signature)
                                                        @if(is_string($applicant_signature) == True)
                                                            @php
                                                                $applicant_signature = $this->getApplicantSignature();
                                                            @endphp
                                                            <img src="data:image/gif;base64,{{ $applicant_signature }}" alt="Image Description" class="w-full h-full object-contain"> 
                                                        @else
                                                            <img src="{{ $applicant_signature->temporaryUrl() }}" class="w-full h-full object-contain" alt="Uploaded Image">
                                                        @endif
                                                        <input id="applicant_signature" type="file" class="hidden" wire:model.live="applicant_signature">
                    
                                                        <button type="button" wire:click="removeImage('applicant_signature')" class="absolute top-0 right-0 m-2 text-red-600 py-1  rounded">
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
                                                            <input id="applicant_signature" type="file" class="hidden" wire:model.blur="applicant_signature" />
                                                        @endif
                                                </label>
                                                @error('applicant_signature')
                                                    <div class="transition transform alert alert-danger text-sm mb-1"
                                                        x-data x-init="document.getElementById('applicant_signature_container').scrollIntoView({ behavior: 'smooth', block: 'center' }); document.getElementById('applicant_signature_container').focus();">
                                                        <span   span class="text-red-500 text-xs "> {{$message}}</span>
                                                    </div> 
                                                @enderror
                                                    </div>
                                                </div>
                                            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow  dark:bg-gray-800 dark:border-gray-700">
                                                <label for="applicant_signature_date"
                                                    class="block mb-2 text-sm font-bold text-gray-900 dark:text-white">Signed Date<span class="text-red-600">*</span></label>
                                                <input type="datetime-local" wire:model="applicant_signature_date"
                                                    class="bg-gray-50 border w-full   border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block  p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                     required >
                                            </div>
                                            </div>
                                                
                                            </div> 
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit"  class="inline-flex items-center float-right px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                    Update Request
            </button>
            </form>
        </div>
    </section>
    </div>
</div>