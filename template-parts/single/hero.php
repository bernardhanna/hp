<?php
/**
 * Single Post Header Section
 *
 */
// Unique section ID if you need it (optional)
$section_id = 'hero-' . wp_generate_uuid4();
// Determine border-radius (hardcoded here, but you could make this an ACF sub-field)
$border_radius = 'rounded-2xl';
// Figure out what image size to use by screen width (you can customize this mapping)
$image_size    = 'hero-large'; // fallback size
// Generate a unique ID for this section instance
$section_id = 'post-header-' . wp_generate_uuid4();
// Get post content and estimate reading time (average 200 wpm)
$content       = get_post_field( 'post_content', get_the_ID() );
$word_count    = str_word_count( wp_strip_all_tags( $content ) );
$reading_time  = max( 1, ceil( $word_count / 200 ) ); // at least "1 min"

// Fetch author, published & modified dates
$author_name       = get_the_author();
$published_time    = get_the_date( 'c' );         // ISO 8601
$published_display = get_the_date( 'j M Y' );     // e.g. "10 Oct 2023"
$modified_time     = get_the_modified_date( 'c' );
$modified_display  = get_the_modified_date( 'j M Y' );
?>

<section id="<?php echo esc_attr( $section_id ); ?>" class="flex overflow-hidden relative flex-col mx-auto w-full px-5 max-w-[1136px]">
  <div class="flex flex-row gap-10 justify-between items-start max-w-[1136px] pt-[10rem]">
   <nav aria-label="Breadcrumb">
      <ol class="flex gap-2 items-center my-2 text-sm font-semibold text-gray-700">
        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
          <g clip-path="url(#clip0_2825_31113)">
                <path d="M3.36964 11.3868C2.956 11.3868 2.61865 11.7195 2.61865 12.1275V20.886C2.61865 21.294 2.95601 21.6268 3.36964 21.6268H18.9234C19.337 21.6268 19.6743 21.294 19.6743 20.886V12.1275C19.6743 11.7195 19.337 11.3868 18.9234 11.3868C18.5097 11.3868 18.1724 11.7195 18.1724 12.1275V20.1453L4.12063 20.1467V12.1275C4.12063 11.7209 3.78621 11.3868 3.36964 11.3868Z" fill="#667085"/>
                <path d="M11.4882 0.979276C11.2066 0.734773 10.7827 0.734773 10.5011 0.979276L0.257236 9.81594C-0.0537185 10.0865 -0.0889248 10.5524 0.185362 10.8605C0.45965 11.1672 0.931957 11.2019 1.24437 10.9314L10.9926 2.51991L20.7408 10.9314C20.8831 11.0529 21.0605 11.1166 21.2365 11.1166C21.4463 11.1166 21.6531 11.0312 21.8042 10.8648C22.0785 10.5581 22.0447 10.0908 21.7323 9.82028L11.4882 0.979276Z" fill="#667085"/>
                <path d="M14.1312 19.1051C14.5449 19.1051 14.8822 18.7723 14.8822 18.3643V13.9243C14.8822 13.5163 14.5449 13.1836 14.1312 13.1836H8.16163C7.74799 13.1836 7.41064 13.5163 7.41064 13.9243V18.3643C7.41064 18.7723 7.748 19.1051 8.16163 19.1051C8.57528 19.1051 8.91262 18.7723 8.91262 18.3643V14.665H13.3802V18.3643C13.3802 18.7723 13.7191 19.1051 14.1312 19.1051Z" fill="#667085"/>
                </g>
                <defs>
                <clipPath id="clip0_2825_31113">
                <rect width="21.99" height="20.8309" fill="white" transform="translate(0 0.795898)"/>
                </clipPath>
                </defs>
            </svg>

              <li><a href="<?php echo home_url(); ?>">Home</a></li>
              <li><svg class="mx-2" width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12l5-5-5-5" stroke="currentColor" stroke-width="2"/></svg></li>
              <?php if (is_singular()): ?>
                <li aria-current="page"><?php echo get_the_title(); ?></li>
              <?php elseif (is_archive()): ?>
                <li aria-current="page"><?php echo post_type_archive_title('', false); ?></li>
              <?php elseif (is_home()): ?>
                <li aria-current="page">Blog</li>
              <?php elseif (is_404()): ?>
                <li aria-current="page">404 Not Found</li>
              <?php endif; ?>
            </ol>
          </nav>
    </div>
  <div class="flex flex-col items-center pb-5 mx-auto w-full max-w-[1024px]">
    <article class="py-12 w-full">
      <header class="w-full max-md:max-w-full">
        <div class="w-full max-md:max-w-full">
          <div
            class="text-xs font-semibold leading-none text-slate-600"
            role="note"
            aria-label="<?php echo esc_attr( $reading_time ); ?> minute reading time"
          >
            <?php echo esc_html( $reading_time ); ?> min reading time
          </div>
          <?php /* Dynamic heading level if you wanted: here we hardcode <h1> for post title */ ?>
          <h1
            class="mt-2 text-5xl font-bold tracking-tighter leading-none text-green-950 max-md:max-w-full max-md:text-4xl"
          >
            <?php the_title(); ?>
          </h1>
        </div>
      </header>

      <div
        class="py-4 mt-6 w-full text-sm leading-none border-t border-b border-solid border-y-gray-200 text-slate-600 max-md:max-w-full"
        role="contentinfo"
      >
        <div class="w-full font-semibold text-slate-600 max-md:max-w-full">
          <?php echo esc_html( $author_name ); ?>
        </div>
        <div class="mt-2 w-full text-slate-600 max-md:max-w-full">
          <time datetime="<?php echo esc_attr( $modified_time ); ?>" aria-label="Last updated">
            Updated on <?php echo esc_html( $modified_display ); ?>
          </time>
          <span aria-hidden="true"> – </span>
          <time datetime="<?php echo esc_attr( $published_time ); ?>" aria-label="Originally published">
            Published on <?php echo esc_html( $published_display ); ?>
          </time>
        </div>
      </div>
    </article>
     <div id="<?php echo esc_attr( $section_id ); ?>" class="flex overflow-hidden relative w-full">
        <div class="flex flex-col items-center pt-5 pb-5 mx-auto w-full max-lg:px-5">
          <div class="overflow-hidden w-full <?php echo esc_attr( $border_radius ); ?>">
            <?php if ( has_post_thumbnail() ) : 
                // Pull attachment ID
                $thumb_id   = get_post_thumbnail_id( get_the_ID() );
                
                // Alt / Title fallback to post title
                $alt_text   = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
                if ( ! $alt_text ) {
                  $alt_text = get_the_title( $thumb_id ) ?: get_the_title();
                }
                $title_text = get_the_title( $thumb_id ) ?: get_the_title();

                // Output responsive <img> with srcset & sizes
                echo wp_get_attachment_image(
                  $thumb_id,
                  $image_size,
                  false,
                  [
                    'class' => 'rounded-2x object-cover w-full aspect-[2.27] max-md:max-w-full',
                    'alt'   => esc_attr( $alt_text ),
                    'title' => esc_attr( $title_text ),
                    // you can add a 'sizes' attribute here if you want custom sizing rules
                  ]
                );
              else :
            ?>
              <!-- Fallback placeholder if no featured image -->
              <div class="w-full aspect-[2.27] bg-gray-300 flex items-center justify-center">
                <span class="text-slate-600">No image available</span>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
  </div>
</section>