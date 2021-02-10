<?php

use Illuminate\Database\Seeder;
use App\TypeCar;

class TypeCarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            "Compacto",
            "Familiar",
            "Subcompacto",
            "Sedan"
        ];
        
        foreach($types as $type){
            $typeCar = new TypeCar();
            $typeCar->name = $type;
            try{
                $typeCar->save();
            }catch(\Exception $e){
                dump("Co fue posible crear el tipo de carro " . $type);
            }
        }
    }
}
