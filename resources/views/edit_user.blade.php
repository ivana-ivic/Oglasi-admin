@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Novi korisnik</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('edit_user') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="username" class="col-md-4 control-label">Korisničko ime</label>

                            <div class="col-md-6">
                                <input id="username" type="hidden" class="form-control" name="username" value="{{ $user['_id'] }}" />
                                <p class="form-control">{{ $user['_id'] }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="input" class="form-control" name="email" value="{{ $user['email'] }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="col-md-4 control-label">Telefon</label>

                            <div class="col-md-6">
                                <input id="phone" type="input" class="form-control" name="phone" value="{{ $user['phone'] }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="district" class="col-md-4 control-label">Okrug</label>

                            <div class="col-md-6">

                              {!! Form::select('district', [ 'Borski okrug' => 'Borski okrug', 'Braničevski okrug' => 'Braničevski okrug', 'Grad Beograd' => 'Grad Beograd', 'Zaječarski okrug' => 'Zaječarski okrug', 'Zapadnobački okrug' => 'Zapadnobački okrug', 'Zlatiborski okrug' => 'Zlatiborski okrug', 'Jablanički okrug' => 'Jablanički okrug', 'Južnobanatski okrug' => 'Južnobanatski okrug', 'Južnobački okrug' => 'Južnobački okrug', 'Kolubarski okrug' => 'Kolubarski okrug', 'Kosovski okrug' => 'Kosovski okrug', 'Kosovskomitrovački okrug' => 'Kosovskomitrovački okrug', 'Kosovskopomoravski okrug' => 'Kosovskopomoravski okrug', 'Mačvanski okrug' => 'Mačvanski okrug', 'Moravički okrug' => 'Moravički okrug', 'Nišavski okrug' => 'Nišavski okrug', 'Pećki okrug' => 'Pećki okrug', 'Pirotski okrug' => 'Pirotski okrug', 'Podunavski okrug' => 'Podunavski okrug', 'Pomoravski okrug' => 'Pomoravski okrug', 'Prizrenski okrug' => 'Prizrenski okrug', 'Pčinjski okrug' => 'Pčinjski okrug', 'Rasinski okrug' => 'Rasinski okrug', 'Raški okrug' => 'Raški okrug', 'Severnobanatski okrug' => 'Severnobanatski okrug', 'Severnobački okrug' => 'Severnobački okrug', 'Srednjobanatski okrug' => 'Srednjobanatski okrug', 'Sremski okrug' => 'Sremski okrug', 'Toplički okrug' => 'Toplički okrug', 'Šumadijski okrug' => 'Šumadijski okrug' ], $user['district'], ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="city" class="col-md-4 control-label">Grad</label>

                            <div class="col-md-6">
                                {!! Form::select('city', ['Beograd' => 'Beograd', 'Novi Sad' => 'Novi Sad', 'Niš' => 'Niš', 'Priština' => 'Priština', 'Kragujevac' => 'Kragujevac', 'Subotica' => 'Subotica', 'Pančevo' => 'Pančevo', 'Zrenjanin' => 'Zrenjanin', 'Čačak' => 'Čačak', 'Kraljevo' => 'Kraljevo', 'Novi Pazar' => 'Novi Pazar', 'Leskovac' => 'Leskovac', 'Smederevo' => 'Smederevo', 'Vranje' => 'Vranje', 'Užice' => 'Užice', 'Valjevo' => 'Valjevo', 'Kruševac' => 'Kruševac', 'Šabac' => 'Šabac', 'Požarevac' => 'Požarevac', 'Sombor' => 'Sombor', 'Pirot' => 'Pirot', 'Zaječar' => 'Zaječar', 'Bor' => 'Bor', 'Kikinda' => 'Kikinda', 'Sremska Mitrovica' => 'Sremska Mitrovica', 'Jagodina' => 'Jagodina', 'Aleksinac' => 'Aleksinac', 'Vršac' => 'Vršac', 'Loznica' => 'Loznica', 'Inđija' => 'Inđija', 'Knjaževac' => 'Knjaževac', 'Mladenovac' => 'Mladenovac', 'Negotin' => 'Negotin', 'Obrenovac' => 'Obrenovac', 'Ruma' => 'Ruma', 'Sjenica' => 'Sjenica', 'Temerin' => 'Temerin', 'Trstenik' => 'Trstenik', 'Ćuprija' => 'Ćuprija', 'Futog' => 'Futog', 'Šid' => 'Šid'], $user['city'], ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-md-4 control-label">Opis</label>

                            <div class="col-md-6">
                                <textarea id="description" class="form-control" name="description" value="{{ $user['description'] }}" required>{{ $user['description'] }}</textarea>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Lozinka</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" value="{{ $user['password'] }}" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Sačuvaj
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
