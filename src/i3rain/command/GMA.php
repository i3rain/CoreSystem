<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;

class GMA extends PluginCommand {

    public function __construct(){
        parent::__construct("gm2", Core::getMain());
        $this->setDescription("Gamemode 2 aktivieren");
        $this->setPermission("cmd.gma");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
		  if ($sender->hasPermission("cmd.gma")) {
            $sender->setGamemode(2);
            $sender->sendMessage(Core::PREFIX."§aDu bist jetzt im Gamemode 2");
        }
        return true;
    }

}