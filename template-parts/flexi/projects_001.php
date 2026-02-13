<?php
$section_id = uniqid('projects-001-');

$title       = get_sub_field('title');
$description = get_sub_field('description');
$button      = get_sub_field('button');

// Get ACF bg image
$bg_image = get_sub_field('background_image');

// Fallbacks for background image
$default_attachment_id = 256; // media item you pointed to
$hardcoded_fallback    = content_url('uploads/2025/06/image-21.png');

if (empty($bg_image) || empty($bg_image['url'])) {
    $fallback_url = wp_get_attachment_url($default_attachment_id);
    $fallback_alt = get_post_meta($default_attachment_id, '_wp_attachment_image_alt', true);

    if (!empty($fallback_url)) {
        $bg_image = [
            'url' => $fallback_url,
            'alt' => $fallback_alt ?: 'Background image',
        ];
    } else {
        $bg_image = [
            'url' => $hardcoded_fallback,
            'alt' => 'Background image',
        ];
    }
}

$project_source = get_sub_field('project_source') ?: 'latest';
$max_projects   = (int)(get_sub_field('max_projects') ?: 3);
$max_projects   = max(1, min(6, $max_projects)); // clamp 1..6

$icon        = get_sub_field('title_icon');
$title_color = get_sub_field('title_color');
$bg_full     = get_sub_field('bg_full_height');
$bg_height   = get_sub_field('bg_fixed_height');
$bg_fit      = get_sub_field('bg_object_fit') ?: 'object-cover';

// Padding classes
$padding_classes = ['pt-5', 'pb-5']; // base defaults
if (have_rows('padding_settings')) {
    $padding_classes = [];
    while (have_rows('padding_settings')) {
        the_row();
        $screen = get_sub_field('screen_size');
        $pt     = get_sub_field('padding_top');
        $pb     = get_sub_field('padding_bottom');
        if ($screen !== '' && $pt !== '' && $pt !== null) {
          $padding_classes[] = "{$screen}:pt-[{$pt}rem]";
        }
        if ($screen !== '' && $pb !== '' && $pb !== null) {
          $padding_classes[] = "{$screen}:pb-[{$pb}rem]";
        }
    }
}

// Dynamic bg wrapper classes
$bg_wrapper_classes = [
    'flex','overflow-hidden','absolute','top-0','z-0','flex-col',
    'w-full','left-0','right-0','max-w-full'
];
if (!is_front_page()) {
    $bg_wrapper_classes[] = 'rounded-3xl';
}
if ($bg_full) {
    $bg_wrapper_classes[] = 'h-full';
} elseif ($bg_height) {
    $bg_wrapper_classes[] = "h-[{$bg_height}px]";
} else {
    $bg_wrapper_classes[] = 'h-[558px]';
}

/**
 * Normalize a "card" array for rendering
 */
function build_card_from_post($pid) {
    $pid = (int)$pid;
    if (!$pid) return null;

    $img_url   = get_the_post_thumbnail_url($pid, 'large');
    $img_id    = get_post_thumbnail_id($pid);
    $img_alt   = $img_id ? get_post_meta($img_id, '_wp_attachment_image_alt', true) : '';
    $img_title = $img_id ? get_the_title($img_id) : '';

    $label = 'PROJECT';
    $terms = get_the_terms($pid, 'project_category');
    if (is_array($terms) && !empty($terms)) {
        $label = $terms[0]->name;
    }

    return [
        'link' => [
            'url' => get_permalink($pid),
        ],
        'image' => [
            'url' => $img_url ?: '',
            'alt' => $img_alt ?: get_the_title($pid),
        ],
        'label' => $label,
        'title' => get_the_title($pid),
    ];
}

// Collect cards depending on source
$cards = [];

