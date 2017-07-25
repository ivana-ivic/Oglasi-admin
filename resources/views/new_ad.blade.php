@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Novi oglas</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('new_ad') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="title" class="col-md-4 control-label">Naslov</label>

                            <div class="col-md-6">
                                <input id="title" type="input" class="form-control" name="title" value="{{ old('title') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="text" class="col-md-4 control-label">Tekst</label>

                            <div class="col-md-6">
                                <textarea id="text" class="form-control" name="text" value="{{ old('text') }}" required></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user_id" class="col-md-4 control-label">Korisnik</label>

                            <div class="col-md-6">
                              <select id="user_id" class="form-control" name="user_id" value="{{ old('user_id') }}" required>
                                @for($i=0;$i<count($usernames);$i++)
                                  <option value="{{ $usernames[$i] }}">{{ $usernames[$i] }}</option>
                                @endfor
                              </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cat1" class="col-md-4 control-label">Kategorija 1</label>

                            <div class="col-md-6">
                                <select id="cat1" class="form-control" name="cat1" value="{{ old('cat1') }}" required>
                                  <option value="Aksesoari">Aksesoari</option>
                                  <option value="Muška odeća">Muška odeća</option>
                                  <option value="Ženska odeća">Ženska odeća</option>
                                  <option value="Kućni ljubimci">Kućni ljubimci</option>
                                  <option value="Kuće">Kuće</option>
                                  <option value="Stanovi">Stanovi</option>
                                  <option value="Tehnika">Tehnika</option>
                                  <option value="Ostalo">Ostalo</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cat2" class="col-md-4 control-label">Kategorija 1</label>

                            <div class="col-md-6">
                                <select id="cat2" class="form-control" name="cat2" value="{{ old('cat2') }}" required>
                                  <option value="Laptopovi">Laptopovi</option>
                                  <option value="Monitori">Monitori</option>
                                  <option value="Kompjuteri">Kompjuteri</option>
                                  <option value="Računarska oprema">Računarska oprema</option>
                                  <option value="Slušalice">Slušalice</option>
                                  <option value="Zvučnici">Zvučnici</option>
                                  <option value="Bela tehnika">Bela tehnika</option>
                                  <option value="Psi">Psi</option>
                                  <option value="Mačke">Mačke</option>
                                  <option value="Haljine">Haljine</option>
                                  <option value="Suknje">Suknje</option>
                                  <option value="Pantalone">Pantalone</option>
                                  <option value="Majice">Majice</option>
                                  <option value="Džemperi">Džemperi</option>
                                  <option value="Košulje">Košulje</option>
                                  <option value="Patike">Patike</option>
                                  <option value="Cipele">Cipele</option>
                                  <option value="Sandale">Sandale</option>
                                  <option value="Duksevi">Duksevi</option>
                                  <option value="Torbe">Torbe</option>
                                  <option value="Rančevi">Rančevi</option>
                                  <option value="Ogrlice">Ogrlice</option>
                                  <option value="Narukvice">Narukvice</option>
                                  <option value="Prstenje">Prstenje</option>
                                  <option value="Izdavanje">Izdavanje</option>
                                  <option value="Prodaja">Prodaja</option>
                                  <option value="Ostalo">Ostalo</option>
                                </select>
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
