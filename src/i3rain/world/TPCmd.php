<?php

namespace i3rain\world;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\plugin\Plugin;
use pocketmine\event\Listener;
use pocketmine\utils\Config;

class TPCmd extends PluginCommand implements Listener {

    public $plugin;
    public $worlds;

    public function __construct(Core $plugin){
		$this->plugin = $plugin;
		$worlds = new Config($this->plugin->getDataFolder().'worlds.yml', Config::YAML);
		parent::__construct($worlds->get("Teleport-Befehl"), Core::getMain());
        $this->setDescription("Zeige alle Welten an");
        $this->setPermission("cmd.tpw");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        $worlds = new Config($this->plugin->getDataFolder().'worlds.yml', Config::YAML);
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
        if ($sender->hasPermission("cmd.tpw")) {
              $sender->sendMessage(Core::PREFIX. $worlds->get("Teleport-Message"));
              $worlds->save();
        }
        return true;
    }

}