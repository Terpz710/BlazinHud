<?php
/**
 *  ____  _            _______ _          _____
 * |  _ \| |          |__   __| |        |  __ \
 * | |_) | | __ _ _______| |  | |__   ___| |  | | _____   __
 * |  _ <| |/ _` |_  / _ \ |  | '_ \ / _ \ |  | |/ _ \ \ / /
 * | |_) | | (_| |/ /  __/ |  | | | |  __/ |__| |  __/\ V /
 * |____/|_|\__,_/___\___|_|  |_| |_|\___|_____/ \___| \_/
 *
 * Copyright (C) 2019 iiFlamiinBlaze
 *
 * iiFlamiinBlaze's plugins are licensed under MIT license!
 * Made by iiFlamiinBlaze for the PocketMine-MP Community!
 *
 * @author iiFlamiinBlaze
 * Twitter: https://twitter.com/iiFlamiinBlaze
 * GitHub: https://github.com/iiFlamiinBlaze
 * Discord: https://discord.gg/znEsFsG
 */
declare(strict_types=1);

namespace iiFlamiinBlaze\BlazinHud;

use pocketmine\player\Player;
use pocketmine\scheduler\Task;

class HudTask extends Task{

	/** @var Player $player */
	protected $player;

	public function __construct(Player $player){
		$this->player = $player;
	}

	public function onRun() : void{
		$hud = BlazinHud::getInstance()->getConfig()->get("hud-message");
		if(isset(BlazinHud::getInstance()->hud[$this->player->getName()])){
			$hud = str_replace([
				"{line}",
				"{max_players}",
				"{online_players}",
				"&",
				"{x}",
				"{y}",
				"{z}",
				"{world}",
				"{tps}",
				"{motd}",
				"{money}",
				"{player}",
			], [
				"\n",
				BlazinHud::getInstance()->getServer()->getMaxPlayers(),
				count(BlazinHud::getInstance()->getServer()->getOnlinePlayers()),
				"§",
				(string)round($this->player->getPosition()->getX()),
				(string)round($this->player->getPosition()->getY()),
				(string)round($this->player->getPosition()->getZ()),
				$this->player->getWorld()->getFolderName(),
				BlazinHud::getInstance()->getServer()->getTicksPerSecond(),
				BlazinHud::getInstance()->getServer()->getMotd(),
				BlazinHud::getInstance()->getServer()->getPluginManager()->getPlugin("EconomyPE")->getInstance->getMoneyPlayer($this->player),
				$this->player->getName()
			], $hud);
			$this->player->sendPopup($hud);
		}
	}
}
