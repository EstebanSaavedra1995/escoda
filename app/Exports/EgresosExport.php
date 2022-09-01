<?php

namespace App\Exports;

use App\Models\Construccion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EgresosExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    
    protected $pieza;
    
    
    public function __construct($pieza)
    {
        $this->pieza = $pieza;
    }
    
    public function headings(): array
    {
        return [
            'id',
            'IE',
            'Codigo Pieza',
            'Numero',
            'Fecha',
            'Condicion',
            'Tipo de Egreso',
            'Nro. Egreso',
            'Fecha intervencion',
            'Pozo',
            'Nro OR',
        ];
    }

    public function collection()
    {
        return $this->pieza;
    }
}