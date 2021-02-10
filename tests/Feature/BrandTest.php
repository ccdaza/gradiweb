<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Brand;

class BrandTest extends TestCase
{
    /**
     * Probando json listado de marcas
     */
    
    public function testListBrands(){
        $brands = Brand::orderBy("name", "asc")->get();
        $response = $this->json("GET", "/brands");
        $response->assertJsonFragment($brands->first()->toArray());
        $response->assertStatus(200);
    }
}
