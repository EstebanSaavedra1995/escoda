<?php

namespace App\Exports;

use App\Models\Construccion;
use Maatwebsite\Excel\Concerns\FromCollection;

class OCExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $pieza;

    public function __construct($pieza)
    {
        $this->pieza = $pieza;
    }

    public function collection()
    {
        return Construccion::where('CodigoPieza', $this->pieza)
            ->where('Estado', 'A')->get();
    }
}
