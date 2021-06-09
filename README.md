## 변수

$radius : 중앙 거리

$unit : 파티클의 간격 각도

$center, $vector_1, $vector2 : 위치

$world : 월드

$side : 변 갯수

$length : 길이

$rotation : 회전

$name : 마인크래프트 파티클 이름

$r, $g, $b = RGB색
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
마인크래프트에 있는 파티클로 원을 구현합니다.
```php
ParticleAPI::getInstance()->mcparticlecircle($center, $radius, $unit, $world, $name);
```
