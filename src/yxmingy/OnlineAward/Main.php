<?php
/*
  Date: 2019.1.1
  Author: xMing
  Editor: Quoda
  Mantra: 新年快乐!
*/
namespace yxmingy\OnlineAward;

use pocketmine\utils\Config;
use yxmingy\OnlineAward\task\AwardTask;

class Main extends ListenerManager
{
  const PLUGIN_NAME = "YOnlineAward";
  private $conf;
  public function getConf()
  {
      return $this->conf;
  }
  public function onLoad()
  {
    self::assignInstance();
    self::info("[".self::PLUGIN_NAME."] is Loading...");
  }
  public function onEnable()
  {
    self::registerListeners();
    $this->conf = new Config($this->getDataFolder()."/Config.yml",Config::YAML,array(
        5=>["tell @p 你获得了5分钟在线奖励！"],
        10=>["tell @p 你获得了10分钟在线奖励！"],
    ));
    
    $this->getScheduler()->scheduleRepeatingTask(new AwardTask($this), 30);
    self::notice("[".self::PLUGIN_NAME."] is Enabled by xMing!");
  }
  public function onDisable()
  {
    self::warning("[".self::PLUGIN_NAME."] is Turned Off.");
  }
}