<?php
$id = uniqid('services-001-');
$section_heading = get_sub_field('section_heading');
$services = get_sub_field('services');

$padding_classes = ['pt-5', 'pb-5'];
if (have_rows('padding_settings')) {
    while (have_rows('padding_settings')) {
        the_row();
        $screen = get_sub_field('screen_size');
        $pt = get_sub_field('padding_top');
        $pb = get_sub_field('padding_bottom');
        $padding_classes[] = "{$screen}:pt-[{$pt}rem]";
        $padding_classes[] = "{$screen}:pb-[{$pb}rem]";
    }
}
?>

<style>
  /* Helper: add a left/right gutter AFTER user moves off slide 0 */
  #<?php echo esc_attr($id); ?> .services-wrapper.has-pad {
    padding-left: 2.25rem;  /* ~px-5 */
    padding-right: 1.25rem; /* ~px-5 */
  }
  /* XL grid (unslicked) should always have the same padding */
  @media (min-width: 1280px) {
    #<?php echo esc_attr($id); ?> .services-wrapper {
      padding-left: 1.25rem;
      padding-right: 1.25rem;
    }
  }
</style>

<section id="<?php echo esc_attr($id); ?>" class="flex overflow-hidden relative">
  <div class="flex flex-col items-center w-full mx-auto max-w-[1480px] <?php echo esc_attr(implode(' ', $padding_classes)); ?>">
    <div class="flex flex-col gap-6 justify-center items-start w-full bg-white">

      <!-- Heading row with your arrows on the right -->
      <div class="flex items-center w-full">
        <?php if ($section_heading): ?>
          <span class="text-3xl font-bold leading-9 text-primary max-sm:text-2xl max-sm:leading-8">
            <?php echo esc_html($section_heading); ?>
          </span>
        <?php endif; ?>

        <!-- External controls (hidden on xl and up) -->
        <div class="flex gap-2 items-center ml-auto w-full xl:hidden services-arrows">
          <nav class="box-border flex justify-between items-center px-5 mx-auto my-0 w-full"
               role="navigation"
               aria-label="Services navigation">
            <div class="flex-1">
              <span class="text-2xl font-bold leading-7 text-slate-600">Our services</span>
            </div>

            <div class="flex gap-6 items-center max-md:gap-4 max-sm:gap-3 max-sm:self-end"
                 role="group"
                 aria-label="Navigation controls">

              <!-- PREV -->
              <button type="button"
                      class="btn flex justify-center items-center bg-gray-300 rounded-lg transition-all cursor-pointer duration-[0.2s] ease-[ease] hover:bg-gray-400 focus:bg-gray-400 h-[40px] w-[40px]"
                      aria-label="Previous services"
                      title="Go to previous services">
                <span class="flex justify-center items-center w-6 h-6 shrink-0" aria-hidden="true">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Left arrow icon">
                    <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </button>

              <!-- NEXT -->
              <button type="button"
                      class="btn flex justify-center items-center bg-gray-300 rounded-lg transition-all cursor-pointer duration-[0.2s] ease-[ease] hover:bg-gray-400 focus:bg-gray-400 h-[40px] w-[40px]"
                      aria-label="Next services"
                      title="Go to next services">
                <span class="flex justify-center items-center w-6 h-6 shrink-0" aria-hidden="true">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Right arrow icon">
                    <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </button>
            </div>
          </nav>
        </div>
      </div>

      <!-- Wrapper starts with NO padding; JS will add .has-pad after first move -->
      <div class="w-full services-wrapper">
        <!-- Flex by default; xl+ becomes 4-col grid (unslicked) -->
        <div class="flex flex-wrap gap-8 items-stretch xl:grid xl:grid-cols-4 xl:auto-rows-fr xl:gap-8 services-slider">
          <?php if (!empty($services)) : foreach ($services as $service): ?>
            <?php $link = $service['link']; $url = $link['url'] ?? ''; $target = $link['target'] ?? '_self'; ?>
            <?php if ($url): ?><a href="<?php echo esc_url($url); ?>" target="<?php echo esc_attr($target); ?>" class="block h-full group"><?php endif; ?>

            <div class="flex flex-col gap-4 items-start p-8 w-full h-full bg-white rounded-2xl border-2 border-solid transition-all duration-300 ease-in-out cursor-pointer service-card group hover:bg-primary border-primary max-sm:p-6 group-hover:bg-accent-greenDark group-hover:text-white">
              <div class="flex relative items-start w-full">
                <?php if (!empty($service['icon'])): ?>
                  <div class="flex justify-center items-center min-w-[48px] h-[48px] bg-amber-600 rounded-lg mr-4" aria-hidden="true">
                    <img src="<?php echo esc_url($service['icon']['url']); ?>" alt="<?php echo esc_attr($service['icon']['alt'] ?: 'Icon'); ?>" class="object-contain" />
                  </div>
                <?php endif; ?>
                <div class="flex flex-row gap-4 justify-between items-center h-full">
                  <span class="text-lg font-bold leading-6 text-primary max-sm:text-base max-sm:leading-6 group-hover:text-white">
                    <?php echo esc_html($service['title']); ?>
                  </span>
                  <span class="flex justify-center items-center w-6 h-6 text-primary group-hover:text-white" aria-hidden="true">
                    <svg width="24" height="24" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M5 12.2109H19M19 12.2109L12 5.21094M19 12.2109L12 19.2109" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                  </span>
                </div>
              </div>
              <div class="text-base leading-6 text-slate-700 max-sm:text-sm max-sm:leading-5 wp_editor group-hover:text-white">
                <?php echo wp_kses_post($service['description']); ?>
              </div>
            </div>

            <?php if ($url): ?></a><?php endif; ?>
          <?php endforeach; endif; ?>
        </div>
      </div>

    </div>
  </div>
