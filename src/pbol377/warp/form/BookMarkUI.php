<?php 

namespace pbol377\warp\form;

use pocketmine\form\Form;
use pocketmine\player\Player;
use pbol377\warp\Main;
use pocketmine\world\WorldManager;
use pocketmine\world\Position;

class BookMarkUI implements Form{
    
    public function __construct(private Main $main){
        
    }
    
    public function jsonSerialize() :array{
       
        $buttons = [];
        foreach ($this->main->bm as $key => $val){
            $array = array("text"=>(string)$key);
            array_push($buttons, $array);
        }
        $this->main->al = $buttons;
        $arr = array("text"=>"§l§f[ §a☦ §f] §0북마크 추가 §f[ §a☦ §f]");
        array_push($buttons, $arr);
        $arr = array("text"=>"§l§f[ §a☦ §f] §0북마크 삭제 §f[ §a☦ §f]");
        array_push($buttons, $arr);
        return [
            'type' => 'form',
            'title' => '§l§f[ §a☦ §f] 월드 이동 §f[ §a☦ §f]',
            "content" => "§l이동할 북마크를 선택해주십시오\n\n",
            "buttons" => $buttons,
        ];
    }
    
    public function handleResponse(Player $player, $data) : void{
        if($data === null) return;
        $count = count($this->main->bm);
        if($data === $count){
            $player->sendForm(new BookMarkMakeUI($this->main));
            return;
        }
        if($data === $count + 1){
            $player->sendForm(new BookMarkDelUI($this->main));
            return;
        }
        $this->main->getServer()->getWorldManager()->loadWorld((string)$this->main->bm[$this->main->al[$data]["text"]]['world']);
        $player->teleport(new Position((float)$this->main->bm[$this->main->al[$data]["text"]]['x'], (float)$this->main->bm[$this->main->al[$data]["text"]]['y'], (float)$this->main->bm[$this->main->al[$data]["text"]]['z'],  $this->main->getServer()->getWorldManager()->getWorldByName($this->main->bm[$this->main->al[$data]["text"]]['world'])));
        $player->sendMessage("§l§f[ §a☦ §f] 월드 이동 §l§f[ §a☦ §f] 성공적으로 이동하였습니다. \n[ X ]: ".$this->main->bm[$this->main->al[$data]["text"]]['x']." [ Y ]: ".$this->main->bm[$this->main->al[$data]["text"]]['y']." [ Z ]: ".$this->main->bm[$this->main->al[$data]["text"]]['z']." [ 월드 ]: ".$this->main->bm[$this->main->al[$data]["text"]]['world']);
    }
    
}

?>