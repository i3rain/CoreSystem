<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;

class GMS extends PluginCommand {

    public function __construct(){
        parent::__construct("gm0", Core::getMain());
        $this->setDescription("Gamemode 0 aktivieren");
        $this->setPermission("cmd.gms");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
		  if ($sender->hasPermission("cmd.gms")) {
            $sender->setGamemode(0);
            $sender->sendMessage(Core::PREFIX."§aDu bist jetzt im Gamemode 0");
        }
        return true;
    }

}