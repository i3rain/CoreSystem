<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;

class Info extends PluginCommand {

    public function __construct(){
        parent::__construct("cinfo", Core::getMain());
        $this->setDescription("Information zum Plugin");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
          if(!$sender instanceof Player) 
        return false;
            $sender->sendMessage(Core::PREFIX."§a Information zum Core System:
§f
§fErsteller des Plugins: §6i3rain
§f
§fVersion: §61.2.8");
        return true;
    }

}
