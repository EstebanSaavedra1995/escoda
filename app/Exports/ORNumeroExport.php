<?php

namespace App\Exports;

use App\Models\OrdenReparacion;
use Maatwebsite\Excel\Concerns\FromCollection;

class ORNumeroExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $numero;


    public function __construct($numero)
    {
        $this->numero = $numero;
    }

    public function collection()
    {
        return OrdenReparacion::where('NroOR', 'LIKE', '%' . $this->numero . '%')->get();
    }
}
