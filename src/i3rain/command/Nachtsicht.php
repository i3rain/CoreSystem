<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;

class Nachtsicht extends PluginCommand {

    public function __construct(){
        parent::__construct("nachtsicht", Core::getMain());
        $this->setDescription("Sehe im Dunkeln");
        $this->setPermission("cmd.ns");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
        if ($sender->hasPermission("cmd.ns")) {
            $effect = new EffectInstance(Effect::getEffect(16), 3600, 3, false);
            $sender->addEffect($effect);
            $sender->sendMessage(Core::PREFIX."§aDu kannst jetzt 3 Minuten im Dunkeln sehen");
        }
        return true;
    }

}