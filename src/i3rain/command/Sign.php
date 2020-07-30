<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;
use onebone\economyapi\EconomyAPI;
use pocketmine\item\Item;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\event\Listener;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;
use DateInterval;
use DateTime;
use pocketmine\event\player\PlayerJoinEvent;

class Sign extends PluginCommand implements Listener {

	public $plugin;

    public function __construct(Core $plugin){
        parent::__construct("sign", Core::getMain());
        $this->setDescription("Signiere ein Item");
        $this->setPermission("cmd.sign");
		 $this->plugin = $plugin;
    }

    public function onJoin(PlayerJoinEvent $event) {
       $player = $event->getPlayer();
		$config = new Config($this->plugin->getDataFolder().'cooldown.yml', Config::YAML);
		if($player->hasPermission("cmd.sign")) {
			if (!$config->exists($player->getName() . "Sign")){
				$config->set($player->getName() . "Sign", date('Y-m-d H:i:s'));
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

 		  $item = $sender->getInventory()->getItemInHand();

        if($item->isNull()){
            $sender->sendMessage(Core::PREFIX. "§cDu hast kein Item in der Hand!");
            return true;
        }

        if(!isset($args[0])){
            $sender->sendMessage(Core::PREFIX. "§cDu musst einen Text eingeben!");
            return true;
        }

			$config = new Config($this->plugin->getDataFolder().'cooldown.yml', Config::YAML);
			
        if ($sender->hasPermission("cmd.sign")) {
			if (!$config->exists($sender->getName() . "Sign")){	
				$config->set($sender->getName() . "Sign", date('Y-m-d H:i:s'));
				$config->save();
			}
			$config = new Config($this->plugin->getDataFolder().'cooldown.yml', Config::YAML);
			$last = new DateTime($config->get($sender->getName() . "Sign"));
			if (new DateTime("now") > $last) {
        $inv = $sender->getInventory()->getItemInHand();
        $inv->setLore([$this->plugin->getSign($sender, implode(' ', $args))]);
        $sender->getInventory()->setItemInHand($inv);
					$date = new DateTime('+1 day');
					$config->set($sender->getName() . "Sign", $date->format('Y-m-d H:i:s'));
					$config->save();
				$sender->sendMessage(Core::PREFIX."§aDein Item wurde signiert!");
				$sender->sendMessage(Core::PREFIX. "§cAm §f" . $date->format('Y-m-d H:i:s') . " §ckannst du wieder ein Item signieren!");
			}else{
				$sender->sendMessage(
					"§6§cAm§f " . $config->get($sender->getName() . "Sign") . " §ckannst du wieder ein Item signieren!");
		  }
		}
		return true;
	}
}