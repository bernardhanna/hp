<?php get_header(); ?>
<?php
$settings = get_field( 'projects_settings', 'option' ) ?: [];

/* ── background image ───────────────────────────────────────────────── */
$hero_bg = ! empty( $settings['hero_background_image']['url'] )
  ? $settings['hero_background_image']
  : null;

if ( $hero_bg ) {
  $bg_url         = esc_url( $hero_bg['url'] );
  $section_style  = "style=\"background-image:url('{$bg_url}');background-size:cover;background-position:center;\"";
  $fallback_class = '';
} else {
  $section_style  = '';
  $fallback_class = 'bg-primary';
}

/* ── heading + texts ───────────────────────────────────────────────── */
$hero_tag   = $settings['hero_heading_tag']  ?? 'h1';
$hero_text  = $settings['hero_heading_text'] ?? 'Our Projects';
$sub_text   = $settings['hero_subheading_text'] ?? 'Take a look at what we’ve built';
$filter_title = $settings['filter_section_title'] ?? 'Filter projects';
?>
<style>
  /* ACTIVE (selected) state stays #DE7C34 and readable */
  [role="radiogroup"] .filter-btn[aria-checked="true"] {
    background-color: #DE7C34 !important;
    color: #000;
  }
  /* Hover should NOT override active */
  [role="radiogroup"] .filter-btn[aria-checked="true"]:hover {
    background-color: #DE7C34 !important;
  }

  /* Card CTA hover/focus behavior (match your preferred section) */
  .project-card .hp-card-cta:hover,
  .project-card .hp-card-cta:focus {
    background-color: #DA6D1D !important;
    outline: 2px solid #DE7C34;
    outline-offset: 2px;
  }
  .project-card .hp-card-cta:hover svg path,
  .project-card .hp-card-cta:focus svg path {
    stroke: #FFFFFF;
  }
</style>

