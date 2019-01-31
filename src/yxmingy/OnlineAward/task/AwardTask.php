<?php
namespace yxmingy\OnlineAward\task;

use pocketmine\scheduler\Task;
use yxmingy\OnlineAward\Main;
use yxmingy\OnlineAward\OnlinePlayerRecord;
use pocketmine\command\ConsoleCommandSender;

class AwardTask extends Task
{
    private $own;
    private static $record = [];
    private $time;
    public function __construct(Main $own)
    {
        $this->own = $own;
        $this->time = $own->getConfig()->get("奖励时间");
    }
    public static function delRecord(string $name):void
    {
        if(isset(self::$record[$name])) unset(self::$record[$name]);
    }
    public function onRun($currentTick)
    {
        foreach ($this->own->getServer()->getOnlinePlayers() as $player){
            $name = $player->getName();
            $time = OnlinePlayerRecord::getOnlineTime($name);
            $player->sendPopup("已在线: ".$time."分钟");
            //如果存在这个家伙的领奖记录或现时-记录时间>=奖励时间
            if(!isset(self::$record[$name]) || ($time-(self::$record[$name])) >= $this->time){
                self::$record[$name] = $time;
                foreach ($this->own->conf->get("奖励指令") as $cmd){
                    $this->own->getServer()->dispatchCommand(new ConsoleCommandSender(), str_replace("@p", $player->getName(), $cmd));
                }
            }
        }
    }
}

