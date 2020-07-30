<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\plugin\Plugin;
use pocketmine\item\Item;
use pocketmine\item\Armor;
use pocketmine\item\Tool;
use pocketmine\utils\Config;
use DateInterval;
use DateTime;
use pocketmine\event\player\PlayerJoinEvent;

class Repair extends Command implements Listener{

	public $plugin;

    public function __construct(Core $plugin){
        parent::__construct("repair");
        $this->setDescription("Repariere ein Item");
		$this->usageMessage = "/repair";
        $this->setPermission("cmd.repair");
		$this->plugin = $plugin;
    }

	public function Repairable(Item $item): bool{
		return $item instanceof Tool || $item instanceof Armor;
	}

    public function onJoin(PlayerJoinEvent $event) {
       $player = $event->getPlayer();
		$config = new Config($this->plugin->getDataFolder().'cooldown.yml', Config::YAML);		
		if($player->hasPermission("cmd.repair")) {
			if (!$config->exists($player->getName() . "Repair")){
				$config->set($player->getName() . "Repair", date('Y-m-d H:i:s'));
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
			
		if(!$this->Repairable($item)){
			$sender->sendMessage(Core::PREFIX. "§cDas Item kann nicht repariert werden");
			return true;
		}
		if (!$item->getDamage() > 0) 
		{
			$sender->sendMessage(Core::PREFIX. "§cDas Item hat keinen Schaden");
			return true;
		}
		$config = new Config($this->plugin->getDataFolder().'cooldown.yml', Config::YAML);		
		if ($sender->hasPermission("cmd.repair")) {
			if (!$config->exists($sender->getName() . "Repair")){	
				$config->set($sender->getName() . "Repair", date('Y-m-d H:i:s'));
				$config->save();
			}
			$config = new Config($this->plugin->getDataFolder().'cooldown.yml', Config::YAML);		
			$last = new DateTime($config->get($sender->getName() . "Repair"));
			if (new DateTime("now") > $last) {
				if($item->getDamage() > 0){
					$sender->getInventory()->setItem($info, $item->setDamage(0));
					$date = new DateTime('+1 day');
					$config->set($sender->getName() . "Repair", $date->format('Y-m-d H:i:s'));
					$config->save();					$sender->sendMessage(Core::PREFIX."§aDein Item wurde Repariert");
				$sender->sendMessage(Core::PREFIX. "§cAm §f" . $config->get($sender->getName() . "Repair") . " §ckannst du wieder ein Item reparieren!");
			}else{
				$sender->sendMessage(
					"§6§cAm§f " . $config->get($sender->getName() . "Repair") . " §ckannst du wieder ein Item reparieren!");
			}
		}
		return true;
		}
	}
} 