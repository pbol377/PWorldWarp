<?php 

namespace pbol377\warp\form;

use pocketmine\form\Form;
use pocketmine\player\Player;
use pbol377\warp\Main;
use pocketmine\world\WorldManager;
use pocketmine\world\Position;

class BookMarkDelUI implements Form{
    public function __construct(private Main $main){
        
    }
    
    public function jsonSerialize() :array{
        $buttons = [];
        foreach ($this->main->bm as $key => $val){
            $array = array("text"=>(string)$key);
            array_push($buttons, $array);
        }
        $this->main->al = $buttons;
        $arr = array("text"=>"§l§f[ §a☦ §f] §0돌아가기 §f[ §a☦ §f]");
        array_push($buttons, $arr);
        
        return [
            'type' => 'form',
            'title' => '§l§f[ §a☦ §f] 월드 이동 §f[ §a☦ §f]',
            "content" => "§l삭제할 북마크를 선택해주십시오\n\n",
            "buttons" => $buttons,
        ];
        
    }
    
    public function handleResponse(Player $player, $data) : void{
        if($data === null) return;
        $count = count($this->main->bm);
        if($data === $count){
            $player->sendForm(new BookMarkUI($this->main));
            return;
        }
        unset($this->main->bm[$this->main->al[$data]["text"]]);
        $player->sendForm(new BookMarkUI($this->main));
        return;
    }
    
}
    
    