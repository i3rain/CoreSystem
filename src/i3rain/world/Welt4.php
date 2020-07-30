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

class Welt4 extends PluginCommand implements Listener{

    public $plugin;
    public $worlds;

    public function __construct(Core $plugin){
    $this->plugin = $plugin;
    $worlds = new Config($this->plugin->getDataFolder().'worlds.yml', Config::YAML);
        parent::__construct($worlds->get("Welt4-Befehl"), Core::getMain());
        $this->setDescription("Teleportiere dich in die Welt");
        $this->setPermission("cmd.tpw");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        $worlds = new Config($this->plugin->getDataFolder().'worlds.yml', Config::YAML);
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
        if(!$sender->getServer()->loadLevel($worlds->get("Welt4-Name"))) {
            $sender->sendMessage(Core::PREFIX. "§cDie Welt kann nicht geladen werden!");
			return true;
        }
        if(!$sender->teleport($sender->getServer()->getLevelByName($worlds->get("Welt4-Name"))->getSafeSpawn())) {
				$sender->sendMessage(Core::PREFIX. "§cDu kannst dich nicht in die Welt teleportieren");
			return true;
		  }
        if ($sender->hasPermission("cmd.tpw")) {
            $sender->getServer()->loadLevel($worlds->get("Welt4-Name"));
            $sender->teleport($sender->getServer()->getLevelByName($worlds->get("Welt4-Name"))->getSafeSpawn());
            $sender->sendMessage(Core::PREFIX. $worlds->get("Welt4-Teleport-Message"));
            $worlds->save();
        }
        return true;
    }

}