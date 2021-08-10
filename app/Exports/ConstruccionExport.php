<?php

namespace App\Exports;

use App\Models\Construccion;
use Maatwebsite\Excel\Concerns\FromCollection;

class ConstruccionExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Construccion::all();
    }
}
