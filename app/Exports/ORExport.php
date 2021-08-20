<?php

namespace App\Exports;

use App\Models\OrdenReparacion;
use Maatwebsite\Excel\Concerns\FromCollection;

class ORExport implements FromCollection
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
        return OrdenReparacion::where('CodConjunto', $this->pieza)->get();
    }
    /* ConjuntoArticulos::select('*')
            ->join('articulosgenerales', 'conjuntoarticulosgenerales.CodArticulo', '=', 'articulosgenerales.CodArticulo')
            ->where('CodPieza', $conjunto)
            ->get(); */
}
