<?php

namespace App\Exports;

use App\Models\ProgramTime;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProgramExport implements FromCollection, WithHeadings, WithMapping
{
    protected $sr;
    protected $programs;

    public function __construct($programs)
    {
        $this->sr = 0;
        $this->programs = $programs;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->programs;
    }

    public function map($program): array
    {

        $this->sr++;
        if($program->program_type == 1){  //1 = Parent , 2 = Athletes
            $programType = "Parent Programs";
        }elseif($program->program_type == 2){
            $programType = "Athletes Programs";
        }else{
            $programType = "N/A";

        }

         // Program Time details:
         $programTime = ProgramTime::where('program_id',$program->id)->get();

         $start = \Carbon\Carbon::parse($programTime->first()->start_time)->format('g:i A');
         $end = \Carbon\Carbon::parse($programTime->first()->end_time)->format('g:i A');
 
         $days = $programTime->pluck('day')->map(function ($day) {
             return 'Every ' . $day;
         })->implode(' + ');

        return [
            $this->sr,
            $programType,
            $program->program_title,
            $program->program_sub_title,
            $program->age_criteria,
            $program->program_duration,
            $program->description,
            $program->session_week,
            $program->term_price ?? '0',
            $program->session_price ?? '0',
            $program->weekly_price ?? '0',
            $days,
            $start.' - '.$end,
            $programTime->first()->location

        ];
    }

    public function headings(): array
    {
        return [
            'Sr. No',
            'Program Type',
            'Program Title',
            'Program Subtitle',
            'Age Criteria',
            'Program Duration',
            'Program Description',
            'Total Sessions',
            'Term Price',
            'Session Price',
            'Weekly Price',
            'Session Frequency',
            'Program Time',
            'Program Location',


            
        ];
    }
}
