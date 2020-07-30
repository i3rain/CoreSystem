<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;

class Heal extends PluginCommand {

    public function __construct(){
        parent::__construct("heal", Core::getMain());
        $this->setDescription("Heile dich selbst");
        $this->setPermission("cmd.heal");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
        if ($sender->hasPermission("cmd.heal")) {
                $sender->setHealth(20);
            $sender->sendMessage(Core::PREFIX."§aDu hast dich geheilt!");
        }
        return true;
    }

}