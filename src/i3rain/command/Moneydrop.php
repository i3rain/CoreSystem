<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;
use onebone\economyapi\EconomyAPI;

class Moneydrop extends PluginCommand {

    public function __construct(){
        parent::__construct("mdrop", Core::getMain());
        $this->setDescription("Mache einen Moneydrop");
        $this->setPermission("cmd.money");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
        	if (!isset($args[0])) {
            $sender->sendMessage(Core::PREFIX."§cDu musst eine Zahl eingeben");
            return;
        }
        if ($sender->hasPermission("cmd.money")) {
				$from = $sender->getName();
				$zahl = $args[0];
				foreach ($sender->getServer()->getOnlinePlayers() as $player) {
                   EconomyAPI::getInstance()->addMoney($player, $zahl);
           	   $player->sendMessage(Core::PREFIX."§aDu hast §f" .$zahl. "$ §aerhalten von einem Moneydrop!");
        	}
					$sender->getServer()->broadcastMessage(Core::PREFIX."§f" .$from. "§a hat einen §f" .$zahl. "$ §aMoneydrop gemacht");
		}
        return true;
    }
}
