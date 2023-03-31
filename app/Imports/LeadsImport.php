<?php

namespace App\Imports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class LeadsImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Lead([
            'name'          => $row[0],
            'email'         => $row[1],
            'mobileno'      => $row[2],
            'altmobileno'   => $row[3],
            'remark'        => $row[4]
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
