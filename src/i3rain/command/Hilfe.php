<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;

class Hilfe extends PluginCommand {

    public function __construct(){
        parent::__construct("chelp", Core::getMain());
        $this->setDescription("Zeige alle Befehle an");
        $this->setPermission("cmd.help");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
        if ($sender->hasPermission("cmd.help")) {
              $sender->sendMessage(Core::PREFIX."§aHier sind alle unseres Systems:

§f- Teleport System §a(/tphelp)
§f- EnderChest §a(/ec)
§f- Heal §a(/heal)
§f- Feed §a(/feed)
§f- Fly §a(/fly)
§f- Nachtsicht §a(/nachtsicht)
§f- Speed §a(/speed)
§f- ItemID §a(/id)
§f- Tag und Nacht §a(/tag, /nacht)
§f- TPAll §a(/tpall)
§f- Moneydrop §a(/mdrop)
§f- Effekte clearen §a(/eclear)
§f- Chat clearen §a(/cclear)
§f- ClearInventar §a(/iclear)
§f- Repair §a(/repair)
§f- RepairAll §a(/repairall)
§f- Signieren §a(/sign {text})
§f- Rename §a(/rename {text})
§f- Informationen §a(/cinfo)");
        }
        return true;
    }

}