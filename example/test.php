<?php

/**
 * @name test
 * @main test\test
 * @author sinestrea 
 * @version S1
 * @api 3.0.0
 */

namespace test;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use pocketmine\event\player\PlayerInteractEvent;

use skymin\particle\ParticleAPI;

class test extends PluginBase implements Listener{
  
  public function onEnable(){
    $this->getServer ()->getPluginManager ()->registerEvents ( $this, $this );
  }
  
  public function onJoin(PlayerInteractEvent $ev){
    $p = $ev->getPlayer();
    $center = $p->getPosition();
    $radius = 3;
    $count = 70;
    $world = $p->getLevel();
    ParticleAPI::getInstance()->mcturnup($center, 2, 10, 5, 1.5, $world, 'minecraft:huge_explosion_emitter',  $p);
  }
}
