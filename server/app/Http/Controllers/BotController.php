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

        $botman->hears('/start', function (BotMan $bot) {
            $bot->startConversation(new WelcomeConversation());
        });

        $botman->hears('userinfo', function (BotMan $bot) {
            $bot->reply(print_r($bot->getUser(), true));
            $bot->reply('Driver: ' . $bot->getDriver()->getName());
        });

        $botman->listen();
    }
}
