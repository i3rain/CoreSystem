<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;

class IClear extends PluginCommand {

    public function __construct(){
        parent::__construct("iclear", Core::getMain());
        $this->setDescription("Leere dein Inventar");
        $this->setPermission("cmd.iclear");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
        if ($sender->hasPermission("cmd.iclear")) {
            $sender->getInventory()->clearAll();
            $sender->sendMessage(Core::PREFIX."§aDu hast dein Inventar geleert");
        }
        return true;
    }

}