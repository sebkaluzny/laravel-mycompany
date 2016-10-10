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

    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td rowspan="3">
                    {{--<h1>MyCompany</h1>--}}
                    <img src="{{ env('LOGO_FILE') }}" alt="">
                </td>
                <td style="text-align: right;">Wygenerowano: {{ date('d-m-Y, H:i') }}</td>
            </tr>
            <tr>
                <td style="text-align: right;"><b>Liczba elementów: {{ count($data) }}</b></td>
            </tr>
            <tr>
                <td style="text-align: right;"><b>Wykonanych sztuk: {{ $countDoneQuantity }}</b></td>
            </tr>
        </table>
    </div>
    <div class="row">
        <div class="col-md-12">
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