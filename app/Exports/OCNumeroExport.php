<?php

namespace App\Exports;

use App\Models\Construccion;
use Maatwebsite\Excel\Concerns\FromCollection;

class OCNumeroExport implements FromCollection
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
        return Construccion::where('Estado', 'A')
            ->where('NroOC', 'LIKE', '%' . $this->numero . '%')->get();
    }
}
