<?php
/**
 * Flexi Block: Hero Project Media
 * Output template
 */

$section_id = function_exists('wp_generate_uuid4') ? 'hero-proj-media-' . wp_generate_uuid4() : 'hero-proj-media-' . uniqid();

// Content
$hero_image          = get_sub_field('hero_image');
$project_heading_tag = get_sub_field('project_heading_tag') ?: 'h1';
$allowed_tags        = ['h1','h2','h3','h4','h5','h6','span','p'];
if (!in_array($project_heading_tag, $allowed_tags, true)) { $project_heading_tag = 'h1'; }

$project_title       = get_sub_field('project_title');
$project_intro       = get_sub_field('project_intro');       // WYSIWYG (intro)
$project_extra       = get_sub_field('project_extra');       // WYSIWYG (additional description)

// Details (left sidebar key/values)
$details_items       = get_sub_field('details_items');       // repeater of {label, value}

// Right column media (top two cards + bottom video)
$media_items         = get_sub_field('media_items');         // repeater: type=image|youtube
// We’ll use the first two (images recommended) for the top grid, and the third (video) for bottom if provided.

// Design
$panel_bg_color      = get_sub_field('panel_bg_color') ?: '#FFFFFF';
$panel_border_color  = get_sub_field('panel_border_color') ?: '#D97706';
$panel_radius_class  = get_sub_field('panel_radius_class') ?: 'rounded-none'; // default rounded-none
$details_box_bg      = get_sub_field('details_box_bg') ?: '#F3F4F6';
$text_color_title    = get_sub_field('title_color') ?: '#0F172A';
$text_color_intro    = get_sub_field('intro_color') ?: '#334155';

// Layout padding repeater on inner wrapper
$padding_classes = ['pt-5','pb-5'];
if (have_rows('padding_settings')) {
  $padding_classes = [];
  while (have_rows('padding_settings')) {
    the_row();
    $screen  = get_sub_field('screen_size');
    $pt      = get_sub_field('padding_top');
    $pb      = get_sub_field('padding_bottom');
    if ($screen !== '' && $pt !== '' && $pt !== null) { $padding_classes[] = "{$screen}:pt-[{$pt}rem]"; }
    if ($screen !== '' && $pb !== '' && $pb !== null) { $padding_classes[] = "{$screen}:pb-[{$pb}rem]"; }
  }
}

// Breadcrumb helpers
$pt_obj        = get_post_type_object(get_post_type());
$archive_label = ($pt_obj && isset($pt_obj->labels->name)) ? $pt_obj->labels->name : 'Projects';
$home_url      = function_exists('home_url') ? home_url('/') : '/';

// Safe media helper
function hero_pm_img($img, $class='') {
  if (empty($img) || empty($img['url'])) return '';
  $alt   = !empty($img['alt'])   ? $img['alt']   : (!empty($img['title']) ? $img['title'] : 'Image');
  $title = !empty($img['title']) ? $img['title'] : $alt;
  return sprintf(
    '<img src="%s" alt="%s" title="%s" class="%s" />',
    esc_url($img['url']),
    esc_attr($alt),
    esc_attr($title),
    esc_attr($class)
  );
}

// YouTube id extractor
if (!function_exists('hero_pm_youtube_id')) {
  function hero_pm_youtube_id($url) {
    if (empty($url)) return '';
    $host = parse_url($url, PHP_URL_HOST);
    $query = [];
    parse_str((string)parse_url($url, PHP_URL_QUERY), $query);
    if (is_string($host) && strpos($host, 'youtu.be') !== false) {
      $path = trim((string)parse_url($url, PHP_URL_PATH), '/'); return $path ?: '';
    }
    if (is_string($host) && strpos($host, 'youtube') !== false) {
      if (!empty($query['v'])) return $query['v'];
      $path = trim((string)parse_url($url, PHP_URL_PATH), '/');
      $parts = explode('/', $path);
      if (count($parts) >= 2 && in_array($parts[0], ['shorts','embed','v'], true)) return $parts[1];
    }
    return '';
  }
}
?>

