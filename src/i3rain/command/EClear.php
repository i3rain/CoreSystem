<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;

class EClear extends PluginCommand {

    public function __construct(){
        parent::__construct("eclear", Core::getMain());
        $this->setDescription("Entferne deine Effekte");
        $this->setPermission("cmd.eclear");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
        if ($sender->hasPermission("cmd.eclear")) {
            $sender->removeAllEffects();
            $sender->sendMessage(Core::PREFIX."§aDu hast deine Effekte entfernt");
        }
        return true;
    }

}