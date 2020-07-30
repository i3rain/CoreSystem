<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;

class GMZ extends PluginCommand {

    public function __construct(){
        parent::__construct("gm3", Core::getMain());
        $this->setDescription("Gamemode 3 aktivieren");
        $this->setPermission("cmd.gmz");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
		  if ($sender->hasPermission("cmd.gmz")) {
            $sender->setGamemode(3);
            $sender->sendMessage(Core::PREFIX."§aDu bist jetzt im Gamemode 3");
        }
        return true;
    }

}