<section id="<?php echo esc_attr($section_id); ?>" class="flex overflow-hidden relative" aria-label="Project hero section">
  <div class="flex flex-col items-center w-full max-lg:px-5 <?php echo esc_attr(implode(' ', $padding_classes)); ?>">

<?php if (!empty($hero_image['url'])): ?>
  <div
    class="w-full h-[44.875rem] bg-center bg-cover"
    role="img"
    aria-label="<?php echo esc_attr(!empty($hero_image['alt']) ? $hero_image['alt'] : (!empty($hero_image['title']) ? $hero_image['title'] : 'Project image')); ?>"
    style="background-image: url('<?php echo esc_url($hero_image['url']); ?>');">
  </div>
<?php endif; ?>

    <div class="z-10 self-end mt-0 w-full max-w-[1547px] mx-auto max-md:max-w-full">
      <div class="grid grid-cols-1 lg:grid-cols-[31%_69%] gap-5 max-md:grid-cols-1">

        <!-- Left: Project details -->
        <article class="w-full -mt-[7.5rem] max-md:px-5 max-md:ml-0">
          <div
            class="flex flex-col pt-12 xl:pr-12 pb-5 px-5 xl:pl-14 mx-auto w-full border-l-8 border-solid  max-md:px-5 max-md:mt-10 max-md:max-w-full lg:rounded-r-2xl  shadow-[0_4px_37px_0_rgba(0,0,0,0.25)]"
            style="background-color: <?php echo esc_attr($panel_bg_color); ?>; border-left-color: <?php echo esc_attr($panel_border_color); ?>;"
          >
          <nav aria-label="Breadcrumb" class="flex gap-2 items-center mb-4">
            <svg width="22" height="21" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_280_18082)">
                <path d="M3.37013 10.5904C2.95648 10.5904 2.61914 10.9231 2.61914 11.3311V20.0896C2.61914 20.4976 2.9565 20.8304 3.37013 20.8304H18.9238C19.3375 20.8304 19.6748 20.4976 19.6748 20.0896V11.3311C19.6748 10.9231 19.3375 10.5904 18.9238 10.5904C18.5102 10.5904 18.1729 10.9231 18.1729 11.3311V19.3489L4.12112 19.3503V11.3311C4.12112 10.9245 3.78669 10.5904 3.37013 10.5904Z" fill="#667085"/>
                <path d="M11.4882 0.183378C11.2066 -0.0611259 10.7827 -0.0611259 10.5011 0.183378L0.257236 9.02004C-0.0537185 9.29059 -0.0889248 9.75645 0.185362 10.0646C0.45965 10.3713 0.931957 10.406 1.24437 10.1355L10.9926 1.72401L20.7408 10.1355C20.8831 10.257 21.0605 10.3207 21.2365 10.3207C21.4463 10.3207 21.6531 10.2353 21.8042 10.0689C22.0785 9.76223 22.0447 9.29494 21.7323 9.02438L11.4882 0.183378Z" fill="#667085"/>
                <path d="M14.1317 18.3089C14.5454 18.3089 14.8827 17.9762 14.8827 17.5682V13.1282C14.8827 12.7202 14.5454 12.3875 14.1317 12.3875H8.16212C7.74848 12.3875 7.41113 12.7202 7.41113 13.1282V17.5682C7.41113 17.9762 7.74849 18.3089 8.16212 18.3089C8.57577 18.3089 8.91311 17.9762 8.91311 17.5682V13.8688H13.3807V17.5682C13.3807 17.9762 13.7196 18.3089 14.1317 18.3089Z" fill="#667085"/>
              </g>
              <defs><clipPath id="clip0_280_18082"><rect width="21.99" height="20.8304" fill="white"/></clipPath></defs>
            </svg>

            <a href="<?= esc_url($home_url) ?>" class="text-sm font-semibold text-gray-700 hover:underline">Home</a>
            <svg class="w-4 h-4 text-gray-500" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M5.99 12L9.99 8L5.99 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="text-sm font-semibold text-gray-500" aria-current="page"><?= esc_html($archive_label) ?></span>
          </nav>

            <!-- Title -->
            <<?php echo tag_escape($project_heading_tag); ?>
              class="mt-4 w-full text-4xl font-bold tracking-tight leading-none text-primary"
             >
              <?php echo esc_html($project_title ?: 'Project title'); ?>
            </<?php echo tag_escape($project_heading_tag); ?>>

            <!-- Intro -->
            <?php if (!empty($project_intro)): ?>
              <div class="mt-4 text-xl leading-7 wp_editor" style="color: <?php echo esc_attr($text_color_intro); ?>;">
                <?php echo wp_kses_post($project_intro); ?>
              </div>
            <?php endif; ?>

            <!-- Details box -->
            <section class="flex flex-col items-start py-8 pr-14 pl-6 mt-4 w-full rounded-lg text-slate-700 max-md:px-5"
                     aria-labelledby="<?php echo esc_attr($section_id); ?>-details"
                     style="background-color: <?php echo esc_attr($details_box_bg); ?>;">
              <h2 id="<?php echo esc_attr($section_id); ?>-details" class="sr-only">Project Details</h2>

              <?php if (!empty($details_items) && is_array($details_items)): ?>
                <div class="space-y-7">
                  <?php foreach ($details_items as $di): ?>
                    <?php
                      $label = isset($di['label']) ? $di['label'] : '';
                      $value = isset($di['value']) ? $di['value'] : '';
                      if ($label === '' && $value === '') continue;
                    ?>
                    <div>
                      <?php if ($label !== ''): ?>
                        <h3 class="text-lg font-bold leading-none text-slate-700"><?php echo esc_html($label); ?></h3>
                      <?php endif; ?>
                      <?php if ($value !== ''): ?>
                        <p class="mt-1 text-base text-slate-700"><?php echo esc_html($value); ?></p>
                      <?php endif; ?>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </section>

            <!-- Extra copy -->
