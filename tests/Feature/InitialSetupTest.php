<?php

namespace Tests\Feature;

use BotMan\BotMan\BotMan;
use Tests\TestCase;

class InitialSetupTest extends TestCase
{
    protected BotMan $botman;

    public function testHappyFlow()
    {
        TODO
         $this->bot
            ->receives('Hi')
            ->assertReply('x');
    }
}
