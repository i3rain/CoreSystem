<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;

class Size extends PluginCommand
{

    public function __construct()
    {
        parent::__construct("size", Core::getMain());
        $this->setDescription("Lege deine Größe fest");
        $this->setPermission("cmd.size");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof Player) return false;
        if (!$sender->hasPermission($this->getPermission())) {
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
        if ($sender->hasPermission("cmd.size")) {
            if (count($args[0]) >= 1) {
                if (is_numeric($args[0])) {
                    $sender->setScale($args[0]);
                    $sender->sendMessage(Core::PREFIX . "§aDeine Größe ist nun" . $args[0] . "!");
                }
            }
        }
        return true;
    }
}