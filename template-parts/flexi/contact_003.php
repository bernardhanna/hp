<?php
$id = uniqid('contact-003-');

/* ── ACF fields ── */
$subheading        = get_sub_field('subheading');
$heading           = get_sub_field('heading');
$heading_tag       = get_sub_field('heading_tag') ?: 'h1';
$description       = get_sub_field('description');
$form_heading      = get_sub_field('form_heading');
$form_heading_tag  = get_sub_field('form_heading_tag') ?: 'h2';
$form_markup       = get_sub_field('form_markup');
$text_color        = get_sub_field('text_color') ?: '#1D2939';
$background_color  = get_sub_field('background_color') ?: '#ffffff';

/* padding repeater */
$padding_classes = ['pt-5','pb-5'];
if ( have_rows('padding_settings') ) {
	while ( have_rows('padding_settings') ) {
		the_row();
		$br = get_sub_field('screen_size');
		$pt = get_sub_field('padding_top');
		$pb = get_sub_field('padding_bottom');
		$padding_classes[] = "{$br}:pt-[{$pt}rem]";
		$padding_classes[] = "{$br}:pb-[{$pb}rem]";
	}
}

/* ── Inject action + data attribute ── */
$form_markup = str_replace(
	'<form',
	sprintf(
		'<form action="%1$s" method="post" enctype="multipart/form-data" data-theme-form="%2$s"',
		esc_url( admin_url('admin-post.php') ),
		esc_attr( $id )
	),
	$form_markup
);

/* ── Build hidden inputs ── */
$hidden  = sprintf(
	'<input type="hidden" name="action" value="theme_form_submit">
	 <input type="hidden" name="theme_form_nonce" value="%1$s">
	 <input type="hidden" name="_theme_form_id"  value="%2$s">',
	wp_create_nonce('theme_form_submit'),
	get_row_index()
);

/* add save-to-DB flag if ticked */
if ( get_sub_field('save_entries_to_db') ) {
	$hidden .= '<input type="hidden" name="_theme_save_to_db" value="1">';
}

/* drop the inputs just before </form> */
$form_markup = str_replace('</form>', $hidden . '</form>', $form_markup);
?>

<section id="<?php echo esc_attr($id); ?>" class="flex overflow-hidden relative">
  <div class="flex flex-col lg:flex-row justify-between items-center w-full mx-auto max-w-[1344px] max-xxl:px-5 <?php echo esc_attr(implode(' ', $padding_classes)); ?>">
  
      <div class="w-1/2 xl:max-w-[528px] max-lg:w-full">
        <div class="w-full max-md:max-w-full" style="color: <?php echo esc_attr($text_color); ?>;">
          <?php if ($subheading): ?>
            <span class="text-lg font-semibold leading-none"><?php echo esc_html($subheading); ?></span>
          <?php endif; ?>
          <?php if ($heading): ?>
            <<?php echo esc_attr($heading_tag); ?> class="text-4xl font-bold tracking-tighter leading-10 text-primary"><?php echo esc_html($heading); ?></<?php echo esc_attr($heading_tag); ?>>
          <?php endif; ?>
          <?php if ($description): ?>
            <div class="mt-6 text-lg leading-6 text-slate-700 wp_editor">
              <?php echo wp_kses_post($description); ?>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="overflow-hidden p-14 my-auto bg-gray-50 rounded-[16px] w-full lg:w-1/2 max-w-[736px] max-md:px-5 max-md:max-w-full">
        <?php if ($form_heading): ?>
          <<?php echo esc_attr($form_heading_tag); ?> class="text-3xl font-bold leading-tight text-slate-600 max-md:max-w-full"><?php echo esc_html($form_heading); ?></<?php echo esc_attr($form_heading_tag); ?>>
        <?php endif; ?>

        <div class="mt-6">
                <?php
                /* Output sanitised form markup */
                echo wp_kses(
                  $form_markup,
                  [
                    'form'=>[
                      'class'=>[], 'role'=>[], 'aria-labelledby'=>[], 'novalidate'=>[],
                      'action'=>[], 'method'=>[], 'enctype'=>[], 'data-theme-form'=>[]
                    ],
                    'header'=>['class'=>[]],'section'=>['class'=>[]],'div'=>['class'=>[],'id'=>[],'role'=>[],'aria-live'=>[],'aria-describedby'=>[],'onclick'=>[],'onkeydown'=>[]],
                    'label'=>['for'=>[], 'class'=>[]],
                    'input'=>['type'=>[], 'id'=>[], 'name'=>[], 'placeholder'=>[], 'required'=>[], 'aria-required'=>[], 'aria-describedby'=>[], 'autocomplete'=>[], 'class'=>[], 'value'=>[], 'accept'=>[]],
                    'textarea'=>['id'=>[], 'name'=>[], 'placeholder'=>[], 'required'=>[], 'aria-required'=>[], 'aria-describedby'=>[], 'rows'=>[], 'class'=>[]],
                    'button'=>['type'=>[], 'class'=>[], 'aria-describedby'=>[]],
                    'span'=>['class'=>[]],'svg'=>['class'=>[], 'fill'=>[], 'stroke'=>[], 'viewBox'=>[], 'xmlns'=>[], 'aria-hidden'=>[]],
                    'path'=>['stroke-linecap'=>[], 'stroke-linejoin'=>[], 'stroke-width'=>[], 'd'=>[]],
                    'a'=>['href'=>[], 'class'=>[], 'target'=>[], 'aria-label'=>[]],
                    'h1'=>['class'=>[]],'h2'=>['class'=>[]],'h3'=>['class'=>[]],'h4'=>['class'=>[]],'h5'=>['class'=>[]],'h6'=>['class'=>[]],'p'=>['class'=>[]],
                  ]
                );
                ?>
              </div>
      </div>

  </div>
</section>
