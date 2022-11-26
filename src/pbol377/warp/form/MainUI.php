<?php 

namespace pbol377\warp\form;

use pocketmine\form\Form;
use pocketmine\player\Player;
use pbol377\warp\Main;
use pocketmine\world\WorldManager;

class MainUI implements Form{
    
    public function __construct(private Main $main){
        
    }
    
    public function jsonSerialize() : array{
        $open = opendir("worlds");
        $maps = array();
        if($open) {
            while(($read = readdir($open))) {
                if($read != ".." or $read != "." or $read != "..."){
                    array_push($maps, $read);
                }
            }
        }
        unset($maps[0]);
        unset($maps[1]);
        $buttons = [];
        $this->main->db = [];
        foreach ($maps as $key => $val){
            $array = array("text"=>"§0".(string)$val);
            array_push($buttons, $array);
            array_push($this->main->db, $val);
        }
        $array = array("text"=>"§l§f[ §a☦ §f] §0북마크 §f[ §a☦ §f]");
        array_push($buttons, $array);
        $array = array("text"=>"§l§f[ §a☦ §f] §0나가기 §f[ §a☦ §f]");
        array_push($buttons, $array);
        return [
            'type' => 'form',
            'title' => '§l§f[ §a☦ §f] 월드 이동 §f[ §a☦ §f]',
            "content" => "§l이동할 월드를 선택해주십시오\n\n북마크는 제일 하단에 있습니다\n\n",
            "buttons" => $buttons,
        ];
    }
    
    public function handleResponse(Player $player, $data) : void{
        $count = count($this->main->db);
        if($data === null) {
            return;
        }
        if($data === $count) {
            $player->sendForm(new BookMarkUI($this->main));
            return;
        }
        if($data === $count + 1){
            return;
        }
        $this->main->pl[$player->getName()] = $this->main->db[$data];
        $player->sendForm(new WarpUI($this->main));
    }
    
}

?>