## 변수

$radius : 중앙 거리

$unit : 파티클 간격

$center, $vec_1, $vec_2 : 위치

$world : 월드

$side : 변 갯수

$length : 길이

$rotation : 회전

$name : 마인크래프트 파티클 이름

$r, $g, $b = RGB색 (255까지 있음)

count : 파티클 갯수
</br>
</br>
## How to use

use skymin\particle\ParticleAPI;
</br>
</br>

RGB색으로 된 원을 구현합니다.

```php
ParticleAPI::getInstance()->colorcircle($center, $radius, $unit, $world, $r, $g, $b);
```
</br>

마인크래프트 기본 파티클로 원을 구현합니다.

```php
ParticleAPI::getInstance()->mccircle($center, $radius, $unit, $world, $name);
```

RGB색으로 직선을 구현합니다.

```php
ParticleAPI::getInstance()->colorstraight($vec_1, $vec_2, $unit, $level, $r, $g, $b);
```

마인크래프트 기본 파티클로 직선을 구현합니다.

```php
ParticleAPI::getInstance()->mcstraight($vec_1, $vec_2, $unit, $level, $name);
```

RGB색으로 다각형을 구현합니다.

```php
ParticleAPI::getInstance()->colorregular($center, $side, $radius, $length, $unit, $rotation, $level, $r, $g, $b);
```

마인크래프트 기본 파티클로 다각형을 구현합니다.

```php
ParticleAPI::getInstance()->mcregular($center, $side, $radius, $length, $unit, $rotation, $level, $name);
```

RGB색으로 범위내에 특정 갯수 만큼 랜덤 위치로 나오는 파티클을 구현합니다.

```php
ParticleAPI::getInstance()->colorrand($center, $radius, $count, $world, $r, $g, $b);
```

마인크래프트 기본 파티클로 범위내에 특정 갯수 만큼 랜덤 위치로 나오는 파티클을 구현합니다.

```php
ParticleAPI::getInstance()->mcrand($center, $radius, $count, $world, $name);
```

</br>

## 마인크래프트 파티클 목록

참고사이트

https://www.digminecraft.com/lists/particle_list_pe.php
