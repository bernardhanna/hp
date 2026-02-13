<?php
// ------------------------------
// Variables (get_sub_field only)
// ------------------------------
$section_id = 'related-services-' . wp_generate_password(6, false);

$heading      = get_sub_field('heading') ?: 'Related services';
$heading_tag  = get_sub_field('heading_tag') ?: 'h2';

$link_source  = get_sub_field('link_source') ?: 'auto_terms';
$taxonomy     = get_sub_field('taxonomy') ?: 'project_category';
$only_current = get_sub_field('only_current_post_terms');
$only_current = ($only_current === null) ? true : (bool) $only_current;
$selected_ids = get_sub_field('selected_terms');
$max_items    = (int) (get_sub_field('max_items') ?: 0);
$orderby      = get_sub_field('term_orderby') ?: 'name';
$order        = get_sub_field('term_order') ?: 'ASC';

$services     = get_sub_field('services'); // manual

// ------------------------------
// Padding classes
// ------------------------------
$padding_classes = ['pt-5', 'pb-5']; // base per guidelines
if (have_rows('padding_settings')) {
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

// ------------------------------
// Build links
// ------------------------------
$links = [];

if ($link_source === 'auto_terms') {
    $terms = [];

    if ($only_current) {
        $terms = get_the_terms(get_the_ID(), $taxonomy);
        if (is_wp_error($terms) || empty($terms)) {
            $terms = [];
        }
        if (!empty($terms)) {
            usort($terms, function($a, $b) use ($orderby, $order) {
                $va = $vb = '';
                switch ($orderby) {
                    case 'slug':    $va = $a->slug;         $vb = $b->slug; break;
                    case 'count':   $va = (int)$a->count;   $vb = (int)$b->count; break;
                    case 'term_id': $va = (int)$a->term_id; $vb = (int)$b->term_id; break;
                    case 'name':
                    default:        $va = $a->name;         $vb = $b->name; break;
                }
                if ($va === $vb) return 0;
                $cmp = ($va < $vb) ? -1 : 1;
                return ($order === 'DESC') ? -$cmp : $cmp;
            });
        }
    } else {
        if (!empty($selected_ids) && is_array($selected_ids)) {
            $terms = get_terms([
                'taxonomy'   => $taxonomy,
                'include'    => array_map('intval', $selected_ids),
                'hide_empty' => false,
                'orderby'    => $orderby,
                'order'      => $order,
            ]);
        } else {
            $terms = get_terms([
                'taxonomy'   => $taxonomy,
                'hide_empty' => true,
                'orderby'    => $orderby,
                'order'      => $order,
            ]);
        }
        if (is_wp_error($terms) || empty($terms)) {
            $terms = [];
        }
    }

    if (!empty($terms)) {
        foreach ($terms as $term) {
            $url = get_term_link($term);
            if (!is_wp_error($url)) {
                $links[] = [
                    'url'    => $url,
                    'title'  => $term->name,
                    'target' => '_self',
                ];
            }
        }
    }

    if ($max_items > 0) {
        $links = array_slice($links, 0, $max_items);
    }
} else {
    // Manual fallback
    if (!empty($services) && is_array($services)) {
        foreach ($services as $svc) {
            if (!empty($svc['link']) && is_array($svc['link'])) {
                $links[] = $svc['link'];
            }
        }
    }
}
?>

<section id="<?php echo esc_attr($section_id); ?>" class="flex overflow-hidden relative">
  <div class="flex flex-col items-center w-full mx-auto max-w-[1472px] pt-5 pb-5 px-5 <?php echo esc_attr(implode(' ', $padding_classes)); ?>">
    <div class="flex flex-col items-start w-full bg-white">
      <<?php echo esc_attr($heading_tag); ?> class="mb-6 text-3xl font-bold leading-9 text-slate-600 max-md:text-3xl max-sm:text-2xl">
        <?php echo esc_html($heading); ?>
      </<?php echo esc_attr($heading_tag); ?>>

      <?php if (!empty($links)) : ?>
        <div class="flex flex-wrap gap-4">
          <?php foreach ($links as $link) :
              $url    = isset($link['url']) ? $link['url'] : '';
              $title  = isset($link['title']) ? $link['title'] : '';
              $target = !empty($link['target']) ? $link['target'] : '_self';
              if (!$url) { continue; }
          ?>
            <a
              href="<?php echo esc_url($url); ?>"
              target="<?php echo esc_attr($target); ?>"
              aria-label="<?php echo esc_attr($title); ?> service"
              class="w-fit whitespace-nowrap px-6 py-2 text-base leading-6 bg-white border border-[#DA6D1D] rounded-[100px] text-[#344054] hover:bg-[#DA6D1D] hover:text-white transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#DA6D1D] max-md:text-base max-sm:text-sm"
            >
              <?php echo esc_html($title); ?>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
