<?php

namespace GetTheTrophy\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;
use GetTheTrophy\Conversations\WelcomeConversation;
use Illuminate\Routing\Controller as BaseController;

class BotController extends BaseController
{
    public function handle()
    {
        $botman = app('BotMan\BotMan\BotMan');

        $botman->hears('/start', function (BotMan $bot) {
            $bot->startConversation(new WelcomeConversation());
        });

        $botman->hears('userinfo', function (BotMan $bot) {
            $bot->reply(print_r($bot->getUser(), true));
            $bot->typesAndWaits(5);
            $bot->reply('Driver: ' . $bot->getDriver()->getName());
        });

        $botman->hears('testsend', function (BotMan $bot) {
            $bot->say(
                "Testsend2 \n to Patrick <b>Hessinger</b> \n <pre>Wie kann das nur sein?</pre>",
                '378557570',
                $bot->loadDriver('Telegram'),
                ['parse_mode' => 'HTML']
            );
        });


        $botman->listen();
    }
}
