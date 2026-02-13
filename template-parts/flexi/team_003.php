<?php
$section_id     = uniqid('team-slider-');
$heading        = get_sub_field('heading');
$heading_tag    = get_sub_field('heading_tag') ?: 'h2';
$text_color     = get_sub_field('text_color') ?: '#334155';
$caption_color  = get_sub_field('caption_text_color') ?: '#334155';
$role_color     = get_sub_field('role_text_color') ?: '#64748b';
$bg_color       = get_sub_field('bg_color') ?: '#ffffff';
$border_radius  = get_sub_field('border_radius') ?: 'rounded-2xl';

// Padding classes
$padding_classes = ['pt-5', 'pb-5'];
if (have_rows('padding_settings')) {
    while (have_rows('padding_settings')) {
        the_row();
        $screen_size = get_sub_field('screen_size');
        $pt = get_sub_field('padding_top');
        $pb = get_sub_field('padding_bottom');
        $padding_classes[] = "{$screen_size}:pt-[{$pt}rem]";
        $padding_classes[] = "{$screen_size}:pb-[{$pb}rem]";
    }
}
?>

<style>
  /* Team wrapper: add gutter AFTER the first move; keep it always on xl grid */
  #<?php echo esc_attr($section_id); ?> .team-wrapper.has-pad {
    padding-left: 1.25rem;  /* ~px-5 */
    padding-right: 1.25rem; /* ~px-5 */
  }
  @media (min-width: 1280px) {
    #<?php echo esc_attr($section_id); ?> .team-wrapper {
      padding-left: 1.25rem;
      padding-right: 1.25rem;
    }
  }
</style>

<section id="<?php echo esc_attr($section_id); ?>" class="flex overflow-hidden relative">
  <div class="flex flex-col items-center w-full mx-auto max-w-[1480px] <?php echo esc_attr(implode(' ', $padding_classes)); ?> max-lg:px-5">
    <div class="flex flex-col justify-start w-full">

      <!-- Heading + external arrows (mobile/tablet only) -->
      <div class="flex items-center w-full">
        <<?php echo esc_attr($heading_tag); ?> class="w-full text-2xl font-bold leading-7" style="color: <?php echo esc_attr($text_color); ?>">
          <?php echo esc_html($heading); ?>
        </<?php echo esc_attr($heading_tag); ?>>

        <!-- External arrow controls -->
        <div class="flex gap-2 items-center ml-auto w-full xl:hidden team-arrows">
          <nav class="box-border flex gap-4 justify-end items-center px-0 mx-0 my-0 w-full"
               role="navigation"
               aria-label="Team navigation">

            <!-- PREV -->
            <button type="button"
                    class="btn flex justify-center items-center bg-gray-300 rounded-lg transition-all cursor-pointer duration-[0.2s] ease-[ease] hover:bg-gray-400 focus:bg-gray-400 h-[40px] w-[40px]"
                    aria-label="Previous team members"
                    title="Go to previous team members">
              <span class="flex justify-center items-center w-6 h-6 shrink-0" aria-hidden="true">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Left arrow icon">
                  <path d="M19 12H5M5 12L12 19M5 12L12 5"
                        stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
            </button>

            <!-- NEXT -->
            <button type="button"
                    class="btn flex justify-center items-center bg-gray-300 rounded-lg transition-all cursor-pointer duration-[0.2s] ease-[ease] hover:bg-gray-400 focus:bg-gray-400 h-[40px] w-[40px]"
                    aria-label="Next team members"
                    title="Go to next team members">
              <span class="flex justify-center items-center w-6 h-6 shrink-0" aria-hidden="true">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Right arrow icon">
                  <path d="M5 12H19M19 12L12 5M19 12L12 19"
                        stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
            </button>
          </nav>
        </div>
      </div>

      <?php if (have_rows('team_members')): ?>
        <!-- Wrapper starts with NO padding; JS will add .has-pad after first move -->
        <div class="w-full team-wrapper">
          <!-- Grid (desktop) → becomes slick slider on <1280px -->
          <div class="grid grid-cols-2 gap-6 mt-6 w-full team-slider max-mob:grid-cols-1 lg:grid-cols-3 xl:grid-cols-4">
            <?php while (have_rows('team_members')): the_row(); 
                $image = get_sub_field('image');
                $name  = get_sub_field('name');
                $role  = get_sub_field('role');
            ?>
              <figure class="relative flex flex-col justify-end overflow-hidden px-6 pb-6 <?php echo esc_attr($border_radius); ?> min-h-[480px] max-md:px-5 max-md:pt-24" style="background-color: <?php echo esc_attr($bg_color); ?>">
                <?php if ($image): ?>
                  <img src="<?php echo esc_url($image['url']); ?>"
                       alt="<?php echo esc_attr($image['alt'] ?: $name); ?>"
                       title="<?php echo esc_attr($image['title'] ?: $name); ?>"
                       class="object-cover absolute inset-0 w-full h-full" />
                <?php endif; ?>
                <figcaption class="flex relative flex-col items-start px-6 py-4 w-full bg-white rounded-lg max-md:px-5">
                  <span class="text-2xl font-bold leading-none" style="color: <?php echo esc_attr($caption_color); ?>"><?php echo esc_html($name); ?></span>
                  <p class="text-sm font-semibold leading-none" style="color: <?php echo esc_attr($role_color); ?>"><?php echo esc_html($role); ?></p>
                </figcaption>
              </figure>
            <?php endwhile; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<script>
