@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $user['_id'] }}<a href="{{ URL::route('delete_user', $user['_id']) }}" style="float:right;" title="Obriši korisnika"><img style="width:32px;height:30px;" src="{{ asset('img/ic_delete_forever_black_18dp_2x.png') }}" /></a><a href="{{ URL::route('edit_user_prepare', $user['_id']) }}" style="float:right;" title="Ažuriraj korisnika"><img style="width:28px;height:28px;" src="{{ asset('img/ic_edit_black_18dp_2x.png') }}" /></a></div>

                <div class="panel-body">
                  <table class="table table-borderless">
                    <tbody>
                      <tr><th>E-mail</th><td>{{ $user['email'] }}</td></tr>
                      <tr><th>Telefon</th><td>{{ $user['phone'] }}</td></tr>
                      <tr><th>Okrug</th><td>{{ $user['district'] }}</td></tr>
                      <tr><th>Grad</th><td>{{ $user['city'] }}</td></tr>
                      <tr><th>Opis</th><td>{{ $user['description'] }}</td></tr>
                      <tr><th>Oglasi ({{ count($user['ads']) }})</th><td>
                        @if(count($user['ads'])==0)
                          <i>Nema oglasa</i>
                        @else
                          <table class="table">
                          @for($i = 0; $i < count($user_ads); $i++)
                            <tr><th><a href="{{ URL::route('ad', $user_ads[$i]) }}">{{ $user_ads[$i] }}</a></th></tr>
                          @endfor
                          </table>
                        @endif
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
