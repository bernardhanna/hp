<?php get_header(); ?>
<?php
// === BLOG OPTIONS (Theme Options → Blog tab) ==========================
$blog_opts   = function_exists('get_field') ? ( get_field('blog_settings', 'option') ?: [] ) : [];
$hero_bg     = !empty($blog_opts['hero_background_image']['url']) ? $blog_opts['hero_background_image'] : null;
$hero_tag    = $blog_opts['hero_heading_tag']     ?? 'h1';
$hero_text   = $blog_opts['hero_heading_text']    ?? "What's new in Hanley Pepper";
$sub_text    = $blog_opts['hero_subheading_text'] ?? 'Latest and greatest.';
$filter_title= $blog_opts['filter_section_title'] ?? 'Filter by';

$section_style = '';
if ($hero_bg) {
  $bg_url        = esc_url($hero_bg['url']);
  $section_style = "style=\"background-image:url('{$bg_url}');background-size:cover;background-position:center;\"";
}
?>
<style>
  /* Active button = #DE7C34 and hover does not override */
  [role="radiogroup"] .filter-btn[aria-checked="true"]{ background-color:#DE7C34!important;color:#000; }
  [role="radiogroup"] .filter-btn[aria-checked="true"]:hover{ background-color:#DE7C34!important; }

  /* Card CTA hover/focus (match preferred section) */
  .post-card .hp-card-cta:hover,
  .post-card .hp-card-cta:focus {
    background-color: #DA6D1D !important;
    outline: 2px solid #DE7C34;
    outline-offset: 2px;
  }
  .post-card .hp-card-cta:hover svg path,
  .post-card .hp-card-cta:focus svg path {
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
          <!-- Breadcrumb -->
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
                <a href="<?php echo esc_url(home_url()); ?>" class="text-sm font-semibold leading-none text-white whitespace-nowrap hover:text-yellow-100 focus:text-yellow-100 focus:outline-2 focus:outline-white focus:outline-offset-2">Home</a>
                <div class="flex gap-2 items-center pt-0.5 w-4 text-white" aria-hidden="true">
                  <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.99 12.21L9.99 8.21L5.99 4.21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
              </li>
              <li><span class="text-sm font-semibold leading-none text-white">Blog</span></li>
            </ol>
          </nav>

          <!-- Hero -->
          <header class="w-full max-md:max-w-full">
            <?php printf('<%1$s class="text-6xl font-bold leading-tight text-white max-md:max-w-full max-md:text-4xl">%2$s</%1$s>', esc_attr($hero_tag), esc_html($hero_text)); ?>
            <?php if ($sub_text): ?>
              <p class="mt-2 text-xl leading-snug text-yellow-100 max-md:max-w-full"><?php echo esc_html($sub_text); ?></p>
            <?php endif; ?>
          </header>
        </div>

        <!-- Filters & Search -->
        <div class="flex overflow-hidden z-0 flex-wrap gap-6 items-end pb-14 w-full max-md:max-w-full">
          <?php
          $all_cats     = get_terms(['taxonomy'=>'category','hide_empty'=>true]);
          $current_slug = is_category() ? get_queried_object()->slug : 'all';
          ?>
          <div class="flex-1 pb-2 text-base shrink min-w-60 max-md:max-w-full">
            <span class="mb-2 font-bold text-white"><?php echo esc_html($filter_title); ?></span>
            <div role="radiogroup" aria-label="Filter posts by category" class="flex flex-wrap gap-4 items-start mt-2 w-full font-medium max-md:max-w-full">
              <button role="radio"
                      class="gap-2 px-6 py-2 whitespace-nowrap rounded-lg btn filter-btn bg-white hover:bg-[#E9A777] text-black focus:outline-none focus:ring-2 focus:ring-offset-2"
                      data-filter="all"
                      aria-checked="<?php echo $current_slug === 'all' ? 'true' : 'false'; ?>"
                      tabindex="<?php echo $current_slug === 'all' ? '0' : '-1'; ?>">
                All posts
              </button>
              <?php foreach ($all_cats as $cat):
                $slug    = esc_attr($cat->slug);
                $name    = esc_html($cat->name);
                $checked = ($slug === $current_slug) ? 'true' : 'false';
                $tab     = ($slug === $current_slug) ? '0' : '-1';
              ?>
                <button role="radio"
                        class="gap-2 px-6 py-2 whitespace-nowrap rounded-lg filter-btn bg-white hover:bg-[#E9A777] text-black focus:outline-none focus:ring-2 focus:ring-offset-2"
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
            <form class="flex w-full" role="search" aria-label="Search posts" id="posts-search-form">
              <div class="flex-1 my-auto text-base shrink min-h-14 min-w-60 text-slate-600">
                <div class="flex-1 w-full">
                  <div class="flex flex-1 justify-between items-center px-4 py-3 bg-white rounded-l size-full">
                    <label for="article-search" class="sr-only">Search posts</label>
                    <input type="search" id="article-search" placeholder="Search posts"
                           class="flex-1 px-4 py-3 bg-white rounded-l border-none size-full text-slate-600 placeholder-slate-600"
                           aria-label="Search posts" />
                  </div>
                </div>
              </div>
              <button type="submit"
                      class="flex gap-2 justify-center items-center px-6 py-4 bg-orange-400 rounded-none min-h-14 w-[72px] max-md:px-5 search-btn"
                      aria-label="Search">
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 21.04L16.65 16.69M19 11.04C19 15.459 15.4183 19.04 11 19.04C6.58172 19.04 3 15.459 3 11.04C3 6.62249 6.58172 3.04077 11 3.04077C15.4183 3.04077 19 6.62249 19 11.0408Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
              </button>
            </form>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Results + Count -->
  <section class="flex overflow-hidden relative">
    <div class="flex flex-col items-center pt-5 pb-5 mx-auto w-full max-w-[1472px] px-5">
      <div class="flex flex-col gap-8 pt-12 pb-14 w-full bg-white">

        <div class="flex justify-between items-center w-full">
          <?php
            $post_total = (int) wp_count_posts('post')->publish;
            $ajax_url   = admin_url('admin-ajax.php');
            $nonce      = wp_create_nonce('hp_archive_count');
          ?>
          <span id="posts-count" class="text-2xl font-bold leading-7 text-slate-600">
            <?php echo esc_html($post_total); ?> posts
          </span>

          <button type="button" id="clear-filters"
                  class="flex gap-2 items-center px-4 py-2 bg-gray-200 rounded cursor-pointer h-[42px] w-fit whitespace-nowrap hover:bg-hover hover:text-hover hidden"
                  aria-label="Clear filters">
            <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M12 4.04102L4 12.041M4 4.04102L12 12.041" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="text-sm font-semibold leading-5 text-slate-700">Clear filters</span>
          </button>
        </div>

        <!-- Use MAIN WP QUERY so the Reading setting & pagination work -->
        <div class="grid grid-cols-3 gap-8 max-md:grid-cols-1 max-lg:grid-cols-2">
          <?php
          $pattern = [2,1, 1,1,1, 1,2, 1,1,1, 1,2];
          $index   = 0;

          // If someone accidentally emptied the main query (rare), fall back:
          if (!have_posts()) {
            // Fallback to posts to avoid empty page (optional)
            query_posts([
              'post_type'      => 'post',
              'posts_per_page' => get_query_var('posts_per_page') ?: 10,
              'paged'          => max(1, get_query_var('paged')),
            ]);
          }

          if (have_posts()) :
            while (have_posts()) : the_post();
              $span  = $pattern[$index % 12];
              $terms = get_the_terms(get_the_ID(), 'category') ?: [];
              $cats  = implode(' ', wp_list_pluck($terms, 'slug'));
              $cat_names  = $terms && !is_wp_error($terms) ? wp_list_pluck($terms, 'name') : [];
              $label_text = $cat_names ? implode(' + ', $cat_names) : 'Posts';
          ?>
            <a href="<?php the_permalink(); ?>"
               class="xl:h-[503px] group overflow-hidden relative rounded-lg h-[430px] post-card lg:col-span-<?php echo (int)$span; ?>"
               data-categories="<?php echo esc_attr($cats); ?>"
               data-title="<?php echo esc_attr(get_the_title()); ?>">

              <?php if (has_post_thumbnail()): ?>
                <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>"
                     alt="<?php the_title_attribute(); ?>"
                     class="object-cover w-full h-full transition-transform duration-300" />
              <?php endif; ?>

              <span aria-hidden="true" class="absolute inset-0 pointer-events-none"
                    style="background:linear-gradient(0deg,#000 0%,rgba(0,0,0,0) 64.03%);"></span>

              <div class="flex justify-between items-end px-8 pt-20 pb-6 w-full min-h-[149px] max-md:px-5 h-full absolute bottom-0 text-white">
                <div class="flex flex-col">
                  <span class="text-xs leading-[1rem]"><?php echo esc_html($label_text); ?></span>
                  <span class="mt-1 text-2xl leading-none"><?php the_title(); ?></span>
                </div>
                <button
                  aria-label="View post details"
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
          else :
            echo '<p class="col-span-3">No posts found.</p>';
          endif;
          ?>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center items-center py-12 w-full pagination">
          <?php
          if (function_exists('my_custom_pagination')) {
            my_custom_pagination();
          } else {
            the_posts_pagination([
              'mid_size'           => 2,
              'prev_text'          => '&larr; Previous',
              'next_text'          => 'Next &rarr;',
              'screen_reader_text' => 'Posts navigation',
            ]);
          }
          ?>
        </div>

      </div>
    </div>
  </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const radiogroup   = document.querySelector('[role="radiogroup"]');
  const buttons      = radiogroup ? radiogroup.querySelectorAll('.filter-btn[role="radio"]') : [];
  const cards        = document.querySelectorAll('.post-card');
  const searchForm   = document.getElementById('posts-search-form');
  const searchInput  = document.getElementById('article-search');
  const clearFilters = document.getElementById('clear-filters');
  const countEl      = document.getElementById('posts-count');

  const AJAX_URL = '<?php echo esc_js( admin_url('admin-ajax.php') ); ?>';
  const NONCE    = '<?php echo esc_js( wp_create_nonce('hp_archive_count') ); ?>';

  let activeFilter = 'all';
  if (buttons && buttons.length) {
    const current = Array.from(buttons).find(b => b.getAttribute('aria-checked') === 'true');
    if (current) activeFilter = current.getAttribute('data-filter');
  }
  let searchTerm = '';

  function visibleCard(card){
    const cats  = (card.getAttribute('data-categories') || '').split(' ').filter(Boolean);
    const title = (card.getAttribute('data-title') || '').toLowerCase();
    const matchCat    = (activeFilter === 'all') || cats.includes(activeFilter);
    const matchSearch = (searchTerm === '') || title.includes(searchTerm);
    return matchCat && matchSearch;
  }

  function applyFilter({ serverCount = true } = {}){
    let visible = 0;
    cards.forEach(c => {
      const show = visibleCard(c);
      c.style.display = show ? '' : 'none';
      if (show) visible++;
    });

    const needsClear = (activeFilter !== 'all') || (searchTerm !== '');
    if (clearFilters) clearFilters.classList.toggle('hidden', !needsClear);

    if (searchTerm !== '') {
      if (countEl) countEl.textContent = `${visible} posts`;
    } else if (serverCount) {
      updateCount(activeFilter);
    }
  }

  async function updateCount(term){
    try {
      const res = await fetch(AJAX_URL, {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8'},
        body: new URLSearchParams({
          action:'hp_count_archive',
          nonce: NONCE,
          post_type:'post',
          taxonomy:'category',
          term: term || 'all'
        })
      });
      const json = await res.json();
      if (json && json.success && countEl) countEl.textContent = `${json.data.count} posts`;
    } catch(e){ console.error('Count failed', e); }
  }

  if (buttons && buttons.length) {
    buttons.forEach(btn => {
      btn.addEventListener('click', () => {
        buttons.forEach(b => { b.setAttribute('aria-checked','false'); b.setAttribute('tabindex','-1'); });
        btn.setAttribute('aria-checked','true'); btn.setAttribute('tabindex','0');
        activeFilter = btn.getAttribute('data-filter') || 'all';
        applyFilter({ serverCount:true });
      });

      btn.addEventListener('keydown', function(e){
        if (!['ArrowLeft','ArrowRight'].includes(e.key)) return;
        e.preventDefault();
        const arr = Array.from(buttons);
        const i = arr.indexOf(this);
        const next = e.key === 'ArrowRight' ? (i+1)%arr.length : (i-1+arr.length)%arr.length;
        arr[next].focus(); arr[next].click();
      });
    });
  }

  if (searchForm && searchInput) {
    searchForm.addEventListener('submit', e => e.preventDefault());
    searchInput.addEventListener('input', () => {
      searchTerm = (searchInput.value || '').trim().toLowerCase();
      applyFilter({ serverCount:false });
    });
  }

  if (clearFilters) {
    clearFilters.addEventListener('click', () => {
      activeFilter = 'all';
      if (buttons && buttons.length) {
        buttons.forEach(b => {
          const isAll = b.getAttribute('data-filter') === 'all';
          b.setAttribute('aria-checked', isAll ? 'true':'false');
          b.setAttribute('tabindex', isAll ? '0':'-1');
        });
      }
      if (searchInput) { searchInput.value=''; searchTerm=''; }
      applyFilter({ serverCount:true });
    });
  }

  applyFilter({ serverCount:true });
});
</script>

<?php get_footer(); ?>
