<?php return [
    'plugin' => [
        'name' => 'Názov pluginu',
        'description' => 'Popis pluginu.',
    ],
    'form' => [
        'update_metadata' => 'Aktualizovať metadáta pre médiá',
        'title' => 'Titulok',
        'keywords' => 'Kľúčové slová',
        'description' => 'Popis',
        'author' => 'Autor',
        'author_url' => 'URL autora',
        'source' => 'Zdroj',
        'source_url' => 'URL zdroja',
    ],
    'component' => [
        'name' => 'Metadáta',
        'description' => 'Zobraziť údaje z metadát médií',
        
        'label_metadata_group' => 'Metadáta k obrázku',

        'prop_image' => 'Cesta k obrázku (filepath)',
        'prop_image_desc' => 'Musí zodpovedať stĺpcu "filepath" v databáze',
    
        'prop_showTitle' => 'Zobraziť titulok',
        'prop_showDescription' => 'Zobraziť popis',
        'prop_showKeywords' => 'Zobraziť kľúčové slová',
    
        'prop_layout' => 'Rozloženie',
        'layout_meta_in_image' => 'Metadáta cez obrázok',
        'layout_meta_below_image' => 'Metadáta pod obrázkom',
    
        'prop_textAlign' => 'Zarovnanie textu',
        'text_left' => 'Vľavo',
        'text_center' => 'Na stred',
        'text_right' => 'Vpravo',
    
        'prop_useDefaultStyles' => 'Použiť predvolené štýly',
        
        'label_author' => 'Autor',
        'label_source' => 'Zdroj',
        'label_keywords' => 'Kľúčové slová',
        'label_image_not_found' => 'Záznam pre obrázok sa nenašiel.',
        
        'file_path' => 'Zdrojový súbor',
        'file_path_description' => 'Vlož cestu z knižnice médií',
        'tag_label' => 'HTML tag',
        'tag_label_description' => 'Obaľ metadáta do tohto HTML tagu',
        'css_classes_label' => 'CSS triedy',
        'css_classes_label_description' => 'Pridaj tieto CSS triedy k tagu',
        'custom_style_label' => 'Vlastné štýly',
        'custom_style_label_description' => 'Ak potrebuješ použiť vlastný štýl',
        'field' => 'Získať údaje z',
        'field_description' => 'Vyber zdroj údajov na zobrazenie',
    ],
];
