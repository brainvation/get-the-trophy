<?php

namespace GetTheTrophy\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use GetTheTrophy\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WelcomeConversation extends Conversation
{
    public function run()
    {
        if (Auth::guest()) {
            //Initial Setup for new users
            $this->welcomeNew();
            $this->getBot()->typesAndWaits(6);
            $this->askPrivacy();
        } elseif (preg_match(
            __('main.commands.settings.pattern'),
            Str::lower($this->getBot()->getMessage()->getText())
        )) {
            //Change Settings?
            $this->askName();
        } else {
            //In any other case, just show menu
            $this->showMenu();
        }
    }

    public function welcomeNew()
    {
        $this->say(__("conversations/welcome.greeting.new"));
    }

    public function showMenu()
    {
        //We have to query the database here for the name, as it might have just been changed in this conversation
        $menuText = __(
            "conversations/welcome.greeting.known",
            ['name' => User::find(Auth::id())->name]
        ) . PHP_EOL . __("conversations/welcome.menu.selection_prompt");
        $question = Question::create($menuText)
            ->addButtons([
                Button::create(__('main.commands.join.buttonText'))->value('/join'),
                Button::create(__('main.commands.create.buttonText'))->value('/create'),
            ]);
        //No ask, as this is the main menu and we can process the answer any time
        $this->say($question);
    }

    public function askPrivacy()
    {
        $questionText = __("conversations/welcome.privacy.prompt");

        $question = Question::create($questionText)
            ->addButtons([
                Button::create(__("conversations/welcome.privacy.yes"))->value('yes'),
                Button::create(__("conversations/welcome.privacy.no"))->value('no')
            ]);

        $this->ask($question, [
            [
                'pattern' => __("conversations/welcome.privacy.yes_pattern"),
                'callback' => function () {
                    //Great! Let's create user
                    $internalUser = User::create([
                        'external_service'  => $this->getBot()->getDriver()->getName(),
                        'external_id'       => $this->getBot()->getUser()->getId(),
                        'privacy_consent'   => true
                    ]);

                    //And reply
                    $this->say(__("conversations/welcome.privacy.agreed"));
                    $this->getBot()->typesAndWaits(2);
                    $this->askName();
                }
            ],
            [
                'pattern' => __("conversations/welcome.privacy.no_pattern"),
                'callback' => function () {
                    $this->say(__("conversations/welcome.privacy.declined"));
                }
            ],
            [
                'pattern' => '.*',
                'callback' => function () {
                    $this->say(__('conversations/welcome.privacy.answer_unclear'));
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
                $nameButtons[] = Button::create($externalUser->getFirstName())
                    ->value($externalUser->getFirstName());
            }
            if (!(empty($externalUser->getLastName()))) {
                $nameButtons[] = Button::create($externalUser->getLastName())
                    ->value($externalUser->getLastName());
            }
            if (!(empty($externalUser->getFirstName())) && !(empty($externalUser->getLastName()))) {
                $fullName = $externalUser->getFirstName() . ' ' . $externalUser->getLastName();
                $nameButtons[] = Button::create($fullName)
                    ->value($fullName);
            }
            if (!(empty($externalUser->getUsername()))) {
                $nameButtons[] = Button::create($externalUser->getUsername())
                    ->value($externalUser->getUsername());
            }
        }

        $questionText = __('conversations/welcome.name.prompt');

        //Add a Text that buttons are optional
        if (count($nameButtons) > 0) {
            $questionText .= __('conversations/welcome.name.buttons_available');
        }

        //Build Question with buttons (if any)
        $question = Question::create($questionText)
            ->addButtons($nameButtons);

        $this->ask($question, function (Answer $answer) {
            $internalUser = User::find(Auth::id());

            //Set Name
            $internalUser->name = $answer->getText();
            $internalUser->save();
            $this->showMenu();
        });
    }
}
