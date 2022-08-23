<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wine;

class WineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = DB::table('users')->get();

        

        //
        return "hello";

        		
    }

    public function getWineList($key){
        // filterId			
        // wineTypeID			
        // wineIdList			
        // customerReview			
        // priceFrom			
        // priceTo	

        $wine = Wine::first();


        return $wine;
    }

    public function getWineDetail($id){
        // wineId			

        $wine = Wine::where('id', '=', $id)->get();


        return $wine;

    }
}
