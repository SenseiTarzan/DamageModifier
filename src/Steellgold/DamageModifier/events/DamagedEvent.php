<?php
/*
 * Copyright (c) 2021. Gaëtan H
 * https://github.com/Steellgold
 */

namespace Steellgold\DamageModifier\events;

use pocketmine\entity\Effect;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\Player;
use Steellgold\DamageModifier\DM;

class DamagedEvent implements Listener {
    public function onInteraction(EntityDamageByEntityEvent $ev){
        $victim = $ev->getEntity();
        $damager = $ev->getDamager();
        if(!($damager instanceof Player && $victim instanceof Player)) return;
        $item = $damager->getInventory()->getItemInHand();
     
        if(!(DM::getInstance()->InItems($dm = $item->getId()."-".$item->getDamage()) && DM::getInstance()->inWorld($damager,$dm))) return;

        $dm = DM::getInstance()->getItem($dm);
        $ev->setModifier($damager->hasEffect(Effect::STRENGTH) ?
            $dm["damage"] * 0.3 * $damager->getEffect(Effect::STRENGTH)->getEffectLevel() :
            $dm["damage"] * 0.3, EntityDamageEvent::MODIFIER_STRENGTH);

        if($dm['knockback'] !== 0){
            if($dm['knockback-chance'] == 0){
                $victim->knockBack($victim, 0, $dm['knockback'], 0, 1);
            }elseif(mt_rand(1, 100) <= $dm['knockback-chance']){
                $victim->knockBack($victim, 0, $dm['knockback'], 0, 1);
            }
        }
        
        if($dm['tip-on-hit'] !== "disable"){
            $text = str_replace(array('{VICTIM}'),array($victim->getName()),$dm['tip-on-hit']);
            if($dm['tip-chance'] == 0){
                $damager->sendTip($text);
            }elseif(mt_rand(1, 100) <= $dm['tip-chance']){
                $damager->sendTip($text);
            }
        }
    }
}
