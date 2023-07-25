<?php 

// Output : 
// 53.454492$
// 55.977413122858$ 

abstract class Car {
  protected $model;
  protected $height;
     
  abstract public function calcTankVolume();
}

class Bmw extends Car {
 
  protected $rib;
  
  public function __construct($model, $rib, $height)
  {
    $this -> model = $model;
    $this -> rib = $rib;
    $this -> height = $height;
  }
   
  // Calculates a rectangular tank volume
  public function calcTankVolume()
  {
    return $this -> rib * $this -> rib * $this -> height;
  } 
}
// Type hinting ensures that the function gets only objects 
// that belong to the Car interface
function calcTankPrice(Car $car, $pricePerGalon)
{
  echo $car -> calcTankVolume() * 0.0043290 * $pricePerGalon . "$";
}

$bmw1 = new Bmw('62182791', 14, 21); 
echo calcTankPrice($bmw1, 3);

?>