<?php 

namespace pbol377\warp\form;

use pocketmine\form\Form;
use pocketmine\player\Player;
use pbol377\warp\Main;
use pocketmine\world\WorldManager;
use pocketmine\world\Position;

class BookMarkMakeUI implements Form{
    
    public function __construct(private Main $main){
        
    }
    
    public function jsonSerialize() :array{
        return [
            'type'  =>  'custom_form',
            'title'  =>  '§l§f[ §a☦ §f] 월드 이동 §l§f[ §a☦ §f]',
            'content'  =>  [
                [
                    'type'  =>  'dropdown',
                    'text'  =>   '§l 월드를 선택해주세요 ',
                    'options' => $this->main->db,
                ],
                [
                    'type'  =>  'input',
                    'text'  =>  '§l X좌표 ',
                    'default' => "0",
                ],
                [
                    'type'  =>  'input',
                    'text'  =>  '§l Y좌표 ',
                    'default' => "0",
                    
                ],
                [
                    'type'  =>  'input',
                    'text'  =>  '§l Z좌표 ',
                    'default' => "0",
                ],
                [
                    'type'  =>  'input',
                    'text'  =>  '§l 북마크 이름 ',
                    'default' => "이름을 입력해주세요",
                ],
            ]
        ];
    }
    
    public function handleResponse(Player $player, $data) : void{
        if($data === null) return;
        $this->main->bm[$data[4]] = [
            'x'=> $data[1],
            'y'=> $data[2],
            'z'=> $data[3],
            'world'=> $this->main->db[$data[0]],
        ];
        $player->sendForm(new BookMarkUI($this->main));
        return;
    }
    
}

?>