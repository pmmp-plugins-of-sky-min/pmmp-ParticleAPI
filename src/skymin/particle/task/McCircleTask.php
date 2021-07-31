<?php
declare(strict_types=1);

namespace skymin\particle\task;

use skymin\particle\ParticleAPI;

use pocketmine\scheduler\Task;

use pocketmine\level\Level;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\math\Vector3;

use pocketmine\network\mcpe\protocol\SpawnParticleEffectPacket;
use function cos;
use function deg2rad;
use function sin;

class McCircleTask extends Task{

	protected $center, $radius, $unit, $angle, $world, $name, $director, $players;

	public function __construct(Vector3 $center, float $radius, float $unit, float $angle, Level $world, string $name, int $dir, array $players){
		$this->center = $center;
		$this->radius = $radius;
		$this->unit = $unit;
		$this->angle = $angle;
		$this->world = $world;
		$this->name = $name;
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
		$name = $this->name;
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
			$pk = new SpawnParticleEffectPacket();
			$pk->particleName = $name;
			$pk->position = $vec;
			Server::getInstance()->batchPackets($players, [$pk], false);
			return;
		}
		$vec = new Vector3($x + sin(deg2rad($this->i + $angle)) * $radius, $y, $z + cos(deg2rad($this->i + $angle)) * $radius);
		$pk = new SpawnParticleEffectPacket();
		$pk->particleName = $name;
		$pk->position = $vec;
		Server::getInstance()->batchPackets($players, [$pk], false);
	}

}