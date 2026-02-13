<?php
use StoutLogic\AcfBuilder\FieldsBuilder;

$content_031 = new FieldsBuilder('content_031', [
    'label' => 'Project Grid Manual',
]);

$content_031
  ->addTab('Content', ['placement' => 'top'])
    ->addRepeater('projects', [
        'label'        => 'Project Items',
        'button_label' => 'Add Item',
        'layout'       => 'row',
    ])
      ->addTrueFalse('use_manual', [
          'label'       => 'Use Manual Content',
          'ui'          => 1,
          'ui_on_text'  => 'Manual',
          'ui_off_text' => 'From Project Post',
      ])

      // Post mode
      ->addPostObject('project_post', [
          'label'         => 'Select Project',
          'post_type'     => ['projects'],
          'return_format' => 'id',
          'conditional_logic' => [
              [
                  ['field' => 'use_manual', 'operator' => '==', 'value' => 0],
              ],
          ],
      ])

      // Manual mode: video toggle + YouTube URL
      ->addTrueFalse('use_video', [
          'label'       => 'Use YouTube Video Instead of Image',
          'ui'          => 1,
          'ui_on_text'  => 'YouTube',
          'ui_off_text' => 'Image',
          'conditional_logic' => [
              [
                  ['field' => 'use_manual', 'operator' => '==', 'value' => 1],
              ],
          ],
      ])
      ->addUrl('manual_video_url', [
          'label'             => 'YouTube URL',
          'instructions'      => 'Paste a full YouTube URL (e.g. https://www.youtube.com/watch?v=VIDEO_ID or https://youtu.be/VIDEO_ID).',
          'placeholder'       => 'https://www.youtube.com/watch?v=XXXXXXXXXXX',
          'conditional_logic' => [
              [
                  ['field' => 'use_manual', 'operator' => '==', 'value' => 1],
                  ['field' => 'use_video',  'operator' => '==', 'value' => 1],
              ],
          ],
      ])

      // 🔁 RESTORED: Manual video poster (shows before playback)
      ->addImage('manual_video_poster', [
          'label'             => 'Manual Video Poster',
          'instructions'      => 'Shown before playback. Recommended 16:9 image.',
          'return_format'     => 'id',
          'preview_size'      => 'medium',
          'conditional_logic' => [
              [
                  ['field' => 'use_manual', 'operator' => '==', 'value' => 1],
                  ['field' => 'use_video',  'operator' => '==', 'value' => 1],
              ],
          ],
      ])

      // Manual mode: image (when NOT a video)
      ->addImage('manual_image', [
          'label'             => 'Manual Image',
          'return_format'     => 'id',
          'preview_size'      => 'medium',
          'conditional_logic' => [
              [
                  ['field' => 'use_manual', 'operator' => '==', 'value' => 1],
                  ['field' => 'use_video',  'operator' => '!=', 'value' => 1],
              ],
          ],
      ])

      // Manual mode: text/meta
      ->addText('manual_title', [
          'label'             => 'Manual Title',
          'conditional_logic' => [
              [
                  ['field' => 'use_manual', 'operator' => '==', 'value' => 1],
              ],
          ],
      ])
      ->addText('manual_date', [
          'label'             => 'Manual Date/Meta',
          'placeholder'       => 'Jan 01, 2025',
          'conditional_logic' => [
              [
                  ['field' => 'use_manual', 'operator' => '==', 'value' => 1],
              ],
          ],
      ])

      // Link (ACF link array)
      ->addLink('item_link', [
          'label'         => 'Optional Link (ACF Link Array)',
          'instructions'  => 'If set, the card becomes clickable. If empty and a Project is chosen, the post permalink is used. For videos, the YouTube URL is used unless this link overrides it.',
          'return_format' => 'array',
      ])

      // Width
      ->addSelect('grid_width', [
          'label'         => 'Grid Width',
          'instructions'  => 'Select a Tailwind width utility class.',
          'choices'       => [
              // 1/1
              'w-full'   => 'Full (1/1 — 100%)',

              // 1/2
              'w-1/2'    => '1/2 (50%)',

              // Thirds
              'w-1/3'    => '1/3 (33.333%)',
              'w-2/3'    => '2/3 (66.666%)',

              // Quarters
              'w-1/4'    => '1/4 (25%)',
              'w-2/4'    => '2/4 (50%)',
              'w-3/4'    => '3/4 (75%)',
              'w-4/4'    => '4/4 (100%)',

              // Fifths
              'w-1/5'    => '1/5 (20%)',
              'w-2/5'    => '2/5 (40%)',
              'w-3/5'    => '3/5 (60%)',
              'w-4/5'    => '4/5 (80%)',
              'w-5/5'    => '5/5 (100%)',

              // Sixths
              'w-1/6'    => '1/6 (16.666%)',
              'w-2/6'    => '2/6 (33.333%)',
              'w-3/6'    => '3/6 (50%)',
              'w-4/6'    => '4/6 (66.666%)',
              'w-5/6'    => '5/6 (83.333%)',

              // Twelfths
              'w-1/12'   => '1/12 (8.333%)',
              'w-2/12'   => '2/12 (16.666%)',
              'w-3/12'   => '3/12 (25%)',
              'w-4/12'   => '4/12 (33.333%)',
              'w-5/12'   => '5/12 (41.666%)',
              'w-6/12'   => '6/12 (50%)',
              'w-7/12'   => '7/12 (58.333%)',
              'w-8/12'   => '8/12 (66.666%)',
              'w-9/12'   => '9/12 (75%)',
              'w-10/12'  => '10/12 (83.333%)',
              'w-11/12'  => '11/12 (91.666%)',
              'w-12/12'  => '12/12 (100%)',
          ],
          'default_value' => 'w-1/2',
          'wrapper'       => ['width' => 50],
      ])
    ->endRepeater()

  ->addTab('Layout')
    ->addRepeater('padding_settings', [
        'label'         => 'Padding Settings',
        'instructions'  => 'Customize padding for different screen sizes.',
        'button_label'  => 'Add Screen Size Padding',
    ])
      ->addSelect('screen_size', [
          'label'   => 'Screen Size',
          'choices' => [
              'xxs'       => 'xxs',
              'xs'        => 'xs',
              'mob'       => 'mob',
              'sm'        => 'sm',
              'md'        => 'md',
              'lg'        => 'lg',
              'xl'        => 'xl',
              'xxl'       => 'xxl',
              'ultrawide' => 'ultrawide',
          ],
      ])
      ->addNumber('padding_top', [
          'label'        => 'Padding Top',
          'instructions' => 'Set the top padding in rem.',
          'min'          => 0,
          'max'          => 20,
          'step'         => 0.1,
          'append'       => 'rem',
      ])
      ->addNumber('padding_bottom', [
          'label'        => 'Padding Bottom',
          'instructions' => 'Set the bottom padding in rem.',
          'min'          => 0,
          'max'          => 20,
          'step'         => 0.1,
          'append'       => 'rem',
      ])
    ->endRepeater();

return $content_031;
