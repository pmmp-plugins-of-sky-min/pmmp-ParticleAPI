## 변수

$radius : 중앙 거리 (float)

$unit : 파티클 간격 각도 (float)

$center, $vec_1, $vec_2 : 위치 (Vector)

$world : 월드 (Level)

$side : 변 갯수 (natural number)

$length : 길이 (float)

$rotation : 회전 (float)

$name : 마인크래프트 파티클 이름 (string)

$r, $g, $b = RGB색 (0~255)

$count : 파티클 갯수 (int)

$height: 높이 (float)

$hunit : 파티클 높이 간격 (float)

$angle : 그리기 시작각도 (int 0~360)

$dir : 원 그려지는 방향 (0 or 1)

$player : 플레이어 변수 또는 배열(Player array)

$delay : Tick (딜레이가 필요 없다면 이 변수는 입력할 필요가 없습니다)
</br>
</br>
## How to use

use skymin\particle\ParticleAPI;
</br>
</br>

RGB색으로 된 원을 구현합니다.

```php
ParticleAPI::getInstance()->colorCircle($center, $radius, $unit, $angle, $world, $r, $g, $b, $dir, $players, $delay);
```

마인크래프트 기본 파티클로 원을 구현합니다.

```php
ParticleAPI::getInstance()->mcCircle($center, $radius, $unit, $angle, $world, $name, $dir, $players, $delay);
```

RGB색으로 직선을 구현합니다.

```php
ParticleAPI::getInstance()->colorStraight($vec_1, $vec_2, $unit, $level, $r, $g, $b, $player, $delay);
```

마인크래프트 기본 파티클로 직선을 구현합니다.

```php
ParticleAPI::getInstance()->mcStraight($vec_1, $vec_2, $unit, $level, $name, $player,  $delay);
```

RGB색으로 다각형을 구현합니다.

```php
ParticleAPI::getInstance()->colorRegular($center, $side, $radius, $length, $unit, $rotation, $world, $r, $g, $b, $player);
```

마인크래프트 기본 파티클로 다각형을 구현합니다.

```php
ParticleAPI::getInstance()->mcRegular($center, $side, $radius, $length, $unit, $rotation, $world, $name, $player);
```

RGB색으로 범위내에 특정 갯수 만큼 랜덤 위치(y좌표 포함)로 나오는 파티클을 구현합니다.

```php
ParticleAPI::getInstance()->colorRandXYZ($center, $radius, $count, $world, $r, $g, $b, $player);
```

마인크래프트 기본 파티클로 범위내에 특정 갯수 만큼 랜덤 위치(y좌표 포함)로 나오는 파티클을 구현합니다.

```php
ParticleAPI::getInstance()->mcRandXYZ($center, $radius, $count, $world, $name, $player);
```

RGB색으로 범위내에 특정 갯수 만큼 랜덤 위치(y좌표 미포함)로 나오는 파티클을 구현합니다.

```php
ParticleAPI::getInstance()->colorRandXZ($center, $radius, $count, $world, $r, $g, $b, $player);
```

마인크래프트 기본 파티클로 범위내에 특정 갯수 만큼 랜덤 위치(y좌표 미포함)로 나오는 파티클을 구현합니다.

```php
ParticleAPI::getInstance()->mcRandXZ($center, $radius, $count, $world, $name, $player);
```

RGB색으로 두개 좌표 범위에 특정 갯수만큼 랜덤 위치(y좌표 미포함)로 나오는 파티클을 구현합니다.

```php
ParticleAPI::getInstance()->colorRandPos($vec_1, $vec_2, $count, $world, $r, $g, $b, $player);
```

마인크래프트 기본 파티클로 두개 좌표 범위에 특정 갯수 만큼 랜덤 위치(y좌표 미포함)로 나오는 파티클을 구현합니다.

```php
ParticleAPI::getInstance()->mcRandPos($vec_1, $vec_2, $count, $world, $name, $player);
```

RGB색으로 원기둥을 구현합니다.

```php
ParticleAPI::getInstance()->colorpillar($center, $radius, $height, $unit, $hunit, $angle, $world, $r, $g, $b, $player);
```

마인크래프트 기본 파티클로 원기둥을 구현합니다.

```php
ParticleAPI::getInstance()->mcpillar($center, $radius, $height, $unit, $hunit, $angle, $world, $name, $player);
```

RGB색으로 올라가는 회오리를 구현합니다.

```php
ParticleAPI::getInstance()->colorturnup($center, $radius, $height, $count, $unit, $hunit, $world, $r, $g, $b, $player);
```

마인크래프트 기본 파티클로 올라가는 회오리를 구현합니다.

```php
ParticleAPI::getInstance()->mcturnup($center, $radius, $height, $count, $unit, $hunit, $world, $name, $player);
```

RGB색으로 내려가는 회오리를 구현합니다.

```php
ParticleAPI::getInstance()->colorturndown($center, $radius, $height, $count, $unit, $hunit, $world, $r, $g, $b, $player);
```

마인크래프트 기본 파티클로 내려가는 회오리를 구현합니다.

```php
ParticleAPI::getInstance()->mcturndown($center, $radius, $height, $count, $unit, $hunit, $world, $name, $player);
```

</br>

## 마인크래프트 파티클 목록

참고사이트

https://www.digminecraft.com/lists/particle_list_pe.php
