<?php
/**
 * Project Grid Manual (content_031.php)
 * - Manual YouTube support with inline playback (thumbnail swaps to iframe on click)
 * - Poster image support for videos (manual_video_poster)
 * - Flex layout so ANY Tailwind w-* width works (1/5, 7/12, etc.)
 * - No default "Project Title" forced; info box hidden if both empty
 * - Uses get_sub_field() and padding controls on the inner wrapper
 * - Default 2rem top/bottom padding
 * - Random section id
 */

// Data
$projects = get_sub_field('projects');

// Padding classes from Layout tab (applied to the inner wrapper div)
$padding_classes = ['pt-[2rem]', 'pb-[2rem]'];
if (have_rows('padding_settings')) {
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

// Unique section id
$section_id = function_exists('wp_generate_uuid4') ? 'content-031-' . wp_generate_uuid4() : 'content-031-' . uniqid();

// Helper: YouTube ID
if (!function_exists('content_031_extract_youtube_id')) {
    function content_031_extract_youtube_id($url) {
        if (empty($url)) return '';
        $host = parse_url($url, PHP_URL_HOST);
        $query = [];
        parse_str((string)parse_url($url, PHP_URL_QUERY), $query);

        // youtu.be/VIDEOID
        if (is_string($host) && strpos($host, 'youtu.be') !== false) {
            $path = trim((string)parse_url($url, PHP_URL_PATH), '/');
            return $path ?: '';
        }

        // youtube.com/watch?v=VIDEOID OR /shorts/VIDEOID OR /embed/VIDEOID OR /v/VIDEOID
        if (is_string($host) && (strpos($host, 'youtube.com') !== false || strpos($host, 'www.youtube.com') !== false)) {
            if (!empty($query['v'])) return $query['v'];
            $path = trim((string)parse_url($url, PHP_URL_PATH), '/');
            $parts = explode('/', $path);
            if (count($parts) >= 2 && in_array($parts[0], ['shorts', 'embed', 'v'], true)) {
                return $parts[1];
            }
        }

        return '';
    }
}
?>

<!-- Mobile video visibility patch -->
<style>
  .yt-media-box { position: relative; width: 100%; height: 100%; }
  @media (max-width: 767px) {
    /* Ensure the iframe has paintable space on small screens */
    .yt-media-box { min-height: 220px; }
  }
  .yt-media-box iframe {
    position: absolute; inset: 0;
    width: 100%; height: 100%;
    display: block; z-index: 30;
    background: #000;
  }
  /* Avoid iOS clipping when inside overflow/transform containers */
  .yt-playing { overflow: visible !important; }
</style>

<section id="<?php echo esc_attr($section_id); ?>" class="flex overflow-hidden relative">
  <div class="flex flex-col items-center w-full mx-auto max-w-[1472px] <?php echo esc_attr(implode(' ', $padding_classes)); ?> px-5">

    <!-- FLEX wrapper so tailwind w-* widths actually apply -->
    <div class="flex flex-col gap-8 w-full lg:flex-row">

      <?php if (!empty($projects) && is_array($projects)) : ?>
        <?php foreach ($projects as $index => $project) : ?>
          <?php
            // Manual or Post
            $use_manual = !empty($project['use_manual']);

            // Use the chosen Tailwind width class directly; default 1/2.
            // Below lg -> full width; from lg up -> chosen width (w-1/2, w-2/5, w-7/12, etc.)
            $width_class = !empty($project['grid_width']) ? $project['grid_width'] : 'w-1/2';
            $card_width_classes = 'w-full lg:' . $width_class;

            // Defaults
            $thumb     = '';
            $title     = '';
            $date_text = '';
            $href      = '';
            $target    = '_self';
            $rel       = '';
            $img_alt   = '';
            $img_title = '';
            $is_video  = false;
            $yt_id     = '';

            if ($use_manual) {
                // Manual mode
                $use_video = !empty($project['use_video']);
                $video_url = !empty($project['manual_video_url']) ? $project['manual_video_url'] : '';

                if ($use_video && !empty($video_url)) {
                    $yt_id = content_031_extract_youtube_id($video_url);
                    if (!empty($yt_id)) {
                        $is_video = true;

                        // Prefer manual poster image if provided
                        $poster_id = !empty($project['manual_video_poster']) ? (int)$project['manual_video_poster'] : 0;
                        if ($poster_id) {
                            $thumb     = wp_get_attachment_image_url($poster_id, 'large');
                            $img_alt   = get_post_meta($poster_id, '_wp_attachment_image_alt', true);
                            $img_title = get_the_title($poster_id);
                        } else {
                            // Fallback to YouTube thumbnail
                            $thumb = 'https://img.youtube.com/vi/' . rawurlencode($yt_id) . '/hqdefault.jpg';
                        }

                        // IMPORTANT: do NOT set $href when video (so we can click to play inline)
                        $target = '_self';
                        $rel    = '';
                    }
                }

                // Fallback to manual image if not a valid video
                if (!$is_video) {
                    $image_id = !empty($project['manual_image']) ? (int)$project['manual_image'] : 0;
                    if ($image_id) {
                        $thumb     = wp_get_attachment_image_url($image_id, 'large');
                        $img_alt   = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                        $img_title = get_the_title($image_id);
                    }
                    // Optional ACF link for non-video items
                    if (!empty($project['item_link']) && !empty($project['item_link']['url'])) {
                        $href   = $project['item_link']['url'];
                        $target = !empty($project['item_link']['target']) ? $project['item_link']['target'] : '_self';
                        $rel    = ($target === '_blank') ? 'noopener noreferrer' : '';
                    }
                }

                // Manual text (no forced default)
                $title     = !empty($project['manual_title']) ? $project['manual_title'] : '';
                $date_text = !empty($project['manual_date'])  ? $project['manual_date']  : '';

            } else {
                // Post mode
                $post_id = isset($project['project_post']) ? (int)$project['project_post'] : 0;
                if (empty($post_id)) { continue; }

                $thumb     = get_the_post_thumbnail_url($post_id, 'large');
                $title     = get_the_title($post_id);
                $date_text = get_the_date('', $post_id);
                $href      = get_permalink($post_id);

                $img_id = get_post_thumbnail_id($post_id);
                if (!empty($img_id)) {
                    $img_alt   = get_post_meta($img_id, '_wp_attachment_image_alt', true);
                    $img_title = get_the_title($img_id);
                }
            }

            // Image attribute fallbacks (accessibility-safe)
            $img_alt   = !empty($img_alt) ? $img_alt : (!empty($title) ? $title : 'Image');
            $img_title = !empty($img_title) ? $img_title : (!empty($title) ? $title : 'Image');

            // Render as link only for NON-video items when a link exists
            $use_link_tag = !$is_video && !empty($href);

            // Unique DOM id for the media container (used for swapping to iframe)
            $media_id = $section_id . '-media-' . $index;
          ?>

          <?php if ($use_link_tag) : ?>
            <a href="<?php echo esc_url($href); ?>"
               target="<?php echo esc_attr($target); ?>"
               <?php echo !empty($rel) ? 'rel="' . esc_attr($rel) . '"' : ''; ?>
               class="group relative overflow-hidden rounded-lg h-max-content lg:h-[530px] <?php echo esc_attr($card_width_classes); ?> project-card">
          <?php else : ?>
            <div class="group relative overflow-hidden rounded-lg h-max-content lg:h-[530px] <?php echo esc_attr($card_width_classes); ?> project-card">
          <?php endif; ?>

              <!-- Media container (image thumbnail / poster; swaps to iframe) -->
              <div id="<?php echo esc_attr($media_id); ?>" class="relative w-full h-full yt-media-box">
                <?php if (!empty($thumb)) : ?>
                  <img
                    src="<?php echo esc_url($thumb); ?>"
                    alt="<?php echo esc_attr($img_alt); ?>"
                    title="<?php echo esc_attr($img_title); ?>"
                    class="object-cover w-full h-full transition-transform duration-300" />
                <?php endif; ?>

                <!-- Overlay placeholder (keep if you add gradients later) -->
                <span aria-hidden="true" class="absolute inset-0 pointer-events-none"></span>

                <?php if ($is_video) : ?>
                  <!-- Click zone for video play -->
                  <button
                    type="button"
                    class="flex absolute inset-0 justify-center items-center"
                    data-yt-id="<?php echo esc_attr($yt_id); ?>"
                    data-target="<?php echo esc_attr($media_id); ?>"
                    aria-label="Play video">
                    <!-- SVG play button -->
                    <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="opacity-90">
                      <rect width="100" height="100" rx="50" fill="#DA6D1D" fill-opacity="0.8"/>
                      <path d="M70.5 44.8038C74.5 47.1132 74.5 52.8868 70.5 55.1962L44.25 70.3516C40.25 72.661 35.25 69.7742 35.25 65.1554L35.25 34.8446C35.25 30.2258 40.25 27.339 44.25 29.6484L70.5 44.8038Z" fill="white"/>
                    </svg>
                  </button>
                <?php endif; ?>
              </div>

              <?php if (!empty($title) || !empty($date_text)) : ?>
                <div class="absolute bottom-6 left-4 md:left-6 p-4 md:py-6 md:pr-6 md:pl-8 rounded-lg bg-white bg-opacity-90 w-[calc(100%-48px)] xl:min-w-[420px] max-w-fit flex flex-col">
                  <?php if (!empty($title)) : ?>
                    <span class="text-sm font-semibold leading-5 text-slate-700"><?php echo esc_html($title); ?></span>
                  <?php endif; ?>

                  <?php if (!empty($date_text)) : ?>
                    <?php if (isset($post_id) && !$use_manual && !empty($post_id)) : ?>
                      <time datetime="<?php echo esc_attr(get_the_date('c', $post_id)); ?>" class="text-sm font-semibold leading-5 text-slate-700">
                        <?php echo esc_html($date_text); ?>
                      </time>
                    <?php else : ?>
                      <span class="mb-1 text-2xl font-bold leading-7 text-slate-700"><?php echo esc_html($date_text); ?></span>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>
              <?php endif; ?>

          <?php if ($use_link_tag) : ?>
            </a>
          <?php else : ?>
            </div>
          <?php endif; ?>

        <?php endforeach; ?>

      <?php else : ?>
        <!-- Placeholder when there are no project items -->
        <div class="p-8 w-full rounded-lg border border-dashed">
          <div class="flex flex-col gap-2 items-start">
            <span class="text-base font-semibold">No projects yet</span>
            <p class="text-sm">Add items in <em>Project Grid Manual → Content → Project Items</em>.</p>
          </div>
        </div>
      <?php endif; ?>

    </div>
  </div>
</section>

<?php // Inline script: swap poster/thumbnail -> iframe with autoplay (iOS safe) ?>
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

    // Relax clipping on slide/card for iOS
    var slide = btn.closest('.slick-slide, .project-card, .group') || container.parentElement;
    if (slide) slide.classList.add('yt-playing');

    var iframe = document.createElement('iframe');
    iframe.setAttribute('allowfullscreen', '');
    iframe.setAttribute('webkit-playsinline', '');
    iframe.setAttribute('playsinline', '');
    iframe.setAttribute('frameborder', '0');
    iframe.setAttribute('title', 'YouTube video player');
    iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share');

    // Ensure it paints above overlays and fills the box
    iframe.style.position = 'absolute';
    iframe.style.inset = '0';
    iframe.style.width = '100%';
    iframe.style.height = '100%';
    iframe.style.display = 'block';
    iframe.style.background = '#000';
    iframe.style.zIndex = '30';

    iframe.src = 'https://www.youtube.com/embed/' + encodeURIComponent(ytId) +
                 '?autoplay=1&rel=0&modestbranding=1&playsinline=1&iv_load_policy=3';

    container.innerHTML = '';
    container.appendChild(iframe);
  });
})();
</script>
