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
    $player = $ev->getPlayer();
    ParticleAPI::getInstance()->mcTurn($player->getPosition(), 3, 35, 3, 3, 0.5, $player->getLevel(), 'minecraft:mob_block_spawn_emitter', 'up', $player->getLevel()->getPlayers());
  }
}
