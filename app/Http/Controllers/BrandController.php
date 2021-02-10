<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;

class BrandController extends Controller
{
    public function index(){
        $brands = Brand::orderBy("name", "asc")->get();
        return response()->json($brands);
    }
}
