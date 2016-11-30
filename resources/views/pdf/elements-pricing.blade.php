@extends('layouts.pdf')

@section('content')

    <script type="text/php">
            if ( isset($pdf) ) {
    $pdf->page_script('
        if ($PAGE_COUNT > 0) {
            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $size = 7;
            $pageText = "Strona " . $PAGE_NUM . "/" . $PAGE_COUNT;
            $y = $pdf->get_height() - 24;
            $x = $pdf->get_width() - 15 - $fontMetrics->get_text_width($pageText, $font, $size);
            $pdf->text($x, $y, $pageText, $font, $size);
        }
    ');
}




    </script>

    <div class="row">
        <div class="col-md-12">
            <div class="header">
                <table style="width: 100%;">
                    <tr>
                        <td>
                            {{--<h1>MyCompany</h1>--}}
                            <img src="{{ env('LOGO_FILE') }}" alt="" style="width: 100px;">
                        </td>
                        <td style="text-align: right;">
                            <h2 style="margin-bottom: 0; font-family: 'Open Sanz'; ">{{ mb_convert_encoding(env('COMPANY_NAME'), 'UTF-8') }}</h2>
                            <h3 style="margin-top: 5px;">Wycena z dnia {{ $pricing->updated_at->toDateString() }}</h3>
                        </td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h4 class="page-header" style="marin-top: 0;">Wycena</h4>
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th style="width: 15%">Nazwa</th>
                    <th>Wartość</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Liczba pozycji</td>
                    <td>{{ count($data) }}</td>
                </tr>
                <tr>
                    <td>Liczba wykonanych sztuk</td>
                    <td>{{ $countDoneQuantity }}</td>
                </tr>
                <tr>
                    <td>Cena</td>
                    <td>{{ $price }} zł</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h4 class="page-header">Elementy</h4>
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Lp.</th>
                    @foreach(array_keys((array)$data[0]) as $key)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <?PHP $i = 1; ?>
                @foreach($data as $item)
                    <tr>
                        <td>{{ $i }}</td>
                        @foreach($item as $key => $val)
                            @if($key == 'Zadania' && (is_array($val)) )
                                <?PHP $obj = (array) $val;?>
                                <td>{!! implode('<br />', $obj) !!}</td>
                            @else
                                <td>{{ $val }}</td>
                            @endif
                        @endforeach
                    </tr>
                    <?PHP $i ++; ?>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop