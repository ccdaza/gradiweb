<?php

namespace App\Http\Controllers;

use App\Car;
use App\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plate' => 'required',
            'brand' => 'required',
            'type' => 'required',
            'owner' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }
        
        $brands = Brand::where("name", $request->brand)->get();
        
        if($brands->count() == 0){
            $brand = $this->createBrand($request->brand);
            if(is_null($brand)){
                return response()->json(["errors" => ["createdBrand" => [ __("errors.createdBrand") ]]], 422);
            }
            $brand->isNew = true;
        }else{
            $brand = $brands->last();
        }
        
        $cars = Car::where("plate", $request->plate)->get();
        
        if($cars->count() > 0){
            if($brand->isNew){
                $brand->delete();
            }
            return response()->json(["errors" => ["carAlreadyExists" => [ __("erros.carAlreadyExists", ["plate" => $request->plate]) ]]], 422);
        }
        
        $car = new Car();
        $car->plate = $request->plate;
        $car->brand_id = $brand->id;
        $car->type_id = $request->type;
        $car->owner_id = $request->owner;
        
        try{
            $car->save();
        }catch(\Exception $e){
            if($brand->isNew){
                $brand->delete();
            }
            return response()->json(["errors" => ["createdCar" => [ __("errors.createdCar") ]]], 422);
        }
        
        return response()->json(["success" => ["message" => [ __("car.successfulCreation") ]]]);
        
        
    }
    
    private function createBrand($name){
        $brand = new Brand();
        
        $brand->name = $name;
        
        try{
            $brand->save();
        }catch(\Exception $e){
            return null;
        }
        
        return $brand;
    }
}
