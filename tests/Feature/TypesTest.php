<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\TypeCar as Type;

class TypesTest extends TestCase
{
    /**
     * Probando json listado de tipos de vehiculos
     */
    
    public function testListTypes(){
        $types = Type::orderBy("name", "asc")->get();
        $response = $this->json("GET", "/types");
        $response->assertJsonFragment($types->first()->toArray());
        $response->assertStatus(200);
    }
}
