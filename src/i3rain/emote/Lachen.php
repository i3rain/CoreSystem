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

class Lachen extends PluginCommand {

    public function __construct(){
       parent::__construct("lachen", Core::getMain());
        $this->setDescription("Zeige das Du lachst");
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
                    $sender->getServer()->broadcastMessage("§f".$name. "§b lacht ...");
                    $sender->getLevel()->addParticle(new DestroyBlockParticle($sender->asVector3(), Block::get(41)));
		}
        return true;
    }

}