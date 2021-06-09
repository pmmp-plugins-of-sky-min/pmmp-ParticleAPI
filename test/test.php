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

use pocketmine\event\player\PlayerJoinEvent;

use skymin\particle\ParticleAPI;

class test extends PluginBase implements Listener{
  
  public function onEnable(){
    $this->getServer ()->getPluginManager ()->registerEvents ( $this, $this );
  }
  
  public function onJoin(PlayerJoinEvent $ev){
    $p = $ev->getPlayer();
    $center = $p->getPosition();
    $radius = 3;
    $count = 70;
    $world = $p->getLevel();
    ParticleAPI::getInstance()->colorregular($center, 3, $radius, 4, 0.1, 0, $world, 255, 60, 60);
    ParticleAPI::getInstance()->colorregular($center, 3, $radius, 4, 0.5, 180, $world, 255, 60, 60);
    ParticleAPI::getInstance()->colorregular($center, 6, $radius, 4, 0.5, 180, $world, 255, 60, 60);
  }
}
