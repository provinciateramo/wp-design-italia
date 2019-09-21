@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, no results were found.', 'sage') }}
    </div>
    {!! get_search_form(false) !!}
  @endif
  <div class="container mt-4">
    <div class="row">
  @while (have_posts()) @php the_post() @endphp
    <div class="col col-sm-6 col-lg-4">
    @include('partials.content')
    </div>
  @endwhile
    </div>
  </div>
  {!! get_the_posts_navigation() !!}
@endsection