<?php
$lg_mt_class = current_user_can('manage_options') ? 'lg:mt-[8.5rem]' : 'lg:mt-[12rem]';
?>
<div class="mt-[5rem] <?php echo esc_attr($lg_mt_class); ?> w-full">
  <section class="flex overflow-hidden relative">
    <div <?php echo $section_style; ?> class="bg-green-800 xxl:rounded-[32px] flex flex-col items-center mx-auto w-full max-w-[1612px] max-lg:px-5">
      <div class="overflow-hidden relative max-w-[1408px] rounded-[32px] px-5 w-full hero-background">

        <div class="flex z-0 flex-col pt-14 pb-8 w-full max-md:max-w-full">
          <!-- Breadcrumb Navigation -->
          <nav class="flex gap-2 items-center self-start mb-4" aria-label="Breadcrumb">
            <div class="pr-2 w-[30px]">
              <div class="flex w-full min-h-[21px]" aria-hidden="true">
                <svg width="21" height="21" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M9 22V12H15V22" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
            </div>
            <ol class="flex gap-2 items-center pt-0.5 min-w-60">
              <li class="flex gap-2 items-center">
                <a href="<?php echo esc_url(home_url()); ?>" class="text-sm font-semibold leading-none text-white whitespace-nowrap hover:text-yellow-100 focus:text-yellow-100 focus:outline-2 focus:outline-white focus:outline-offset-2" aria-label="Home">Home</a>
                <?php if (!is_front_page()) : ?>
                  <div class="flex gap-2 items-center pt-0.5 w-4 text-white" aria-hidden="true">
                    <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M5.99023 12.2104L9.99023 8.21045L5.99023 4.21045" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </div>
                <?php endif; ?>
              </li>

              <?php
              $blog_page_id = get_option('page_for_posts');
              $is_blog_home = is_home() && !is_front_page();

              if ($is_blog_home || is_category() || is_single() || is_tag() || is_date() || is_author()) {
                $resources_page_id = get_page_by_path('resources');
                if ($resources_page_id) {
                  ?>
                  <li class="flex gap-2 items-center">
                    <a href="<?php echo esc_url(get_permalink($resources_page_id)); ?>" class="text-sm font-semibold leading-none text-white whitespace-nowrap hover:text-yellow-100 focus:text-yellow-100 focus:outline-2 focus:outline-white focus:outline-offset-2" aria-label="Resources">
                      Resources
                    </a>
                    <?php if (!is_home() && !is_post_type_archive('projects') && !is_page($resources_page_id->ID)) : ?>
                      <div class="flex gap-2 items-center pt-0.5 w-4" aria-hidden="true">
                        <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M5.99023 12.2104L9.99023 8.21045L5.99023 4.21045" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </div>
                    <?php endif; ?>
                  </li>
                  <?php
                }

                if (is_single()) {
                  $categories = get_the_category();
                  if (!empty($categories)) {
                    $category = $categories[0];
                    echo '<li class="flex gap-2 items-center">';
                    echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="text-sm font-semibold leading-none text-white whitespace-nowrap hover:text-yellow-100 focus:text-yellow-100 focus:outline-2 focus:outline-white focus:outline-offset-2" aria-label="' . esc_attr($category->name) . '">';
                    echo esc_html($category->name);
                    echo '</a>';
                    echo '<div class="flex gap-2 items-center pt-0.5 w-4" aria-hidden="true">';
                    echo '<svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M5.99023 12.2104L9.99023 8.21045L5.99023 4.21045" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>';
                    echo '</div>';
                    echo '</li>';
                  }
                }
              }

              // Current page/post/archive title
              echo '<li><span class="text-sm font-semibold leading-none text-white">';
              if (is_single() || is_page()) {
                the_title();
              } elseif (is_category()) {
                single_cat_title();
              } elseif (is_tag()) {
                single_tag_title();
              } elseif (is_author()) {
                the_author();
              } elseif (is_date()) {
                if (is_day()) {
                  echo get_the_date('F j, Y');
                } elseif (is_month()) {
                  echo get_the_date('F Y');
                } elseif (is_year()) {
                  echo get_the_date('Y');
                }
              } elseif (is_search()) {
                echo 'Search Results for "' . get_search_query() . '"';
              } elseif (is_404()) {
                echo 'Page Not Found';
              } elseif (is_post_type_archive('projects')) {
                echo 'Projects';
              } elseif ($is_blog_home) {
                echo 'What\'s new in Hanley Pepper';
              }
              echo '</span></li>';
              ?>
            </ol>
          </nav>

          <!-- Main Heading Section -->
          <header class="w-full max-md:max-w-full">
            <?php
              printf(
                '<%1$s class="text-6xl font-bold leading-tight text-white max-md:max-w-full max-md:text-4xl">%2$s</%1$s>',
                esc_attr($hero_tag),
                esc_html($hero_text)
              );
            ?>
            <?php if ($sub_text): ?>
              <p class="mt-2 text-xl leading-snug text-yellow-100 max-md:max-w-full">
                <?php echo esc_html($sub_text); ?>
              </p>
            <?php endif; ?>
          </header>
        </div>

        <!-- Filter + Search -->
        <div class="flex overflow-hidden z-0 flex-wrap gap-6 items-end pb-14 w-full max-md:max-w-full">
          <?php
          $all_cats = get_terms([
            'taxonomy'   => 'project_category',
            'hide_empty' => true,
          ]);
          $current_slug = 'all';
          if (is_tax('project_category')) {
            $queried      = get_queried_object();
            $current_slug = $queried->slug;
          }
          ?>
          <div class="flex-1 pb-2 text-base shrink min-w-60 max-md:max-w-full">
            <span class="mb-2 font-bold text-white"><?php echo esc_html($filter_title); ?></span>

            <div role="radiogroup"
                 aria-label="Filter news by category"
                 class="flex flex-wrap gap-4 items-start mt-2 w-full font-medium max-md:max-w-full">

              <!-- All -->
              <button role="radio"
                      class="gap-2 px-6 py-2 whitespace-nowrap rounded-lg btn filter-btn
                             bg-white hover:bg-[#E9A777] text-black
                             focus:outline-none focus:ring-2 focus:ring-offset-2"
                      data-filter="all"
                      aria-checked="<?php echo $current_slug === 'all' ? 'true' : 'false'; ?>"
                      tabindex="<?php echo $current_slug === 'all' ? '0' : '-1'; ?>">
                All projects
              </button>

              <!-- Categories -->
              <?php foreach ($all_cats as $cat) :
                $slug    = esc_attr($cat->slug);
                $name    = esc_html($cat->name);
                $checked = ($slug === $current_slug) ? 'true' : 'false';
                $tab     = ($slug === $current_slug) ? '0' : '-1';
              ?>
                <button role="radio"
                        class="gap-2 px-6 py-2 whitespace-nowrap rounded-lg filter-btn
                               bg-white hover:bg-[#E9A777] text-black
                               focus:outline-none focus:ring-2 focus:ring-offset-2"
                        data-filter="<?php echo $slug; ?>"
                        aria-checked="<?php echo $checked; ?>"
                        tabindex="<?php echo $tab; ?>">
                  <?php echo $name; ?>
                </button>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Search -->
          <div class="flex items-center w-96 min-w-60">
            <form class="flex w-full" role="search" aria-label="Search projects" id="projects-search-form">
              <div class="flex-1 my-auto text-base shrink min-h-14 min-w-60 text-slate-600">
                <div class="flex-1 w-full">
                  <div class="flex flex-1 justify-between items-center px-4 py-3 bg-white rounded-l size-full">
                    <label for="article-search" class="sr-only">Search projects</label>
                    <input type="search"
                           id="article-search"
                           placeholder="Search projects"
                           class="flex-1 px-4 py-3 bg-white rounded-l border-none size-full text-slate-600 placeholder-slate-600"
                           aria-label="Search projects" />
                  </div>
                </div>
              </div>

              <button type="submit"
                      class="flex gap-2 justify-center items-center px-6 py-4 bg-orange-400 rounded-none min-h-14 w-[72px] max-md:px-5 search-btn"
                      aria-label="Search">
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M21 21.0408L16.65 16.6908M19 11.0408C19 15.459 15.4183 19.0408 11 19.0408C6.58172 19.0408 3 15.459 3 11.0408C3 6.62249 6.58172 3.04077 11 3.04077C15.4183 3.04077 19 6.62249 19 11.0408Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </button>
            </form>
          </div>
        </div><!-- /Filter + Search -->

      </div>
    </div>
  </section>

  <!-- Results + Count -->
  <section class="flex overflow-hidden relative">
    <div class="flex flex-col items-center pt-5 pb-5 mx-auto w-full max-w-[1472px] px-5">
      <div class="flex flex-col gap-8 pt-12 pb-14 w-full bg-white">

        <!-- Heading: Total + Clear -->
        <div class="flex justify-between items-center w-full">
          <?php
            $project_counts = wp_count_posts('projects');
            $project_total  = isset($project_counts->publish) ? (int) $project_counts->publish : 0;
            $ajax_url = admin_url('admin-ajax.php');
            $nonce    = wp_create_nonce('hp_projects');
          ?>
          <span id="projects-count" class="text-2xl font-bold leading-7 text-slate-600">
            <?php echo esc_html($project_total); ?> projects
          </span>

          <button type="button"
                  id="clear-filters"
                  class="flex gap-2 items-center px-4 py-2 bg-gray-200 rounded cursor-pointer h-[42px] w-fit whitespace-nowrap hover:bg-hover hover:text-hover hidden"
                  aria-label="Clear filters">
            <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M12 4.04102L4 12.041M4 4.04102L12 12.041" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="text-sm font-semibold leading-5 text-slate-700">Clear filters</span>
          </button>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-3 gap-8 max-md:grid-cols-1 max-lg:grid-cols-2">
        <?php
        $args = [
          'post_type'      => 'projects',
          'posts_per_page' => 12,
          'paged'          => max( 1, get_query_var( 'paged' ) ),
        ];
        $query   = new WP_Query( $args );
        $pattern = [ 2,1, 1,1,1, 1,2, 1,1,1, 1,2 ]; // index-modulo-12 pattern
        $index   = 0;

        if ( $query->have_posts() ) :
          while ( $query->have_posts() ) : $query->the_post();
            $span   = $pattern[ $index % 12 ];
            $terms  = get_the_terms( get_the_ID(), 'project_category' ) ?: [];
            $cats   = implode( ' ', wp_list_pluck( $terms, 'slug' ) );

            $cat_names  = $terms && ! is_wp_error( $terms ) ? wp_list_pluck( $terms, 'name' ) : [];
            $label_text = $cat_names ? implode( ' + ', $cat_names ) : 'Projects';
        ?>
          <a href="<?php the_permalink(); ?>"
             class="xl:h-[503px] group overflow-hidden relative rounded-lg h-[430px] project-card lg:col-span-<?php echo $span; ?>"
             data-categories="<?php echo esc_attr( $cats ); ?>"
             data-title="<?php echo esc_attr( get_the_title() ); ?>">
              <?php if ( has_post_thumbnail() ) : ?>
                <img src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>"
                     alt="<?php the_title_attribute(); ?>"
                     class="object-cover w-full h-full transition-transform duration-300" />
              <?php endif; ?>

              <!-- gradient overlay -->
              <span aria-hidden="true" class="absolute inset-0 pointer-events-none" style="background:linear-gradient(0deg,#000 0%,rgba(0,0,0,0) 64.03%);"></span>

              <div class="flex justify-between items-end px-8 pt-20 pb-6 w-full min-h-[149px] max-md:px-5 h-full absolute bottom-0 text-white">
                <div class="flex flex-col">
                  <span class="text-xs leading-[1rem]"><?php echo esc_html( $label_text ); ?></span>
                  <span class="mt-1 text-2xl leading-none"><?php the_title(); ?></span>
                </div>
                <button
                  aria-label="View project details"
                  type="button"
                  class="hp-card-cta transition-colors duration-300 rounded-full p-2 bg-transparent
                         group-hover:bg-[#DA6D1D] group-focus-within:bg-[#DA6D1D]
                         focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-orange-400">
                  <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M7.66675 17.2109L17.6667 7.21094M17.6667 7.21094H7.66675M17.6667 7.21094V17.2109"
                          stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </button>
              </div>
          </a>
        <?php
            $index++;
          endwhile;
          wp_reset_postdata();
        else :
          echo '<p>No projects found.</p>';
        endif;
        ?>
        </div><!-- /Grid -->
      </div>
    </div>
  </section>

  <div class="flex justify-center items-center py-12 w-full pagination" x-show="activeCategory === 'all'">
    <?php my_custom_pagination(); ?>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const radiogroup    = document.querySelector('[role="radiogroup"]');
  const buttons       = radiogroup ? radiogroup.querySelectorAll('.filter-btn[role="radio"]') : [];
  const cards         = document.querySelectorAll('.project-card');
  const searchForm    = document.getElementById('projects-search-form');
  const searchInput   = document.getElementById('article-search');
  const clearFilters  = document.getElementById('clear-filters');
  const countEl       = document.getElementById('projects-count');

  const AJAX_URL = '<?php echo esc_js($ajax_url); ?>';
  const NONCE    = '<?php echo esc_js($nonce); ?>';

  // INITIAL ACTIVE FILTER (from server-rendered aria-checked)
  let activeFilter = 'all';
  if (buttons && buttons.length) {
    const current = Array.from(buttons).find(b => b.getAttribute('aria-checked') === 'true');
    if (current) activeFilter = current.getAttribute('data-filter');
  }
  let searchTerm = '';

  function visibleCard(card) {
    const cats  = (card.getAttribute('data-categories') || '').split(' ').filter(Boolean);
    const title = (card.getAttribute('data-title') || '').toLowerCase();

    const matchesCategory = (activeFilter === 'all') || cats.includes(activeFilter);
    const matchesSearch   = (searchTerm === '') || title.includes(searchTerm);

    return matchesCategory && matchesSearch;
  }

  function applyFilter({ updateServerCount = true } = {}) {
    let visible = 0;
    cards.forEach(card => {
      const show = visibleCard(card);
      card.style.display = show ? '' : 'none';
      if (show) visible++;
    });

    // Toggle Clear button
    const needsClear = (activeFilter !== 'all') || (searchTerm !== '');
    if (clearFilters) clearFilters.classList.toggle('hidden', !needsClear);

    // Update count
    if (searchTerm !== '') {
      // When searching, show client-visible count
      if (countEl) countEl.textContent = `${visible} projects`;
    } else if (updateServerCount) {
      // Category only: get server-accurate count
      updateCount(activeFilter);
    }
  }

  async function updateCount(term) {
    try {
      const res = await fetch(AJAX_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8' },
        body: new URLSearchParams({
          action: 'hp_count_projects',
          nonce: NONCE,
          term: term || 'all'
        })
      });
      const json = await res.json();
      if (json && json.success && countEl) {
        countEl.textContent = `${json.data.count} projects`;
      }
    } catch (err) {
      console.error('Count update failed', err);
    }
  }

  // CATEGORY BUTTONS (ARIA radios)
  if (buttons && buttons.length) {
    buttons.forEach((btn, i) => {
      btn.addEventListener('click', () => {
        // set selection
        buttons.forEach(b => {
          b.setAttribute('aria-checked', 'false');
          b.setAttribute('tabindex', '-1');
        });
        btn.setAttribute('aria-checked', 'true');
        btn.setAttribute('tabindex', '0');

        activeFilter = btn.getAttribute('data-filter') || 'all';

        // Dispatch event (if you have other listeners)
        document.dispatchEvent(new CustomEvent('newsFilter', { detail: { filter: activeFilter } }));

        // Apply + server count
        applyFilter({ updateServerCount: true });
      });

      // Keyboard support
      btn.addEventListener('keydown', function (e) {
        if (!['ArrowLeft', 'ArrowRight'].includes(e.key)) return;
        e.preventDefault();
        const arr = Array.from(buttons);
        const idx = arr.indexOf(this);
        const next = e.key === 'ArrowRight' ? (idx + 1) % arr.length : (idx - 1 + arr.length) % arr.length;
        arr[next].focus();
        arr[next].click();
      });
    });
  }

  // SEARCH
  if (searchForm && searchInput) {
    // Prevent page submit
    searchForm.addEventListener('submit', e => e.preventDefault());

    // Live input
    searchInput.addEventListener('input', () => {
      searchTerm = (searchInput.value || '').trim().toLowerCase();
      // When searching, we don't ping server; show visible
      applyFilter({ updateServerCount: false });
    });
  }

  // CLEAR FILTERS
  if (clearFilters) {
    clearFilters.addEventListener('click', () => {
      // Reset category to 'all'
      activeFilter = 'all';
      if (buttons && buttons.length) {
        buttons.forEach(b => {
          const isAll = (b.getAttribute('data-filter') === 'all');
          b.setAttribute('aria-checked', isAll ? 'true' : 'false');
          b.setAttribute('tabindex', isAll ? '0' : '-1');
        });
      }
      // Reset search
      if (searchInput) {
        searchInput.value = '';
        searchTerm = '';
      }

      // Apply + server count
      applyFilter({ updateServerCount: true });
    });
  }

  // Also respond if any other code dispatches newsFilter
  document.addEventListener('newsFilter', e => {
    const term = (e.detail && e.detail.filter) ? e.detail.filter : 'all';
    activeFilter = term;
    applyFilter({ updateServerCount: true });
  });

  // Initial paint
  applyFilter({ updateServerCount: true });
});
</script>

<?php get_footer(); ?>
