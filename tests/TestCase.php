<?php

namespace Tests;

use BotMan\BotMan\BotMan;
use BotMan\Studio\Testing\BotManTester;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected BotMan $botman;

    protected BotManTester $bot;
}
