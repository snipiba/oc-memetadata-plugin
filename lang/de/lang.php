<?php return [
    'plugin' => [
        'name' => 'Plugin-Name',
        'description' => 'Plugin-Beschreibung.',
    ],
    'form' => [
        'update_metadata' => 'Metadaten für Medien aktualisieren',
        'title' => 'Titel',
        'keywords' => 'Schlüsselwörter',
        'description' => 'Beschreibung (Alternativtext)',
        'author' => 'Autor',
        'author_url' => 'Link des Autors',
        'source' => 'Quelle',
        'source_url' => 'Quelle des Autors (Link)',
    ],
    'component' => [
        'name' => 'Metadata',
        'description' => 'Daten aus Medien-Metadaten anzeigen',
        
        
        'prop_image' => 'Pfad zum Bild (Bildpfad)',
        'prop_image_desc' => 'Muss mit der Spalte „Dateipfad“ in der Datenbank übereinstimmen',
    
        'prop_showTitle' => 'Titel anzeigen',
        'prop_showDescription' => 'Beschreibung anzeigen',
        'prop_showKeywords' => ' Schlüsselwörter anzeigen',
    
        'prop_layout' => 'Layout',
        'layout_meta_in_image' => 'Metadaten über dem Bild',
        'layout_meta_below_image' => 'Metadaten unter dem Bild',
    
        'prop_textAlign' => 'Textausrichtung',
        'text_left' => 'links',
        'text_center' => 'zentriert',
        'text_right' => 'rechts',
    
        'prop_useDefaultStyles' => 'Standardstile verwenden',
        
        'label_author' => 'Autor',
        'label_source' => 'Quelle',
        'label_keywords' => 'Schlüsselwörter',
        'label_image_not_found' => 'Bilddatei nicht gefunden.',
        
        'file_path' => 'Source file',
        'file_path_description' => 'Pfad aus der Medienbibliothek einfügen',
        'tag_label' => 'HTML tag',
        'tag_label_description' => 'Metadaten in diesen HTML-Tag einbetten',
        'css_classes_label' => 'CSS-Klassen',
        'css_classes_label_description' => 'Füge diese CSS-Klassen zum Tag hinzu',
        'custom_style_label' => 'Benutzerdefinierte Stile',
        'custom_style_label_description' => 'Wenn du einen Stil verwenden möchtest',
        'field' => 'Daten abrufen von',
        'field_description' => 'Wählen die Quelle der anzuzeigenden Daten',
    ],
];
