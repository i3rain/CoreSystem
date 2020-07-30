<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\plugin\Plugin;
use pocketmine\event\Listener;
use pocketmine\entity\Creature;
use pocketmine\entity\Human;
use pocketmine\entity\object\ExperienceOrb;
use pocketmine\entity\object\PrimedTNT;
use pocketmine\entity\object\ItemEntity;

class Laggs extends PluginCommand implements Listener {

    public $plugin;

    public function __construct(Core $plugin){
        parent::__construct("laggs", Core::getMain());
        $this->setDescription("Entferne TNT und Items die Laggs verursachen");
        $this->setPermission("cmd.laggs");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
        if ($sender->hasPermission("cmd.laggs")) {
				$items = 0;
				$tnt = 0;
				$all = 0;
				
        foreach($this->plugin->getServer()->getLevels() as $world) {
			foreach($world->getEntities() as $entity) {
                if($entity instanceof ItemEntity) {
                    $items++;
						$all++;
                    $entity->flagForDespawn();
                }
				
		        if($entity instanceof PrimedTNT){
						$tnt++;
						$all++;
						$entity->flagForDespawn(); 
		        }
            }
			}
			if($all > 1){
			$sender->sendMessage(Core::PREFIX. "§aEs wurden §f" .$items. " §aItems und§f " .$tnt. " §aTNT entfernt!");
			}else{
			$sender->sendMessage(Core::PREFIX. "§cEs gab nichts zum entfernen");
			}
		}
     return true;
	}
}