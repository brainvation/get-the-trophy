<?php

namespace GetTheTrophy\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class WelcomeConversation extends Conversation
{
    public function run()
    {
        $this->askName();
    }

    public function askName()
    {
        try {
            $user = $this->getBot()->getUser();
        } catch (\Throwable $th) {
            $user = null;
        }

        $question = Question::create('Servus! Und herzlich Willkommen ? Wie darf ich dich nennen?');

        if (!empty($user)) {
            if (!(empty($user->getFirstName()))) {
                $question->addButton(Button::create($user->getFirstName()));
            }
            if (!(empty($user->getUsername()))) {
                $question->addButton(Button::create($user->getUsername()));
            }
        }
        $this->ask($question, function (Answer $answer) {
            $this->say("Hallo" . $answer->getText());
        });
    }
}