jQuery(function($) {
  const $wrap    = $('#<?php echo esc_js($section_id); ?>');
  const $slider  = $wrap.find('.team-slider');
  const $wrapPad = $wrap.find('.team-wrapper');
  const xlMQ     = window.matchMedia('(min-width: 1280px)'); // Tailwind xl

  // External arrows
  const $prevBtn = $wrap.find('.team-arrows [aria-label="Previous team members"]');
  const $nextBtn = $wrap.find('.team-arrows [aria-label="Next team members"]');

  function toggleWrapperPadding(index) {
    if ($slider.hasClass('slick-initialized')) {
      if (index > 0) { $wrapPad.addClass('has-pad'); } else { $wrapPad.removeClass('has-pad'); }
    } else {
      $wrapPad.removeClass('has-pad'); // xl padding handled by CSS
    }
  }

  function initTeamSlider() {
    if ($slider.hasClass('slick-initialized')) return;

    // Remove grid classes to avoid fighting slick layout
    $slider.removeClass('grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4').addClass('flex');

    // Bind events BEFORE init
    $slider
      .off('.team') // clean namespace in case of rebind
      .on('init.team',               function(e, slick){ toggleWrapperPadding(slick.currentSlide); })
      .on('beforeChange.team',       function(e, slick, curr, next){ toggleWrapperPadding(next); })
      .on('afterChange.team',        function(e, slick, curr){ toggleWrapperPadding(curr); })
      .on('setPosition.team reInit.team', function(e, slick){ toggleWrapperPadding(slick.currentSlide); })
      .on('destroy.team',            function(){
        // Slick just unslicked (e.g., via responsive 'unslick')
        $slider.removeClass('flex').addClass('grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4');
        $wrapPad.removeClass('has-pad');
      });

    $slider.slick({
      mobileFirst: true,
      infinite: false,
      dots: false,
      arrows: true,
      prevArrow: $prevBtn,
      nextArrow: $nextBtn,
      centerMode: false,
      slidesToShow: 1,
      slidesToScroll: 1,
      responsive: [
        { breakpoint: 640,  settings: { slidesToShow: 2 } },
        { breakpoint: 1024, settings: { slidesToShow: 3 } },
        // At ≥1280px (with mobileFirst), let Slick UNSLICK itself
        { breakpoint: 1280, settings: 'unslick' }
      ]
    });
  }

  function ensureMode() {
    if (xlMQ.matches) {
      // Desktop: if slider is active, unslick (in case responsive didn't fire yet)
      if ($slider.hasClass('slick-initialized')) {
        $slider.slick('unslick');
        // 'destroy' handler restores grid + removes has-pad
      } else {
        // Ensure grid classes exist (if coming from SSR or previous state)
        $slider.removeClass('flex').addClass('grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4');
        $wrapPad.removeClass('has-pad'); // xl CSS handles padding
      }
    } else {
      // Mobile/tablet: ensure slider is initialized
      initTeamSlider();
      if ($slider.hasClass('slick-initialized')) {
        const slick = $slider.slick('getSlick');
        toggleWrapperPadding(slick ? slick.currentSlide : 0);
      }
    }
  }

  // Initial + responsive
  ensureMode();

  // React to breakpoint changes (more reliable than window.resize alone)
  if (xlMQ.addEventListener) {
    xlMQ.addEventListener('change', ensureMode);
  } else if (xlMQ.addListener) { // Safari/old
    xlMQ.addListener(ensureMode);
  }

  // Fallback on resize as well (debounced)
  let raf = null;
  $(window).on('resize orientationchange', function(){
    if (raf) return;
    raf = requestAnimationFrame(function(){ ensureMode(); raf = null; });
  });
});
</script>
