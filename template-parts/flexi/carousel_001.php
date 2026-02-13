<style>
  .carousel_001 .slick-track {
    gap: 0;
    overflow: hidden;
  }

  .carousel_001 .slick-prev {
    left: 2.8rem;
  }

  .carousel_001 .slick-next {
    right: 2.8rem;
  }

  @media (max-width: 1300px) {
    .carousel_001 .slick-prev { left: 0px; }
    .carousel_001 .slick-next { right: 0px; }
  }

  /* Desktop / default dots placement (bottom-right) */
  .carousel_001 .slick-dots {
    position: absolute;
    bottom: 5.5rem;
    right: 2.8rem;
    display: flex !important;
  }

  /* Mobile: dots become part of the overlay flow (we move them into the active slide overlay) */
@media (max-width: 640px) {
  .carousel_001 .slick-dots {
    position: relative;
    bottom: auto;
    right: auto;
    left: auto !important;

    /* make them align left */
    display: flex !important;
    justify-content: flex-start !important;
    text-align: left;

    /* optional cleanups */
    width: auto;
    margin: 0;
    padding: 0;
  }
}

  .carousel_001 .indicator {
    background-color: white;
    display: inline-block;
    padding: 0;
    border-radius: unset;
    width: 32px;
    height: 4px;
  }

  .carousel_001 .slick-dots li.slick-active .indicator {
    background-color: #F59E0B; /* amber-600 */
  }

  .carousel_001 .slick-dots li button {
    border-radius: unset;
    width: 32px;
    height: 4px;
  }
</style>

<?php
// Variables Setup
$background_color     = get_sub_field('background_color');
$text_color           = get_sub_field('text_color');
$image_border_radius  = get_sub_field('image_border_radius');
$padding_classes      = [];

if (have_rows('padding_settings')) {
  while (have_rows('padding_settings')) {
    the_row();
    $screen_size    = get_sub_field('screen_size');
    $padding_top    = get_sub_field('padding_top');
    $padding_bottom = get_sub_field('padding_bottom');

    $padding_classes[] = "{$screen_size}:pt-[{$padding_top}rem]";
    $padding_classes[] = "{$screen_size}:pb-[{$padding_bottom}rem]";
  }
}

$padding_classes = implode(' ', $padding_classes);
$section_id      = 'carousel-' . wp_rand();
$margin_classes  = 'mt-[6rem] lg:mt-[10rem]'; // non-admin default

if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) {
  // Treat as "WP admin is logged in"
  $margin_classes = 'mt-[4rem] lg:mt-[8rem]';
}
?>

<div class="relative <?php echo esc_attr($margin_classes); ?>"></div>

<section id="<?php echo esc_attr($section_id); ?>" class="flex overflow-hidden relative carousel_001">
  <div class="relative flex flex-col items-center w-full mx-auto max-w-container px-2 max-xxl:px-5 <?php echo esc_attr($padding_classes); ?>">

    <div class="slider slick-slider w-full max-w-[1472px] mx-auto px-0 lg::pt-10 lg:pb-16">

      <?php if (have_rows('carousel_slides')): ?>
        <?php while (have_rows('carousel_slides')): the_row();
          $slide_image        = get_sub_field('slide_image');
          $slide_decorative   = get_sub_field('slide_decorative');
          $slide_heading_tag  = get_sub_field('slide_heading_tag') ?: 'h2';
          $slide_heading      = get_sub_field('slide_heading');
          $slide_description  = get_sub_field('slide_description');
        ?>
          <div class="relative p-0 h-[620px] rounded-[32px] overflow-hidden max-md:h-[500px] max-sm:h-[400px]">
            <?php if (!empty($slide_image)): ?>
              <img
                src="<?php echo esc_url($slide_image['url']); ?>"
                <?php if ($slide_decorative): ?>
                  alt="" role="presentation"
                <?php else: ?>
                  alt="<?php echo esc_attr($slide_image['alt']); ?>"
                  title="<?php echo esc_attr($slide_image['title']); ?>"
                <?php endif; ?>
                class="object-cover w-full h-full"
              />
            <?php endif; ?>

            <!-- Overlay (mobile should show dots ABOVE the title inside this container) -->
            <div class="flex absolute inset-x-0 bottom-0 flex-col gap-1 px-8 py-6 to-transparent slide-overlay sm:bg-gradient-to-t max-sm:p-4 sm:from-black/60 max-sm:bg-primary">
              <!-- Slick will prepend the dots UL here on mobile -->
              <?php if (!empty($slide_heading)): ?>
                <<?php echo esc_attr($slide_heading_tag); ?> class="text-2xl font-bold text-white max-sm:text-lg">
                  <?php echo esc_html($slide_heading); ?>
                </<?php echo esc_attr($slide_heading_tag); ?>>
              <?php endif; ?>

              <?php if (!empty($slide_description)): ?>
                <div class="text-xs text-white max-sm:text-xs wp_editor">
                  <?php echo $slide_description; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>

    </div>
  </div>
