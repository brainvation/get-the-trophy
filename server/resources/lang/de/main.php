<?php

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
        'stop' => [
            'buttonText' => 'Aktuellen Dialog stoppen',
            'answer' => 'Gestoppt. Du gelangst zurück zum Startmenü mit /start'
        ],
        'deleteme' => [
            'buttonText' => 'Meine Daten löschen',
            'success' => "Deine Daten wurden gelöscht.
\nDu kannst jederzeit diesen Bot neu nutzen, indem du ihn mit dem Befehl /start neu startest."
        ],
        'debuginfo' => [
            'buttonText' => 'Informationen zur Fehleranalyse anzeigen'
        ],
        'unknown' => "Hmm. 🤔 Sorry, ich weiß leider nicht, was du vom mir willst. 😕
\nMit dem Befehl /start kommst du zum Startmenü..."
    ]
];
