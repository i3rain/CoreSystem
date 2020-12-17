<?php

namespace i3rain;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\SimpleCommandMap;
use i3rain\command\Fly;
use i3rain\command\Vanish;
use i3rain\command\GMS;
use i3rain\command\GMC;
use i3rain\command\GMZ;
use i3rain\command\GMA;
use i3rain\command\Feed;
use i3rain\command\Heal;
use i3rain\command\Nachtsicht;
use i3rain\command\Speed;
use i3rain\command\Tag;
use i3rain\command\Nacht;
use i3rain\command\TPAll;
use i3rain\command\ItemID;
use i3rain\command\IClear;
use i3rain\command\EClear;
use i3rain\command\CClear;
use i3rain\command\EC;
use i3rain\command\Hilfe;
use i3rain\command\Info;
use i3rain\command\Moneydrop;
use i3rain\command\Rename;
use i3rain\command\Repair;
use i3rain\command\RepairAll;
use i3rain\command\Sign;
use i3rain\command\Laggs;
use i3rain\world\TPCmd;
use i3rain\world\Welt1;
use i3rain\world\Welt2;
use i3rain\world\Welt3;
use i3rain\world\Welt4;
use i3rain\world\Welt5;
use i3rain\world\Welt6;
use i3rain\world\Welt7;
use i3rain\emote\Emote;
use i3rain\emote\Lachen;
use i3rain\emote\Freuen;
use i3rain\emote\Tanzen;
use i3rain\emote\Traurig;
use i3rain\emote\Wut;
use i3rain\emote\Happy;
use i3rain\emote\Verliebt;
use i3rain\command\Size;


class Core extends PluginBase{
    public const PREFIX = "§0[§6Core§0] §f: §r";
    public const NOPERM = self::PREFIX."§cDu hast keine Berechtigung!";
    public static $Core;
    public $format;
    public $worlds;

    public function onEnable()
    {
        self::$Core = $this;
		date_default_timezone_set("Europe/Berlin");
		$this->format = new Config($this->getDataFolder().'format.yml', Config::YAML);
		$this->format->save();
		$this->worlds = new Config($this->getDataFolder() . "worlds.yml", Config::YAML);
	    $this->worlds->save();
		$this->getServer()->getPluginManager()->registerEvents(new Repair($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new RepairAll($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new Rename($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new Sign($this), $this);
		$this->getServer()->getPluginManager()->registerEvents(new Laggs($this), $this);
        $this->getServer()->getCommandMap()->registerAll("Core",[new Fly(), new Vanish(), new GMS(), new GMC(), new GMZ(), new GMA(), new Heal(), new Feed(), new Nachtsicht(), new Speed(), new Tag(), new Nacht(), new ItemID(), new IClear(), new EC(), new TPAll(), new Welt1($this), new Welt2($this), new Welt3($this), new Welt4($this), new Welt5($this), new Welt6($this), new Welt7($this), new TPCmd($this), new Moneydrop(), new EClear(), new CClear(), new Hilfe(), new Info(), new Emote(), new Lachen(), new Freuen(), new Tanzen(), new Verliebt(), new Traurig(), new Wut(), new Happy(), new Rename($this), new Repair($this), new RepairAll($this), new Sign($this), new Laggs($this), new Size($this)]);
		$economy = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
		if (is_null($economy)){
			$cmdMap = $this->getServer()->getCommandMap();
			$cmd = $cmdMap->getCommand('mdrop');
			if ($cmd instanceof Command){
				$cmdMap->unregister($cmd);
			$this->getLogger()->error(self::PREFIX . "EconomyAPI wird benötigt, daher ist der Moneydrop deaktiviert.");
			}
		}
	}

	public function onLoad(){
		$this->CheckConfig(2.0);
	}

    public static function getMain(): self{
        return self::$Core;
    }

    public function getSign(Player $player, $text){
        $sign = $this->format->get('signtext');
        $sign = str_replace('{text}', $text, $sign);
        $sign = str_replace('{spieler}', $player->getName(), $sign);
        $sign = str_replace('{datum}', (new \DateTime())->format($this->format->get('signtime')), $sign);
        return $sign;
	}
	
	public function CheckConfig($version){
		$formatpath = $this->getDataFolder() . "format.yml";
		$worldpath = $this->getDataFolder() . "worlds.yml";
		if (file_exists($formatpath & $worldpath)) {
			$cfgs = $this->getConfig()->get("version");
			if($cfgs !== $version){
				$this->saveResource("format.yml");
				$this->saveResource("worlds.yml");
			}
		}else {
			$this->saveResource("format.yml");
			$this->saveResource("worlds.yml");
		}
	}
}
