<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\level\Position;
use pocketmine\Server;

class TPAll extends PluginCommand {

    public function __construct(){
        parent::__construct("tpall", Core::getMain());
        $this->setDescription("Teleportiere alle Spieler");
        $this->setPermission("cmd.tp");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
        if ($sender->hasPermission("cmd.tp")) {
            foreach ($sender->getServer()->getOnlinePlayers() as $player) {
            $player->teleport($sender);
			}
			  $sender->sendMessage(Core::PREFIX."§aDu hast alle Spieler teleportiert");
        }
        return true;
    }

}