<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportedUsersExport implements  FromCollection, WithHeadings, WithMapping
{
    protected $sr;
    protected $users;

    public function __construct($users)
    {
        $this->sr = 0;
        $this->users = $users;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->users;
    }

    public function map($user): array
    {
        $this->sr++;
        return [
            $this->sr,
            $user->reported_user->full_name,
            $user->reported_by_user->full_name,
            valueOrEmptyString($user->reason, 'N/A'),
            valueOrEmptyString($user->other_reason, 'N/A'),
        ];
    }

    public function headings(): array
    {
        return [
            'Sr. No',
            'First Name',
            'Reported By',
            'Reason',
            'Other Reason',
        ];
    }
}
