<?php
$id     = uniqid('services-slider-');
$slides = get_sub_field('slides') ?: [];
// helper
if (!function_exists('has_meaningful_content')) {
    function has_meaningful_content($html) {
        if (!is_string($html)) return false;
        $text = wp_strip_all_tags($html);
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        $text = preg_replace('/(\x{00A0}|\xc2\xa0|&nbsp;|\s)+/u', '', $text);
        return $text !== '';
    }
}

// only real descriptions + map slide index -> description index (or -1)
$desc_items = [];
$desc_map   = [];
foreach ($slides as $i => $slide) {
    $desc_html = isset($slide['description']) ? $slide['description'] : '';
    if (has_meaningful_content($desc_html)) {
        $desc_items[] = ['index' => $i, 'html' => $desc_html];
        $desc_map[$i] = count($desc_items) - 1;
    } else {
        $desc_map[$i] = -1;
    }
}
// safe first bg (fallback empty)
$first_bg = '';
if (!empty($slides) && !empty($slides[0]['background_image']['url'])) {
    $first_bg = $slides[0]['background_image']['url'];
}

// helper to detect meaningful content
if (!function_exists('has_meaningful_content')) {
    function has_meaningful_content($html) {
        if (!is_string($html)) return false;
        $text = wp_strip_all_tags($html);
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        // remove unicode NBSP + &nbsp; + all whitespace
        $text = preg_replace('/(\x{00A0}|\xc2\xa0|&nbsp;|\s)+/u', '', $text);
        return $text !== '';
    }
}

// Build description items (only for slides that actually have content)
// and a mapping from slide index -> description index (or -1)
$desc_items = [];
$desc_map   = [];
foreach ($slides as $i => $slide) {
    $desc_html = isset($slide['description']) ? $slide['description'] : '';
    if (has_meaningful_content($desc_html)) {
        $desc_items[] = [
            'index' => $i,
            'html'  => $desc_html,
        ];
        $desc_map[$i] = count($desc_items) - 1; // visible description index
    } else {
        $desc_map[$i] = -1; // no description for this slide
    }
}
$has_descriptions = count($desc_items) > 0;

$heading_tag      = get_sub_field('heading_tag') ?: 'h2';
$heading_text     = get_sub_field('heading_text');
$text_color       = get_sub_field('text_color');
$hover_text_color = get_sub_field('hover_text_color');
$hover_bg_color   = get_sub_field('hover_bg_color');

// Handle padding classes
$padding_classes = ['', ''];
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

// desktop bg style
$bg_style = $first_bg
    ? "background-image: url('" . esc_url($first_bg) . "'); background-size: cover; background-position: center;"
    : '';
?>

<style>
@media (max-width: 767px) {
  #<?php echo esc_attr($id); ?>-bg {
    display: none !important;
  }
}
</style>

