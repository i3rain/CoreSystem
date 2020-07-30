<?php

namespace i3rain\emote;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\level\Level;
use pocketmine\block\Block;
use pocketmine\level\particle\DestroyBlockParticle;

class Traurig extends PluginCommand {

    public function __construct(){
       parent::__construct("traurig", Core::getMain());
        $this->setDescription("Zeige das Du traurig bist");
        $this->setPermission("cmd.emote");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        $name = $sender->getName();
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
        if ($sender->hasPermission("cmd.emote")) {
                    $sender->getServer()->broadcastMessage("§f".$name. "§1 ist traurig ...");
                    $sender->getLevel()->addParticle(new DestroyBlockParticle($sender->asVector3(), Block::get(22)));
		}
        return true;
    }

}