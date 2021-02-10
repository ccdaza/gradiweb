<?php

use Illuminate\Database\Seeder;
use App\Owner;
use Illuminate\Support\Str;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         for($i = 0; $i<=20 ; $i++){
             $owner = new Owner();
             $owner->name = Str::random(9);
             $owner->document = rand(50000000, 1000000000);
             try{
                 $owner->save();
             }catch(\Exception $error){
                 dump($error->getMessage());
             }
         }
    }
}
