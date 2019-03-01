<div class="card-space">
  <div class="card card-bg card-img no-after">
    @if (has_post_thumbnail())
    <div class="img-responsive-wrapper">
      <div class="img-responsive">
        <div class="img-wrapper">
          <img src="{{Single::archive_featured_image()}}" title="img title" alt="imagealt">
        </div>
      </div>
    </div>
    @endif
    <div class="card-body">
     <article id="post-@php the_ID() @endphp" @php post_class() @endphp>
       <header>
         <div class="category-top">
        @include('partials/entry-meta')
         </div>
         <h5 class="card-title"><a href="{{ get_permalink() }}">{{ get_the_title() }}</a></h5>
       </header>
       <p class="card-text">
          @php the_excerpt() @endphp
        </p>
       <a class="read-more" href="{{ get_permalink() }}">
         <span class="text">Leggi di più</span>
         <svg class="icon">
           <use xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-arrow-right"></use>
         </svg>
       </a>
      </article>
    </div>
  </div>
</div>
