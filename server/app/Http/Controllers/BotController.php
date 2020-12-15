<?php

namespace GetTheTrophy\Http\Controllers;

use BotMan\BotMan\BotMan;
use GetTheTrophy\Conversations\WelcomeConversation;
use Illuminate\Routing\Controller as BaseController;

class BotController extends BaseController
{
    public function handle()
    {
        $botman = app('BotMan\BotMan\BotMan');

        $botman->hears('/start|start|hi|hallo|👋|hello|hey|servus|moin', function (BotMan $bot) {
            $bot->startConversation(new WelcomeConversation());
        });

        $botman->hears('/debuginfo', function (BotMan $bot) {
            $bot->reply(print_r($bot->getUser(), true));
            $bot->typesAndWaits(5);
            $bot->reply('Driver: ' . $bot->getDriver()->getName());
        });

        $botman->hears('testsend', function (BotMan $bot) {
            $bot->say(
                "Testsend2 \n to Patrick _Hessinger_ \n <pre>Wie kann das nur sein?</pre>",
                '378557570',
                $bot->loadDriver('Telegram')
            );
        });


        $botman->listen();
    }
}
