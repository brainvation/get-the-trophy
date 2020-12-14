<?php

namespace GetTheTrophy\Http\Controllers;

use BotMan\BotMan\BotMan;
use GetTheTrophy\Conversations\WelcomeConversation;
use Illuminate\Routing\Controller as BaseController;

class BotController extends BaseController
{
    public function handle()
    {
        $botman = app('botman');

        $botman->hears('/start', function (BotMan $bot) {
            $bot->startConversation(new WelcomeConversation());
        });
        
        

        $botman->listen();
    }
}
