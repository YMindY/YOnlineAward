<?php
namespace yxmingy\OnlineAward\task;

use pocketmine\scheduler\Task;
use yxmingy\OnlineAward\Main;
use pocketmine\command\ConsoleCommandSender;

class AwardTask extends Task
{
    private $own;
    public function __construct(Main $own)
    {
        $this->own = $own;
    }
    public function onRun($currentTick)
    {
        foreach ($this->own->getServer()->getOnlinePlayers() as $player){
            foreach ($this->own->conf->get("奖励指令") as $cmd){
                $this->own->getServer()->dispatchCommand(new ConsoleCommandSender(), str_replace("@p", $player->getName(), $cmd));
            }
        }
    }
}

