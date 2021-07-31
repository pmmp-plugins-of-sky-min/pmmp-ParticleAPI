<?php
declare(strict_types=1);

namespace skymin\particle\task;

use pocketmine\level\Level;
use pocketmine\level\particle\DustParticle;
use pocketmine\math\Vector3;
use pocketmine\scheduler\Task;
use skymin\particle\ParticleAPI;
use function atan2;
use function rad2deg;
use function sqrt;

class ColorStraightTask extends Task{

	public $vec_2, $unit, $world, $r, $g, $b, $players, $distance, $pitch, $yaw;

	public function __construct(Vector3 $vec_1, Vector3 $vec_2, float $unit, Level $world, int $r, int $g, int $b, array $players){
		$x = $vec_1->getX() - $vec_2->getX();
		$y = $vec_1->getY() - $vec_2->getY();
		$z = $vec_1->getZ() - $vec_2->getZ();
		$xz_sq = $x * $x + $z * $z;
		$xz_modulus = sqrt($xz_sq);
		$yaw = rad2deg(atan2(-$x, $z));
		$pitch = rad2deg(-atan2($y, $xz_modulus));
		$distance = $vec_1->distance($vec_2);
		$this->unit = $unit;
		$this->vec_1 = $vec_1;
		$this->distance = $distance;
		$this->yaw = $yaw;
		$this->pitch = $pitch;
		$this->unit = $unit;
		$this->world = $world;
		$this->r = $r;
		$this->g = $g;
		$this->b = $b;
		$this->players = $players;
	}

	private $i = 0;

	public function onRun(int $currentTick) : void{
		$unit = $this->unit;
		$vec_1 = $this->vec_1;
		$distance = $this->distance;
		$yaw = $this->yaw;
		$pitch = $this->pitch;
		$unit = $this->unit;
		$world = $this->world;
		$r = $this->r;
		$g = $this->g;
		$b = $this->b;
		$players = $this->players;
		if($this->i > $distance){
			ParticleAPI::getInstance()->closeTask($this->getTaskId());
		}
		$this->i += $unit;
		$vec = $vec_1;
		$x1 = $vec_1->getX() - $this->i * (-\sin($yaw / 180 * M_PI));
		$y1 = $vec_1->getY() - $this->i * (-\sin($pitch / 180 * M_PI));
		$z1 = $vec_1->getZ() - $this->i * (\cos($yaw / 180 * M_PI));
		$vec = new Vector3($x1, $y1, $z1);
		$world->addParticle(new DustParticle($vec, $r, $g, $b), $players);
	}

}