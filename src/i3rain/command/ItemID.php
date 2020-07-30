<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;

class ItemID extends PluginCommand {

    public function __construct(){
        parent::__construct("id", Core::getMain());
        $this->setDescription("Zeigt die Item ID");
        $this->setPermission("cmd.id");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
        if ($sender->hasPermission("cmd.id")) {
                $item = $sender->getInventory()->getItemInHand();
            $sender->sendMessage(Core::PREFIX."§aItem ID: §f" . $item->getID());
        }
        return true;
    }

}