<?php

declare(strict_types=1);

namespace Ken_Cir\OutiServerSensouPlugin\Forms\Admin\ScheduleMessage;

use Ken_Cir\OutiServerSensouPlugin\Database\ScheduleMessageData\ScheduleMessageDataManager;
use Ken_Cir\OutiServerSensouPlugin\Forms\Admin\AdminForm;
use pocketmine\player\Player;
use Vecnavium\FormsUI\SimpleForm;

class ScheduleMessageManagerForm
{
    public function __construct()
    {
    }

    public function execute(Player $player): void
    {
        $scheduleMessages = ScheduleMessageDataManager::getInstance()->getAll();
        $form = new SimpleForm(function (Player $player, $data) use ($scheduleMessages) {
            if ($data === null) return true;
            elseif ($data === 0) {
                $form = new AdminForm();
                $form->execute($player);
            }
            elseif ($data === 1) {
                $form = new ScheduleMessageAddForm();
                $form->execute($player);
            }
            else {
                $form = new ScheduleMessageEditForm();
                $form->execute($player, $scheduleMessages[$data - 2]);
            }

            return true;
        });

        $form->setTitle("定期メッセージの管理");
        $form->addButton("戻る");
        $form->addButton("追加");
        foreach ($scheduleMessages as $scheduleMessage) {
            $form->addButton($scheduleMessage->getContent());
        }
        $player->sendForm($form);
    }
}