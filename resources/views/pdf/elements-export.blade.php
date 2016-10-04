@extends('layouts.pdf')

@section('content')
    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td rowspan="2">
                    {{--<h1>MyCompany</h1>--}}
                    <img src="{{ env('LOGO_FILE') }}" alt="">
                </td>
                <td style="text-align: right;">Wygenerowano: {{ date('d-m-Y, H:i') }}</td>
            </tr>
            <tr>
                <td style="text-align: right;"><b>Liczba elementów: {{ count($data) }}</b></td>
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