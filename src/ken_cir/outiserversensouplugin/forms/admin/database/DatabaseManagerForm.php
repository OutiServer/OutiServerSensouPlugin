<?php

declare(strict_types=1);

namespace ken_cir\outiserversensouplugin\forms\admin\database;

use Error;
use Exception;
use jojoe77777\FormAPI\SimpleForm;
use ken_cir\outiserversensouplugin\forms\admin\AdminForm;
use ken_cir\outiserversensouplugin\Main;
use pocketmine\player\Player;

class DatabaseManagerForm
{
    public function __construct()
    {
    }

    public function execute(Player $player): void
    {
        try {
            $form = new SimpleForm(function (Player $player, $data) {
                try {
                    if ($data === 0) {
                        (new AdminForm())->execute($player);
                    }
                    elseif ($data === 1) {
                        (new PlayerForm())->execute($player);
                    }
                }
                catch (Error|Exception $exception) {
                    Main::getInstance()->getOutiServerLogger()->error($exception, true, $player);
                }
            });

            $form->setTitle("データベース管理");
            $form->addButton("キャンセルして戻る");
            $form->addButton("プレイヤーデータ");
            $player->sendForm($form);
        }
        catch (Error|Exception $exception) {
            Main::getInstance()->getOutiServerLogger()->error($exception, true, $player);
        }
    }
}