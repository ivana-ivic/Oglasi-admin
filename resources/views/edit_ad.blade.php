@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $ad['_id'] }}</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('edit_ad') }}">
                        {{ csrf_field() }}

                        <input type="hidden" id="ad_id" name="ad_id" value="{{ $ad['_id'] }}" />

                        <div class="form-group">
                            <label for="title" class="col-md-4 control-label">Naslov</label>

                            <div class="col-md-6">
                                <input id="title" type="input" class="form-control" name="title" value="{{ $ad['title'] }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="text" class="col-md-4 control-label">Tekst</label>

                            <div class="col-md-6">
                                <textarea id="text" class="form-control" name="text" value="{{ $ad['text'] }}" required>{{ $ad['text'] }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user_id" class="col-md-4 control-label">Korisnik</label>

                            <div class="col-md-6">
                              <p class="form-control">{{ $ad['user_id'] }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cat1" class="col-md-4 control-label">Kategorija 1</label>

                            <div class="col-md-6">
                              {!! Form::select('cat1', ['Aksesoari' => 'Aksesoari', 'Muška odeća' => 'Muška odeća', 'Ženska odeća' => 'Ženska odeća', 'Kućni ljubimci' => 'Kućni ljubimci', 'Kuće' => 'Kuće', 'Stanovi' => 'Stanovi', 'Tehnika' => 'Tehnika', 'Ostalo' => 'Ostalo'], $ad['cat1'], ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cat2" class="col-md-4 control-label">Kategorija 2</label>

                            <div class="col-md-6">
                              {!! Form::select('cat2', ['Laptopovi' => 'Laptopovi', 'Monitori' => 'Monitori', 'Kompjuteri' => 'Kompjuteri', 'Računarska oprema' => 'Računarska oprema', 'Slušalice' => 'Slušalice', 'Zvučnici' => 'Zvučnici', 'Bela tehnika' => 'Bela tehnika', 'Psi' => 'Psi', 'Mačke' => 'Mačke', 'Haljine' => 'Haljine', 'Suknje' => 'Suknje', 'Pantalone' => 'Pantalone', 'Majice' => 'Majice', 'Džemperi' => 'Džemperi', 'Košulje' => 'Košulje', 'Patike' => 'Patike', 'Cipele' => 'Cipele', 'Sandale' => 'Sandale', 'Duksevi' => 'Duksevi', 'Torbe' => 'Torbe', 'Rančevi' => 'Rančevi', 'Ogrlice' => 'Ogrlice', 'Narukvice' => 'Narukvice', 'Prstenje' => 'Prstenje', 'Izdavanje' => 'Izdavanje', 'Prodaja' => 'Prodaja', 'Ostalo' => 'Ostalo'], $ad['cat2'], ['class' => 'form-control']) !!}
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
