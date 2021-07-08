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
    $vec_1 = $p->getPosition();
    $vec_2 = $ev->getTouchVector();
    $unit = 0.7;
    $count = 70;
    $world = $p->getLevel();
    ParticleAPI::getInstance()->colorstraight($vec_1, $vec_2, $unit, $world, 3, 200, 70, [$p], 2);
  }
}
