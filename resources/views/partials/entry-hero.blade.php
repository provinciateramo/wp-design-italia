<div class="it-hero-wrapper it-hero-small-size it-primary it-overlay">
  <div class="img-responsive-wrapper">
    <div class="img-responsive">
      <div class="img-wrapper">
        <img src="{{ $image }}" title="'.$image_title.'" alt="{{ $image_title }}" />
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="it-hero-text-wrapper bg-dark">
          <span class="it-category"><?php the_category(', '); ?></span>
          <h1 class="no_toc">{!! get_the_title() !!}</h1>
          <p class="d-none d-lg-block"><time class="updated" datetime="{{ get_post_time('c', true) }}">{{ get_the_date() }}</time></p>
            @if (App::show_author())
          <p class="byline author vcard">
            {{ __('By', 'sage') }} <a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" rel="author" class="fn">
              {{ get_the_author() }}
            </a>
          </p>
          @endif
          @if (has_excerpt())
          <p class="d-none d-lg-block"><?php echo get_post()->post_excerpt ?></p>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
