<?php
declare(strict_types=1);

namespace skymin\particle\task;

use skymin\particle\ParticleAPI;

use pocketmine\scheduler\Task;

use pocketmine\level\Level;
use pocketmine\level\particle\DustParticle;

use pocketmine\Player;

use pocketmine\math\Vector3;

class ColorCircleTask extends Task{
  
  protected $center, $radius, $unit, $angle, $world, $r, $g, $b, $director, $players;
  
  public function __construct(Vector3 $center, float $radius, float $unit, float $angle, Level $world, int $r, int $g, int $b, int $dir, array $players){
    $this->center = $center;
    $this->radius = $radius;
    $this->unit = $unit;
    $this->angle = $angle;
    $this->world = $world;
    $this->r = $r;
    $this->g = $g;
    $this->b = $b;
    $this->director = $dir;
    $this->players = $players;
  }
  
  private $i = 0;
  
  public function onRun(int $currentTick):void{
    $center = $this->center;
    $radius = $this->radius;
    $unit = $this->unit;
    $angle = $this->angle;
    $world = $this->world;
    $r = $this->r;
    $g = $this->g;
    $b = $this->b;
    $dir = $this->director;
    $players = $this->players;
    if($this->i > 360){
      ParticleAPI::getInstance()->closeTask($this->getTaskId());
    }
    $x = $center->getX();
    $y = $center->getY();
    $z = $center->getZ();
    $this->i += $unit;
    if($dir === 0){
      $vec = new Vector3($x + sin(deg2rad($this->i + $angle)) * $radius, $y, $z + cos(deg2rad($this->i + $angle)) * $radius);
      $world->addParticle(new DustParticle($vec, $r, $g, $b), $players);
      return;
    }
    $vec = new Vector3($x + sin(deg2rad($this->i + $angle)) * $radius, $y, $z + cos(deg2rad($this->i + $angle)) * $radius);
    $world->addParticle(new DustParticle($vec, $r, $g, $b), $players);
  }
  
}