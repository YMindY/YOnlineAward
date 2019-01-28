<?php
namespace yxmingy\OnlineAward\starter;
use pocketmine\Server;
//PHP鐗规�� Trait
trait Starter
{
  protected static $instance;
  //杩欎釜涓�瀹氳鍦ㄤ富绫绘墽琛�
  protected function assignInstance()
  {
    self::$instance=$this;
  }
  public static function getInstance()
  {
    return self::$instance;
  }
  public static function info(string $message):void
  {
    Server::getInstance()->getLogger()->info($message);
  }
  public static function notice(string $message):void
  {
    Server::getInstance()->getLogger()->notice($message);
  }
  public static function warning(string $message):void
  {
    Server::getInstance()->getLogger()->warning($message);
  }
  public static function error(string $message):void
  {
    Server::getInstance()->getLogger()->error($message);
  }
}