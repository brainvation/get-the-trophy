<?php

return [
    'commands' => [
        'start' => [
            'buttonText' => 'Startmenu',
            'pattern' => '/\/start|start|hi|hallo|👋|hello|hey|servus|moin/'
        ],
        'join' => [
            'buttonText' => 'Wettbewerb beitreten'
        ],
        'create' => [
            'buttonText' => 'Wettbewerb starten'
        ],
        'deleteme' => [
            'buttonText' => 'Meine Daten löschen',
            'success' => "Deine Daten wurden gelöscht.
\nDu kannst jederzeit disesen Bot neu nutzen, indem du ihn mit dem Befehl /start neu startest."
        ],
        'debuginfo' => [
            'buttonText' => 'Informationen zur Fehleranalyse anzeigen'
        ],
        'unknown' => "Hmm. 🤔 Sorry, ich weiß leider nicht, was du vom mit willst. 😕
\nMit dem Befehl /start kommst du zum Startmenü"
    ]
];
