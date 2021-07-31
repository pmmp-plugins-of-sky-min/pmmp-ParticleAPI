<?php
declare(strict_types=1);

namespace skymin\particle;

use pocketmine\event\Listener;
use pocketmine\level\Level;
use pocketmine\level\particle\DustParticle;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\BatchPacket;
use pocketmine\network\mcpe\protocol\SpawnParticleEffectPacket;
use pocketmine\plugin\PluginBase;
use skymin\particle\task\ColorCircleTask;
use skymin\particle\task\ColorStraightTask;
use skymin\particle\task\ColorTurnTask;
use skymin\particle\task\McCircleTask;
use skymin\particle\task\McStraightTask;
use skymin\particle\task\McTurnTask;
use function atan2;
use function cos;
use function deg2rad;
use function mt_rand;
use function rad2deg;
use function sin;
use function sqrt;

class ParticleAPI extends PluginBase implements Listener{

	public static ParticleAPI $instance;

	public static function getInstance() : ParticleAPI{
		return self::$instance;
	}

	public function onLoad() : void{
		self::$instance = $this;
	}

	public function onEnable() : void{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function colorCircle(Vector3 $center, float $radius, float $unit, float $angle, Level $world, int $r, int $g, int $b, int $dir, array $players, int $delay = 0) : void{
		$x = $center->getX();
		$y = $center->getY();
		$z = $center->getZ();
		$packet = new BatchPacket();
		if($delay === 0){
			if($dir === 0){
				for($i = 0; $i < 360; $i += $unit){
					$vec = new Vector3($x + sin(deg2rad($i + $angle)) * $radius, $y, $z + cos(deg2rad($i + $angle)) * $radius);
					$world->addParticle(new DustParticle($vec, $r, $g, $b), $players);
				}
				return;
			}
			for($i = 0; $i < 360; $i += $unit){
				$vec = new Vector3($x + sin(deg2rad((360 - $i) + $angle)) * $radius, $y, $z + cos(deg2rad((360 - $i) + $angle)) * $radius);
				$world->addParticle(new DustParticle($vec, $r, $g, $b), $players);
			}
			return;
		}
		$this->getScheduler()->scheduleRepeatingTask(new ColorCircleTask($center, $radius, $unit, $angle, $world, $r, $g, $b, $dir, $players), $delay);
	}

	public function mcCircle(Vector3 $center, float $radius, float $unit, float $angle, Level $world, string $name, int $dir, array $players, int $delay = 0) : void{
		$x = $center->getX();
		$y = $center->getY();
		$z = $center->getZ();
		if($delay === 0){
			if($dir === 0){
				for($i = 0; $i < 360; $i += $unit){
					$vec = new Vector3($x + sin(deg2rad($i + $angle)) * $radius, $y, $z + cos(deg2rad($i + $angle)) * $radius);
					$pk = new SpawnParticleEffectPacket();
					$pk->particleName = $name;
					$pk->position = $vec;
					$this->getServer()->batchPackets($players, [$pk], false);
				}
				return;
			}
			for($i = 0; $i < 360; $i += $unit){
				$vec = new Vector3($x + sin(deg2rad((360 - $i) + $angle)) * $radius, $y, $z + cos(deg2rad((360 - $i) + $angle)) * $radius);
				$pk = new SpawnParticleEffectPacket();
				$pk->particleName = $name;
				$pk->position = $vec;
				$this->getServer()->batchPackets($players, [$pk], false);
			}
			return;
		}
		$this->getScheduler()->scheduleRepeatingTask(new McCircleTask($center, $radius, $unit, $angle, $world, $name, $dir, $players), $delay);
	}

	public function colorStraight(Vector3 $vec_1, Vector3 $vec_2, float $unit, Level $world, int $r, int $g, int $b, array $players, int $delay = 0) : void{
		$x = $vec_1->getX() - $vec_2->getX();
		$y = $vec_1->getY() - $vec_2->getY();
		$z = $vec_1->getZ() - $vec_2->getZ();
		$xz_sq = $x * $x + $z * $z;
		$xz_modulus = sqrt($xz_sq);
		$yaw = rad2deg(atan2(-$x, $z));
		$pitch = rad2deg(-atan2($y, $xz_modulus));
		$distance = $vec_1->distance($vec_2);
		if($delay === 0){
			for($i = 0; $i <= $distance; $i += $unit){
				$x1 = $vec_1->getX() - $i * (-sin($yaw / 180 * M_PI));
				$y1 = $vec_1->getY() - $i * (-sin($pitch / 180 * M_PI));
				$z1 = $vec_1->getZ() - $i * (cos($yaw / 180 * M_PI));
				$vec = new Vector3($x1, $y1, $z1);
				$world->addParticle(new DustParticle($vec, $r, $g, $b), $players);
			}
			return;
		}
		$this->getScheduler()->scheduleRepeatingTask(new ColorStraightTask($vec_1, $vec_2, $unit, $world, $r, $g, $b, $players), $delay);
	}

	public function mcStraight(Vector3 $vec_1, Vector3 $vec_2, float $unit, Level $world, string $name, array $players, int $delay = 0) : void{
		$x = $vec_1->getX() - $vec_2->getX();
		$y = $vec_1->getY() - $vec_2->getY();
		$z = $vec_1->getZ() - $vec_2->getZ();
		$xz_sq = $x * $x + $z * $z;
		$xz_modulus = sqrt($xz_sq);
		$yaw = rad2deg(atan2(-$x, $z));
		$pitch = rad2deg(-atan2($y, $xz_modulus));
		$distance = $vec_1->distance($vec_2);
		if($delay === 0){
			for($i = 0; $i <= $distance; $i += $unit){
				$vec = $vec_1;
				$x1 = $vec_1->getX() - $i * (-sin($yaw / 180 * M_PI));
				$y1 = $vec_1->getY() - $i * (-sin($pitch / 180 * M_PI));
				$z1 = $vec_1->getZ() - $i * (cos($yaw / 180 * M_PI));
				$vec = new Vector3($x1, $y1, $z1);
				$pk = new SpawnParticleEffectPacket();
				$pk->particleName = $name;
				$pk->position = $vec;
				$this->getServer()->batchPackets($players, [$pk], false);
			}
			return;
		}
		$this->getScheduler()->scheduleRepeatingTask(new McStraightTask($vec_1, $vec_2, $unit, $world, $name, $players), $delay);
	}

	public function colorRegular(Vector3 $center, int $side, float $radius, float $length, float $unit, float $rotation, Level $world, int $r, int $g, int $b, array $players) : void{
		$vec = $center;
		$ang = 180 * ($side - 2);
		$round = 180 - ($ang / $side);
		for($i = $rotation; $i <= $rotation + 360; $i += $round){
			$x2 = $vec->getX() + $radius * (-\sin($i / 180 * M_PI));
			$y2 = $vec->getY();
			$z2 = $vec->getZ() + $radius * (\cos($i / 180 * M_PI));
			$x1 = ($i === $rotation) ? $vec->getX() + $radius * (-\sin($i / 180 * M_PI)) : $x2;
			$y1 = ($i === $rotation) ? $vec->getY() : $y2;
			$z1 = ($i === $rotation) ? $vec->getZ() + $radius * (\cos($i / 180 * M_PI)) : $z2;
			if($i !== $rotation){
				$vec_1 = new Vector3($x1, $y1, $z1);
				$vec_2 = new Vector3($x2, $y2, $z2);
				$this->colorstraight($vec_1, $vec_2, $unit, $world, $r, $g, $b, $players);
			}
		}
	}

	public function mcRegular(Vector3 $center, int $side, float $radius, float $length, float $unit, float $rotation, Level $world, string $name, array $players) : void{
		$vec = $center;
		$ang = 180 * ($side - 2);
		$r = 180 - ($ang / $side);
		for($i = $rotation; $i <= $rotation + 360; $i += $r){
			$x1 = ($i == $rotation) ? $vec->getX() + $radius * (-\sin($i / 180 * M_PI)) : $x2;
			$y1 = ($i == $rotation) ? $vec->getY() : $y2;
			$z1 = ($i == $rotation) ? $vec->getZ() + $radius * (\cos($i / 180 * M_PI)) : $z2;
			$x2 = $vec->getX() + $radius * (-\sin($i / 180 * M_PI));
			$y2 = $vec->getY();
			$z2 = $vec->getZ() + $radius * (\cos($i / 180 * M_PI));
			if($i !== $rotation){
				$vec_1 = new Vector3($x1, $y1, $z1);
				$vec_2 = new Vector3($x2, $y2, $z2);
				$this->mcstraight($vec_1, $vec_2, $unit, $world, $name, $players);
			}
		}
	}

	public function colorRandXYZ(Vector3 $center, float $radius, int $count, Level $world, int $r, int $g, int $b, array $players) : void{
		for($i = 0; $i <= $count; $i++){
			$addx = random_int(-$radius * 100, $radius * 100) / 100;
			$addy = random_int(-$radius * 100, $radius * 100) / 100;
			$addz = random_int(-$radius * 100, $radius * 100) / 100;
			$x = $center->getX();
			$y = $center->getY();
			$z = $center->getZ();
			$vec = new Vector3($x + $addx, $y + $addy, $z + $addz);
			$world->addParticle(new DustParticle($vec, $r, $g, $b), $players);
		}
	}

	public function mcRandXYZ(Vector3 $center, float $radius, int $count, Level $world, string $name, array $players) : void{
		$packets = [];
		for($i = 0; $i <= $count; $i++){
			$addx = random_int(-$radius * 100, $radius * 100) / 100;
			$addy = random_int(-$radius * 100, $radius * 100) / 100;
			$addz = random_int(-$radius * 100, $radius * 100) / 100;
			$x = $center->getX();
			$y = $center->getY();
			$z = $center->getZ();
			$vec = new Vector3($x + $addx, $y + $addy, $z + $addz);
			$pk = new SpawnParticleEffectPacket();
			$pk->particleName = $name;
			$pk->position = $vec;
			$packets[] = $pk;
		}
		$this->getServer()->batchPackets($players, $packets, false);
	}

	public function colorRandXZ(Vector3 $center, float $radius, int $count, Level $world, int $r, int $g, int $b, array $players, int $delay = 0) : void{
		for($i = 0; $i <= $count; $i++){
			$addx = random_int(-$radius * 100, $radius * 100) / 100;
			$addz = random_int(-$radius * 100, $radius * 100) / 100;
			$x = $center->getX();
			$y = $center->getY();
			$z = $center->getZ();
			$vec = new Vector3($x + $addx, $y, $z + $addz);
			$world->addParticle(new DustParticle($vec, $r, $g, $b), $players);
		}
	}

	public function mcRandXZ(Vector3 $center, float $radius, int $count, Level $world, string $name, array $players, int $delay = 0) : void{
		for($i = 0; $i <= $count; $i++){
			$addx = random_int(-$radius * 100, $radius * 100) / 100;
			$addz = random_int(-$radius * 100, $radius * 100) / 100;
			$x = $center->getX();
			$y = $center->getY();
			$z = $center->getZ();
			$vec = new Vector3($x + $addx, $y, $z + $addz);
			$pk = new SpawnParticleEffectPacket();
			$pk->particleName = $name;
			$pk->position = $vec;
			$this->getServer()->batchPackets($players, [$pk], false);
		}
	}

	public function colorRandPos(Vector3 $vec_1, Vector3 $vec_2, float $radius, int $count, Level $world, int $r, int $g, int $b, array $players, int $delay = 0) : void{
		$x1 = $vec_1->getX();
		$y1 = $vec_1->getY();
		$z1 = $vec_1->getZ();
		$x2 = $vec_2->getX();
		$y2 = $vec_2->getY();
		$z2 = $vec_2->getZ();
		for($i = 0; $i <= $count; $i++){
			if($x1 > $x2){
				$x = random_int($x2, $x1);
			}else{
				$x = random_int($x1, $x2);
			}
			if($y1 > $y2){
				$y = random_int($y2, $y1);
			}else{
				$y = random_int($y1, $y2);
			}
			if($z1 > $z2){
				$z = random_int($z2, $z1);
			}else{
				$z = random_int($z1, $z2);
			}
			$vec = new Vector3($x, $y, $z);
			$world->addParticle(new DustParticle($vec, $r, $g, $b), $players);
		}
	}

	public function mcRandPos(Vector3 $vec_1, Vector3 $vec_2, int $count, Level $world, string $name, array $players, int $delay = 0) : void{
		$x1 = $vec_1->getX();
		$y1 = $vec_1->getY();
		$z1 = $vec_1->getZ();
		$x2 = $vec_2->getX();
		$y2 = $vec_2->getY();
		$z2 = $vec_2->getZ();
		$packets = [];
		for($i = 0; $i <= $count; $i++){
			if($x1 > $x2){
				$x = random_int($x2, $x1);
			}else{
				$x = random_int($x1, $x2);
			}
			if($y1 > $y2){
				$y = random_int($y2, $y1);
			}else{
				$y = random_int($y1, $y2);
			}
			if($z1 > $z2){
				$z = random_int($z2, $z1);
			}else{
				$z = random_int($z1, $z2);
			}
			$vec = new Vector3($x, $y, $z);
			$pk = new SpawnParticleEffectPacket();
			$pk->particleName = $name;
			$pk->position = $vec;
			$packets[] = $pk;
		}
		$this->getServer()->batchPackets($players, $packets, false);
	}

	public function colorPillar(Vector3 $center, float $radius, float $height, float $unit, float $hunit, float $angle, Level $world, int $r, int $g, int $b, int $dir, array $players, int $delay = 0) : void{
		$x = $center->getX();
		$y = $center->getY();
		$z = $center->getZ();
		for($i = 0; $i < $height; $i += $hunit){
			$vec = new Vector3($x, $y + $i, $z);
			$this->colorCircle($vec, $radius, $unit, $angle, $world, $r, $g, $b, $dir, $players, $delay);
		}
	}

	public function mcPillar(Vector3 $center, float $radius, float $height, float $unit, float $hunit, float $angle, Level $world, int $r, int $g, int $b, int $dir, array $players, int $delay = 0) : void{
		$x = $center->getX();
		$y = $center->getY();
		$z = $center->getZ();
		for($i = 0; $i < $height; $i += $hunit){
			$vec = new Vector3($x, $y + $i, $z);
			$this->colorCircle($vec, $radius, $unit, $angle, $world, $r, $g, $b, $dir, $players, $delay);
		}
	}

	public function colorTurn(Vector3 $center, float $radius, float $height, int $count, float $unit, float $hunit, Level $world, int $r, int $g, int $b, string $type, array $players, int $delay = 0) : void{
		$x = $center->getX();
		$y = $center->getY();
		$z = $center->getZ();
		$angle = 360 / $count;
		if($delay === 0){
			if($type === 'up'){
				for($h = 0, $a = 0; $h < $height; $h += $hunit, $a += $unit){
					$vec = new Vector3($x, $y + $h, $z);
					$this->colorCircle($vec, $radius, $angle, $a, $world, $r, $g, $b, 0, $players);
				}
				return;
			}
			if($type === 'down'){
				for($h = 0, $a = 0; $h < $height; $h += $hunit, $a += $unit){
					$vec = new Vector3($x, $y - $h, $z);
					$this->colorCircle($vec, $radius, $angle, $a, $world, $r, $g, $b, 0, $players);
				}
				return;
			}
			return;
		}
		$this->getScheduler()->ScheduleRepeatingTask(new ColorTurnTask($center, $radius, $height, $count, $unit, $hunit, $world, $r, $g, $b, $type, $players), $delay);
	}

	public function mcTurn(Vector3 $center, float $radius, float $height, int $count, float $unit, float $hunit, Level $world, string $name, string $type, array $players, int $delay = 0) : void{
		$x = $center->getX();
		$y = $center->getY();
		$z = $center->getZ();
		$angle = 360 / $count;
		if($delay === 0){
			if($type === 'up'){
				for($h = 0, $a = 0; $h < $height; $h += $hunit, $a += $unit){
					$vec = new Vector3($x, $y + $h, $z);
					$this->mcCircle($vec, $radius, $angle, $a, $world, $name, 0, $players, $delay);
				}
				return;
			}
			if($type === 'down'){
				for($h = 0, $a = 0; $h < $height; $h += $hunit, $a += $unit){
					$vec = new Vector3($x, $y - $h, $z);
					$this->mcCircle($vec, $radius, $angle, $a, $world, $name, 0, $players, $delay);
				}
				return;
			}
			return;
		}
		$this->getScheduler()->ScheduleRepeatingTask(new McTurnTask($center, $radius, $height, $count, $unit, $hunit, $world, $name, $type, $players), $delay);
	}

	public function closeTask(int $id){
		$this->getScheduler()->cancelTask($id);
	}
}
