<?php

namespace skymin\particle;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\level\particle\DustParticle;

use pocketmine\math\Vector3;

use pocketmine\utils\Color;

use pocketmine\network\mcpe\protocol\SpawnParticleEffectPacket;

class ParticleAPI extends PluginBase implements Listener{
  
  public static $instance;
  
  public static function getInstance():?ParticleAPI{
    return self::$instance;
  }
  
  public function onLoad():void{
    self::$instance = $this;
  }
  
  public function onEnable():void{
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }
  
  public function colorcircle(Vector3 $center, float $radius, float $unit, int $angle, Level $world, int $r, int $g, int $b){
    for($i = 0; $i < 360; $i += $unit){
      $x = $center->getX();
      $y = $center->getY();
      $z = $center->getZ();
      $vec = new Vector3($x + sin(deg2rad($i + $angle)) * $radius, $y, $z + cos(deg2rad($i + $angle)) * $radius);
      $world->addParticle(new DustParticle($vec, $r, $g, $b));
    }
  }
  
  public function mccircle(Vector3 $center, float $radius, float $unit, int $angle, Level $world, string $name){
    for($i = 0; $i < 360; $i += $unit){
      $x = $center->getX();
      $y = $center->getY();
      $z = $center->getZ();
      $vec = new Vector3($x + sin(deg2rad($i + $angle)) * $radius, $y, $z + cos(deg2rad($i + $angle)) * $radius);
      $pk = new SpawnParticleEffectPacket();
      $pk->particleName = $name;
      $pk->position = $vec;
      $world->broadcastGlobalPacket($pk);
    }
  }
  
  public function colorstraight(Vector3 $vec_1, Vector3 $vec_2, float $unit, Level $world, int $r, int $g, int $b){
    $x = $vec_1->getX() - $vec_2->getX();
    $y = $vec_1->getY() - $vec_2->getY();
    $z = $vec_1->getZ() - $vec_2->getZ();
    $xz_sq = $x * $x + $z * $z;
    $xz_modulus = sqrt($xz_sq);
    $yaw = rad2deg(atan2(-$x, $z));
    $pitch = rad2deg(- atan2($y, $xz_modulus));
    $distance = $vec_1->distance($vec_2);
    for($i = 0; $i <= $distance; $i += $unit){
      $vec = $vec_1;
      $x1 = $vec_1->getX() - $i * (-\sin($yaw / 180 * M_PI));
      $y1 = $vec_1->getY() - $i * (-\sin($pitch / 180 * M_PI));
      $z1 = $vec_1->getZ() - $i * (\cos($yaw / 180 * M_PI));
      $vec = new Vector3($x1, $y1, $z1);
      $world->addParticle(new DustParticle($vec, $r, $g, $b));
    }
  }
  
  public function mcstraight(Vector3 $vec_1, Vector3 $vec_2, float $unit, Level $world, string $name){
    $x = $vec_1->getX() - $vec_2->getX();
    $y = $vec_1->getY() - $vec_2->getY();
    $z = $vec_1->getZ() - $vec_2->getZ();
    $xz_sq = $x * $x + $z * $z;
    $xz_modulus = sqrt($xz_sq);
    $yaw = rad2deg(atan2(-$x, $z));
    $pitch = rad2deg(- atan2($y, $xz_modulus));
    $distance = $vec_1->distance($vec_2);
    for($i = 0; $i <= $distance; $i += $unit){
      $vec = $vec_1;
      $x1 = $vec_1->getX() - $i * (-\sin($yaw / 180 * M_PI));
      $y1 = $vec_1->getY() - $i * (-\sin($pitch / 180 * M_PI));
      $z1 = $vec_1->getZ() - $i * (\cos($yaw / 180 * M_PI));
      $vec = new Vector3($x1, $y1, $z1);
      $pk = new SpawnParticleEffectPacket();
      $pk->particleName = $name;
      $pk->position = $vec;
      $world->broadcastGlobalPacket($pk);
    }
  }
  
