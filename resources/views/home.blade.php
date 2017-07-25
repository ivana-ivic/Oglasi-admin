@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Prijavljeni oglasi ({{ count($ads) }})</div>

                <div class="panel-body">
                    <table class="table table-bordered">
                      <tbody>
                        <tr><th>ID oglasa</th><th>Broj prijava oglasa</th></tr>
                        @for($i = 0; $i < count($ads); $i++)
                        <tr><td><a href="{{ URL::route('ad', $ads[$i]['ad_id']) }}">{{ $ads[$i]['ad_id'] }}</a></td><td>{{ $ads[$i]['report_count'] }}</td></tr>
                        @endfor
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