<?php
// Read-more settings (ACF fields are optional; hard-coded defaults if not present)
$rm_limit      = (int) (get_sub_field('readmore_word_limit') ?: 60); // words
$rm_more_label = get_sub_field('readmore_more_label') ?: 'Read more';
$rm_less_label = get_sub_field('readmore_less_label') ?: 'Read less';
?>

<?php if (!empty($project_extra)): ?>
  <?php
    $extra_plain = wp_strip_all_tags($project_extra);
    $total_words = str_word_count($extra_plain);
    $use_readmore = $rm_limit > 0 && $total_words > $rm_limit;

    // Build preview HTML from plain text to avoid broken tags in partial HTML
    $preview_html = $use_readmore
      ? wpautop( esc_html( wp_trim_words( $extra_plain, $rm_limit, '' ) ) )
      : '';

    // IDs for a11y
    $rm_wrapper_id = $section_id . '-rm';
    $rm_content_id = $section_id . '-rm-content';
  ?>

  <div id="<?php echo esc_attr($rm_wrapper_id); ?>" class="mt-4 text-xl leading-7 text-slate-700">
    <?php if ($use_readmore): ?>
      <!-- Preview (collapsed state) -->
      <div class="wp_editor" data-rm-preview>
        <?php echo $preview_html; ?><span aria-hidden="true"></span>
      </div>
      <!-- Full content (expanded state) -->
      <div id="<?php echo esc_attr($rm_content_id); ?>" class="hidden wp_editor" data-rm-full>
        <?php echo wp_kses_post($project_extra); ?>
      </div>

      <!-- Toggle button -->
      <button
        type="button"
        class="inline-flex items-center mt-3 text-lg font-semibold underline underline-offset-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-600 focus-visible:ring-offset-2 hover:no-underline"
        data-rm-toggle
        aria-expanded="false"
        aria-controls="<?php echo esc_attr($rm_content_id); ?>">
        <?php echo esc_html($rm_more_label); ?>
      </button>
    <?php else: ?>
      <!-- No read-more needed -->
      <div class="wp_editor">
        <?php echo wp_kses_post($project_extra); ?>
      </div>
    <?php endif; ?>
  </div>
