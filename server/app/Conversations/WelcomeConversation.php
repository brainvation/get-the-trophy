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
        //Try to get the UserInfo and build buttons
        $user = $this->getBot()->getUser();

        //Add the info we have as buttons
        $nameButtons = [];
        if (!empty($user)) {
            if (!(empty($user->getFirstName()))) {
                $nameButtons[] = Button::create($user->getFirstName())->value($user->getFirstName());
            }
            if (!(empty($user->getUsername()))) {
                $nameButtons[] = Button::create($user->getUsername())->value($user->getUsername());
            }
        } else {
            $this->say("Leider konnte ich dir keine eindeutige ID zuordnen. Bitte versuche es erneut.");
            return;
        }

        $questionText = 'Wie darf ich dich nennen?';

        //Add a Text that buttons are optional
        if (count($nameButtons) > 0) {
            $questionText .= "\n Wähle aus den unteren Vorschlägen aus oder gib deine eigene Antwort ein.";
        }

        //Build Question with buttons (if any)
        $question = Question::create($questionText)
            ->addButtons($nameButtons);

        $this->ask($question, function (Answer $answer) {
            $this->say("Hallo " . $answer->getText());
        });
    }
}
