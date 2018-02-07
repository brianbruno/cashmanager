<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 02/02/2018
 * Time: 22:21
 */

namespace App\Http\Controllers;

use Illuminate\Notifications\Notification;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Http\Controllers\Auth\MinhaContaController;

class TelegramNotificationController extends Notification
{

    protected $minhaConta;
    public function __construct() {
        $this->minhaConta = new MinhaContaController();
    }

    public function toTelegram()
    {
        $user_id = $this->minhaConta->getTelegramUserID();


        $response = Telegram::sendMessage([
            'chat_id' => 'CHAT_ID',
            'text' => 'Hello World'
        ]);

        $messageId = $response->getMessageId();

        $response = Telegram::getMe();

        $botId = $response->getId();
        $firstName = $response->getFirstName();
        $username = $response->getUsername();


        $response = Telegram::getUpdates();
        var_dump($response);die;

        /*$response = Telegram::sendMessage([
            'chat_id' => '@brian_bruno',
            'text' => 'Boa porra'
        ]);

        return $response->getMessageId();*/

    }
}