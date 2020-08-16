<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\plugin\Plugin;
use pocketmine\event\Listener;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\item\Item;
use pocketmine\utils\Config;
use DateInterval;
use DateTime;
use pocketmine\event\player\PlayerJoinEvent;

class Rename extends PluginCommand implements Listener{

	public $plugin;

    public function __construct(Core $plugin){
        parent::__construct("rename", Core::getMain());
        $this->setDescription("Benenne ein Item um");
        $this->setPermission("cmd.rename");
		$this->plugin = $plugin;
    }

    public function onJoin(PlayerJoinEvent $event) {
       $player = $event->getPlayer();
		$config = new Config($this->plugin->getDataFolder().'cooldown.yml', Config::YAML);		
		if($player->hasPermission("cmd.rename")) {
			if (!$config->exists($player->getName() . "Rename")){
				$config->set($player->getName() . "Rename", date('Y-m-d H:i:s'));
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

        if ($item->isNull()) {
            $sender->sendMessage(Core::PREFIX."§cDu musst ein Item in der Hand haben");
            return;
        }
        if (!isset($args[0])) {
            $sender->sendMessage(Core::PREFIX."§cDu musst ein Text eingeben");
            return;
        }
		$config = new Config($this->plugin->getDataFolder().'cooldown.yml', Config::YAML);
		if ($sender->hasPermission("cooldown.bypass")) {	
			$item->setCustomName(implode(" ", $args));
        	$sender->getInventory()->setItemInHand($item);
			$sender->sendMessage(Core::PREFIX."§aDein Item wurde umbennant!");
			return true;
		}elseif ($sender->hasPermission("cmd.rename")) {
			if (!$config->exists($sender->getName() . "Rename")){	
				$config->set($sender->getName() . "Rename", date('Y-m-d H:i:s'));
				$config->save();
			}
			$config = new Config($this->plugin->getDataFolder().'cooldown.yml', Config::YAML);		
			$last = new DateTime($config->get($sender->getName() . "Rename"));
			if (new DateTime("now") > $last) {
        $item->setCustomName(implode(" ", $args));
        $sender->getInventory()->setItemInHand($item);
					$date = new DateTime('+1 day');
					$config->set($sender->getName() . "Rename", $date->format('Y-m-d H:i:s'));
					$config->save();
				$sender->sendMessage(Core::PREFIX."§aDein Item wurde umbennant!");
				$sender->sendMessage(Core::PREFIX. "§cAm §f" . $date->format('Y-m-d H:i:s') . " §ckannst du wieder ein Item umbennenen!");
			}else{
				$sender->sendMessage(
					"§6§cAm§f " . $config->get($sender->getName() . "Rename") . " §ckannst du wieder ein Item umbennenen!"
				);
			}
		}
        return true;
		}
	}