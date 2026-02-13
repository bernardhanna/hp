<?php
function my_custom_pagination() {
  global $wp_query;

  $total_pages  = (int) $wp_query->max_num_pages;
  $current_page = max(1, (int) get_query_var('paged'));

  if ($total_pages <= 1) {
    return;
  }

  // Build a compact list with dots
  $links_array = paginate_links([
    'total'     => $total_pages,
    'current'   => $current_page,
    'type'      => 'array',
    'prev_next' => false, // we'll render Back/Next manually
    'end_size'  => 1,
    'mid_size'  => 2,
  ]);

  // Helper to pull page number + href out of a paginate_links() piece
  $parse_page_link = function($html) {
    // Dots
    if (strpos($html, 'dots') !== false) {
      return ['type' => 'dots'];
    }
    // Current (span)
    if (strpos($html, 'current') !== false && preg_match('/>(\d+)</', $html, $m)) {
      return ['type' => 'current', 'page' => (int) $m[1]];
    }
    // Regular link (a)
    if (preg_match('/href=[\'"]([^\'"]+)[\'"][^>]*>(\d+)</', $html, $m)) {
      return ['type' => 'link', 'url' => esc_url($m[1]), 'page' => (int) $m[2]];
    }
    return null;
  };

  // Previous / Next URLs
  $prev_url = ($current_page > 1)              ? get_pagenum_link($current_page - 1) : '';
  $next_url = ($current_page < $total_pages)    ? get_pagenum_link($current_page + 1) : '';

  ?>
  <nav class="flex flex-row gap-10 justify-between items-start pb-8 w-full text-sm font-semibold leading-none whitespace-nowrap max-w-container text-slate-700 max-md:px-5"
       aria-label="Pagination Navigation">

    <!-- Back -->
    <?php if ($prev_url): ?>
      <a href="<?php echo esc_url($prev_url); ?>"
         class="btn flex gap-2 justify-center items-center px-4 py-3 rounded min-h-[42px] w-fit whitespace-nowrap hover:bg-hover hover:text-hover"
         aria-label="Go to previous page">
        <img src="https://api.builder.io/api/v1/image/assets/f35586c581c84ecf82b6de32c55ed39e/03f6b1942e2fdc55a47a784a7b399b35f09143e1?placeholderIfAbsent=true"
             alt="" class="object-contain w-4 shrink-0 aspect-square" role="presentation" />
        <span class="text-slate-700 max-lg:hidden">Back</span>
      </a>
    <?php else: ?>
      <button class="btn flex gap-2 justify-center items-center px-4 py-3 rounded min-h-[42px] w-fit whitespace-nowrap opacity-50 cursor-not-allowed"
              aria-disabled="true" aria-label="No previous page">
        <img src="https://api.builder.io/api/v1/image/assets/f35586c581c84ecf82b6de32c55ed39e/03f6b1942e2fdc55a47a784a7b399b35f09143e1?placeholderIfAbsent=true"
             alt="" class="object-contain w-4 shrink-0 aspect-square" role="presentation" />
        <span class="max-lg:hidden text-slate-700">Back</span>
      </button>
    <?php endif; ?>

    <!-- Page numbers -->
    <div class="flex gap-4 justify-center items-center min-w-60" role="group" aria-label="Page numbers">
      <?php
      foreach ($links_array as $piece) {
        $item = $parse_page_link($piece);
        if (!$item) { continue; }

        if ($item['type'] === 'dots') {
          echo '<span class="px-2" aria-hidden="true">…</span>';
          continue;
        }

        if ($item['type'] === 'current') {
          $num = (int) $item['page'];
          echo '<button class="btn flex gap-2 justify-center items-center px-4 bg-gray-200 rounded h-[42px] min-h-[42px] w-[42px] w-fit" aria-current="page" aria-label="Page ' . esc_attr($num) . ', current page"><span class="text-slate-700">' . esc_html($num) . '</span></button>';
          continue;
        }

        if ($item['type'] === 'link') {
          $num = (int) $item['page'];
          $url = $item['url'];
          echo '<a href="' . esc_url($url) . '" class="btn flex gap-2 justify-center items-center px-4 py-3 rounded min-h-[42px] w-[42px] w-fit hover:bg-hover hover:text-hover" aria-label="Go to page ' . esc_attr($num) . '"><span class="text-slate-700">' . esc_html($num) . '</span></a>';
          continue;
        }
      }
      ?>
    </div>

    <!-- Next -->
    <?php if ($next_url): ?>
      <a href="<?php echo esc_url($next_url); ?>"
         class="btn flex gap-2 justify-center items-center px-4 py-3 rounded min-h-[42px] w-fit whitespace-nowrap hover:bg-hover hover:text-hover"
         aria-label="Go to next page">
        <span class="text-slate-700 max-lg:hidden">Next</span>
        <img src="https://api.builder.io/api/v1/image/assets/f35586c581c84ecf82b6de32c55ed39e/dcc7f83a8227ff16c5e9cfab84de7c79c6a11515?placeholderIfAbsent=true"
             alt="" class="object-contain w-4 shrink-0 aspect-square" role="presentation" />
      </a>
    <?php else: ?>
      <button class="btn flex gap-2 justify-center items-center px-4 py-3 rounded min-h-[42px] w-fit whitespace-nowrap opacity-50 cursor-not-allowed"
              aria-disabled="true" aria-label="No next page">
        <span class="text-slate-700 max-lg:hidden">Next</span>
        <img src="https://api.builder.io/api/v1/image/assets/f35586c581c84ecf82b6de32c55ed39e/dcc7f83a8227ff16c5e9cfab84de7c79c6a11515?placeholderIfAbsent=true"
             alt="" class="object-contain w-4 shrink-0 aspect-square" role="presentation" />
      </button>
    <?php endif; ?>
  </nav>

  <script>
    // Optional keyboard nav across the pagination buttons/links
    (function(){
      const nav = document.querySelector('nav[aria-label="Pagination Navigation"]');
      if (!nav) return;
      const focusables = nav.querySelectorAll('a,button');
      nav.addEventListener('keydown', function(e){
        const keys = ['ArrowLeft','ArrowRight','Home','End'];
        if (!keys.includes(e.key)) return;
        const list = Array.from(focusables);
        const i = list.indexOf(document.activeElement);
        if (i < 0) return;
        e.preventDefault();
        if (e.key === 'ArrowLeft')  (list[i-1] || list[0]).focus();
        if (e.key === 'ArrowRight') (list[i+1] || list[list.length-1]).focus();
        if (e.key === 'Home')       list[0].focus();
        if (e.key === 'End')        list[list.length-1].focus();
      });
    })();
  </script>
  <?php
}
