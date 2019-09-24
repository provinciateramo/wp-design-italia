@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
  <article @php post_class() @endphp>
    @include('partials.content-singular-header-'.get_post_type())
    @include( 'partials.content-single-'.get_post_type(),[ 'has_toc' => $toc_enabled ] )
  </article>
  @endwhile
@endsection
