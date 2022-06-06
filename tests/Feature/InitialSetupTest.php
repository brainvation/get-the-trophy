<?php

namespace Tests\Feature;

use BotMan\BotMan\BotMan;
use Tests\TestCase;

class InitialSetupTest extends TestCase
{
    protected BotMan $botman;

    public function testHappyFlow()
    {
        $this->bot
            ->receives('Hi')
            ->assertReply(__("conversations/welcome.greeting.new"));
    }
}
