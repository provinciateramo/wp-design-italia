@if ($use_hero)
	{!! $featured_image !!}
@endif

<div class="row border-top row-column-border row-column-menu-left">
	@includeWhen($has_toc, 'partials.it-navigation-heading')
	<section class="@php echo ($has_toc) ?'col-lg-8 it-page-sections-container':'col-lg-12';@endphp">
		@if (!$use_hero) {!! $featured_image !!} @endif
		@php the_content() @endphp
	</section>
</div>
<footer>
	{!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
</footer>
@php comments_template('/partials/comments.blade.php') @endphp