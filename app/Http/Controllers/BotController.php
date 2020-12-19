<?php

namespace GetTheTrophy\Http\Controllers;

use BotMan\BotMan\BotMan;
use GetTheTrophy\Conversations\WelcomeConversation;
use GetTheTrophy\Models\User;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BotController extends BaseController
{
    public function handle()
    {
        $botman = app('BotMan\BotMan\BotMan');

        //Exception Handling
        $botman->exception(Exception::class, function ($exception, $bot) {
            $bot->reply(__('main.commands.unknown', ['exception' => print_r($exception, true)]));
        });

        //Global Stop Commands
        $botman->hears('/stop|/start|/deleteme', function (BotMan $bot) {
            //empty, as it will be processed later
        })->stopsConversation();
        //Global Skip Commands
        $botman->hears('/debuginfo', function (BotMan $bot) {
            //empty as it will be processed later
        })->skipsConversation();

        //Here we react to everything and route later...
        $botman->hears('(.*)', function (BotMan $bot, string $message) {
            //Check if we know the user
            if (Auth::check()) {
                //If the user has a session, process the commands
                $this->processCommands($bot, $message);
            } else {
                //If not -> go to Welcome Conversation
                $bot->startConversation(new WelcomeConversation());
            }
        });

        $botman->listen();
    }

    protected function processCommands(BotMan $bot, string $message)
    {
        $messageLower = Str::lower($message);
        if ($messageLower == "/deleteme") {
            User::destroy(Auth::id());
            $bot->reply(__('main.commands.deleteme.success'));
        } elseif ($messageLower == '/stop') {
            $bot->reply(__('main.commands.stop.answer'));
        } elseif ($messageLower == "/debuginfo") {
            $debuginfo = print_r($bot->getUser(), true);
            $bot->reply($debuginfo);
        } elseif (
            preg_match(__('main.commands.start.pattern'), $messageLower)
            || preg_match(__('main.commands.settings.pattern'), $messageLower)
        ) {
            $bot->startConversation(new WelcomeConversation());
        } else {
            $bot->reply(__('main.commands.unknown'));
        }
        /*
        $botman->hears('testsend', function (BotMan $bot) {
            $bot->say(
                "Testsend2 \n to Patrick _Hessinger_ \n <pre>Wie kann das nur sein?</pre>",
                '378557570',
                $bot->loadDriver('Telegram')
            );
        }); */
    }
}