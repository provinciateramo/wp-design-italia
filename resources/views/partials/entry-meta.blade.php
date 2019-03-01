<p class="m-0"><strong>&#9679; <?php the_category( ', ' ); ?></strong></p>
<time class="updated" datetime="{{ get_post_time('c', true) }}">{{ get_the_date() }}</time>
@if (App::show_author())
<p class="byline author vcard">
  {{ __('By', 'sage') }} <a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" rel="author" class="fn">
    {{ get_the_author() }}
  </a>
</p>
@endif
