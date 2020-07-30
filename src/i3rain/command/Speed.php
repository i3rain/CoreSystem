<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;

class Speed extends PluginCommand {

    public function __construct(){
        parent::__construct("speed", Core::getMain());
        $this->setDescription("Bewege dich schneller");
        $this->setPermission("cmd.speed");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
        if ($sender->hasPermission("cmd.speed")) {
            $effect = new EffectInstance(Effect::getEffect(1), 3600, 3, false);
            $sender->addEffect($effect);
            $sender->sendMessage(Core::PREFIX."§aDu bewegst dich jetzt 3 Minuten schneller");
        }
        return true;
    }

}