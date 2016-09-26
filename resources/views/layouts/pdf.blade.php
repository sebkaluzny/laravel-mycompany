<!DOCTYPE html>
<html lang="en">
<head>
    {{--<meta charset="utf-8">--}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {{--<link rel="stylesheet" href="{{ asset('css/app.min.css') }}">--}}
    {{--<link href="https://fonts.googleapis.com/css?family=Lato:400,700,900&subset=latin-ext" rel="stylesheet">--}}

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <style>
        /*@import 'https://fonts.googleapis.com/css?family=Open+Sans&subset=latin-ext';*/
        /*@import 'https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800&subset=latin-ext';*/
        @font-face {
            font-family: 'Open Sanz';
            font-style: normal;
            font-weight: normal;
            src: url(http://mycompany.dev/fonts/OpenSans-Regular.ttf) format('truetype');
        }

        @font-face {
            font-family: 'Open Sanz';
            font-style: normal;
            font-weight: bold;
            src: url(http://mycompany.dev/fonts/OpenSans-Bold.ttf) format('truetype');
        }

        body {
            font-family: 'Open Sanz';
            font-size: 12px;
        }

        .column-centered-content {
            display: flex;
            align-items: center;
            /*justify-content:center;*/
        }

        .header h1 {
            margin: 0;
        }
        .header {
            padding: 0 0 30px 0;
            border-bottom: 1px solid #dbdbdb;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>

@yield('content')

</body>
</html>