<?php endif; ?>

          </div>
        </article>
        <!-- Right: Media gallery -->
        <section class="w-full max-xl:px-5" aria-labelledby="<?php echo esc_attr($section_id); ?>-media-heading">
          <h2 id="<?php echo esc_attr($section_id); ?>-media-heading" class="sr-only">Project Media Gallery</h2>

          <div class="px-5 w-full max-lg:px-0 md:py-10 xl:py-20 max-md:mt-10 max-md:max-w-full">
            <?php
              $items = array_slice((array)$media_items, 0, 3);
              $top   = array_slice($items, 0, 2);
              $bottom= isset($items[2]) ? $items[2] : null;

              // helper: render an image or YouTube as a "card"
              function hero_pm_render_media_card($item, $size = 'md', $media_id_prefix = '') {
                $type   = $item['type'] ?? 'image';
                $title  = $item['title'] ?? '';
                $label  = $item['label'] ?? '';
                $img    = $item['image'] ?? null;
                $poster = $item['poster'] ?? null;
                $yt_url = $item['youtube_url'] ?? '';
                $yt_id  = function_exists('hero_pm_youtube_id') ? hero_pm_youtube_id($yt_url) : '';

                $is_video = ($type === 'youtube' && $yt_id);

                // sizing
                $wrap_classes = $size === 'lg'
                  ? 'flex overflow-hidden relative flex-col justify-center items-center rounded-lg min-h-[530px] w-full max-md:px-5 max-md:py-24 max-md:max-w-full yt-media-box'
                  : 'flex relative flex-col items-start px-6 pt-96 pb-6 w-full min-h-[530px] text-slate-700 max-md:px-5 max-md:pt-24 max-md:mt-10 max-md:max-w-full overflow-hidden rounded-lg';

                // choose media (poster > image > yt thumb)
                $media_html = '';
                if ($is_video) {
                  if (!empty($poster) && !empty($poster['url'])) {
                    $media_html = hero_pm_img($poster, 'object-cover absolute inset-0 w-full h-full');
                  } else {
                    $thumb = 'https://img.youtube.com/vi/' . rawurlencode($yt_id) . '/hqdefault.jpg';
                    $media_html = '<img src="' . esc_url($thumb) . '" alt="Video thumbnail" class="object-cover absolute inset-0 w-full h-full" />';
                  }
                } else {
                  if (!empty($img)) {
                    $media_html = hero_pm_img($img, 'object-cover absolute inset-0 w-full h-full');
                  }
                }

                // ID for inline swap (if video)
                $mid = $media_id_prefix ? $media_id_prefix . '-' . uniqid() : 'media-' . uniqid();
                ?>
                <div id="<?php echo esc_attr($mid); ?>" class="<?php echo esc_attr($wrap_classes); ?>">
                  <?php echo $media_html; ?>

                  <?php if ($is_video): ?>
                    <button
                      type="button"
                      class="btn play-button flex relative gap-2 justify-center items-center bg-amber-600 bg-opacity-80 h-[100px] min-h-[100px] rounded-full w-[100px] hover:bg-opacity-100 transition-all duration-200"
                      aria-label="Play project video"
                      data-yt-id="<?php echo esc_attr($yt_id); ?>"
                      data-target="<?php echo esc_attr($mid); ?>">
                        <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="opacity-70">
                        <rect width="100" height="100" rx="50" fill="#DA6D1D" fill-opacity="0.8"></rect>
                        <path d="M70.5 44.8038C74.5 47.1132 74.5 52.8868 70.5 55.1962L44.25 70.3516C40.25 72.661 35.25 69.7742 35.25 65.1554L35.25 34.8446C35.25 30.2258 40.25 27.339 44.25 29.6484L70.5 44.8038Z" fill="white"></path>
                        </svg>
                    </button>
                  <?php endif; ?>

                  <?php if (!$is_video && ($title !== '' || $label !== '')): ?>
                    <div class="flex relative items-start py-6 pr-6 pl-8 bg-white bg-opacity-90 rounded-lg max-md:px-5">
                      <div class="w-[319px]">
                        <?php if ($label !== ''): ?>
                          <p class="text-base font-semibold"><?php echo esc_html($label); ?></p>
                        <?php endif; ?>
                        <?php if ($title !== ''): ?>
                          <h3 class="text-2xl font-bold leading-none"><?php echo esc_html($title); ?></h3>
                        <?php endif; ?>
                      </div>
                    </div>
                  <?php endif; ?>
                </div>
                <?php
              }
            ?>

            <!-- Top two (image or video) -->
            <?php if (!empty($top)): ?>
              <div class="max-w-full">
                <div class="grid grid-cols-1 gap-5 xl:gap-10 md:grid-cols-2">
                  <?php
                    $i=0;
                    foreach ($top as $t) {
                      $i++;
                      echo '<article class="'.($i===2 ? ' ' : '').'w-full">';
                      hero_pm_render_media_card($t, 'md', $section_id . '-top');
                      echo '</article>';
                    }
                  ?>
                </div>
              </div>
            <?php endif; ?>

            <!-- Bottom one (image or video) -->
            <?php if ($bottom): ?>
              <section class="flex gap-8 mt-5 w-full xl:mt-10" aria-labelledby="<?php echo esc_attr($section_id); ?>-video-heading">
                <h3 id="<?php echo esc_attr($section_id); ?>-video-heading" class="sr-only">Project Media</h3>
                <div class="w-full">
                  <?php hero_pm_render_media_card($bottom, 'lg', $section_id . '-bottom'); ?>
                </div>
              </section>
            <?php endif; ?>
          </div>
        </section>


      </div>
    </div>
  </div>
