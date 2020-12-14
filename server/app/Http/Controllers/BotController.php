<?php

namespace GetTheTrophy\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
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
        
        

        $botman->listen();
    }
}
