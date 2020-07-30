<?php

namespace i3rain\emote;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;

class Emote extends PluginCommand {

    public function __construct(){
       parent::__construct("emotes", Core::getMain());
        $this->setDescription("Zeige alle Emotes");
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
            $sender->sendMessage(Core::PREFIX."§aDies sind unsere Emotes:
§f/lachen
§f/freuen
§f/tanzen
§f/verliebt
§f/überrascht
§f/wütend
§f/traurig");
		}
        return true;
    }

}