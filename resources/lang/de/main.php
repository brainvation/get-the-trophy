<?php

// phpcs:disable Generic.Files.LineLength -- Translation File

return [
    'commands' => [
        'start' => [
            'buttonText' => 'Startmenü',
            'pattern' => '/\/start|start|hi|hallo|👋|hello|hey|servus|moin/'
        ],
        'join' => [
            'buttonText' => 'Wettbewerb beitreten'
        ],
        'create' => [
            'buttonText' => 'Wettbewerb starten'
        ],
        'settings' => [
            'pattern' => '/\/settings|einstellungen/',
            'buttonText' => 'Einstellungen ändern'
        ],
        'stop' => [
            'buttonText' => 'Aktuellen Dialog stoppen',
            'answer' => 'Gestoppt. Du gelangst zurück zum Startmenü mit /start'
        ],
        'deleteme' => [
            'buttonText' => 'Benutzerkonto und Daten löschen',
            'success' => "Deine Daten wurden gelöscht.
\nDu kannst jederzeit diesen Bot neu nutzen, indem du ihn mit dem Befehl /start neu startest."
        ],
        'debuginfo' => [
            'buttonText' => 'Informationen zur Fehleranalyse anzeigen',
            'answer' => 'User Info: :userinfo'
        ],
        'unknown' => "Hmm. 🤔 Sorry, ich weiß leider nicht, was du vom mir willst. 😕
\nMit dem Befehl /start kommst du zum Startmenü..."
    ],
    'exception' => [
        'occurred' => "Ein Fehler ist aufgetreten:\n:exception"
    ]
];
