<?php

namespace GetTheTrophy\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use GetTheTrophy\Models\User;
use Illuminate\Support\Facades\Auth;

class WelcomeConversation extends Conversation
{
    public function run()
    {
        if (Auth::guest()) {
            $this->welcomeNew();
            $this->getBot()->typesAndWaits(6);
            $this->askPrivacy();
        } else {
            $this->showMenu();
        }
    }

    public function welcomeNew()
    {
        $this->say("Hallo und willkommen bei Hohl den Pokal!
                    \nIch bin ein automatisierter Bot und führe zusammen mit dem Spielleiter durch das Spiel.
                    \n*Hohl den Pokal!* ist ein interaktives Spiel mit deinen Freunden, dass du komplett online oder auch in Teilen im Real Life spielen kannst. 
                    \nIhr spielt gemeinsam in mehreren Spielen gegeneinander, und der beste Spieler hohlt sich am Ende den Pokal. 🏆
                    \nIch hoffe du freust dich genauso sehr auf die nächste Partie wie ich! 🤩");
    }

    public function showMenu()
    {
        //We have to query the database here for the name, as it might have just been changed in this conversation
        $menuText = "Willkommen, " . User::find(Auth::id())->name . "! 👋
                    \nWas möchtest du tun?";
        $question = Question::create($menuText)
            ->addButtons([
                Button::create('Einem Wettbewerb beitreten')->value('/join'),
                Button::create('Einen Wettbewerb starten')->value('/create')
            ]);
        $this->ask($question, function (Answer $answer) {
            $this->say('To be continued...');
        });
    }

    public function askPrivacy()
    {
        $questionText = "Im Rahmen dieses Bots verarbeiten und speichern wir Daten von dir.
                        \nDies ist teilweise technisch notwendig oder dient dem Komfort (z.B. Anzeige deiner Ergebnisse und Namens bei Spielständen).
                        \nKeine Angst, wir verkaufen deine Daten nicht. Wie geben Sie nur an Dritte weiter, wenn es notwendig ist (wie z.B. an die verwendeten Platformen um die Nachrichten/Transaktionen abzuwickeln oder an deine Mitspieler.)
                        \nDu kannst jederzeit deine Daten mit dem Befehl /deleteme löschen.
                        \nDie ausführliche Datenschutzerklärung findest du unter: https://get-the-trophy.bvapps.de/privacy
                        \nStimmst du dem zu?";

        $question = Question::create($questionText)
            ->addButtons([
                Button::create('Ich stimme der Datenverarbeitung zu.')->value('yes'),
                Button::create('Ich stimme nicht zu.')->value('/deleteme')
            ]);

        $this->ask($question, [
            [
                'pattern' => 'yes|yep|ja|ok|okay',
                'callback' => function () {
                    //Great! Let's create user
                    $internalUser = User::create([
                        'external_service'  => $this->getBot()->getDriver()->getName(),
                        'external_id'       => $this->getBot()->getUser()->getId(),
                        'privacy_consent'   => true
                    ]);

                    //And reply
                    $this->say('Großartig! 👍 Dann können wir fortfahren.');
                    $this->getBot()->typesAndWaits(2);
                    $this->askName();
                }
            ],
            [
                'pattern' => 'nah|no|nope|nein|/deleteMe',
                'callback' => function () {
                    $this->say("Schade, dann kannst du diesen Dienst leider nicht nutzen. 😞
                                \nAuf Wiedersehen!
                                \nUm neu zu starten schreibe /start");
                }
            ],
            [
                'pattern' => '.*',
                'callback' => function () {
                    $this->say('Das hab ich leider nicht verstanden. Antworte bitte mit Ja oder Nein.');
                    $this->repeat();
                }
            ]
        ]);
    }

    public function askName()
    {
        //Try to get the UserInfo and build buttons
        $externalUser = $this->getBot()->getUser();

        //Add the info we have as buttons
        $nameButtons = [];
        if (!empty($externalUser)) {
            if (!(empty($externalUser->getFirstName()))) {
                $nameButtons[] = Button::create($externalUser->getFirstName())->value($externalUser->getFirstName());
            }
            if (!(empty($externalUser->getLastName()))) {
                $nameButtons[] = Button::create($externalUser->getLastName())->value($externalUser->getLastName());
            }
            if (!(empty($externalUser->getUsername()))) {
                $nameButtons[] = Button::create($externalUser->getUsername())->value($externalUser->getUsername());
            }
        }

        $questionText = "Wie darf ich dich nennen?
                        \nDiesen Namem verwende ich auch für Spielstände, Menüs und die Kommunikation mit Mitspielern.";

        //Add a Text that buttons are optional
        if (count($nameButtons) > 0) {
            $questionText .= "\nMir wurden da schon ein paar Tipps gegeben. Wähle gerne einfach hier aus oder gib deine eigene Antwort ein.";
        }

        //Build Question with buttons (if any)
        $question = Question::create($questionText)
            ->addButtons($nameButtons);

        $this->ask($question, function (Answer $answer) {
            //Looks like we have to query the user this way
            //as the Auth does not take effect that soon / in the same function...
            /*$internalUser =  $user = User::where([
                'external_service' => $this->getBot()->getDriver()->getName(),
                'external_id' => $this->getBot()->getUser()->getId()
            ])->first();*/
            $internalUser = User::find(Auth::id());

            //Set Name
            $internalUser->name = $answer->getText();
            $internalUser->save();
            $this->showMenu();
        });
    }
}
