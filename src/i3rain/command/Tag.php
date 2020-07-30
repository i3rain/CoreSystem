<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;

class Tag extends PluginCommand {

    public function __construct(){
        parent::__construct("tag", Core::getMain());
        $this->setDescription("Mach es zu Tag");
        $this->setPermission("cmd.time");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
        if ($sender->hasPermission("cmd.time")) {
            $sender->getLevel()->setTime(6000);
            $sender->sendMessage(Core::PREFIX."§aDu hast es zu Tag gemacht");
        }
        return true;
    }

}