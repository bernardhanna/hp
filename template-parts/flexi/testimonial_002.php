<style>
  .testimonial-slider-container { position: relative; width: 100%; }
  .testimonial-slider { width: 100%; }
  .testimonial-slide { outline: none; }

  .testimonial-slider .slick-dots { display: none !important; }
  .testimonial-slider .slick-arrow { display: none !important; }
  .testimonial-slider .slick-list { overflow: hidden; }
  .testimonial-slider .slick-track { display: flex; align-items: stretch; transition: transform 0.5s ease; }
  .testimonial-slider .slick-slide { height: auto; }
  .testimonial-slider .slick-slide > div { height: 100%; }

  .slick-prev-custom, .slick-next-custom { z-index: 10; transition: all 0.3s ease; }
  .slick-prev-custom:hover, .slick-next-custom:hover { transform: translateY(-50%) scale(1.05); }
  .slick-prev-custom:focus, .slick-next-custom:focus { outline: 2px solid #059669; outline-offset: 2px; }

  @media (max-width: 768px) {
    .slick-prev-custom { left: 1rem; }
    .slick-next-custom { right: 1rem; }
  }

  /* Only after Slick is initialized */
  .testimonial-slider.slick-initialized [aria-hidden="true"] { pointer-events: none; }
  .testimonial-slider.slick-initialized .testimonial-slide:not(.slick-active) { visibility: hidden; }
  .testimonial-slider.slick-initialized .testimonial-slide.slick-active { visibility: visible; }

  .testimonial-slider.slick-loading { opacity: 0.5; }
  .testimonial-slider.slick-initialized { opacity: 1; transition: opacity 0.3s ease; }
</style>

<?php
$source       = get_sub_field('source') ?: 'manual';
$section_id   = 'testimonial-slider-' . uniqid();

$items = [];

$quote_text_size_lg_value = get_sub_field('quote_text_size_lg_value');
$quote_line_height_lg_rem = get_sub_field('quote_line_height_lg_rem');
$quote_text_size_class    = 'lg:text-2xl';
$blockquote_style_attr    = '';

if (!empty($quote_text_size_lg_value)) {
    $raw = trim((string)$quote_text_size_lg_value);
    if (preg_match('/^\d+(\.\d+)?$/', $raw)) { $raw .= 'px'; }
    if (preg_match('/^-?\d+(\.\d+)?(px|rem|em|%)$/', $raw)) {
        $quote_text_size_class = 'lg:text-[' . esc_attr($raw) . ']';
    }
}

if (!empty($quote_line_height_lg_rem) && is_numeric($quote_line_height_lg_rem)) {
    $rem = (float)$quote_line_height_lg_rem;
    if ($rem > 0) $blockquote_style_attr = 'line-height: ' . esc_attr($rem) . 'rem;';
}

if ($source === 'posts') {
    $post_ids = get_sub_field('testimonial_posts');
    if (is_array($post_ids) && !empty($post_ids)) {
        foreach ($post_ids as $pid) {
            $pid = (int) $pid;
            if (!$pid) continue;

            $thumb_url   = get_the_post_thumbnail_url($pid, 'large');
            $thumb_id    = get_post_thumbnail_id($pid);
            $thumb_alt   = $thumb_id ? get_post_meta($thumb_id, '_wp_attachment_image_alt', true) : '';
            $thumb_title = $thumb_id ? get_the_title($thumb_id) : '';

            $quote   = apply_filters('the_content', get_post_field('post_content', $pid));
            $name    = get_the_title($pid);
            $excerpt = get_the_excerpt($pid);

            $items[] = [
                'quote_html'   => $quote,
                'author_name'  => $name,
                'author_title' => $excerpt,
                'image_url'    => $thumb_url,
                'image_alt'    => $thumb_alt ?: $name,
                'image_title'  => $thumb_title ?: $name,
            ];
        }
    }
} else {
    $manual = get_sub_field('testimonials');
    if (is_array($manual) && !empty($manual)) {
        foreach ($manual as $row) {
            $img = $row['testimonial_image'] ?? null;
            $items[] = [
                'quote_html'   => wp_kses_post($row['quote_text'] ?? ''),
                'author_name'  => $row['author_name'] ?? '',
                'author_title' => $row['author_title'] ?? '',
                'image_url'    => is_array($img) && !empty($img['url']) ? $img['url'] : '',
                'image_alt'    => is_array($img) && !empty($img['alt']) ? $img['alt'] : ($row['author_name'] ?? 'Testimonial author photo'),
                'image_title'  => is_array($img) && !empty($img['title']) ? $img['title'] : ($row['author_name'] ?? 'Image'),
            ];
        }
    }
}

$has_multiple = count($items) > 1;

$padding_classes = ['lg:pt-5', 'lg:pb-5'];
if (have_rows('padding_settings')) {
    $padding_classes = [];
    while (have_rows('padding_settings')) {
        the_row();
        $screen_size    = get_sub_field('screen_size');
        $padding_top    = get_sub_field('padding_top');
        $padding_bottom = get_sub_field('padding_bottom');

        if ($screen_size !== '' && $padding_top !== '' && $padding_top !== null) {
          $padding_classes[] = "{$screen_size}:pt-[{$padding_top}rem]";
        }
        if ($screen_size !== '' && $padding_bottom !== '' && $padding_bottom !== null) {
          $padding_classes[] = "{$screen_size}:pb-[{$padding_bottom}rem]";
        }
    }
}
$padding_class_string = implode(' ', $padding_classes);
?>

<section id="<?php echo esc_attr($section_id); ?>" class="flex overflow-hidden relative testimonial-slider-container" role="region" aria-label="Customer testimonials">
  <div class="flex flex-col items-center w-full mx-auto max-w-container pt-5 pb-5 max-lg:px-5 <?php echo esc_attr($padding_class_string); ?>">

    <div class="w-full testimonial-slider">
      <?php if (!empty($items)) : ?>
        <?php foreach ($items as $index => $it) :
          $quote_html  = $it['quote_html'] ?? '';
          $author_name = $it['author_name'] ?? '';
          $author_sub  = $it['author_title'] ?? '';
          $img_url     = $it['image_url'] ?? '';
          $img_alt     = $it['image_alt'] ?? 'Testimonial author photo';
          $img_title   = $it['image_title'] ?? 'Image';
        ?>
        <article class="testimonial-slide">
          <div class="flex relative flex-col gap-10 mx-auto w-full max-w-[1216px] lg:pt-8 pb-5 xl:pb-20 lg:flex-row items-center">
            <div class="overflow-hidden z-0 rounded-lg min-w-60 w-full max-w-[352px]">
              <?php if (!empty($img_url)) : ?>
                <img
                  src="<?php echo esc_url($img_url); ?>"
                  alt="<?php echo esc_attr($img_alt); ?>"
                  title="<?php echo esc_attr($img_title); ?>"
                  class="object-contain w-full h-full rounded-lg"
                />
              <?php endif; ?>
            </div>

            <div class="flex relative z-0 flex-col justify-center items-start px-8 lg:flex-1 lg:self-stretch min-w-60 max-xl:px-12 max-md:max-w-full">
              <?php
              $blockquote_classes = [
                'z-0',
                'self-stretch',
                'text-[20px]',
                $quote_text_size_class,
                'font-bold',
                'text-green-950',
                'max-md:max-w-full',
              ];
              if (empty($blockquote_style_attr)) $blockquote_classes[] = 'leading-7';
              ?>

            <?php if ($has_multiple): ?>
              <!-- Indicators ABOVE the blockquote with SVG to the LEFT -->
              <nav class="flex gap-4 justify-center mb-4 testimonial-progress-indicators" aria-label="Testimonial Progress">
                <!-- SVG sits absolutely at the left, not a <div> so it won't be touched by JS -->
                <span class="absolute -left-6 -top-[1rem]" aria-hidden="true">
                  <svg width="44" height="35" viewBox="0 0 44 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18.8 0.0104449L12.2 24.0104L10 15.0104C12.8667 15.0104 15.2 15.8438 17 17.5104C18.8 19.1771 19.7 21.4771 19.7 24.4104C19.7 27.2771 18.7667 29.6104 16.9 31.4104C15.1 33.1438 12.8333 34.0104 10.1 34.0104C7.3 34.0104 4.96667 33.1438 3.1 31.4104C1.3 29.6104 0.4 27.2771 0.4 24.4104C0.4 23.5438 0.466667 22.7104 0.6 21.9104C0.733334 21.0438 1 20.0438 1.4 18.9104C1.8 17.7771 2.36667 16.2771 3.1 14.4104L8.9 0.0104449H18.8ZM42.4 0.0104449L35.8 24.0104L33.6 15.0104C36.4667 15.0104 38.8 15.8438 40.6 17.5104C42.4 19.1771 43.3 21.4771 43.3 24.4104C43.3 27.2771 42.3667 29.6104 40.5 31.4104C38.7 33.1438 36.4333 34.0104 33.7 34.0104C30.9 34.0104 28.5667 33.1438 26.7 31.4104C24.9 29.6104 24 27.2771 24 24.4104C24 23.5438 24.0667 22.7104 24.2 21.9104C24.3333 21.0438 24.6 20.0438 25 18.9104C25.4 17.7771 25.9667 16.2771 26.7 14.4104L32.5 0.0104449H42.4Z" fill="#003800"/>
                  </svg>
                </span>

                <?php for ($i = 0; $i < count($items); $i++): ?>
                  <div
                    class="w-8 h-1 <?php echo $i === 0 ? 'bg-amber-600' : 'bg-slate-600'; ?>"
                    data-index="<?php echo esc_attr($i); ?>"
                    aria-current="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                    role="presentation">
                  </div>
                <?php endfor; ?>
              </nav>
            <?php endif; ?>

              <blockquote
                class="<?php echo esc_attr(implode(' ', $blockquote_classes)); ?>"
                <?php echo !empty($blockquote_style_attr) ? 'style="' . esc_attr($blockquote_style_attr) . '"' : ''; ?>
              >
                <?php echo $quote_html; ?>
              </blockquote>

              <div class="z-0 mt-6 w-full max-w-[712px]">
                <cite class="text-lg not-italic font-bold leading-none text-slate-600 max-md:max-w-full">
                  <?php echo esc_html($author_name); ?>
                </cite>
                <?php if (!empty($author_sub)) : ?>
                  <p class="mt-1 text-sm leading-none text-slate-700 max-md:max-w-full">
                    <?php echo esc_html($author_sub); ?>
                  </p>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </article>
        <?php endforeach; ?>
      <?php endif; ?>
    </div><!-- /.testimonial-slider -->

  </div><!-- /.wrapper -->

  <?php if ($has_multiple): ?>
    <div class="hidden absolute bottom-0 flex-row px-12 w-full xxl:flex max-lg:gap-8 lg:justify-between lg:top-1/2">
      <button
        class="btn flex z-10 gap-2 justify-center items-center w-12 h-12 bg-gray-300 rounded-lg -translate-y-2/4 min-h-12 translate-x-[0%] slick-prev-custom hover:bg-gray-400 transition-colors duration-200"
        aria-label="Previous testimonial"
        type="button">
        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="48" height="48" rx="8" fill="#D0D5DD"/>
          <path d="M31 24H17M17 24L24 31M17 24L24 17" stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>

      <button
        class="btn flex z-10 gap-2 justify-center items-center w-12 h-12 bg-amber-600 rounded-lg -translate-y-2/4 min-h-12 translate-x-[0%] slick-next-custom hover:bg-amber-700 transition-colors duration-200"
        aria-label="Next testimonial"
        type="button">
        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="48" height="48" rx="8" fill="#DA6D1D"/>
          <path d="M17 24H31M31 24L24 17M31 24L24 31" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>
    </div>
  <?php endif; ?>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
  if (typeof jQuery === 'undefined' || typeof jQuery.fn.slick === 'undefined') {
    console.error('Slick Slider is not loaded. Please ensure jQuery and Slick Slider are included.');
    return;
  }

  var hasMultiple = <?php echo $has_multiple ? 'true' : 'false'; ?>;
  var $root   = jQuery('#<?php echo esc_js($section_id); ?>');
  var $slider = $root.find('.testimonial-slider');

  if (!hasMultiple) return;

  $slider.on('init reInit afterChange', function(event, slick, currentSlide) {
    var current = typeof currentSlide === 'number' ? currentSlide : 0;
    updateIndicators(current, slick.slideCount);
  });

  $slider.slick({
    dots: false,
    arrows: false,
    infinite: true,
    fade: true,
    cssEase: "linear",
    speed: 500,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 5000,
    pauseOnHover: true,
    pauseOnFocus: true,
    accessibility: true,
    focusOnSelect: false,
    focusOnChange: true,
    responsive: [
      { breakpoint: 768, settings: { autoplaySpeed: 4000, speed: 400 } }
    ]
  });

  // Arrows
  $root.find('.slick-prev-custom').on('click', function(e) {
    e.preventDefault();
    $slider.slick('slickPrev');
  });
  $root.find('.slick-next-custom').on('click', function(e) {
    e.preventDefault();
    $slider.slick('slickNext');
  });

  // Clickable bars
  $root.on('click', '.testimonial-progress-indicators > div', function() {
    var i = parseInt(jQuery(this).attr('data-index'), 10);
    if (!isNaN(i)) $slider.slick('slickGoTo', i);
  });

  // Keyboard support inside the section
  jQuery(document).on('keydown', function(e) {
    if (e.target.closest('#<?php echo esc_js($section_id); ?>')) {
      switch (e.key) {
        case 'ArrowLeft':  e.preventDefault(); $slider.slick('slickPrev'); break;
        case 'ArrowRight': e.preventDefault(); $slider.slick('slickNext'); break;
        case ' ':
          e.preventDefault();
          if ($slider.slick('slickGetOption', 'autoplay')) $slider.slick('slickPause');
          else $slider.slick('slickPlay');
          break;
      }
    }
  });

  let touchStartX = 0, touchEndX = 0;
  $slider.on('touchstart', function(e) { if (!e.changedTouches) return; touchStartX = e.changedTouches[0].screenX; });
  $slider.on('touchend',   function(e) { if (!e.changedTouches) return; touchEndX   = e.changedTouches[0].screenX; handleSwipe(); });
  function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartX - touchEndX;
    if (Math.abs(diff) > swipeThreshold) { if (diff > 0) $slider.slick('slickNext'); else $slider.slick('slickPrev'); }
  }

  // Strictly enforce exact classes (active: w-8 h-1 bg-amber-600, inactive: w-8 h-1 bg-slate-600)
  function updateIndicators(activeIndex, totalSlides) {
    // reset all bars (every nav, including in non-active slides)
    $root.find('.testimonial-progress-indicators > div')
      .each(function() {
        jQuery(this)
          .attr('class', 'w-8 h-1 bg-slate-600')
          .attr('aria-current', 'false');
      });

    // set the Nth bar active in ALL navs (the visible one will show)
    $root.find('.testimonial-progress-indicators').each(function() {
      var $bars = jQuery(this).children('div');
      if ($bars.length) {
        $bars.eq(activeIndex)
          .attr('class', 'w-8 h-1 bg-amber-600')
          .attr('aria-current', 'true');
      }
    });
  }

  // Respect prefers-reduced-motion
  if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    $slider.slick('slickSetOption', 'autoplay', false, true);
    $slider.slick('slickSetOption', 'speed', 0, true);
  }
});

// Pause when out of view
if ('IntersectionObserver' in window) {
  const sliderObserver = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
      const $root   = jQuery('#<?php echo esc_js($section_id); ?>');
      const $slider = $root.find('.testimonial-slider');
      if (!$slider.length || !$slider.hasClass('slick-initialized')) return;
      if (entry.isIntersecting) $slider.slick('slickPlay');
      else $slider.slick('slickPause');
    });
  }, { threshold: 0.5 });

  const sliderContainer = document.querySelector('#<?php echo esc_js($section_id); ?>');
  if (sliderContainer) sliderObserver.observe(sliderContainer);
}
</script>
