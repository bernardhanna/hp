<?php
// template-parts/blog/content.php

// Get the current queried object (category, tag, date, etc.)
$queried_object = get_queried_object();
$category_slug = is_category() ? $queried_object->slug : 'all';

// 1) grab entire group from Options (or wherever it’s attached)
$settings = get_field('blog_settings', 'option') ?: [];

// 2) Background image logic
$hero_bg = ! empty($settings['hero_background_image']['url'])
  ? $settings['hero_background_image']
  : null;

if ($hero_bg) {
  $bg_url = esc_url($hero_bg['url']);
  $section_style = "style=\"background-image:url('{$bg_url}');background-size:cover;background-position:center;\"";
  $fallback_class = '';
} else {
  // fallback Tailwind if no image
  $section_style = '';
  $fallback_class = 'bg-green-800';
}

// 3) Hero heading tag & text
$hero_tag  = $settings['hero_heading_tag']   ?? 'h1';
$hero_text = $settings['hero_heading_text']  ?? "What's new in Hanley Pepper";

// 4) Sub-heading
$sub_text  = $settings['hero_subheading_text'] ?? 'Latest and greatest.';

// 5) Filter title
$filter_title = $settings['filter_section_title'] ?? 'Filter by';

?>
<div class="mt-[8rem] w-full" x-data="{
        activeCategory: '<?php echo esc_js($category_slug); ?>',
        setCategory(category) {
            window.location.href = category === 'all' ? '/resources/' : '/category/' + category;
        }
    }">
    <section class="flex overflow-hidden relative">
        <div <?php echo $section_style; ?>  class="bg-green-800 xxl:rounded-[32px] flex flex-col items-center mx-auto w-full max-w-[1612px] max-lg:px-5">
            <div class="overflow-hidden relative max-w-[1408px] rounded-[32px] max-xxl:px-5 w-full hero-background">

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
                                <a href="<?php echo esc_url(home_url()); ?>" class="text-sm font-semibold leading-none text-white whitespace-nowrap hover:text-yellow-100 focus:text-yellow-100 focus:outline-2 focus:outline-white focus:outline-offset-2" aria-label="Home">
                                    Home
                                </a>
                                <?php if (!is_front_page()) : // Only show arrow if not on home page ?>
                                <div class="flex gap-2 items-center pt-0.5 w-4 text-white" aria-hidden="true">
                                   <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.99023 12.2104L9.99023 8.21045L5.99023 4.21045" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>

                                </div>
                                <?php endif; ?>
                            </li>

                            <?php
                            // Determine if we're on the main blog archive page (often the "Posts Page")
                            $blog_page_id = get_option('page_for_posts');
                            $is_blog_home = is_home() && !is_front_page(); // `is_home()` is true for the Posts Page, `!is_front_page()` ensures it's not the static front page.

                            // If we are on the blog home (Posts Page) or a category/single post from a standard post type
                            if ($is_blog_home || is_category() || is_single() || is_tag() || is_date() || is_author()) {
                                // Add "Resources" or your blog archive link here
                                $resources_page_id = get_page_by_path('resources'); // Get the page object for 'resources'
                                if ($resources_page_id) {
                                    ?>
                                    <li class="flex gap-2 items-center">
                                        <a href="<?php echo esc_url(get_permalink($resources_page_id)); ?>" class="text-sm font-semibold leading-none text-white whitespace-nowrap hover:text-yellow-100 focus:text-yellow-100 focus:outline-2 focus:outline-white focus:outline-offset-2" aria-label="Resources">
                                            Resources
                                        </a>
                                        <?php if (!is_home() && !is_post_type_archive('projects') && !is_page($resources_page_id->ID)) : // Only show arrow if there's more to come after Resources ?>
                                        <div class="flex gap-2 items-center pt-0.5 w-4" aria-hidden="true">
                                   <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.99023 12.2104L9.99023 8.21045L5.99023 4.21045" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                        </div>
                                        <?php endif; ?>
                                    </li>
                                    <?php
                                }

                                // Category breadcrumb for single posts or category archives
                                if (is_single()) {
                                    $categories = get_the_category();
                                    if (!empty($categories)) {
                                        $category = $categories[0]; // Get the first category
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
                            if (is_single()) {
                                the_title();
                            } elseif (is_page()) {
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
                            } elseif (is_post_type_archive('projects')) { // For custom post type archive
                                echo 'Projects'; // Or your desired title
                            } elseif ($is_blog_home) {
                                // If 'Resources' is your main blog page, this will be the final breadcrumb
                                // You can customize this or remove it if 'Resources' itself is the final breadcrumb for the blog home
                                echo 'What\'s new in Hanley Pepper'; // Or the actual title of your "Resources" page
                            }
                            echo '</span></li>';
                            ?>
                        </ol>
                    </nav>

                    <!-- Main Heading Section -->
                  <header class="w-full max-md:max-w-full">
                        <?php
                          // dynamic heading tag
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

                <!-- Filter and Search Section -->
                <div class="flex overflow-hidden z-0 flex-wrap gap-6 items-end pb-14 w-full max-md:max-w-full">

                    <!-- Filter Section -->
                  <?php
                  // before you output anything, grab the WP categories and current filter
                  $all_cats      = get_terms([
                    'taxonomy'   => 'category',
                    'hide_empty' => true,
                  ]);
                  $current_slug  = $category_slug; // you already have this from get_queried_object()
                ?>
                <div class="flex-1 pb-2 text-base shrink min-w-60 max-md:max-w-full">
                  <span class="mb-2 font-bold text-white"><?php echo esc_html($filter_title); ?></span>
                  <div
                    role="radiogroup"
                    aria-label="Filter news by category"
                    class="flex flex-wrap gap-4 items-start mt-2 w-full font-medium max-md:max-w-full"
                  >
                    <button
                      role="radio"
                      class="gap-2 px-6 py-2 whitespace-nowrap rounded-lg filter-btn bg-secondary hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 btn"
                      data-filter="all"
                      aria-checked="<?php echo $current_slug === 'all' ? 'true' : 'false'; ?>"
                      tabindex="<?php echo $current_slug === 'all' ? '0' : '-1'; ?>"
                    >
                      All news
                    </button>

                    <?php foreach ( $all_cats as $cat ) :
                      $slug    = esc_attr( $cat->slug );
                      $name    = esc_html( $cat->name );
                      $checked = ( $slug === $current_slug ) ? 'true' : 'false';
                      $tab     = ( $slug === $current_slug ) ? '0' : '-1';
                    ?>
                      <button
                        role="radio"
                        class="gap-2 px-6 py-2 whitespace-nowrap rounded-lg filter-btn bg-secondary hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-3black"
                        data-filter="<?php echo $slug; ?>"
                        aria-checked="<?php echo $checked; ?>"
                        tabindex="<?php echo $tab; ?>"
                      >
                        <?php echo $name; ?>
                      </button>
                    <?php endforeach; ?>
                  </div>
                </div>


                    <!-- Search Section -->
                    <div class="flex items-center w-96 min-w-60">
                        <form class="flex w-full" role="search" aria-label="Search articles">
                            <div class="flex-1 my-auto text-base shrink min-h-14 min-w-60 text-slate-600">
                                <div class="flex-1 w-full">
                                    <div class="flex flex-1 justify-between items-center px-4 py-3 bg-white rounded-l size-full">
                                        <label for="article-search" class="sr-only">Search articles</label>
                                          <input
                                            type="search"
                                            id="article-search"
                                            placeholder="Search articles"
                                            class="flex-1 px-4 py-3 bg-white rounded-l border-none size-full text-slate-600 placeholder-slate-600"
                                            aria-label="Search articles"
                                          />
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="flex gap-2 justify-center items-center px-6 py-4  bg-orange-400 rounded-none min-h-14 w-[72px] max-md:px-5 search-btn" aria-label="Search">
                              <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 21.0408L16.65 16.6908M19 11.0408C19 15.459 15.4183 19.0408 11 19.0408C6.58172 19.0408 3 15.459 3 11.0408C3 6.62249 6.58172 3.04077 11 3.04077C15.4183 3.04077 19 6.62249 19 11.0408Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>

                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filter button functionality
            const filterButtons = document.querySelectorAll('[data-filter]');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active state from all buttons
                    filterButtons.forEach(btn => {
                        btn.setAttribute('aria-pressed', 'false');
                    });

                    // Add active state to clicked button
                    this.setAttribute('aria-pressed', 'true');

                    // Trigger filter event (can be extended for actual filtering)
                    const filterValue = this.getAttribute('data-filter');
                    const filterEvent = new CustomEvent('newsFilter', {
                        detail: { filter: filterValue }
                    });
                    document.dispatchEvent(filterEvent);
                });
            });

            // Search form functionality
            const searchForm = document.querySelector('form[role="search"]');
            if (searchForm) {
                searchForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const searchInput = this.querySelector('input[type="search"]');
                    const searchValue = searchInput.value.trim();

                    if (searchValue) {
                        // Trigger search event (can be extended for actual search)
                        const searchEvent = new CustomEvent('newsSearch', {
                            detail: { query: searchValue }
                        });
                        document.dispatchEvent(searchEvent);
                        console.log('Searching for:', searchValue);
                    }
                });
            }
        });
    </script>

  </div>

