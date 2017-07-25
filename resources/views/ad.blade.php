@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="padding-bottom:10px;">{{ $ad['title'] }}<a href="{{ URL::route('delete_ad', $ad['_id']) }}" style="float:right;" title="Obriši oglas"><img style="width:32px;height:28px;" src="{{ asset('img/ic_delete_forever_black_18dp_2x.png') }}" alt="Obriši oglas" /></a><a href="{{ URL::route('edit_ad_prepare', $ad['_id']) }}" style="float:right;" title="Ažuriraj oglas"><img style="width:28px;height:28px;" src="{{ asset('img/ic_edit_black_18dp_2x.png') }}" alt="Obriši oglas" /></a>@if($ad['report_flag']==true)<a href="{{ URL::route('approve_ad', $ad['_id']) }}" style="float:right;margin-right:10px;margin-top:3px;" title="Potvrdi oglas">Odobri oglas</a>@endif</div>

                <div class="panel-body">

                  <div id="myCarousel" class="carousel slide" data-ride="carousel">
                  <!-- Indicators -->
                  <ol class="carousel-indicators">

                    @if(count($ad['images'])>0)
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                      @if(count($ad['images'])>=2)
                        @for($i=1;$i<count($ad['images']);$i++)
                          <li data-target="#myCarousel" data-slide-to="{{$i}}"></li>
                        @endfor
                      @endif
                    @endif
                  </ol>

                  <!-- Wrapper for slides -->
                  <div class="carousel-inner">

                    {!!html_entity_decode($images)!!}

                  </div>

                  @if(count($ad['images'])>0)
                  <!-- Left and right controls -->
                  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    {{-- <span class="glyphicon glyphicon-chevron-left"></span> --}}
                    <span class="sr-only">Previous</span>
                  </a>
                  <a style="display: table-cell;vertical-align: middle;" class="right carousel-control" href="#myCarousel" data-slide="next">
                    {{-- <span class="glyphicon glyphicon-chevron-right"></span> --}}
                    <span class="sr-only">Next</span>
                  </a>
                  @endif
                </div>

                  <table class="table table-borderless">
                    <tbody>
                      <tr><th>ID</th><td>{{ $ad['_id'] }}</td></tr>
                      <tr><th>ID vlasnika</th><td><a href="{{ URL::route('user', $ad['user_id']) }}"><strong>{{ $ad['user_id'] }}</strong></a></td></tr>
                      <tr><th>Kategorija</th><td>{{ $ad['cat1'] }}</td></tr>
                      <tr><th>Potkategorija</th><td>{{ $ad['cat2'] }}</td></tr>
                      <tr><th>Tekst</th><td>{{ $ad['text'] }}</td></tr>
                      <tr><th>Vreme kreiranja</th><td>{{ date("d.m.Y,\tH:i\h",$ad['created_at']) }}</td></tr>
                      <tr><th>Vreme poslednje izmene</th><td>{{ date("d.m.Y,\tH:i\h",$ad['updated_at']) }}</td></tr>
                      <tr><th>Komentari ({{ count($ad['comments']) }})</th><td>
                        @if(count($ad['comments'])==0)
                          <i>Nema komentara</i>
                        @else
                        <table class="table">
                          @for($i = 0; $i < count($ad['comments']); $i++)
                            <tr><th><a href="{{ URL::route('user', $ad['comments'][$i]['user']) }}">{{ $ad['comments'][$i]['user'] }}</a></th><td class="small">{{ date("d.m.Y,\tH:i\h",$ad['comments'][$i]['timestamp']/1000) }}</td><td>{{ $ad['comments'][$i]['text'] }}</td></tr>
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
<script>
jQuery(document).ready(function ($) {

  $('#checkbox').change(function(){
    setInterval(function () {
        moveRight();
    }, 3000);
  });

	var slideCount = $('#slider ul li').length;
	var slideWidth = $('#slider ul li').width();
	var slideHeight = $('#slider ul li').height();
	var sliderUlWidth = slideCount * slideWidth;

	$('#slider').css({ width: slideWidth, height: slideHeight });

	$('#slider ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });

    $('#slider ul li:last-child').prependTo('#slider ul');

    function moveLeft() {
        $('#slider ul').animate({
            left: + slideWidth
        }, 200, function () {
            $('#slider ul li:last-child').prependTo('#slider ul');
            $('#slider ul').css('left', '');
        });
    };

    function moveRight() {
        $('#slider ul').animate({
            left: - slideWidth
        }, 200, function () {
            $('#slider ul li:first-child').appendTo('#slider ul');
            $('#slider ul').css('left', '');
        });
    };

    $('a.control_prev').click(function () {
        moveLeft();
    });

    $('a.control_next').click(function () {
        moveRight();
    });

});
</script>
@endsection