if ($project_source === 'manual') {
    $manual_groups = ['project_1','project_2','project_3'];
    foreach ($manual_groups as $g) {
        $grp = get_sub_field($g);
        if (!is_array($grp)) continue;
        $img = isset($grp['image']) && is_array($grp['image']) ? $grp['image'] : null;
        $link = isset($grp['link']) && is_array($grp['link']) ? $grp['link'] : null;

        $cards[] = [
            'link' => [
                'url' => !empty($link['url']) ? $link['url'] : '#',
            ],
            'image' => [
                'url' => !empty($img['url']) ? $img['url'] : '',
                'alt' => !empty($img['alt']) ? $img['alt'] : 'Project thumbnail',
            ],
            'label' => !empty($grp['label']) ? $grp['label'] : 'PROJECT',
            'title' => !empty($grp['title']) ? $grp['title'] : 'Project Name',
        ];
    }
    $cards = array_slice(array_values(array_filter($cards, function($c){
        return !empty($c['image']['url']) || !empty($c['title']);
    })), 0, 3);

} elseif ($project_source === 'selected') {
    $ids = get_sub_field('selected_projects');
    if (is_array($ids) && !empty($ids)) {
        $ids = array_slice($ids, 0, $max_projects);
        foreach ($ids as $pid) {
            $card = build_card_from_post($pid);
            if ($card) $cards[] = $card;
        }
    }

} elseif ($project_source === 'related') {
    $tax = get_sub_field('related_taxonomy') ?: 'project_category';
    $current_id = get_the_ID();
    $terms = $current_id ? wp_get_object_terms($current_id, $tax, ['fields' => 'ids']) : [];
    if (!is_wp_error($terms) && !empty($terms)) {
        $q = new WP_Query([
            'post_type'      => 'projects',
            'posts_per_page' => $max_projects,
            'post__not_in'   => [$current_id],
            'tax_query'      => [[
                'taxonomy' => $tax,
                'field'    => 'term_id',
                'terms'    => $terms,
            ]],
            'orderby' => 'date',
            'order'   => 'DESC',
            'no_found_rows' => true,
            'ignore_sticky_posts' => true,
        ]);
        if ($q->have_posts()) {
            while ($q->have_posts()) { $q->the_post();
                $card = build_card_from_post(get_the_ID());
                if ($card) $cards[] = $card;
            }
            wp_reset_postdata();
        }
    }
    if (empty($cards)) {
        $q = new WP_Query([
            'post_type'      => 'projects',
            'posts_per_page' => $max_projects,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'no_found_rows' => true,
            'ignore_sticky_posts' => true,
        ]);
        if ($q->have_posts()) {
            while ($q->have_posts()) { $q->the_post();
                $card = build_card_from_post(get_the_ID());
                if ($card) $cards[] = $card;
            }
            wp_reset_postdata();
        }
    }

} else { // latest
    $q = new WP_Query([
        'post_type'      => 'projects',
        'posts_per_page' => $max_projects,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'no_found_rows' => true,
        'ignore_sticky_posts' => true,
    ]);
    if ($q->have_posts()) {
        while ($q->have_posts()) { $q->the_post();
            $card = build_card_from_post(get_the_ID());
            if ($card) $cards[] = $card;
        }
        wp_reset_postdata();
    }
}

