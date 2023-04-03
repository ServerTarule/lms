<?php

namespace App\Exports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeadsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Lead::all();
    }

    public function headings(): array
    {
        return [
            'Lead Id',
            'Name',
            'Email',
            'Mobile No',
            'Alternate Mobile No',
            'Received Date',
            'Remark',
            'Employee No',
            'Received Date',
            'Updated Date'
        ];
    }


}
