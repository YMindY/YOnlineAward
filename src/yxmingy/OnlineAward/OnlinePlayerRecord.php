<?php
namespace yxmingy\OnlineAward;

date_default_timezone_set('PRC');

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class OnlinePlayerRecord implements Listener
{
    private static $date = [];
    private static $record = [];
    
    /* Unit: minute */
    public static function getOnlineTime(string $player):int
    {
        if(($time=self::getRecord($player)) == 0) return 0;
        return (int)((time()-$time)/60);
    }
    private static function getRecord(string $player):int
    {
        return isset(self::$record[$player]) ? self::$record[$player] : 0;
    }
    public function onPlayerJoin(PlayerJoinEvent $event):void
    {
        $name = $event->getPlayer()->getName();
        if(!isset(self::$record[$name]) || self::$date[$name] != time("j")) {
            self::$record[$name] = time();
            self::$date[$name] = time("j");
        }
    }
    public function onPlayerQuit(PlayerQuitEvent $event):void
    {
        $name = $event->getPlayer()->getName();
        if(self::$date[$name] != time("j")) {
            unset(self::$record[$name]);
        task\AwardTask::delRecord($name);
        }
    }
}