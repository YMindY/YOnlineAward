<?php
namespace yxmingy\OnlineAward\task;

use pocketmine\scheduler\Task;
use yxmingy\OnlineAward\Main;
use yxmingy\OnlineAward\OnlinePlayerRecord;

class PopupTask extends Task
{
    private $own;
    public function __construct(Main $own)
    {
        $this->own = $own;
    }
    public function onRun($currentTick)
    {
        foreach ($this->own->getServer()->getOnlinePlayers() as $player){
            $player->sendPopup("已在线: ".OnlinePlayerRecord::getOnlineTime($player->getName())."分钟");
        }
    }
}

