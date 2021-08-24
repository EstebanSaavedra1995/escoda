<?php

namespace App\Exports;

use App\Models\Construccion;
use Maatwebsite\Excel\Concerns\FromCollection;

class OCFechasExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $fecha1;
    protected $fecha2;

    public function __construct($fecha1, $fecha2)
    {
        $this->fecha1 = $fecha1;
        $this->fecha2 = $fecha2;
    }

    public function collection()
    {

        $fechaI = str_replace('-', '', $this->fecha1);
        $fechaF = str_replace('-', '', $this->fecha2);
        
        $fechaI = substr($fechaI, -6);
        $fechaF = substr($fechaF, -6);

        return Construccion::whereBetween('Fecha', [$fechaI, $fechaF])
            ->where('Estado', 'A')->get();
    }
}
