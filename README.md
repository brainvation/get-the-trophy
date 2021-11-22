## About Get-The-Trophy
A party game supported via Bots - currently in development

## Idea / Notes


Ideas:
- Build it so it can work with various front-ends
- Start with Telegram Bot
- Games need a feature list, which should allow the frontend to check if games can be run
- There should be Compentition Manager, managing
    - time & agenda of Compentition
    - scroing mode
        - fixed assigned points for winner of games
            - preconfiguerd options:
                - 
        - individual scores from games are counted together
        
    - set of games
    - participants
    - competition host / admin
    - scores of participants
- Games
    - Should have a common interface
    - A "dummy game"
        - Having just a name and possibilty to score
        - manuell input by host who won
    - A simple interaction game:
        - Host gives question
        - Participants answer privatly
        - Host says who get's the point
        - Timelimit of game
        - Timelimit of question
    - Freeform Quiz based on simple interaction game
        - Host can prepare questions and answers
        - If participants answer matches -> auto point
        - manual overwrite by admin
    - Quiz with options
        - Prepared Questions and Answers
        - Options A, B, C, D
        - Choosing correct option, answer is credited
        - Option for syncronous or asyncronous answering
        - Time limit for questions 
- Database
    - Game & competition State
- Session Management
    - Which player?
    - Which competition?
    - Which game?
    - Context Info of the game

Future:
    - Easy-Compentition:
        - If people only want to play one game
        - Auto starts a 1 game competition with game scoring


TO CHECK: Are we allowed to store Data from Telegram etc.?
TODO: Data consent when starting bot



User
     Can only have one active Turn
     Cannot join a competition when another one active
     What happens if you leave a game?
        for now: player has to wait for end

Data Model


GroupGameInstance
- SeqNo
- Game
- State
- 1:x Turns
- 1:n Players
    - SeqNo
    - Context Info
    - Turns
    -   State
    -   Indiviual Context info
    

Turn
- PK SeqNo
- Context Info dependend of game




Roles
    - admin
    - Player
    - Left/deleted


Game Interface:

Game Data (DB or not)
- name
- TurnType
    - Syncronous
    - asyncronous
- MaxScore (opt.)
- ScorePositive = true
- canAdminPlay?
- options (arraycast)

- initGame
    - will create data needed for the GroupGameInstance
    - will trigger "setup wizard"

TODO:
    - Contriubte Icon creator:
        <div>Icons made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik
        Creative Commons(Attribution-NonCommercial 3.0 unported)
    - Consider rate limiting: Send one mesage whereever possible
    - LImit groups to max. 10 participants (rate limiting)
    - Implement group feature to cut down on send messages
    - or typesAndWaits...
    - Create a middleware that switches to Markdown V2 parsing
    - Add secret key to Telegram bot URL and verify in program

FUTURE:
    - Telegram Login https://pociot.dev/12-use-the-telegram-login-widget

OPEN:
    - How to skip questions in a conversation? / end game for a participant?

InteractionController for setup
    - Game etc. has to provide a array with
        - required field
        - type
        - mandatory? / default value?
        - Readable name
        - Description/Question (opt)
        - optionsset (opt)
        - repeatable/endless (user has to cancel)
    - There could be  a set of common fiels, that could be autofilled via view
    - Controller then will then pass that to "view" which collects data
    - Future: Provide preconfiguerd Sets
    - Future: Let users/group save sets

Example:
    In a Setup of a competition this would work like this:
    - Compentition asks for above data
        - If using Telegram users, admin (?) etc. are taken from group
        - Fills database
    - Asks which games to play (endless loop) 
        - Creates instances of Games
        - Game State is init
    - After selection of game, Game does init asking for questions about game
        - Fills context info
    - Then continues with turn setup
        - Fills turn context info
    - After all that is done, back to competition controller
    - Game State SetupDone
    - Loops till all games are setup
    - At the end, check if players are all connected to bot
        https://stackoverflow.com/questions/45233413/cant-send-message-to-some-bot-users-in-telegram
    - Competition can then be started
    - Competition starts
        - First Game Starts 
            - Creates player turns with "waiting"
            - Game State active
        Based on Turn type turn states are set
        - Based on Turn Type bot writes to group or users
        - Play State Update always to group
            - In case there is no group -> update to all
            - QUESTION: Is a group needed? - Not really, but will help keeping load down