<?php
/*
 * Copyright (c) 2021. Gaëtan H
 * https://github.com/Steellgold
 */

namespace Steellgold\DamageModifier;

use pocketmine\plugin\PluginBase;
use Steellgold\DamageModifier\events\DamagedEvent;

class Main extends PluginBase {
    private string $version = "1.0";

    public static $instance;

    public function onEnable() {
        self::setInstance($this);

        if($this->getConfig()->exists("version") AND $this->getConfig()->get("version") !== $this->version){
            $this->getLogger()->alert("The plug-in configuration has been modified since an update, your old configuration has been renamed to old_config.yml");
            rename($this->getDataFolder() . "config.yml",$this->getDataFolder() . "old_config.yml");
            $this->getServer()->getPluginManager()->disablePlugin($this);
            return;
        }

        $this->getServer()->getPluginManager()->registerEvents(new DamagedEvent(), $this);
    }

    public function getItems(): array {
        return self::getInstance()->getConfig()->get("items");
    }

    public static function getInstance() : Main {
        return self::$instance;
    }

    public static function setInstance($instance): void {
        self::$instance = $instance;
    }
}