</section>

<style>
  /* Mobile video visibility + inline playback */
  #<?php echo esc_js($section_id); ?> .yt-media-box { position: relative; width: 100%; height: 100%; }
  @media (max-width: 767px) {
    #<?php echo esc_js($section_id); ?> .yt-media-box { min-height: 220px; }
  }
  #<?php echo esc_js($section_id); ?> .yt-media-box iframe {
    position: absolute; inset: 0; width: 100%; height: 100%;
    display: block; z-index: 30; background: #000;
  }
  #<?php echo esc_js($section_id); ?> .yt-playing { overflow: visible !important; }
</style>

<script>
(function(){
  var root = document.getElementById(<?php echo json_encode($section_id); ?>);
  if (!root) return;

  root.addEventListener('click', function(e){
    var btn = e.target.closest('button[data-yt-id][data-target]');
    if (!btn) return;

    var ytId = btn.getAttribute('data-yt-id');
    var targetId = btn.getAttribute('data-target');
    var container = document.getElementById(targetId);
    if (!ytId || !container) return;

    var slide = btn.closest('.project-card, .group') || container.parentElement;
    if (slide) slide.classList.add('yt-playing');

    var iframe = document.createElement('iframe');
    iframe.setAttribute('allowfullscreen', '');
    iframe.setAttribute('webkit-playsinline', '');
    iframe.setAttribute('playsinline', '');
    iframe.setAttribute('frameborder', '0');
    iframe.setAttribute('title', 'YouTube video player');
    iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share');
    iframe.src = 'https://www.youtube.com/embed/' + encodeURIComponent(ytId) + '?autoplay=1&rel=0&modestbranding=1&playsinline=1&iv_load_policy=3';

    container.innerHTML = '';
    container.appendChild(iframe);
  });
})();
</script>
<script>
(function(){
  var root = document.getElementById(<?php echo json_encode($section_id); ?>);
  if (!root) return;

  var rmWrap = root.querySelector('[id$="-rm"]');
  if (!rmWrap) return;

  var btn   = rmWrap.querySelector('[data-rm-toggle]');
  var prev  = rmWrap.querySelector('[data-rm-preview]');
  var full  = rmWrap.querySelector('[data-rm-full]');
  if (!btn || !prev || !full) return;

  var moreLabel = <?php echo json_encode( $rm_more_label ); ?>;
  var lessLabel = <?php echo json_encode( $rm_less_label ); ?>;

  btn.addEventListener('click', function(){
    var expanded = btn.getAttribute('aria-expanded') === 'true';
    if (expanded) {
      // collapse
      full.classList.add('hidden');
      prev.classList.remove('hidden');
      btn.setAttribute('aria-expanded', 'false');
      btn.textContent = moreLabel;
    } else {
      // expand
      prev.classList.add('hidden');
      full.classList.remove('hidden');
      btn.setAttribute('aria-expanded', 'true');
      btn.textContent = lessLabel;
    }
  });
})();
</script>
