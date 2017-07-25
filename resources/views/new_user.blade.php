@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Novi korisnik</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('create_new_user') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="username" class="col-md-4 control-label">Korisničko ime</label>

                            <div class="col-md-6">
                                <input id="username" type="input" class="form-control" name="username" value="{{ old('username') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="col-md-4 control-label">Telefon</label>

                            <div class="col-md-6">
                                <input id="phone" type="number" class="form-control" name="phone" value="{{ old('phone') }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="district" class="col-md-4 control-label">Okrug</label>

                            <div class="col-md-6">
                                <select id="district" class="form-control" name="district" value="{{ old('district') }}" required>
                                  <option value="Borski okrug">Borski okrug</option>
                                  <option value="Braničevski okrug">Braničevski okrug</option>
                                  <option value="Grad Beograd">Grad Beograd</option>
                                  <option value="Zaječarski okrug">Zaječarski okrug</option>
                                  <option value="Zapadnobački okrug">Zapadnobački okrug</option>
                                  <option value="Zlatiborski okrug">Zlatiborski okrug</option>
                                  <option value="Jablanički okrug">Jablanički okrug</option>
                                  <option value="Južnobanatski okrug">Južnobanatski okrug</option>
                                  <option value="Južnobački okrug">Južnobački okrug</option>
                                  <option value="Kolubarski okrug">Kolubarski okrug</option>
                                  <option value="Kosovski okrug">Kosovski okrug</option>
                                  <option value="Kosovskomitrovački okrug">Kosovskomitrovački okrug</option>
                                  <option value="Kosovskopomoravski okrug">Kosovskopomoravski okrug</option>
                                  <option value="Mačvanski okrug">Mačvanski okrug</option>
                                  <option value="Moravički okrug">Moravički okrug</option>
                                  <option value="Nišavski okrug">Nišavski okrug</option>
                                  <option value="Pećki okrug">Pećki okrug</option>
                                  <option value="Pirotski okrug">Pirotski okrug</option>
                                  <option value="Podunavski okrug">Podunavski okrug</option>
                                  <option value="Pomoravski okrug">Pomoravski okrug</option>
                                  <option value="Prizrenski okrug">Prizrenski okrug</option>
                                  <option value="Pčinjski okrug">Pčinjski okrug</option>
                                  <option value="Rasinski okrug">Rasinski okrug</option>
                                  <option value="Raški okrug">Raški okrug</option>
                                  <option value="Severnobanatski okrug">Severnobanatski okrug</option>
                                  <option value="Severnobački okrug">Severnobački okrug</option>
                                  <option value="Srednjobanatski okrug">Srednjobanatski okrug</option>
                                  <option value="Sremski okrug">Sremski okrug</option>
                                  <option value="Toplički okrug">Toplički okrug</option>
                                  <option value="Šumadijski okrug">Šumadijski okrug</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="city" class="col-md-4 control-label">Grad</label>

                            <div class="col-md-6">
                                <select id="city" class="form-control" name="city" value="{{ old('city') }}" required>
                                  <option value="Beograd">Beograd</option>
                                  <option value="Novi Sad">Novi Sad</option>
                                  <option value="Niš">Niš</option>
                                  <option value="Priština">Priština</option>
                                  <option value="Kragujevac">Kragujevac</option>
                                  <option value="Subotica">Subotica</option>
                                  <option value="Pančevo">Pančevo</option>
                                  <option value="Zrenjanin">Zrenjanin</option>
                                  <option value="Čačak">Čačak</option>
                                  <option value="Kraljevo">Kraljevo</option>
                                  <option value="Novi Pazar">Novi Pazar</option>
                                  <option value="Leskovac">Leskovac</option>
                                  <option value="Smederevo">Smederevo</option>
                                  <option value="Vranje">Vranje</option>
                                  <option value="Užice">Užice</option>
                                  <option value="Valjevo">Valjevo</option>
                                  <option value="Kruševac">Kruševac</option>
                                  <option value="Šabac">Šabac</option>
                                  <option value="Požarevac">Požarevac</option>
                                  <option value="Sombor">Sombor</option>
                                  <option value="Sombor">Sombor</option>
                                  <option value="Pirot">Pirot</option>
                                  <option value="Zaječar">Zaječar</option>
                                  <option value="Bor">Bor</option>
                                  <option value="Kikinda">Kikinda</option>
                                  <option value="Sremska Mitrovica">Sremska Mitrovica</option>
                                  <option value="Jagodina">Jagodina</option>
                                  <option value="Aleksinac">Aleksinac</option>
                                  <option value="Vršac">Vršac</option>
                                  <option value="Loznica">Loznica</option>
                                  <option value="Inđija">Inđija</option>
                                  <option value="Knjaževac">Knjaževac</option>
                                  <option value="Mladenovac">Mladenovac</option>
                                  <option value="Negotin">Negotin</option>
                                  <option value="Obrenovac">Obrenovac</option>
                                  <option value="Ruma">Ruma</option>
                                  <option value="Sjenica">Sjenica</option>
                                  <option value="Temerin">Temerin</option>
                                  <option value="Trstenik">Trstenik</option>
                                  <option value="Ćuprija">Ćuprija</option>
                                  <option value="Futog">Futog</option>
                                  <option value="Šid">Šid</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-md-4 control-label">Opis</label>

                            <div class="col-md-6">
                                <textarea id="description" class="form-control" name="description" value="{{ old('description') }}" required></textarea>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Lozinka</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

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
                                    Dodaj
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
