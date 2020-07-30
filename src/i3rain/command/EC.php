<?php

namespace i3rain\command;

use i3rain\Core;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\block\Block;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\plugin\PluginBase;
use pocketmine\tile\EnderChest;
use pocketmine\tile\Tile;
use pocketmine\utils\TextFormat;

class EC extends PluginCommand {

    public function __construct(){
        parent::__construct("ec", Core::getMain());
        $this->setDescription("Öffne die EnderChest");
        $this->setPermission("cmd.ec");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return false;
        if(!$sender->hasPermission($this->getPermission())){
            $sender->sendMessage(Core::NOPERM);
            return false;
        }
        if ($sender->hasPermission("cmd.ec")) {
			$nbt = new CompoundTag("", [new StringTag("id", Tile::CHEST), new StringTag("CustomName", "EnderChest"), new IntTag("x", (int)floor($sender->x)), new IntTag("y", (int)floor($sender->y) - 4), new IntTag("z", (int)floor($sender->z))]);
			$tile = Tile::createTile("EnderChest", $sender->getLevel(), $nbt);
			$block = Block::get(Block::ENDER_CHEST);
			$block->x = (int)$tile->x;
			$block->y = (int)$tile->y;
			$block->z = (int)$tile->z;
			$block->level = $tile->getLevel();
			$block->level->sendBlocks([$sender], [$block]);
			$sender->getEnderChestInventory()->setHolderPosition($tile);
			$sender->addWindow($sender->getEnderChestInventory());
            $sender->sendMessage(Core::PREFIX."§aDu hast deine EC geöffnet");
        }
        return true;
    }

}