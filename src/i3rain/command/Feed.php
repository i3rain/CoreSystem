<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;

class Feed extends PluginCommand {

    public function __construct(){
        parent::__construct("feed", Core::getMain());
        $this->setDescription("Füllt deinen Hunger");
        $this->setPermission("cmd.feed");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
        if ($sender->hasPermission("cmd.feed")) {
                $sender->setFood(20);
            $sender->sendMessage(Core::PREFIX."§aDu bist jetzt Satt");
        }
        return true;
    }

}