  public function colorregular(Vector3 $center, int $side, float $radius, float $length, float $unit, float $rotation, Level $world, int $r, int $g, int $b){
    $vec = $center;
    $ang = 180 * ($side - 2);
    $r = 180 - ($ang / $side);
    for($i = $rotation; $i <= $rotation + 360; $i += $r){
      $x1 = ($i == $rotation) ? $vec->getX() + $radius * (-\sin ($i / 180 * M_PI)) : $x2;
      $y1 = ($i == $rotation) ? $vec->getY() : $y2;
      $z1 = ($i == $rotation) ? $vec->getZ() + $radius * (\cos($i / 180 * M_PI)) : $z2;
      $x2 = $vec->getX() + $radius * (-\sin($i / 180 * M_PI));
      $y2 = $vec->getY();
      $z2 = $vec->getZ() + $radius * (\cos($i / 180 * M_PI));
      if($i !== $rotation){
        $vec_1 = new Vector3($x1, $y1, $z1);
        $vec_2 = new Vector3($x2, $y2, $z2);
        $this->colorstraight($vec_1, $vec_2, $unit, $world, $r, $g, $b);
      }
    }
  }
  
  public function mcregular(Vector3 $center, int $side, float $radius, float $length, float $unit, float $rotation, Level $world, string $name){
    $vec = $center;
    $ang = 180 * ($side - 2);
    $r = 180 - ($ang / $side);
    for($i = $rotation; $i <= $rotation + 360; $i += $r){
      $x1 = ($i == $rotation) ? $vec->getX() + $radius * (-\sin ($i / 180 * M_PI)) : $x2;
      $y1 = ($i == $rotation) ? $vec->getY() : $y2;
      $z1 = ($i == $rotation) ? $vec->getZ() + $radius * (\cos($i / 180 * M_PI)) : $z2;
      $x2 = $vec->getX() + $radius * (-\sin($i / 180 * M_PI));
      $y2 = $vec->getY();
      $z2 = $vec->getZ() + $radius * (\cos($i / 180 * M_PI));
      if($i !== $rotation){
        $vec_1 = new Vector3($x1, $y1, $z1);
        $vec_2 = new Vector3($x2, $y2, $z2);
        $this->mcstraight($vec_1, $vec_2, $unit, $world, $name);
      }
    }
  }
  
  public function colorrand(Vector3 $center, float $radius, int $count, Level $world, int $r, int $g, int $b){
    for($i = 0; $i<=$count; $i++){
      $addx = mt_rand(-$radius *100, $radius * 100)/100;
      $addy = mt_rand(-$radius *100, $radius * 100)/100;
      $addz = mt_rand(-$radius *100, $radius * 100)/100;
      $x = $center->getX();
      $y = $center->getY();
      $z = $center->getZ();
      $vec = new Vector3($x + $addx, $y + $addy, $z + $addz);
      $world->addParticle(new DustParticle($vec, $r, $g, $b));
    }
  }
  
  public function mcrand(Vector3 $center, float $radius, int $count, Level $world, string $name){
    for($i = 0; $i<=$count; $i++){
      $addx = mt_rand(-$radius *100, $radius * 100)/100;
      $addy = mt_rand(-$radius *100, $radius * 100)/100;
      $addz = mt_rand(-$radius *100, $radius * 100)/100;
      $x = $center->getX();
      $y = $center->getY();
      $z = $center->getZ();
      $vec = new Vector3($x + $addx, $y + $addy, $z + $addz);
      $pk = new SpawnParticleEffectPacket();
      $pk->particleName = $name;
      $pk->position = $vec;
      $world->broadcastGlobalPacket($pk);
    }
  }
  
  public function colorpillar(Vector3 $center, float $radius, float $height, float $unit, int $angle, Level $world, int $r, int $g, int $b){
    for($i = 0; $i < 360; $i += $unit){
      for($h = 0; $h < $height; $h += $unit){
        $x = $center->getX();
        $y = $center->getY();
        $z = $center->getZ();
        $vec = new Vector3($x + sin(deg2rad($i + $angle)) * $radius, $y + $h, $z + cos(deg2rad($i + $angle)) * $radius);
        $world->addParticle(new DustParticle($vec, $r, $g, $b));
      }
    }
  }
  
