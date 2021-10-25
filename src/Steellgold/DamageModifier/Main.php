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

    public static array $items = [];

    public static $instance;

    public function onEnable() {
        self::setInstance($this);

        if($this->getConfig()->exists("version") AND $this->getConfig()->get("version") !== $this->version){
            $this->getLogger()->alert("The plug-in configuration has been modified since an update, your old configuration has been renamed to old_config.yml");
            rename($this->getDataFolder() . "config.yml",$this->getDataFolder() . "old_config.yml");
            $this->getServer()->getPluginManager()->disablePlugin($this);
            return;
        }

        if($this->getConfig()->exists("items")){
            foreach ($this->getConfig()->get("items") as $item => $data){
                var_dump($item);
                var_dump($data);
                var_dump("-------------------");
            }
        }

        $this->getServer()->getPluginManager()->registerEvents(new DamagedEvent(), $this);
    }

    /**
     * @return array
     */
    public static function getItems(): array {
        return self::$items;
    }

    /**
     * @param array $items
     */
    public static function setItems(array $items): void {
        self::$items = $items;
    }

    public static function getInstance() {
        return self::$instance;
    }

    public static function setInstance($instance): void {
        self::$instance = $instance;
    }
}