<section id="<?php echo esc_attr($id); ?>" class="flex overflow-hidden relative max-md:flex-col">
    <!-- Mobile image (shows below md) -->
    <div class="relative w-full md:hidden">
        <img
            id="<?php echo esc_attr($id); ?>-mobile-img"
            src="<?php echo esc_url($first_bg); ?>"
            alt=""
            class="relative inset-0 w-full h-[200px] sm:h-[400px] object-cover z-0">

        <!-- Mobile content overlay -->
        <div class="flex flex-col items-center w-full <?php echo esc_attr(implode(' ', $padding_classes)); ?> mx-auto max-w-container relative z-10 px-5 -mt-20">
            <div class="flex flex-col gap-14 items-end p-2 w-full min-h-full md:p-4">
                <!-- Sidebar Nav for Mobile -->
                <div class="flex relative z-10 flex-col gap-6 items-start self-start p-8 w-full bg-white rounded-3xl">
                    <div class="flex flex-row items-center w-full">
                        <svg class="mr-4" width="68" height="68" viewBox="0 0 64 65" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="4" y="4.21094" width="56" height="56" rx="12" fill="#DA6D1D"></rect>
                            <rect x="4" y="4.21094" width="56" height="56" rx="12" stroke="#F8E2D2" stroke-width="8"></rect>
                            <path d="M43.3111 38.3493L25.6923 20.73C25.025 20.0627 23.9433 20.0627 23.276 20.73L20.4985 23.5074C19.8312 24.1747 19.8312 25.2565 20.4985 25.9238L38.1178 43.5431L43.3116 38.3493H43.3111Z" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M21.8872 27.3126L27.0344 22.166" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M26.7275 25.0684L41.6596 40.0005" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M24.8374 26.959L39.7695 41.8906" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M38.1172 43.5434L43.9834 44.1692L43.311 38.3496" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M38.2285 30.3483L44.0024 24.5743L41.8204 22.3929L39.639 20.2109L33.6655 26.1844" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M25.7323 34.1182L20.0024 39.848L24.3658 44.2114L29.949 38.6288" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M39.0929 22.9377L38.002 21.8467" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M37.4572 24.5748L36.3662 23.4844" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M35.7938 26.1844L34.73 25.1201" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M26.0031 36.0295L24.9121 34.9385" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M24.3659 37.6652L23.2754 36.5742" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M22.7301 39.3019L21.6392 38.2109" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M41.7139 43.9413C41.8898 43.4899 42.1601 43.0668 42.5243 42.7021C42.8761 42.3502 43.2834 42.0861 43.7173 41.9102" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <<?php echo tag_escape($heading_tag); ?> class="text-[20px] md:text-3xl font-bold leading-9 text-slate-700 max-sm:text-2xl max-sm:leading-8">
                            <?php echo esc_html($heading_text); ?>
                        </<?php echo tag_escape($heading_tag); ?>>
                    </div>
                    <nav class="self-start w-full h-full" aria-label="Services navigation">
                        <ul class="flex flex-col items-start self-start w-full">
                            <?php foreach ($slides as $i => $slide): ?>
                                <?php
                                $link_url   = !empty($slide['link']['url']) ? $slide['link']['url'] : '#';
                                $link_title = !empty($slide['link']['title']) ? $slide['link']['title'] : '';
                                $bg_url     = !empty($slide['background_image']['url']) ? $slide['background_image']['url'] : '';
                                $desc_index = isset($desc_map[$i]) ? (int) $desc_map[$i] : -1;
                                ?>
                                <li class="w-full border-t border-solid border-t-gray-200 hover:bg-neutral-200">
                                    <a href="<?php echo esc_url($link_url); ?>"
                                        data-bg="<?php echo esc_url($bg_url); ?>"
                                        data-desc="<?php echo esc_attr($desc_index); ?>"
                                        class="flex justify-between items-center px-2 py-3 w-full group slide-link hover:bg-neutral-200">
                                        <span class="text-[14px] leading-6 text-slate-700">
                                            <?php echo esc_html($link_title); ?>
                                        </span>
                                        <svg width="17" height="17" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M6.375 13.4609L10.625 9.21094L6.375 4.96094"
                                                stroke="#222534" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop background (shows above md) -->
    <div class="relative w-full" style="<?php echo esc_attr($bg_style); ?>" id="<?php echo esc_attr($id); ?>-bg">
        <div class="flex flex-col items-center w-full <?php echo esc_attr(implode(' ', $padding_classes)); ?> mx-auto max-w-container">
            <div class="flex xl:gap-14 items-end xl:p-16 min-h-full xl:min-h-[800px] max-md:flex-col w-full">
                <!-- Sidebar Nav for Desktop -->
                <div class="flex relative z-10 flex-col gap-6 items-start self-start p-8 w-96 bg-white rounded-[0px] xl:rounded-3xl max-md:w-full">
                    <div class="flex flex-row items-center w-full">
                        <svg class="mr-4" width="68" height="68" viewBox="0 0 64 65" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="4" y="4.21094" width="56" height="56" rx="12" fill="#DA6D1D"></rect>
                            <rect x="4" y="4.21094" width="56" height="56" rx="12" stroke="#F8E2D2" stroke-width="8"></rect>
                            <path d="M43.3111 38.3493L25.6923 20.73C25.025 20.0627 23.9433 20.0627 23.276 20.73L20.4985 23.5074C19.8312 24.1747 19.8312 25.2565 20.4985 25.9238L38.1178 43.5431L43.3116 38.3493H43.3111Z" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M21.8872 27.3126L27.0344 22.166" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M26.7275 25.0684L41.6596 40.0005" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M24.8374 26.959L39.7695 41.8906" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M38.1172 43.5434L43.9834 44.1692L43.311 38.3496" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M38.2285 30.3483L44.0024 24.5743L41.8204 22.3929L39.639 20.2109L33.6655 26.1844" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M25.7323 34.1182L20.0024 39.848L24.3658 44.2114L29.949 38.6288" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M39.0929 22.9377L38.002 21.8467" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M37.4572 24.5748L36.3662 23.4844" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M35.7938 26.1844L34.73 25.1201" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M26.0031 36.0295L24.9121 34.9385" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M24.3659 37.6652L23.2754 36.5742" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M22.7301 39.3019L21.6392 38.2109" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M41.7139 43.9413C41.8898 43.4899 42.1601 43.0668 42.5243 42.7021C42.8761 42.3502 43.2834 42.0861 43.7173 41.9102" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <<?php echo tag_escape($heading_tag); ?> class="text-3xl font-bold leading-9 text-slate-700 max-sm:text-2xl max-sm:leading-8">
                            <?php echo esc_html($heading_text); ?>
                        </<?php echo tag_escape($heading_tag); ?>>
                    </div>
                    <nav class="self-start w-full h-full" aria-label="Services navigation">
                        <ul class="flex flex-col items-start self-start w-full">
                            <?php foreach ($slides as $i => $slide): ?>
                                <?php
                                $link_url   = !empty($slide['link']['url']) ? $slide['link']['url'] : '#';
                                $link_title = !empty($slide['link']['title']) ? $slide['link']['title'] : '';
                                $bg_url     = !empty($slide['background_image']['url']) ? $slide['background_image']['url'] : '';
                                $desc_index = isset($desc_map[$i]) ? (int) $desc_map[$i] : -1;
                                ?>
                                <li class="w-full border-t border-solid border-t-gray-200 hover:bg-neutral-200">
                                    <a href="<?php echo esc_url($link_url); ?>"
                                        data-bg="<?php echo esc_url($bg_url); ?>"
                                        data-desc="<?php echo esc_attr($desc_index); ?>"
                                        class="flex justify-between items-center px-2 py-3 w-full group slide-link hover:bg-neutral-200">
                                        <span class="text-[14px] leading-6 text-slate-700">
                                            <?php echo esc_html($link_title); ?>
                                        </span>
                                        <svg width="17" height="17" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M6.375 13.4609L10.625 9.21094L6.375 4.96094"
                                                stroke="#222534" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                </div>

                <?php if ($has_descriptions) : ?>
                    <div id="<?php echo esc_attr($id); ?>-descriptions"
                        class="hidden relative z-10 flex-1 gap-8 items-start py-4 pr-4 pl-6 bg-white md:hidden xl:rounded-2xl max-md:w-full max-sm:flex-col max-sm:p-3">
                    <?php foreach ($desc_items as $idx => $item): ?>
                        <div class="description-item <?php echo $idx === 0 ? 'block' : 'hidden'; ?>">
                        <div class="text-base leading-6 text-slate-700 wp_editor">
                            <?php echo wp_kses_post($item['html']); ?>
                        </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const root      = document.getElementById('<?php echo esc_attr($id); ?>');
  const wrapper   = document.getElementById('<?php echo esc_attr($id); ?>-bg');
  const mobileImg = document.getElementById('<?php echo esc_attr($id); ?>-mobile-img');
  const links     = root.querySelectorAll('.slide-link');
  const descWrap  = document.getElementById('<?php echo esc_attr($id); ?>-descriptions');
  const descItems = root.querySelectorAll('#<?php echo esc_attr($id); ?>-descriptions .description-item');

  function setDescVisibility(hasContent) {
    if (!descWrap) return;
    if (hasContent) {
      descWrap.classList.remove('hidden','md:hidden');
      descWrap.classList.add('md:flex');
    } else {
      descWrap.classList.add('hidden','md:hidden');
      descWrap.classList.remove('md:flex');
    }
  }

  // start hidden
  setDescVisibility(false);

  function triggerSlide(link) {
    const bg        = link.getAttribute('data-bg');
    const descIndex = parseInt(link.getAttribute('data-desc'), 10);

    if (wrapper && bg) wrapper.style.backgroundImage = "url('" + bg + "')";
    if (mobileImg && bg) mobileImg.src = bg;

    if (isNaN(descIndex) || descIndex < 0 || !descItems.length) {
      setDescVisibility(false);
      return;
    }

    setDescVisibility(true);
    descItems.forEach((el, i) => {
      const match = i === descIndex;
      el.classList.toggle('hidden', !match);
      if (match) el.classList.add('block'); else el.classList.remove('block');
    });
  }

  // Hover over LI should move slide
  const listItems = root.querySelectorAll('nav[aria-label="Services navigation"] li');
  listItems.forEach(li => {
    li.addEventListener('mouseenter', () => {
      const link = li.querySelector('.slide-link');
      if (link) triggerSlide(link);
    });
  });

  // Also support hover/focus on the link itself
  links.forEach(link => {
    link.addEventListener('mouseenter', () => triggerSlide(link));
    link.addEventListener('focus', () => triggerSlide(link));

    // Drag guard so click+drag doesn't navigate
    let startX = 0, startY = 0, isDragging = false;

    link.addEventListener('mousedown', (e) => {
      startX = e.clientX;
      startY = e.clientY;
      isDragging = false;
    });

    link.addEventListener('mousemove', (e) => {
      if (e.buttons !== 1) return; // only when mouse is down
      const dx = Math.abs(e.clientX - startX);
      const dy = Math.abs(e.clientY - startY);
      if (dx > 5 || dy > 5) isDragging = true; // threshold
    });

    link.addEventListener('click', (e) => {
      if (isDragging) {
        e.preventDefault();
        e.stopPropagation();
      }
    });
  });
});
</script>