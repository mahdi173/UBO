<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Statistiques\Service\StatistiqueService;


class StatistiqueController extends Controller
{    
    /**
     * __construct
     *
     * @param  mixed $statistiqueService
     * @return void
     */
    public function __construct( protected StatistiqueService $statistiqueService)
    {
    } 
    
    public function statistics()
    {
        return $this->statistiqueService->statistics() ;
    }
   
}

