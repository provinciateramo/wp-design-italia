<div class="card-wrapper card-space p-2">
  <div class="card card-bg card-img no-after" id="post-@php the_ID() @endphp">
    @if (has_post_thumbnail())
    <div class="img-responsive-wrapper">
      <div class="img-responsive">
        <div class="img-wrapper">
          <img src="{{Singular::archive_featured_image()}}" title="img title" alt="imagealt">
        </div>
      </div>
    </div>
    @endif
    <div class="card-body">
       <h5 class="card-title"><a href="{{ get_permalink() }}">{{ get_the_title() }}</a></h5>
       <p class="card-text">
          @php the_excerpt() @endphp
        </p>
       <a class="read-more" href="{{ get_permalink() }}">
         <span class="text">Leggi di più</span>
         <svg class="icon">
           <use xlink:href="{{ \App\asset_path('bootstrap-italia/svg/sprite.svg') }}#it-arrow-right"></use>
         </svg>
       </a>
       <div class="it-card-footer2 mt-3">
         {!! \app\Controllers\Category::category_links() !!}
       </div>

    </div>
  </div>
</div>
