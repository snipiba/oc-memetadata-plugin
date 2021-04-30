<?php
namespace SNiPI\MEMetadata\Components;

use Cms\Classes\ComponentBase;
use SNiPI\MEMetadata\Models\MediaLIbraryItemMetadata;

class Metadata extends ComponentBase {
	
	public function componentDetails()
    {
        return [
            'name' => 'snipi.memetadata::lang.component.name',
            'description' => 'snipi.memetadata::lang.component.description'
        ];
    }


    public function defineProperties()
	{
	    return [
	        'file_path' => [
	             'title'             => 'snipi.memetadata::lang.component.file_path',
	             'description'       => 'snipi.memetadata::lang.component.file_path_description',
	             'type'              => 'string',
	             'required'			=> true,
	        ],
	        'tag' => [
	             'title'             => 'snipi.memetadata::lang.component.tag_label',
	             'description'       => 'snipi.memetadata::lang.component.tag_label_description',
	             'default'			=> 'span',
	             'type'              => 'string',
	        ],
	        'css_classes' => [
	             'title'             => 'snipi.memetadata::lang.component.css_classes_label',
	             'description'       => 'snipi.memetadata::lang.component.css_classes_label_description',
	             'type'              => 'string',
	        ],
	        'custom_style' => [
	             'title'             => 'snipi.memetadata::lang.component.custom_style_label',
	             'description'       => 'snipi.memetadata::lang.component.custom_style_label_description',
	             'type'              => 'string',
	        ],
	        'field' => [
	             'title'             => 'snipi.memetadata::lang.component.field',
	             'description'       => 'snipi.memetadata::lang.component.field_description',
	             'default'			=> 'title',
	             'type'              => 'dropdown',
            	'placeholder' => 'Select field',
	             'options' => [
	             	'image' => 'Image tag with src',
	             	'path' => 'Relative media path',
	             	'title' => 'Title metadata',
	             	'description' => 'Description metadata',
	             	'keywords' => 'Keyowds metadata',
	             	'author' => 'Author metadata',
	             	'author_url' => 'Author URL',
	             	'source' => 'Source metadata',
	             	'source_url' => 'Source URL'
	             ]
	        ]

	    ];
	}


    public function tag() {
    	return $this->property('tag');
    }

    public function field() {
    	return $this->property('field');
    }

    public function path() {
    	return $this->property('file_path');
    }

    public function cssClasses() {
    	return $this->property('css_classes');
    }

    public function styles() {
    	return $this->property('custom_style') ?? false;
    }

    public function value() {
        $field = $this->property('field');
    	if($this->property('file_path') != '') {
			$metadata = MediaLIbraryItemMetadata::where('filepath', 'like' ,'%' . $this->property('file_path'))->first();
			if($metadata) {
		        return $metadata->$field;
		    }
		}
    }
}