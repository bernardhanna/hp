<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article class="p-8 mx-auto w-full max-w-[1048px] bg-white rounded-lg shadow-sm">
  <!-- Post Title -->
  <h1 class="mb-8 text-3xl font-bold text-gray-900">
    <?php the_title(); ?>
  </h1>

  <!-- Post Content -->
  <div class="mb-8 max-w-none prose">
    <?php
      // Outputs the post content. If you want to limit to an excerpt, swap to the_excerpt().
      the_content();
    ?>
  </div>

  <!-- Author & Date Section -->
  <?php
    // Prepare dates
    $published_iso   = get_the_date( 'c' );
    $published_disp  = get_the_date( 'j M Y' );
    $modified_iso    = get_the_modified_date( 'c' );
    $modified_disp   = get_the_modified_date( 'j M Y' );
  ?>
  <section
    class="py-4 text-sm leading-none border-t border-solid border-t-gray-200 text-slate-600"
    role="contentinfo"
    aria-label="Article metadata"
  >
    <header class="w-full font-semibold text-slate-600 max-md:max-w-full">
      <h2 class="sr-only">Author Information</h2>
      <?php echo esc_html( get_the_author() ); ?>
    </header>
    <div class="mt-2 w-full text-slate-600 max-md:max-w-full">
      <time datetime="<?php echo esc_attr( $modified_iso ); ?>" aria-label="Last updated">
        Updated on <?php echo esc_html( $modified_disp ); ?>
      </time>
      <span aria-hidden="true"> – </span>
      <time datetime="<?php echo esc_attr( $published_iso ); ?>" aria-label="Originally published">
        Published on <?php echo esc_html( $published_disp ); ?>
      </time>
    </div>
  </section>
</article>

<?php endwhile; endif; ?>
