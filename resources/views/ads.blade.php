@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Svi oglasi ({{ count($ads) }})<a href="{{ URL::route('new_ad_prepare') }}" style="float:right;" title="Dodaj oglas"><img style="width:31px;height:30px;" src="{{ asset('img/ic_add_circle_black_18dp_2x.png') }}" /></a></div>

                <div class="panel-body">
                    <table class="table table-bordered">
                      <tbody>
                        <tr><th>ID oglasa</th><th>Naslov oglasa</th></tr>
                        @for($i = 0; $i < count($ads); $i++)
                        <tr><td><a href="{{ URL::route('ad', $ads[$i]['ad_id']) }}">{{ $ads[$i]['ad_id'] }}</a></td><td>{{ $ads[$i]['ad_title'] }}</td></tr>
                        @endfor
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
