<?php
namespace pbol377\warp;

use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerJoinEvent;

use pbol377\warp\command\WarpCommand;

class Main extends PluginBase implements Listener{
    
    protected function onEnable() : void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getCommandMap()->register('월드', new WarpCommand($this));
        $this->data = new Config($this->getDataFolder() . "data.yml", Config::YAML, []);
        $this->db = $this->data->getAll();
        $this->db = [];
        $this->pla = new Config($this->getDataFolder() . "player.yml", Config::YAML, []);
        $this->pl = $this->pla->getAll();
        $this->bookmark = new Config($this->getDataFolder() . "bookmark.yml", Config::YAML, []);
        $this->bm = $this->bookmark->getAll();
        if(!isset($this->bm))$this->bm = [];
        $this->all = new Config($this->getDataFolder() . "all.yml", Config::YAML, []);
        $this->al = $this->all->getAll();
    }
    
    protected function onDisable():void {
        $this->bookmark->setAll($this->bm);
        $this->bookmark->save();
    }
    
    public function onJoin(PlayerJoinEvent $event){
        if($this->getServer()->isOp($event->getPlayer()->getName())){
            $event->getPlayer()->sendMessage ("§l§f[ §a☦ §f] 월드 이동 §f[ §a☦ §f] 본 서버는 §bpbol377§f의 월드 이동 플러그인을 사용하고 있습니다.");
        }
    }
    
}
?>