<?php

namespace GetTheTrophy\Http\Controllers;

use BotMan\BotMan\BotMan;
use Exception;
use GetTheTrophy\Conversations\WelcomeConversation;
use GetTheTrophy\Models\User;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class BotController extends BaseController
{
    public function handle()
    {
        $botman = app('BotMan\BotMan\BotMan');

        //First try a user authentication
        $botman->hears('.*', function (BotMan $bot) {
            $this->userAuth($bot);
        });

        //If that did not work -> go to Welcome Conversation
        if (Auth::guest()) {
            $botman->hears('.*', function (BotMan $bot) {
                $bot->startConversation(new WelcomeConversation());
            });
        } else {
            //If the user has a session, process the commands
            $this->processCommands($botman);
        }

        $botman->listen();
    }

    protected function processCommands(BotMan $botman)
    {
        $botman->hears('/start|start|hi|hallo|👋|hello|hey|servus|moin', function (BotMan $bot) {
            $bot->startConversation(new WelcomeConversation());
        });

        $botman->hears('/debuginfo', function (BotMan $bot) {
            $debuginfo =
                'User Info: ' . print_r($bot->getUser(), true)
                . '\nDriver: ' . $bot->getDriver()->getName();
            $bot->reply($debuginfo);
        });

        $botman->hears('testsend', function (BotMan $bot) {
            $bot->say(
                "Testsend2 \n to Patrick _Hessinger_ \n <pre>Wie kann das nur sein?</pre>",
                '378557570',
                $bot->loadDriver('Telegram')
            );
        });
    }

    protected function userAuth(BotMan $botman)
    {

        //Try to get the UserInfo
        $botUser = $botman->getUser();
        //If we got none, something is seriously wrong
        if (empty($botUser)) {
            $botman->reply("Leider konnte ich dir keine eindeutige ID zuordnen. 
                \nBitte prüfen die dem Bot erteilten Berechtigungen und versuche es erneut.");
            throw new Exception;
        }

        //If the user has no session...
        if (Auth::guest()) {
            //See if we can find them in the database
            $user = User::where([
                'external_service' => $botman->getDriver()->getName(),
                'external_id' => $botUser->getId()
            ])->first();
            //If we did, log them in
            if ($user) {
                Auth::login($user);
            }
        }
    }
}
