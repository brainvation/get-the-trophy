<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>BotMan Widget</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <script>
            var botmanWidget = {
                chatServer: '/bot',
                frameEndpoint: '/chatframe'    
            };
            </script>
       <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
    </body>
</html>
