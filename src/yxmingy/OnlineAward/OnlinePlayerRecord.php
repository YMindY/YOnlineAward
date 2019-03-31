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
        if(!isset(self::$record[$name]) || self::$date[$name] != date("j")) {
            self::$record[$name] = time();
            self::$date[$name] = date("j");
            task\AwardTask::delRecord($name);
        }
        if(self::$record[$name] < 0) {
            self::$record[$name] += time();
        }
    }
    public function onPlayerQuit(PlayerQuitEvent $event):void
    {
        $name = $event->getPlayer()->getName();
        self::$record[$name] = self::$record[$name]-time();
        if(self::$date[$name] != date("j")) {
            unset(self::$record[$name]);
            task\AwardTask::delRecord($name);
        }
    }
}