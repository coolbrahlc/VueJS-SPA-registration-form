<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

        <title>Note App</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

        <!-- Styles -->
        <styl2>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }
            .component-header {
                padding-bottom: 34px;
                padding-top: 34px;
            }
            li .options{
                cursor: pointer;
            }
            li:hover .options{
                margin-right:20px;
                font-size: 15px;
            }
            .glyphicon {
                margin-right: 20px;
            }
            .header-nav > a {
                padding-right: 20px;
            }
            .header-nav {
                padding: 20px;
                text-align: left;
            }
            body {
                font-size: 16px;
                font-weight: 600;
            }
            .note-form33 {
                padding-top: 20px;
            }
        </styl2>
    </head>
    <body>
        <div id="app"></div>
    </body>
    <script src="{{ asset('js/app.js') }}"></script>
</html>
