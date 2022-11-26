<?php 

namespace pbol377\warp\form;

use pocketmine\form\Form;
use pocketmine\player\Player;
use pbol377\warp\Main;
use pocketmine\world\WorldManager;
use pocketmine\world\Position;

class WarpUI implements Form{
    
    public function __construct(private Main $main){
        
    }
    
    public function jsonSerialize() :array{
        return [
            'type'  =>  'custom_form',
            'title'  =>  '§l§f[ §a☦ §f] 월드 이동 §l§f[ §a☦ §f]',
            'content'  =>  [
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
            ]
        ];
    }
        
    public function handleResponse(Player $player, $data) : void{
        if($data === null) return;
        $this->main->getServer()->getWorldManager()->loadWorld($this->main->pl[$player->getName()]);
        $player->teleport(new Position((float)$data[0], (float)$data[1], (float)$data[2],  $this->main->getServer()->getWorldManager()->getWorldByName($this->main->pl[$player->getName()])));
        $player->sendMessage("§l§f[ §a☦ §f] 월드 이동 §l§f[ §a☦ §f] 성공적으로 이동하였습니다. \n[ X ]: {$data[0]} [ Y ]: {$data[1]} [ Z ]: {$data[2]} [ 월드 ]: ".$this->main->pl[$player->getName()]);
    }
    
}