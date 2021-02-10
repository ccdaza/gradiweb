<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TypeCar as Type;

class TypesController extends Controller
{
     public function index(){
        $types = Type::orderBy("name", "asc")->get();
        return response()->json($types);
    }
}