</section>

<script>
  jQuery(function($) {
    var $section = $('#<?php echo esc_js($section_id); ?>');
    var $slider  = $section.find('.slider');

    function isMobile() {
      return window.matchMedia('(max-width: 640px)').matches;
    }

    function placeDotsAt(index) {
      var $dots = $slider.find('.slick-dots');
      if (!$dots.length) return;

      if (isMobile()) {
        // Prefer the non-cloned slide overlay for stability
        var $target = $slider.find('.slick-slide[data-slick-index="' + index + '"]:not(.slick-cloned) .slide-overlay');

        if (!$target.length) {
          $target = $slider.find('.slick-slide[data-slick-index="' + index + '"] .slide-overlay').first();
        }

        if ($target.length) {
          // Put dots ABOVE the heading
          $target.prepend($dots);
        }
      } else {
        // Desktop: restore to slider root (abs pos via CSS)
        $slider.append($dots);
      }
    }

    // Bind BEFORE init so first paint is correct on mobile
    $slider.on('init', function(event, slick) {
      placeDotsAt(slick.currentSlide);
      // Second pass after layout settles (fonts, etc.)
      setTimeout(function(){ placeDotsAt(slick.currentSlide); }, 0);
    });

    // Keep dots anchored during navigation and reflows
    $slider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
      placeDotsAt(nextSlide);
    });
    $slider.on('afterChange', function(event, slick, currentSlide) {
      placeDotsAt(currentSlide);
    });
    $slider.on('setPosition reInit', function(event, slick) {
      placeDotsAt(slick.currentSlide);
    });

    // Init slick (note: handler already bound above)
    $slider.slick({
      arrows: true,
      dots: true,
      infinite: true,
      speed: 600,
      fade: true,
      cssEase: 'linear',
      autoplay: true,
      autoplaySpeed: 4000,
      slidesToShow: 1,
      slidesToScroll: 1,
      customPaging: function(slider, i) {
        return '<button class="indicator max-sm:w-6" role="tab" aria-label="Project ' + (i + 1) + '"></button>';
      },
      prevArrow: `<button class="absolute top-1/2 z-10 p-3 bg-white rounded-full transition-colors duration-200 -translate-y-1/2 cursor-pointer max-sm:hidden hover:bg-orange-500 slick-prev custom-arrow slick-arrow group" aria-label="Previous">
        <svg width="56" height="57" viewBox="0 0 56 57" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect y="0.210938" width="56" height="56" rx="8" fill="white" class="transition-colors duration-200 group-hover:fill-orange-500"></rect>
          <path d="M35 28.2109H21M21 28.2109L28 35.2109M21 28.2109L28 21.2109" stroke="#344054" class="transition-colors duration-200" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
      </button>`,
      nextArrow: `<button class="absolute top-1/2 z-10 p-3 bg-white rounded-full transition-colors duration-200 -translate-y-1/2 cursor-pointer max-sm:hidden hover:bg-orange-500 slick-next custom-arrow group" aria-label="Next">
        <svg width="56" height="57" viewBox="0 0 56 57" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect y="0.210938" width="56" height="56" rx="8" fill="white" class="transition-colors duration-200 group-hover:fill-orange-500"/>
          <path d="M21 28.2109H35M35 28.2109L28 21.2109M35 28.2109L28 35.2109" stroke="#344054" class="transition-colors duration-200" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>`,
      responsive: [
        {
          breakpoint: 641,
          settings: { arrows: false }
        }
      ]
    });

    // Debounced resize relayout
    var resizeTimer;
    $(window).on('resize', function() {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function() {
        var slick = $slider.slick('getSlick');
        placeDotsAt(slick.currentSlide);
      }, 150);
    });
  });
</script>