@extends('layouts.app')

@section('content')
  @include('partials.generic-header')

  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, no results were found.', 'sage') }}
    </div>
    {!! get_search_form(false) !!}
  @endif
  <div class="container mt-4">
    <div class="row bricklayer">
  @while (have_posts()) @php the_post() @endphp
    <!--<div class="col col-sm-6 p-4">-->
      @include('partials.cards-content')
    <!--</div>-->
  @endwhile
    </div>
  </div>
  {!! get_the_posts_navigation() !!}
@endsection
