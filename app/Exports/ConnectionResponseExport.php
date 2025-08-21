<?php

namespace App\Exports;

use App\Models\UserMatch;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ConnectionResponseExport implements  FromCollection, WithHeadings, WithMapping
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
            $user->tell_me_why,
            valueOrEmptyString($user->fromUser?->full_name, 'N/A'),
            valueOrEmptyString($user->user?->full_name, 'N/A'),
            ($user->is_spark == UserMatch::SPARK_REQUEST)? 'Spark Request':'Connection Request'
        ];
    }

    public function headings(): array
    {
        return [
            'Sr. No',
            'Connection Responses',
            'Added By',
            'Send To',
            'Request Type',
        ];
    }
}
