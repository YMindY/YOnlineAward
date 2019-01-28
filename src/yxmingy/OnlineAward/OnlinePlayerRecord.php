<?php
namespace yxmingy\OnlineAward;

date_default_timezone_set('PRC');

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class OnlinePlayerRecord implements Listener
{
    private static $record = [];
    /* Unit: minute */
    public static function getOnlineTime(string $player):int
    {
        if(empty($time=self::getOnlineTime($player))) return 0;
        return (int)$time/60;
    }
    private static function getRecord(string $player):array
    {
        return isset(self::$record[$player]) ? self::$record[$player] : array();
    }
    public function onPlayerJoin(PlayerJoinEvent $event):void
    {
        self::$record[$event->getPlayer()->getName()] = time();
    }
    public function onPlayerQuit(PlayerQuitEvent $event):void
    {
        unset(self::$record[$event->getPlayer()->getName()]);
    }
}