  public function mcpillar(Vector3 $center, float $radius, float $height, float $unit, int $angle,Level $world, string $name){
    for($i = 0; $i < 360; $i += $unit){
      for($h = 0; $h < $height; $h += $unit){
        $x = $center->getX();
        $y = $center->getY();
        $z = $center->getZ();
        $vec = new Vector3($x + sin(deg2rad($i + $angle)) * $radius, $y + $h, $z + cos(deg2rad($i + $angle)) * $radius);
        $pk = new SpawnParticleEffectPacket();
        $pk->particleName = $name;
        $pk->position = $vec;
        $world->broadcastGlobalPacket($pk);
      }
    }
  }
  
  public function colorturnup(Vector3 $center, float $radius, float $height, int $count, float $unit, Level $world, int $r, int $g, int $b){
    $ang = 180 * ($count - 2);
    $r = 180 - ($ang / $count);
    for($i = 0, $h = 0; $h<$height; $i=$i+$unit*$height, $h=$h+$unit){
      for($c = 0; $c <= 360; $c+=$r){
        $x = $center->getX() + $radius * (-\sin($c / 180 * M_PI));
        $y = $center->getY();
        $z = $center->getZ() + $radius * (\cos($c / 180 * M_PI));
         $vec = new Vector3($x + sin(deg2rad($i)) * $radius, $y + $h, $z + cos(deg2rad($i)) * $radius);
        $world->addParticle(new DustParticle($vec, $r, $g, $b));
      }
    }
  }
  
  public function mcturnup(Vector3 $center, float $radius, float $height, int $count, float $unit, Level $world, string $name){
    $ang = 180 * ($count - 2);
    $r = 180 - ($ang / $count);
    for($i = 0, $h = 0; $h<$height; $i=$i+$unit*$height, $h=$h+$unit){
      for($c = 0; $c <= 360; $c+=$r){
        $x = $center->getX() + $radius * (-\sin($c / 180 * M_PI));
        $y = $center->getY();
        $z = $center->getZ() + $radius * (\cos($c / 180 * M_PI));
        $vec = new Vector3($x + sin(deg2rad($i)) * $radius, $y + $h, $z + cos(deg2rad($i)) * $radius);
        $pk = new SpawnParticleEffectPacket();
        $pk->particleName = $name;
        $pk->position = $vec;
        $world->broadcastGlobalPacket($pk);
      }
    }
  }
  
  public function colorturndown(Vector3 $center, float $radius, float $height, int $count, float $unit, Level $world, int $r, int $g, int $b){
    $ang = 180 * ($count - 2);
    $r = 180 - ($ang / $count);
    for($i = 0, $h = 0; $h<$height; $i=$i+$unit*$height, $h=$h+$unit){
      for($c = 0; $c <= 360; $c+=$r){
        $x = $center->getX() + $radius * (-\sin($c / 180 * M_PI));
        $y = $center->getY();
        $z = $center->getZ() + $radius * (\cos($c / 180 * M_PI));
         $vec = new Vector3($x + sin(deg2rad($i)) * $radius, $y - $h, $z + cos(deg2rad($i)) * $radius);
        $world->addParticle(new DustParticle($vec, $r, $g, $b));
      }
    }
  }
  
  public function mcturndown(Vector3 $center, float $radius, float $height, int $count, float $unit, Level $world, string $name){
    $ang = 180 * ($count - 2);
    $r = 180 - ($ang / $count);
    for($i = 0, $h = 0; $h<$height; $i=$i+$unit*$height, $h=$h+$unit){
      for($c = 0; $c <= 360; $c+=$r){
        $x = $center->getX() + $radius * (-\sin($c / 180 * M_PI));
        $y = $center->getY();
        $z = $center->getZ() + $radius * (\cos($c / 180 * M_PI));
        $vec = new Vector3($x + sin(deg2rad($i)) * $radius, $y - $h, $z + cos(deg2rad($i)) * $radius);
        $pk = new SpawnParticleEffectPacket();
        $pk->particleName = $name;
        $pk->position = $vec;
        $world->broadcastGlobalPacket($pk);
      }
    }
  }
}
