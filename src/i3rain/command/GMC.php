<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;

class GMC extends PluginCommand {

    public function __construct(){
        parent::__construct("gm1", Core::getMain());
        $this->setDescription("Gamemode 1 aktivieren");
        $this->setPermission("cmd.gmc");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
		  if ($sender->hasPermission("cmd.gmc")) {
            $sender->setGamemode(1);
            $sender->sendMessage(Core::PREFIX."§aDu bist jetzt im Gamemode 1");
        }
        return true;
    }

}