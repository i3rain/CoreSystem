<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class Vanish extends PluginCommand {

    public function __construct(){
        parent::__construct("vanish", Core::getMain());
        $this->setDescription("Mach dich Unsichtbar");
        $this->setPermission("cmd.vanish");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
        if($sender->isInvisible()){
        $sender->setInvisible(false);
        $sender->setNameTagVisible(true);
        $sender->sendMessage(Core::PREFIX."§cVanish deaktiviert");
        return true;
        }
        if(!$sender->isInvisible()){
            $sender->setInvisible(true);
            $sender->setNameTagVisible(false);
            $sender->sendMessage(Core::PREFIX."§aVanish aktiviert");
        }
        return true;
    }
}