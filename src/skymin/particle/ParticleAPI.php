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
  
  public static function getInstance(){
    return self::$instance;
  }
  
  public function onLoad(){
    self::$instance = $this;
  }
  
  public function onEnable(){
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }
}