</section>

<script>
jQuery(function($) {
  const $wrap     = $('#<?php echo esc_js($id); ?>');
  const $slider   = $wrap.find('.services-slider');
  const $wrapper  = $wrap.find('.services-wrapper');
  const XL        = 1280; // Tailwind xl breakpoint

  const $prevBtn  = $wrap.find('.services-arrows [aria-label="Previous services"]');
  const $nextBtn  = $wrap.find('.services-arrows [aria-label="Next services"]');

  function toggleWrapperPadding(index) {
    // On slider (mobile/tablet): no padding on first slide; add after user moves
    if ($slider.hasClass('slick-initialized')) {
      if (index > 0) { $wrapper.addClass('has-pad'); } else { $wrapper.removeClass('has-pad'); }
    } else {
      // On XL grid (unslicked) padding is handled by CSS media query
      $wrapper.removeClass('has-pad');
    }
  }

  function equalize() {
    if (!$slider.hasClass('slick-initialized')) {
      $slider.find('.service-card').css('height','');
      return;
    }
    let max = 0;
    const $cards = $slider.find('.service-card').css('height','auto');
    $cards.each(function(){ max = Math.max(max, $(this).outerHeight()); });
    if (max) $cards.height(max);
  }

  function bindSlickEvents() {
    $slider
      .on('init',               function(e, slick){ toggleWrapperPadding(slick.currentSlide); })
      .on('beforeChange',       function(e, slick, curr, next){ toggleWrapperPadding(next); })
      .on('afterChange',        function(e, slick, curr){ toggleWrapperPadding(curr); })
      .on('setPosition reInit', function(e, slick){ toggleWrapperPadding(slick.currentSlide); equalize(); });
  }

  function initSlick() {
    if ($slider.hasClass('slick-initialized')) return;
    bindSlickEvents();
    $slider.slick({
      mobileFirst: true,
      infinite: false,
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: false,
      arrows: true,
      prevArrow: $prevBtn,
      nextArrow: $nextBtn,
      responsive: [
        { breakpoint: 768,  settings: { slidesToShow: 2 } },
        { breakpoint: 1084, settings: { slidesToShow: 3 } }
      ]
    });
  }

  function destroySlick() {
    if ($slider.hasClass('slick-initialized')) {
      $slider.slick('unslick');
      $slider.find('.service-card').css({height:'', width:''});
    }
    // XL grid padding comes from CSS; ensure helper is off
    $wrapper.removeClass('has-pad');
  }

  function update() {
    if (window.innerWidth < XL) { initSlick(); } else { destroySlick(); }
    // Set wrapper padding correctly for current mode
    if ($slider.hasClass('slick-initialized')) {
      const slick = $slider.slick('getSlick');
      toggleWrapperPadding(slick ? slick.currentSlide : 0);
    } else {
      $wrapper.removeClass('has-pad'); // CSS handles xl
    }
  }

  update();
  let raf = null;
  $(window).on('resize', function(){
    if (raf) return;
    raf = requestAnimationFrame(function(){ update(); raf = null; });
  });
  $(window).on('load', update);
});
</script>
