<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\plugin\Plugin;
use pocketmine\item\Item;
use pocketmine\item\Armor;
use pocketmine\item\Tool;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use DateInterval;
use DateTime;
use pocketmine\event\player\PlayerJoinEvent;


class RepairAll extends PluginCommand implements Listener{

	 public $plugin;

    public function __construct(Core $plugin){
        parent::__construct("repairall", Core::getMain());
        $this->setDescription("Repariere alle Items");
        $this->setPermission("cmd.repairall");
		 $this->plugin = $plugin;
    }

	public function Repairable(Item $item): bool{
		return $item instanceof Tool || $item instanceof Armor;
	}

    public function onJoin(PlayerJoinEvent $event) {
       $player = $event->getPlayer();
		$config = new Config($this->plugin->getDataFolder().'cooldown.yml', Config::YAML);		
		if($player->hasPermission("cmd.repairall")) {
			if (!$config->exists($player->getName() . "RepairAll")){
				$config->set($player->getName() . "RepairAll", date('Y-m-d H:i:s'));
				$config->save();
			}
		}
	}

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }

			$info = $sender->getInventory()->getHeldItemIndex();
			$item = $sender->getInventory()->getItem($info);
			$config = new Config($this->plugin->getDataFolder().'cooldown.yml', Config::YAML);		
			if ($sender->hasPermission("cooldown.bypass")) {
				foreach($sender->getInventory()->getContents() as $info => $item){
					if($this->Repairable($item)){
						if($item->getDamage() > 0){
							$sender->getInventory()->setItem($info, $item->setDamage(0));
						}
					}
				}
				foreach($sender->getArmorInventory()->getContents() as $info => $item){
					if($this->Repairable($item)){
						if($item->getDamage() > 0){
							$sender->getArmorInventory()->setItem($info, $item->setDamage(0));
							}
						}
					}
				$sender->sendMessage(Core::PREFIX."§aDeine ganzen Items wurden Repariert");
				return true;
			}		
			if ($sender->hasPermission("cmd.repairall")) {
			if (!$config->exists($sender->getName() . "RepairAll")){	
				$config->set($sender->getName() . "RepairAll", date('Y-m-d H:i:s'));
				$config->save();
			}
			$config = new Config($this->plugin->getDataFolder().'cooldown.yml', Config::YAML);		
			$last = new DateTime($config->get($sender->getName() . "RepairAll"));
			if (new DateTime("now") > $last) {
			foreach($sender->getInventory()->getContents() as $info => $item){
				if($this->Repairable($item)){
					if($item->getDamage() > 0){
						$sender->getInventory()->setItem($info, $item->setDamage(0));
					}
				}
			}
			foreach($sender->getArmorInventory()->getContents() as $info => $item){
				if($this->Repairable($item)){
					if($item->getDamage() > 0){
						$sender->getArmorInventory()->setItem($info, $item->setDamage(0));
						}
					}
				}
					$date = new DateTime('+1 day');
					$config->set($sender->getName() . "RepairAll", $date->format('Y-m-d H:i:s'));
					$config->save();
				$sender->sendMessage(Core::PREFIX."§aDeine ganzen Items wurden Repariert");
				$sender->sendMessage(Core::PREFIX. "§cAm §f" . $date->format('Y-m-d H:i:s') . " §ckannst du wieder alle Items reparieren!");
			}else{
				$sender->sendMessage(
					"§6§cAm§f " . $config->get($sender->getName() . "RepairAll") . " §ckannst du wieder alle Items reparieren!"
				);
			}
		}
		return true;
		}
	}