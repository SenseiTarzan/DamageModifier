<?php
/*
 * Copyright (c) 2021. Gaëtan H
 * https://github.com/Steellgold
 */

namespace Steellgold\DamageModifier\events;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use Steellgold\DamageModifier\Main;

class DamagedEvent implements Listener {
    public function onInteraction(EntityDamageByEntityEvent $ev){
        $damager = $ev->getDamager(); $victim = $ev->getEntity();
    }
}
