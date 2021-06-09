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
  
  public function colorcircle(Vector3 $center, float $radius, float $unit, Level $world, int $r, int $g, int $b){
    for($i = 0; $i < 360; $i += $unit){
      $x = $center->getX();
      $y = $center->getY();
      $z = $center->getZ();
      $vec = new Vector3($x + sin(deg2rad($i)) * $radius, $y, $z + cos(deg2rad($i)) * $radius);
      $world->addParticle(new DustParticle($vec, $r, $g, $b));
    }
  }
  
  public function mccircle(Vector3 $center, float $radius, float $unit, Level $world, string $name){
    for($i = 0; $i < 360; $i += $unit){
      $x = $center->getX();
      $y = $center->getY();
      $z = $center->getZ();
      $vec = new Vector3($x + sin(deg2rad($i)) * $radius, $y, $z + cos(deg2rad($i)) * $radius);
      $pk = new SpawnParticleEffectPacket();
      $pk->particleName = $name;
      $pk->position = $vec;
      $world->broadcastGlobalPacket($pk);
    }
  }
  
  public function colorstraight(Vector3 $vec_1, Vector3 $vec_2, float $unit, Level $level, int $r, int $g, int $b){
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
      $level->addParticle(new DustParticle($vec, $r, $g, $b));
    }
  }
  
  public function mcstraight(Vector3 $vec_1, Vector3 $vec_2, float $unit, Level $level, string $name){
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
  
  public function colorregular(Vector3 $center, int $side, float $radius, float $length, float $unit, float $rotation, Level $level, int $r, int $g, int $b){
    $vec = $center;
    $angle = 180 * ($side - 2);
    $r = 180 - ($angle / $side);
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
        $this->straightParticle($vec_1, $vec_2, $unit, $level, $r, $g, $b);
      }
    }
  }
  
  public function mcregular(Vector3 $center, int $side, float $radius, float $length, float $unit, float $rotation, Level $level, string $name){
    $vec = $center;
    $angle = 180 * ($side - 2);
    $r = 180 - ($angle / $side);
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
        $this->mcparticlestraight($vec_1, $vec_2, $unit, $level, $name);
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
  
}