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
    private $time = [];
    public function __construct(Main $own)
    {
        $this->own = $own;
        $this->time = array_keys($own->getConf()->getAll());
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
            
            if(in_array($time,$this->time) && (!isset(self::$record[$name]) || self::$record[$name] != $time)){
                self::$record[$name] = $time;
                foreach ($this->own->conf->get($time) as $cmd){
                    $this->own->getServer()->dispatchCommand(new ConsoleCommandSender(), str_replace("@p", $player->getName(), $cmd));
                }
            }
        }
    }
}

