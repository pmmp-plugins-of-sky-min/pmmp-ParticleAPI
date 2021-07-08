<?php
declare(strict_types=1);

namespace skymin\particle\task;

use skymin\particle\ParticleAPI;

use pocketmine\scheduler\Task;

use pocketmine\level\Level;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\math\Vector3;

class McTurnTask extends Task{
  
  protected $center, $radius, $height, $unit, $hunit, $angle, $world, $name, $players, $type;
  
  public function __construct(Vector3 $center, float $radius, float $height, int $count, float $unit, float $hunit, Level $world, string $name, string $type, array $players){
    $this->center = $center;
    $this->radius = $radius;
    $this->height = $height;
    $this->unit = $unit;
    $this->hunit = $hunit;
    $this->world = $world;
    $this->name = $name;
    $this->type = $type;
    $this->players = $players;
    $this->angle = 360/$count;
  }
  
  private $h = 0;
  private $a = 0;
  
  public function onRun(int $currentTick):void{
    $center = $this->center;
    $radius = $this->radius;
    $height = $this->height;
    $unit = $this->unit;
    $hunit = $this->hunit;
    $world = $this->world;
    $name = $this->name;
    $type = $this->type;
    $players = $this->players;
    $angle = $this->angle;
    if($this->h > $height){
      ParticleAPI::getInstance()->closeTask($this->getTaskId());
    }
    $x = $center->getX();
    $y = $center->getY();
    $z = $center->getZ();
    $this->h += $hunit;
    $this->a += $unit;
    if($type === 'up'){
      $vec = new Vector3($x, $y + $this->h, $z);
      ParticleAPI::getInstance()->mcCircle($vec, $radius, $angle, $this->a, $world, $name, 0, $players);
      return;
    }
    if($type === 'down'){
      $vec = new Vector3($x, $y - $this->h, $z);
      ParticleAPI::getInstance()->mcCircle($vec, $radius, $angle, $this->a, $world, $name, 0, $players);
      return;
    }
  }
  
}