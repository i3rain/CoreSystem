<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;

class Nacht extends PluginCommand {

    public function __construct(){
        parent::__construct("nacht", Core::getMain());
        $this->setDescription("Mach es zu Nacht");
        $this->setPermission("cmd.time");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
        if ($sender->hasPermission("cmd.time")) {
            $sender->getLevel()->setTime(16000);
            $sender->sendMessage(Core::PREFIX."§aDu hast es zu Nacht gemacht");
        }
        return true;
    }

}