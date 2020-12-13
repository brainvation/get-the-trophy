<?php

namespace GetTheTrophy\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Routing\Controller as BaseController;

class BotController extends BaseController
{
    public function handle()
    {
        $botman = app('botman');
    }
}
