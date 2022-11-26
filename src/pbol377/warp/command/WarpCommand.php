<?php
namespace pbol377\warp\command;

use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pbol377\warp\Main;
use pbol377\warp\form\MainUI;

class WarpCommand extends Command{
    
    public function __construct(private Main $main){
        parent::__construct('월드', 'made by pbol377');
        $this->setPermission('pbol.warp');
    }
    
    public function execute(Commandsender $sender, string $label, array $args) : bool{
        $name = $sender->getName();
        if (!$sender instanceof Player) {
            $sender->sendMessage("§c§lProhibited in Console");
            return true;
        }
        if($this->main->getServer()->isOp($name)){
            $sender->sendForm(new MainUI($this->main));
        }
        return true;
    }

}

