<?php

namespace App\Exports;

use App\Models\PaymentHistory;
use App\Models\ProgramDetails;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use App\Models\User;
use App\Models\User_booking;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements  FromCollection, WithHeadings, WithMapping
{
    protected $sr;
    protected $users;
    protected $userChildren; 

    public function __construct($users)
    {
        $this->sr = 0;
        $this->users = $users;

        $this->userChildren = collect();

        foreach ($users as $user) {
            $children = $user->ChildrenInfo; // Eager load `children` relationship
            // dd($children);
            if ($children->isEmpty()) {
                $this->userChildren->push([
                    'user' => $user,
                    'child' => null
                ]);
            } else {
                foreach ($children as $child) {
                    $this->userChildren->push([
                        'user' => $user,
                        'child' => $child
                    ]);
                }
            }
        }
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return $this->users;
        // dd($this->userChildren);
        return $this->userChildren;
    }

    public function map($row): array
    {
        // dd($user);
        // $this->sr++;

        $user = $row['user'];
        $child = $row['child'];

        static $lastUserId = null;
        $showUserData = $lastUserId !== $user->id;
        if ($showUserData) {
            $this->sr++;
            $lastUserId = $user->id;
        }

        if($user->user_type == 1){  //1 = Parent , 2 = Athletes
            $userType = "Parent";
        }elseif($user->user_type == 2){
            $userType = "Athlete";
        }else{
            $userType = "N/A";

        }

        if($user->gender == 1){
            $gender = "Male";

        }elseif($user->gender == 2){
            $gender = "Female";

        }else{
            $gender = "N/A";
        }

        // if($user->is_parents == 1){
        //     $isParents = "Parent";

        // }elseif($user->is_parents == 2){
        //     $isParents = "Gaurdian";

        // }else{
        //     $isParents = "N/A";
        // }

        if($user->is_setup_profile == 1){
            $isSetupProfile = "Done";
        }else{
            $isSetupProfile = "Pending";
        }

        if($user->stage_verify == 0){
            $stageVerify = "Not stage verify";

        }elseif($user->stage_verify == 1){
            $stageVerify = "Stage 1 verify";

        }elseif($user->stage_verify == 2){
            $stageVerify = "Stage 1 verify";

        }else{
            $stageVerify = "N/A";
        }

        if($user->medical_clearance == 0){
            $medicalClearance = "Pass";

        }elseif($user->medical_clearance == 1){
            $medicalClearance = "Fail";

        }elseif($user->medical_clearance == 2){
            $medicalClearance = "Stage 2 pass";

        }else{
            $medicalClearance = "N/A";
        }
        

        
        if($user->device_type == 0){
            $device = "Web";
        }elseif($user->device_type == 1){
            $device = "iOS";
        }else{
            $device = "Android";
        }

         // Child info (if any)
         $childFirstName = $child->first_name ?? 'N/A';
         $childLastName = $child->last_name ?? 'N/A';
         $childName = $childFirstName .' '. $childLastName;
         $childDOB = isset($child->date_of_birth) ? fetchDateFormate($child->date_of_birth) : 'N/A';

         $childGender = '';
         $currentProgram = '';
         if($child){

            $childProgram = PaymentHistory::where(['user_id'=>$user->id,'child_id'=>$child->id])->latest()->first();
            $program = ProgramDetails::where('id',$childProgram->program_id)->first();
            // dd($childProgram);

            $currentProgram = $program->program_title;

             if($child->gender == 1){
                $childGender = "Boy";
    
            }elseif($user->is_parents == 2){
                $childGender = "Girl";
    
            }else{
                $childGender = "N/A";
            }
         }
 

        return [
            // $this->sr,
            // $userType,
            // $user->first_name ?? 'N/A',
            // $user->last_name ?? 'N/A',
            // $user->email,
            // $user->mobile_no,
            // fetchDateFormate($user->date_of_birth),
            // $isSetupProfile,
            // $isParents,
            // $gender,
            // $stageVerify,
            // $medicalClearance,
            // $user->address ?? 'N/A',
            // $device,
            // $user->app_version,
            // $user->os_version,
            // $user->device_name,

            // // Child fields
            // $childFirstName,
            // $childLastName,
            // // $childDOB,


            $showUserData ? $this->sr : '',
            $showUserData ? $userType : '',
            $showUserData ? ($user->first_name ?? 'N/A') : '',
            $showUserData ? ($user->last_name ?? 'N/A') : '',
            $showUserData ? $user->email : '',
            $showUserData ? $user->mobile_no : '',
            $showUserData ? fetchDateFormate($user->date_of_birth) : '',
            // $showUserData ? $isSetupProfile : '',
            // $showUserData ? $isParents : '',
            $showUserData ? $gender : '',
            $showUserData ? $stageVerify : '',
            $showUserData ? $medicalClearance : '',
            $showUserData ? ($user->address ?? 'N/A') : '',
            $childName,
            $childDOB,
            $childGender,
            $currentProgram,
            $showUserData ? $device : '',
            $showUserData ? $user->app_version : '',
            $showUserData ? $user->os_version : '',
            $showUserData ? $user->device_name : '',
    
            // Child-specific fields
            // $childFirstName,
            // $childLastName,
        ];
    }

    public function headings(): array
    {
        return [
            'Sr. No',
            'User Type',
            'First Name',
            'Last Name',
            'Email',
            'Mobile',
            'Date of Birth',
            // 'Setup Profile',
            // 'IsParents',
            'Gender',
            'Stage Verified',
            'Medical Clearance',
            'Address',
            'Child Name',
            'Child Date of birth',
            'Child Gender',
            'Child Current Program',
            'Device Type',
            'App Version',
            'OS Version',
            'Device Name',


            
        ];
    }
}