// Card renderer (added mobile width for peek)
function render_project_card($project) {
    if (!$project) return;
    $url = isset($project['link']['url']) ? $project['link']['url'] : '#';
    $img_url = $project['image']['url'] ?? '';
    $img_alt = $project['image']['alt'] ?? 'Project thumbnail';
    $label   = $project['label'] ?? 'PROJECT';
    $title   = $project['title'] ?? 'Project Name';
    ?>
    <a href="<?php echo esc_url($url); ?>"
       class="group flex overflow-hidden relative flex-col sm:flex-1 sm:shrink xl:rounded-lg
              max-md:min-h-[400px] min-h-[530px] max-h-[530px] max-md:max-h-[400px] max-mob:max-h-[300px]
              min-w-60 max-sm:w-[82vw] sm:w-auto mr-4
              transition-shadow duration-300 focus-within:ring-4 focus-within:ring-orange-400"
       style="transition: box-shadow .3s cubic-bezier(.4,0,.2,1);">
        <div class="overflow-hidden absolute inset-0 w-full h-full rounded-[8px] md:rounded-lg">
            <?php if ($img_url): ?>
            <img src="<?php echo esc_url($img_url); ?>"
                 alt="<?php echo esc_attr($img_alt); ?>"
                 class="object-cover w-full h-full transition-transform duration-500" />
            <?php endif; ?>
            <div class="absolute inset-0 pointer-events-none"
                 style="background: linear-gradient(0deg, #000 0%, rgba(0,0,0,0.00) 54.03%);"></div>
        </div>
        <div class="flex justify-between items-end px-8 pt-20 pb-6 w-full min-h-[149px] max-md:px-5 h-full absolute bottom-0 z-10">
            <div class="flex flex-col">
                <?php if (!empty($label)): ?>
                  <span class="text-[12px] md:text-xs leading-none text-white"><?php echo esc_html($label); ?></span>
                <?php endif; ?>
                <?php if (!empty($title)): ?>
                  <span class="mt-1 text-2xl leading-none"><?php echo esc_html($title); ?></span>
                <?php endif; ?>
            </div>
            <button
                aria-label="View project details"
                type="button"
                class="transition-colors duration-300 rounded-full p-2 bg-transparent
                       group-hover:bg-[#DA6D1D] group-focus-within:bg-[#DA6D1D] focus-visible:bg-[#DA6D1D]
                       focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-orange-400">
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.66675 17.2109L17.6667 7.21094M17.6667 7.21094H7.66675M17.6667 7.21094V17.2109"
                          stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </a>
    <?php
}
?>

<?php
$section_classes = ['flex','overflow-hidden','relative'];
if ( ! is_front_page() ) {
  $section_classes[] = 'lg:px-5';
}
?>
<section id="<?php echo esc_attr($section_id); ?>" class="<?php echo esc_attr(implode(' ', $section_classes)); ?>">
  <div class="flex flex-col items-center w-full mx-auto <?php echo is_front_page() ? 'max-w-full' : 'max-w-container'; ?> max-lg:bg-primary <?php echo esc_attr(implode(' ', $padding_classes)); ?>">
    <div class="flex flex-col justify-center w-full">
      <div class="relative w-full <?php echo is_front_page() ? 'max-w-full' : 'max-w-[1472px]'; ?> mx-auto lg:py-20 overflow-hidden <?php echo is_front_page() ? 'rounded-none' : 'rounded-3xl'; ?> max-md:max-w-full">
        <?php if (!empty($bg_image) && !empty($bg_image['url'])): ?>
          <div class="<?php echo esc_attr(implode(' ', $bg_wrapper_classes)); ?>">
            <img src="<?php echo esc_url($bg_image['url']); ?>"
                 alt="<?php echo esc_attr($bg_image['alt'] ?? 'Background image'); ?>"
                 class="w-full <?php echo esc_attr($bg_fit); ?> <?php echo $bg_full ? 'h-full' : 'aspect-[2.64]'; ?> max-md:max-w-full" />
          </div>
        <?php endif; ?>

        <div class="relative flex flex-col md:flex-row items-center justify-between w-full gap-10 text-white max-w-[1216px] mx-auto max-xxl:px-5">
          <div class="flex flex-col my-auto w-full max-w-[961px]">
            <div class="flex gap-4 items-center">
              <?php if (!empty($icon)): ?>
                <img src="<?php echo esc_url($icon['url']); ?>"
                     alt="<?php echo esc_attr($icon['alt'] ?? ''); ?>"
                     class="w-auto max-h-12" />
              <?php endif; ?>
              <?php if (!empty($title)): ?>
              <span class="gap-6 text-3xl font-bold leading-tight"
                    <?php if (!empty($title_color)): ?>style="color: <?php echo esc_attr($title_color); ?>;"<?php endif; ?>>
                <?php echo esc_html($title); ?>
              </span>
              <?php endif; ?>
            </div>
            <?php if (!empty($description)): ?>
              <p class="mt-4 text-[16px] md:text-xl leading-7 max-xl:max-w-[700px]"><?php echo esc_html($description); ?></p>
            <?php endif; ?>
          </div>

          <?php if (!empty($button) && !empty($button['url'])): ?>
            <style>
              .group:hover .btn-svg .svg-border,
              .group:focus .btn-svg .svg-border,
              .group:focus-visible .btn-svg .svg-border { stroke-opacity: 0 !important; transition: stroke-opacity 0.2s; }
              .slide-label { transition: max-width .35s cubic-bezier(.4,0,.2,1), margin-right .35s cubic-bezier(.4,0,.2,1), opacity .35s cubic-bezier(.4,0,.2,1); will-change: max-width, opacity, margin-right; }
            </style>
 <a href="<?php echo esc_url($button['url']); ?>"
               target="<?php echo esc_attr($button['target'] ?: '_self'); ?>"
               aria-label="<?php echo esc_attr($button['title'] ?? 'View projects'); ?>"
               class="cursor-pointer flex overflow-hidden relative justify-center items-center px-0 py-0 bg-transparent rounded border-0 transition-all duration-300 group text-tertiary focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 max-md:w-full max-md:border-2 max-md:border-white max-md:px-6 max-md:py-3  max-md:hover:bg-secondary max-md:hover:border-secondary !md:max-w-full md:max-w-fit text-center max-md:text-white max-md:bg-transparent w-full"
               style="height: 56px; padding-left: 1rem;">
              <span class="absolute inset-0 rounded border-2 opacity-0 transition-all duration-300 pointer-events-none border-secondary md:group-hover:opacity-100 md:group-focus:opacity-100 max-md:hidden" style="background-color: #DE7C34; z-index: 0;"></span>
              <span class="overflow-hidden z-10 items-center mr-0 max-w-0 font-semibold text-white whitespace-nowrap opacity-0 md:text-black text-[14px] md:text-md slide-label md:group-hover:max-w-xs md:group-hover:opacity-100 md:group-hover:mr-3 md:group-focus:max-w-xs md:group-focus:opacity-100 md:group-focus:mr-3 max-md:max-w-none max-md:opacity-100 max-md:mr-3">
                <?php echo esc_html($button['title'] ?? 'Learn more'); ?>
              </span>
              <span class="flex flex-shrink-0 justify-center items-center transition-all duration-300 max-sm:w-5 max-sm:h-5" style="z-index: 1;">
                <svg class="btn-svg max-md:hidden" width="56" height="56" viewBox="0 0 72 73" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                  <rect x="8" y="8.21094" width="56" height="56" rx="4" fill="#DE7C34"></rect>
                  <rect x="4" y="4.21094" width="64" height="64" rx="8" stroke="white" stroke-width="8" stroke-opacity="0.1" class="svg-border"></rect>
                  <path d="M29 36.2109H43M43 36.2109L36 29.2109M43 36.2109L36 43.2109" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                <svg class="md:hidden" width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                  <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
            </a>
          <?php endif; ?>
        </div>

        <style>
          /* Mobile “peek” for the slider */
          @media (max-width: 639px){
            #<?php echo esc_attr($section_id); ?> .project-slider .slick-list { overflow: visible; }
            #<?php echo esc_attr($section_id); ?> .project-slider { padding-left: 16px; }
            #<?php echo esc_attr($section_id); ?> .project-slider .slick-slide { outline: none; }
            #<?php echo esc_attr($section_id); ?> .slick-prev { left: -8px; }
            #<?php echo esc_attr($section_id); ?> .slick-next { right: -8px; }
          }
        </style>

        <div class="z-0 flex flex-wrap items-start w-full gap-4 mt-12 font-bold text-white max-md:mt-10 max-md:max-w-full max-w-[1216px] mx-auto project-slider max-lg:px-0 max-xl:px-5">
          <?php
          $visible_cards = array_slice($cards, 0, 3);
          foreach ($visible_cards as $c) { render_project_card($c); }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
jQuery(document).ready(function($) {
  const sliderSection = '#<?php echo esc_attr($section_id); ?> .project-slider';

  function initSlick() {
    const useSlider = $(window).width() < 1084; // slider active up to 1083px

    if (useSlider && !$(sliderSection).hasClass('slick-initialized')) {
      $(sliderSection).slick({
        mobileFirst: true,
        infinite: false,
        // Base: phones — show "peek"
        variableWidth: true,
        centerMode: false,
        slidesToShow: 1,            // ignored when variableWidth is true
        swipeToSlide: true,
        touchThreshold: 10,
        edgeFriction: 0.15,
        dots: false,
        arrows: true,
        prevArrow: `<button type="button" class="slick-prev" aria-label="Previous project">
          <svg width="40" height="40" viewBox="0 0 72 73" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="8" y="8" width="56" height="56" rx="4" fill="#DE7C34"/>
            <rect x="4" y="4" width="64" height="64" rx="8" stroke="white" stroke-opacity="0.1" stroke-width="8"/>
            <path d="M43 36H29M29 36L36 29M29 36L36 43" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>`,
        nextArrow: `<button type="button" class="slick-next" aria-label="Next project">
          <svg width="40" height="40" viewBox="0 0 72 73" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="8" y="8" width="56" height="56" rx="4" fill="#DE7C34"/>
            <rect x="4" y="4" width="64" height="64" rx="8" stroke="white" stroke-opacity="0.1" stroke-width="8"/>
            <path d="M29 36H43M43 36L36 29M43 36L36 43" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>`,
        // Upgrade layout as width increases (mobileFirst = min-width breakpoints)
        responsive: [
          // ≥640px: no peek, show 2 full slides
          { breakpoint: 640, settings: { variableWidth: false, slidesToShow: 2, centerMode: false } },
          // ≥900px: show 3 slides
          { breakpoint: 900, settings: { variableWidth: false, slidesToShow: 3, centerMode: false } }
        ]
      });
    } else if (!useSlider && $(sliderSection).hasClass('slick-initialized')) {
      $(sliderSection).slick('unslick');
    }
  }

  initSlick();
  $(window).on('resize', initSlick);
});
</script>
