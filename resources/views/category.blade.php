@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, no results were found.', 'sage') }}
    </div>
    {!! get_search_form(false) !!}
  @endif
  <div class="row mt-4">
    <div class="card-columns ">
  @while (have_posts()) @php the_post() @endphp
    <!--<div class="col col-sm-6 p-4">
      <div class="border-top border-primary border-top-thick">-->
      @include('partials.content')
      <!--</div>
    </div>-->
  @endwhile
    </div>
  </div>
  {!! get_the_posts_navigation() !!}
@endsection
