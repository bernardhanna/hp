<?php
/**
 * Related Posts Section
 * Place this inside your Single Post template (e.g. single.php) after the_content()
 */

$related_section_id = uniqid('related-001-');

// 1) Determine related by shared categories
$categories    = wp_get_post_terms( get_the_ID(), 'category', array( 'fields' => 'ids' ) );
$related_query = new WP_Query( array(
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post__not_in'   => array( get_the_ID() ),
    'category__in'   => $categories,
    'orderby'        => 'date',
    'order'          => 'DESC',
) );

// 2) Fallback to latest posts
if ( ! $related_query->have_posts() ) {
    $related_query = new WP_Query( array(
        'post_type'      => 'post',
        'posts_per_page' => 3,
        'post__not_in'   => array( get_the_ID() ),
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );
}
?>

<?php if ( $related_query->have_posts() ) : ?>
<section id="<?php echo esc_attr( $related_section_id ); ?>" class="flex overflow-hidden relative">
  <div class="flex flex-col items-center pt-5 pb-5 mx-auto w-full max-w-container max-lg:bg-primary">
    <div class="flex flex-col justify-center w-full">
      <div class="relative w-full max-w-[1472px] mx-auto lg:py-20 overflow-hidden lg:rounded-3xl max-md:max-w-full">
        <!-- Optional Background Hero Image -->
        <div class="flex overflow-hidden absolute px-5 top-0 z-0 flex-col w-full left-0 right-0 rounded-3xl max-w-full h-[558px]">
          <img src="/wp-content/uploads/2025/06/image-21.png" alt="" class="w-full object-cover aspect-[2.64] max-md:max-w-full">
        </div>

        <div class="relative flex flex-row items-center justify-between w-full gap-10 text-white max-w-[1216px] mx-auto max-xxl:px-5">
          <div class="flex flex-col my-auto w-full max-w-[961px]">
            <div class="flex gap-4 items-center">
              <span class="gap-6 text-3xl font-bold leading-tight">Related Posts</span>
            </div>
            <p class="mt-4 text-xl leading-7 max-md:max-w-full">
              You might also like these posts
            </p>
          </div>
          <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"
             class="flex overflow-hidden relative justify-center items-center px-0 py-0 bg-transparent rounded border-0 transition-all duration-300 max-mob:hidden group text-tertiary focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500"
             style="max-width: fit-content; height: 56px; padding-left: 1rem;">
            <span class="absolute inset-0 rounded border-2 opacity-0 transition-all duration-300 pointer-events-none border-secondary group-hover:opacity-100 group-focus:opacity-100"
                  style="background-color: #DE7C34; z-index: 0;"></span>
            <span class="overflow-hidden mr-0 max-w-0 text-sm font-semibold whitespace-nowrap opacity-0 slide-label group-hover:max-w-xs group-hover:opacity-100 group-hover:mr-3"
                  style="width:100%;align-items:center;color:black;z-index:1;">View All Posts</span>
            <span class="flex flex-shrink-0 justify-center items-center transition-all duration-300" style="z-index:1;">
              <svg class="btn-svg" width="56" height="56" viewBox="0 0 72 73" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                <rect x="8" y="8.21094" width="56" height="56" rx="4" fill="#DE7C34"></rect>
                <rect x="4" y="4.21094" width="64" height="64" rx="8" stroke="white" stroke-width="8" stroke-opacity="0.1" class="svg-border"></rect>
                <path d="M29 36.2109H43M43 36.2109L36 29.2109M43 36.2109L36 43.2109" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
              </svg>
            </span>
          </a>
        </div>

        <style>
          /* “Peek” on small screens */
          @media (max-width: 639px){
            #<?php echo esc_attr($related_section_id); ?> .related-slider .slick-list { overflow: visible; }
            #<?php echo esc_attr($related_section_id); ?> .related-slider { padding-left: 16px; }
            #<?php echo esc_attr($related_section_id); ?> .related-slider .slick-slide { outline: none; }
            #<?php echo esc_attr($related_section_id); ?> .slick-prev { left: -8px; }
            #<?php echo esc_attr($related_section_id); ?> .slick-next { right: -8px; }
          }
        </style>

        <div class="related-slider z-0 flex flex-wrap items-start w-full gap-4 mt-12 font-bold text-white max-md:mt-10 max-md:max-w-full max-w-[1216px] mx-auto max-lg:px-0 max-xl:px-5">
          <?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
            <a href="<?php the_permalink(); ?>"
               class="group flex overflow-hidden relative flex-col sm:flex-1 sm:shrink xl:rounded-lg
                      min-h-[530px] max-mob:min-h-[300px] max-h-[530px] max-mob:max-h-[300px]
                      min-w-60 max-sm:w-[82vw] sm:w-auto mr-4
                      transition-shadow duration-300 focus-within:ring-4 focus-within:ring-orange-400"
               style="transition: box-shadow .3s cubic-bezier(.4,0,.2,1);">
              <div class="overflow-hidden absolute inset-0 w-full h-full rounded-[8px] md:rounded-lg">
                <?php if ( has_post_thumbnail() ) : ?>
                  <?php the_post_thumbnail( 'hero-large', [
                    'class' => 'object-cover w-full h-full transition-transform duration-500',
                    'alt'   => esc_attr( get_the_title() ),
                  ] ); ?>
                <?php else : ?>
                  <div class="w-full h-full bg-gray-700"></div>
                <?php endif; ?>
                <div class="absolute inset-0 pointer-events-none" style="background: linear-gradient(0deg, #000 0%, rgba(0,0,0,0) 104.03%);"></div>
              </div>
              <div class="flex justify-between items-end px-8 pt-20 pb-6 w-full min-h-[149px] max-md:px-5 h-full absolute bottom-0 z-10">
                <div class="flex flex-col">
                  <span class="text-[12px] md:text-xs leading-none text-white"><?php echo esc_html( get_the_date( 'j M Y' ) ); ?></span>
                  <span class="mt-1 text-2xl leading-none"><?php the_title(); ?></span>
                </div>
                <button aria-label="View post details" type="button" class="transition-colors duration-300 rounded-full p-2 bg-transparent
                           group-hover:bg-[#DA6D1D] group-focus-within:bg-[#DA6D1D] focus-visible:bg-[#DA6D1D]
                           focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-orange-400">
                  <svg width="25" height="25" viewBox="0 0 25 25" fill="none">
                    <path d="M7.66675 17.2109L17.6667 7.21094M17.6667 7.21094H7.66675M17.6667 7.21094V17.2109"
                          stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                </button>
              </div>
            </a>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
jQuery(document).ready(function($) {
  const slider = '#<?php echo esc_js($related_section_id); ?> .related-slider';

  function initRelatedSlick() {
    const useSlider = $(window).width() < 1084;

    if (useSlider && !$(slider).hasClass('slick-initialized')) {
      $(slider).slick({
        mobileFirst: true,
        infinite: false,
        // phones: “peek”
        variableWidth: true,
        centerMode: false,
        slidesToShow: 1, // ignored w/ variableWidth
        swipeToSlide: true,
        touchThreshold: 10,
        edgeFriction: 0.15,
        dots: false,
        arrows: true,
        prevArrow: `<button type="button" class="slick-prev" aria-label="Previous post">
          <svg width="40" height="40" viewBox="0 0 72 73" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="8" y="8" width="56" height="56" rx="4" fill="#DE7C34"/>
            <rect x="4" y="4" width="64" height="64" rx="8" stroke="white" stroke-opacity="0.1" stroke-width="8"/>
            <path d="M43 36H29M29 36L36 29M29 36L36 43" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>`,
        nextArrow: `<button type="button" class="slick-next" aria-label="Next post">
          <svg width="40" height="40" viewBox="0 0 72 73" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="8" y="8" width="56" height="56" rx="4" fill="#DE7C34"/>
            <rect x="4" y="4" width="64" height="64" rx="8" stroke="white" stroke-opacity="0.1" stroke-width="8"/>
            <path d="M29 36H43M43 36L36 29M43 36L36 43" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>`,
        // Step up as width increases (mobileFirst uses min-width)
        responsive: [
          { breakpoint: 640, settings: { variableWidth: false, slidesToShow: 2, centerMode: false } },
          { breakpoint: 900, settings: { variableWidth: false, slidesToShow: 3, centerMode: false } }
        ]
      });
    } else if (!useSlider && $(slider).hasClass('slick-initialized')) {
      $(slider).slick('unslick');
    }
  }

  initRelatedSlick();
  $(window).on('resize', initRelatedSlick);
});
</script>
<?php endif; ?>
