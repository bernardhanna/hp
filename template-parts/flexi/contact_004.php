<?php
$subheading     = get_sub_field('subheading');
$heading        = get_sub_field('heading');
$heading_tag    = get_sub_field('heading_tag') ?: 'h2';
$description    = get_sub_field('description');
$form_heading      = get_sub_field('form_heading') ?: 'Send us a message';
$form_heading_tag  = get_sub_field('form_heading_tag') ?: 'h2';
$form_markup       = get_sub_field('form_markup');
$privacy_policy_url = get_sub_field('privacy_policy_url') ?: '#';
$phone          = get_sub_field('phone');
$phone_icon     = get_sub_field('phone_icon');
$fax            = get_sub_field('fax');
$fax_icon       = get_sub_field('fax_icon');
$email          = get_sub_field('email');
$email_icon     = get_sub_field('email_icon');
$address        = get_sub_field('address');
$address_icon   = get_sub_field('address_icon');
$hours          = get_sub_field('hours');
$hours_icon     = get_sub_field('hours_icon');
$background_color = get_sub_field('background_color');
$text_color = get_sub_field('text_color');

$padding_classes = ['pt-5', 'pb-5'];
if (have_rows('padding_settings')) {
    while (have_rows('padding_settings')) {
        the_row();
        $screen_size = get_sub_field('screen_size');
        $padding_top = get_sub_field('padding_top');
        $padding_bottom = get_sub_field('padding_bottom');
        $padding_classes[] = "{$screen_size}:pt-[{$padding_top}rem]";
        $padding_classes[] = "{$screen_size}:pb-[{$padding_bottom}rem]";
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

if ( $name = get_sub_field('form_name') ) {
    $hidden .= '<input type="hidden" name="_theme_form_name" value="' . esc_attr( $name ) . '">';
}

/* add save-to-DB flag if ticked */
if ( get_sub_field('save_entries_to_db') ) {
    $hidden .= '<input type="hidden" name="_theme_save_to_db" value="1">';
}

/* drop the inputs just before </form> */
$form_markup = str_replace('</form>', $hidden . '</form>', $form_markup);

/* Replace privacy policy URL placeholder */
$form_markup = str_replace('href="#"', 'href="' . esc_url($privacy_policy_url) . '"', $form_markup);
?>
<section id="contact-004-<?php echo esc_attr( uniqid() ); ?>" class="flex overflow-hidden relative" style="background-color:<?php echo esc_attr($background_color); ?>;">
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-md:gap-6 w-full mx-auto max-xxl:px-5 max-w-[1344px] <?php echo esc_attr( implode( ' ', $padding_classes ) ); ?>">
    <div class="flex flex-col w-full lg:max-w-[662px] gap-6">
      <header class="flex flex-col gap-6">
        <?php if ($subheading): ?>
          <p class="text-lg font-semibold text-slate-600">
            <?php echo esc_html($subheading); ?>
          </p>
        <?php endif; ?>
        <<?php echo esc_attr($heading_tag); ?> class="text-4xl font-bold tracking-tighter text-primary" style="color:<?php echo esc_attr($text_color); ?>">
          <?php echo esc_html($heading); ?>
        </<?php echo esc_attr($heading_tag); ?>>
        <?php if ($description): ?>
          <div class="text-lg text-slate-700 wp_editor">
            <?php echo $description; ?>
          </div>
        <?php endif; ?>
      </header>
      <div class="flex flex-col gap-4 px-12 py-10 bg-gray-50 rounded-2xl max-md:w-full max-sm:p-5">
        <?php if ($phone): ?>
          <div class="flex gap-4 items-center">
            <div class="flex justify-center items-center">
              <?php if ($phone_icon): ?>
                <img src="<?php echo esc_url($phone_icon['url']); ?>" alt="<?php echo esc_attr($phone_icon['alt'] ?: 'Phone'); ?>" class="relative h-[48px] w-[48px]" />
              <?php endif; ?>
            </div>
            <div class="flex flex-col gap-1">
              <a href="tel:<?php echo esc_attr($phone); ?>" class="text-base text-slate-700 hover:underline">
                <?php echo esc_html($phone); ?>
              </a>
              
            </div>
          </div>
        <?php endif; ?>
        <?php if ($fax): ?>
          <div class="flex gap-4 items-center">
            <div class="flex justify-center items-center">
              <?php if ($fax_icon): ?>
                <img src="<?php echo esc_url($fax_icon['url']); ?>" alt="<?php echo esc_attr($fax_icon['alt'] ?: 'Fax'); ?>" class="relative h-[48px] w-[48px]" />
              <?php endif; ?>
            </div>
            <div class="flex flex-col gap-1">
              <a href="fax:<?php echo esc_attr($fax); ?>" class="text-base text-slate-700 hover:underline">
                <?php echo esc_html($fax); ?>
              </a>
             
            </div>
          </div>
        <?php endif; ?>
        <?php if ($email): ?>
          <div class="flex gap-4 items-center">
            <div class="flex justify-center items-center">
              <?php if ($email_icon): ?>
                <img src="<?php echo esc_url($email_icon['url']); ?>" alt="<?php echo esc_attr($email_icon['alt'] ?: 'Email'); ?>" class="relative h-[48px] w-[48px]" />
              <?php endif; ?>
            </div>
            <div class="flex flex-col gap-1">
              <a href="mailto:<?php echo esc_attr($email); ?>" class="text-base text-slate-700 hover:underline">
                <?php echo esc_html($email); ?>
              </a>
          
            </div>
          </div>
        <?php endif; ?>
        <?php if ($address): ?>
          <div class="flex gap-4 items-center">
            <div class="flex justify-center items-center">
              <?php if ($address_icon): ?>
                <img src="<?php echo esc_url($address_icon['url']); ?>" alt="<?php echo esc_attr($address_icon['alt'] ?: 'Address'); ?>" class="relative h-[48px] w-[48px]" />
              <?php endif; ?>
            </div>
            <address class="text-base not-italic text-slate-700">
              <?php echo esc_html($address); ?>
            </address>
          </div>
        <?php endif; ?>
        <?php if ($hours): ?>
          <div class="flex gap-4 items-center">
            <div class="flex justify-center items-center">
              <?php if ($hours_icon): ?>
                <img src="<?php echo esc_url($hours_icon['url']); ?>" alt="<?php echo esc_attr($hours_icon['alt'] ?: 'Hours'); ?>" class="relative h-[48px] w-[48px]" />
              <?php endif; ?>
            </div>
            <div class="text-base text-slate-700 wp_editor">
              <?php echo $hours; ?>
            </div>
          </div>
        <?php endif; ?>
        <?php if (have_rows('social_links')): ?>
        <div class="flex flex-col gap-2">
            <h3 class="text-base font-bold text-slate-600">Follow us</h3>
            <div class="flex gap-4">
            <?php while (have_rows('social_links')): the_row();
                $label = get_sub_field('label');
                $url = get_sub_field('url');
                $icon_image = get_sub_field('icon_image');
                $icon_svg = get_sub_field('icon_svg');
            ?>
                <a href="<?php echo esc_url($url); ?>" aria-label="<?php echo esc_attr($label); ?>" class="transition-opacity hover:opacity-80">
                <?php if ($icon_image): ?>
                    <img src="<?php echo esc_url($icon_image['url']); ?>"
                        alt="<?php echo esc_attr($icon_image['alt'] ?: $label); ?>"
                        class="relative h-[48px] w-[48px]" />
                <?php elseif ($icon_svg): ?>
                    <?php echo $icon_svg; ?>
                <?php endif; ?>
                </a>
            <?php endwhile; ?>
            </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="flex flex-col w-full lg:max-w-[662px] gap-6 p-5 xl:p-14 bg-gray-50 rounded-[16px] max-md:w-full">
        <header>
            <<?php echo esc_attr($form_heading_tag); ?> id="form-heading-<?php echo esc_attr($id); ?>" class="text-3xl font-bold leading-tight text-slate-600 max-md:max-w-full">
                <?php echo esc_html($form_heading); ?>
            </<?php echo esc_attr($form_heading_tag); ?>>
        </header>
       <?php if ($form_markup): ?>
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
                        'label'=>['for'=>[], 'class'=>[], 'id'=>[]],
                        'input'=>['type'=>[], 'id'=>[], 'name'=>[], 'placeholder'=>[], 'required'=>[], 'aria-required'=>[], 'aria-describedby'=>[], 'autocomplete'=>[], 'class'=>[], 'value'=>[], 'accept'=>[], 'rows'=>[]],
                        'textarea'=>['id'=>[], 'name'=>[], 'placeholder'=>[], 'required'=>[], 'aria-required'=>[], 'aria-describedby'=>[], 'rows'=>[], 'class'=>[]],
                        'button'=>['type'=>[], 'class'=>[], 'aria-describedby'=>[]],
                        'span'=>['class'=>[], 'id'=>[]],'svg'=>['class'=>[], 'fill'=>[], 'stroke'=>[], 'viewBox'=>[], 'xmlns'=>[], 'aria-hidden'=>[]],
                        'path'=>['stroke-linecap'=>[], 'stroke-linejoin'=>[], 'stroke-width'=>[], 'd'=>[], 'stroke'=>[]],
                        'a'=>['href'=>[], 'class'=>[], 'target'=>[], 'aria-label'=>[]],
                        'h1'=>['class'=>[], 'id'=>[]],'h2'=>['class'=>[], 'id'=>[]],'h3'=>['class'=>[], 'id'=>[]],'h4'=>['class'=>[], 'id'=>[]],'h5'=>['class'=>[], 'id'=>[]],'h6'=>['class'=>[], 'id'=>[]],'p'=>['class'=>[]],
                    ]
                );
                ?>
            <?php endif; ?>
    </div>
  </div>
</section>