<section class="flex overflow-hidden relative">
  <div class="flex flex-col items-center pt-5 pb-5 mx-auto w-full max-w-[1472px] px-5">
    <div class="flex flex-col gap-8 pt-12 pb-14 w-full bg-white max-md:p-8 max-sm:p-4">
      
      <!-- Heading: Total posts + Clear Filters Button -->
      <div class="flex justify-between items-center w-full">
        <span class="text-2xl font-bold leading-7 text-slate-600">
          <?php echo wp_count_posts()->publish; ?> posts
        </span>
        <button
            type="button"
            id="clear-filters"
            class="flex gap-2 items-center px-4 py-2 bg-gray-200 rounded cursor-pointer h-[42px] w-fit whitespace-nowrap hover:bg-hover hover:text-hover hidden"
            aria-label="Clear filters"
          >
          <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M12 4.04102L4 12.041M4 4.04102L12 12.041" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
          </svg>
          <span class="text-sm font-semibold leading-5 text-slate-700">Clear filters</span>
        </button>
      </div>

      <!-- Blog Posts Grid -->
      <div class="grid grid-cols-2 gap-8 max-md:grid-cols-1">
        <?php
        $args = [
          'post_type'      => 'post',
          'posts_per_page' => 10,
          'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
        ];

        $query = new WP_Query($args);

        if ($query->have_posts()) :
          while ($query->have_posts()) : $query->the_post();
          // get an array of category slugs for this post
          $post_cats = array_map( function( $c ){ return $c->slug; }, get_the_category() );
          $data_attr = implode( ' ', $post_cats );
        ?>
       <a
          href="<?php the_permalink(); ?>"
          class="group overflow-hidden relative rounded-lg h-[430px] project-card"
          data-categories="<?php echo esc_attr( $data_attr ); ?>">
            <?php if (has_post_thumbnail()) : ?>
              <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" alt="<?php the_title_attribute(); ?>" class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-105" />
            <?php endif; ?>
                        <!-- gradient overlay -->
            <span aria-hidden="true"
                    class="absolute inset-0 pointer-events-none"
                    style="background:linear-gradient(0deg,#000 0%,rgba(0,0,0,0) 64.03%);">
            </span>
            <div class="absolute bottom-6 left-6 py-6 pr-6 pl-8 rounded-lg bg-white bg-opacity-90 w-[calc(100%-48px)]">
              <h3 class="mb-1 text-2xl font-bold leading-7 text-slate-700">
                <?php the_title(); ?>
              </h3>
              <time datetime="<?php echo get_the_date('c'); ?>" class="text-sm font-semibold leading-5 text-slate-700">
                <?php echo get_the_date(); ?>
              </time>
            </div>
          </a>
        <?php endwhile;
          wp_reset_postdata();
        else : ?>
          <p>No posts found.</p>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>
    <div class="flex justify-center items-center py-12 w-full pagination" x-show="activeCategory === 'all'">
      <?php my_custom_pagination(); ?>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const buttons      = document.querySelectorAll('.filter-btn');
  const cards        = document.querySelectorAll('.project-card');
  const searchInput  = document.getElementById('article-search');
  const clearFilters = document.getElementById('clear-filters');

  if (!clearFilters) {
    console.warn('⚠️ #clear-filters button not found');
    return;
  }

  let activeFilter = 'all';
  let searchTerm   = '';

  // decide visibility of a card
  function cardVisible(card) {
    const cats = card.getAttribute('data-categories').split(' ');
    const titleEl = card.querySelector('h3');
    const title   = titleEl ? titleEl.textContent.toLowerCase() : '';

    const matchesCategory = (activeFilter === 'all') || cats.includes(activeFilter);
    const matchesSearch   = (searchTerm === '') || (title.indexOf(searchTerm) !== -1);

    return matchesCategory && matchesSearch;
  }

  // apply to all cards, then toggle clear button
  function applyFilter() {
    cards.forEach(card => {
      card.style.display = cardVisible(card) ? '' : 'none';
    });

    // Show clearFilters if we're not default
    const needsClear = (activeFilter !== 'all') || (searchTerm !== '');
    if (needsClear) {
      clearFilters.classList.remove('hidden');
    } else {
      clearFilters.classList.add('hidden');
    }
  }

  // CATEGORY BUTTONS
  buttons.forEach(btn => {
    btn.addEventListener('click', () => {
      // reset aria-pressed
      buttons.forEach(b => b.setAttribute('aria-pressed','false'));
      btn.setAttribute('aria-pressed','true');

      activeFilter = btn.getAttribute('data-filter');
      applyFilter();
    });
  });

  // LIVE SEARCH
  if (searchInput) {
    searchInput.addEventListener('input', () => {
      searchTerm = searchInput.value.trim().toLowerCase();
      applyFilter();
    });
  }

  // CLEAR FILTERS BUTTON
  clearFilters.addEventListener('click', () => {
    // Reset category buttons
    activeFilter = 'all';
    buttons.forEach(b => {
      b.setAttribute('aria-pressed', b.getAttribute('data-filter') === 'all' ? 'true' : 'false');
    });

    // Reset search
    if (searchInput) {
      searchInput.value = '';
      searchTerm = '';
    }

    applyFilter();
  });

  // initial run (hide it by default)
  applyFilter();
});
</script>
