<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Owner;

class OwnerTest extends TestCase
{
    
    /**
     * Probando json listado de propitarios
     */
    
    public function testListOwner(){
        $owners = Owner::orderBy("name", "asc")->get();
        $response = $this->json("GET", "/owners");
        $response->assertJsonFragment($owners->first()->toArray());
        $response->assertStatus(200);
    }
}
