<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;
use App\Owner;
use App\TypeCar as Type;
use App\Car;
use App\Brand;

class CarTest extends TestCase
{
      
    /**
     * Probando validacion vehiculo debe tener placa
    */
    public function testCarPlateNull()
    {
        $owner = Owner::all()->random();
        $type = Type::all()->random();
        $response = $this->json('POST', '/cars', ["brand" => "Mazda", "type" => $type->id, "owner" => $owner->id]);
        $response->assertStatus(422);
        $response->assertJsonFragment(['plate' => [ __("validation.required", ["attribute" => "plate"]) ]]);
    }
    
    /**
     * Probando validacion vehiculo debe tener marca
    */
    public function testCarBrandNull()
    {
        $owner = Owner::all()->random();
        $type = Type::all()->random();
        $response = $this->json('POST', '/cars', ["plate" => "XXX000", "type" => $type->id, "owner" => $owner->id]);        
        $response->assertStatus(422);
        $response->assertJsonFragment(['brand' => [ __("validation.required", ["attribute" => "brand"]) ]]);
    }
    
    /**
     * Probando validacion vehiculo debe tener tipo
    */
    public function testCarTypeNull()
    {
        $owner = Owner::all()->random();
        $response = $this->json('POST', '/cars', ["plate" => "XXX000", "brand" => "Mazda", "owner" => $owner->id]);
        $response->assertStatus(422);
        $response->assertJsonFragment(['type' => [ __("validation.required", ["attribute" => "type"]) ]]);
    }
    
    /**
     * Probando validacion vehiculo debe tener propietario
    */
    public function testCarOwnerNull()
    {
        $type = Type::all()->random();
        $response = $this->json('POST', '/cars', ["plate" => "XXX000", "brand" => "Mazda", "type" => $type->id]);
        $response->assertStatus(422);
        $response->assertJsonFragment(['owner' => [ __("validation.required", ["attribute" => "owner"]) ]]);
    }
    
    /**
     * Probando la creacion de la marca en la tabla brands
    */
    public function testSuccessfullyCreatedBrand()
    {
        $owner = Owner::all()->random();
        $type = Type::all()->random();
        $plate = Str::random(3) . rand(000, 999);
        $brand = "Marca" . \date("YmdHis");
        $response = $this->json('POST', '/cars', ["plate" => $plate, "brand" => $brand, "type" => $type->id, "owner" => $owner->id]);
        $this->assertDatabaseHas('brands', [
            'name' => $brand,
        ]);
    }
    
    /**
     * Probando la validacion si el vehiculo la existe
    */
    public function testCarAlreadyExists()
    {
        $cars = Car::all();
        if($cars->count() > 0){
            $car = $cars->random();
            $response = $this->json('POST', '/cars', ["plate" => $car->plate, "brand" => "Toyota", "type" => $car->type->id, "owner" => $car->owner->id]);
            $response->assertStatus(422);
            $response->assertJsonFragment(['carAlreadyExists' => [ __("erros.carAlreadyExists", ["plate" => $car->plate]) ]]);
        }else{
            $this->assertDatabaseCount('cars', 0);
        }
        
    }
    
    /**
     * Probando la creacion del vehiculo en la tabla cars
    */
    public function testSuccessfullyCreatedCar()
    {
        $owner = Owner::all()->random();
        $brand = Brand::all()->random();
        $type = Type::all()->random();
        $plate = Str::random(3) . rand(000, 999);
        $response = $this->json('POST', '/cars', ["plate" => $plate, "brand" => $brand->name, "type" => $type->id, "owner" => $owner->id]);
        $this->assertDatabaseHas('cars', [
            'plate' => $plate,
        ]);
        $response->assertJsonFragment(['message' => [ __("car.successfulCreation") ]]);
        $response->assertStatus(200);
    }
    
    /**
     * Probando json listado de vehiculos
     */
    
    public function testListCars(){
        $cars = Car::orderBy("created_at", "desc")->with("type", "brand", "owner")->get();
        $response = $this->json("GET", "/cars");
        $response->assertJsonFragment($cars->first()->toArray());
        $response->assertStatus(200);
    }
    
    
    
}
