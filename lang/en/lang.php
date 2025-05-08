<?php return [
    'plugin' => [
        'name' => 'Plugin name',
        'description' => 'Plugin description.',
    ],
    'form' => [
        'update_metadata' => 'Update metadata for media',
        'title' => 'Title',
        'keywords' => 'Keywords',
        'description' => 'Description',
        'author' => 'Author',
        'author_url' => 'Author URL',
        'source' => 'Source',
        'source_url' => 'Source URL',
    ],
    'component' => [
        'name' => 'Metadata',
        'description' => 'Show data from media metadata',
        
        
        'prop_image' => 'Image path (filepath)',
        'prop_image_desc' => 'Must match the "filepath" column in the database',
    
        'prop_showTitle' => 'Show title',
        'prop_showDescription' => 'Show description',
        'prop_showKeywords' => 'Show keywords',
    
        'prop_layout' => 'Layout',
        'layout_meta_in_image' => 'Metadata over image',
        'layout_meta_below_image' => 'Metadata below image',
    
        'prop_textAlign' => 'Text alignment',
        'text_left' => 'Left',
        'text_center' => 'Center',
        'text_right' => 'Right',
    
        'prop_useDefaultStyles' => 'Use default styles',
        
        'label_author' => 'Author',
        'label_source' => 'Source',
        'label_keywords' => 'Keywords',
        'label_image_not_found' => 'Image record not found.',
        
        'file_path' => 'Source file',
        'file_path_description' => 'Paste path from media library',
        'tag_label' => 'HTML tag',
        'tag_label_description' => 'Wrap metadata into this HTML tag',
        'css_classes_label' => 'CSS classes',
        'css_classes_label_description' => 'Append this CSS classes to tag',
        'custom_style_label' => 'Custom styles',
        'custom_style_label_description' => 'When you need to use style',
        'field' => 'Fetch data from',
        'field_description' => 'Choose source of data to show',
    ],
];