<?php
/*
  Date: 2019.1.1
  Author: xMing
  Editor: Quoda
  Mantra: 新年快乐!
*/
namespace yxmingy\OnlineAward;
class Main extends ListenerManager
{
  const PLUGIN_NAME = "YOnlineAward";
  private $conf;
  public function onLoad()
  {
    self::assignInstance();
    self::info("[".self::PLUGIN_NAME."] is Loading...");
  }
  public function onEnable()
  {
    self::registerListeners();
    self::notice("[".self::PLUGIN_NAME."] is Enabled by xMing!");
  }
  public function onDisable()
  {
    self::warning("[".self::PLUGIN_NAME."] is Turned Off.");
  }
}