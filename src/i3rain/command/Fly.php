<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class Fly extends PluginCommand {

    public function __construct(){
        parent::__construct("fly", Core::getMain());
        $this->setDescription("Fliegen ein oder ausschalten");
        $this->setPermission("cmd.fly");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
        if($sender->getAllowFlight()){
            $sender->setAllowFlight(false);
            $sender->setFlying(false);
            $sender->sendMessage(Core::PREFIX."§cFliegen deaktiviert");
        }else{
            $sender->setAllowFlight(true);
            $sender->sendMessage(Core::PREFIX."§aFliegen aktiviert");
        }
        return true;
    }

}