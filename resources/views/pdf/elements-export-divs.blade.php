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
                    <img src="{{ env('LOGO_FILE') }}" alt="" style="width: 100px;">
                </td>
                <td style="text-align: right;">Wygenerowano: {{ date('d-m-Y, H:i') }}</td>
            </tr>
            <tr>
                <td style="text-align: right;"><b>Liczba pozycji: {{ count($data) }}</b></td>
            </tr>
            <tr>
                <td style="text-align: right;"><b>Wykonanych sztuk: {{ $countDoneQuantity }}</b></td>
            </tr>
        </table>
    </div>
    <div class="elements">
        <?PHP $i = 1; ?>
        @foreach($data as $item)
            <div class="element">
                <div class="elementCell">{{ $i }}</div>
                @foreach($item as $key => $val)
                    @if($key == 'Zadania' && (is_array($val)) )
                        <?PHP $obj = (array) $val;?>
                        <div class="elementCell">{!! implode('<br />', $obj) !!}</div>
                    @else
                        <div class="elementCell">{{ $val }}</div>
                    @endif
                @endforeach
            </div>
            <?PHP $i ++; ?>
        @endforeach
    </div>
@stop