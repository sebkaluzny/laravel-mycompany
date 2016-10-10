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
        {{--@font-face {--}}
            {{--font-family: 'Open Sanz';--}}
            {{--font-style: normal;--}}
            {{--font-weight: normal;--}}
            {{--src: url({{ asset('fonts/OpenSans-Regular.ttf') }}) format('truetype');--}}
        {{--}--}}

        {{--@font-face {--}}
            {{--font-family: 'Open Sanz';--}}
            {{--font-style: normal;--}}
            {{--font-weight: bold;--}}
            {{--src: url({{ asset('fonts/OpenSans-Bold.ttf') }}) format('truetype');--}}
        {{--}--}}

        body {
            font-family: 'Open Sanz';
            font-size: 10px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        @page { margin: 25px; }

        hr {
            border-color: #000!important;
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
            margin-top: 0;
            padding: 0 0 15px 0;
            border-bottom: 1px solid #222222;
            margin-bottom: 15px;
        }
        .table-bordered,
        .table-bordered th,
        .table-bordered td {
            border-color: #000!important;
            padding: 2px 4px!important;
            vertical-align: middle!important;
        }
        .table-striped>tbody>tr:nth-of-type(odd) {
            background-color: #ececec;
        }
    </style>
</head>
<body>



@yield('content')

</body>
</html>
