<article @php post_class() @endphp>
  <header>
    @if ( is_singular() ) {!!  $wp_breadcrumb !!} @endif
    @if (!$use_hero)
      <h1 class="entry-title">{{ get_the_title() }}</h1>
      @include('partials/entry-meta')
        @else
        {!! $featured_image !!}
      @endif
  </header>
  <div class="entry-content">
    @if (!$use_hero) {!! $featured_image !!} @endif
    @php the_content() @endphp
  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
  </footer>
  @php comments_template('/partials/comments.blade.php') @endphp
</article>
