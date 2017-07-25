@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Korisnici ({{ count($users) }})<a href="{{ URL::route('new_user') }}" style="float:right;" title="Dodaj korisnika"><img style="width:31px;height:30px;" src="{{ asset('img/ic_person_add_black_18dp_2x.png') }}" /></a></div>

                <div class="panel-body">
                    <table class="table table-bordered">
                      <tbody>
                        <tr><th>Korisničko ime</th><th>Email</th></tr>
                        @for($i = 0; $i < count($users); $i++)
                        <tr><td><a href="{{ URL::route('user', $users[$i]['user_id']) }}">{{ $users[$i]['user_id'] }}</a></td><td>{{ $users[$i]['user_email'] }}</td></tr>
                        @endfor
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
