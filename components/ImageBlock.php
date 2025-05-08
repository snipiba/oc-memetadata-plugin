<?php 
namespace SNiPI\MEmetadata\Components;

use Cms\Classes\ComponentBase;
use SNiPI\MEMetadata\Models\MediaLibraryItemMetadata;

class ImageBlock extends ComponentBase
{
    public $meta;
    
    public function componentDetails()
    {
        return [
            'name'        => 'snipi.memetadata::lang.component.name',
            'description' => 'snipi.memetadata::lang.component.description'
        ];
    }
    
    public function defineProperties()
    {
        return [
            'image' => [
                'title'       => 'snipi.memetadata::lang.component.prop_image',
                'description' => 'snipi.memetadata::lang.component.prop_image_desc',
                'type'        => 'string',
            ],
            'showTitle' => [
                'title'   => 'snipi.memetadata::lang.component.prop_showTitle',
                'type'    => 'checkbox',
                'default' => true,
            ],
            'showDescription' => [
                'title'   => 'snipi.memetadata::lang.component.prop_showDescription',
                'type'    => 'checkbox',
                'default' => true,
            ],
            'showKeywords' => [
                'title'   => 'snipi.memetadata::lang.component.prop_showKeywords',
                'type'    => 'checkbox',
                'default' => true,
            ],
            'layout' => [
                'title'   => 'snipi.memetadata::lang.component.prop_layout',
                'type'    => 'dropdown',
                'default' => 'meta-below-image',
                'options' => [
                    'meta-in-image'    => 'snipi.memetadata::lang.component.layout_meta_in_image',
                    'meta-below-image' => 'snipi.memetadata::lang.component.layout_meta_below_image',
                ],
            ],
            'textAlign' => [
                'title'   => 'snipi.memetadata::lang.component.prop_textAlign',
                'type'    => 'dropdown',
                'default' => 'left',
                'options' => [
                    'left'   => 'snipi.memetadata::lang.component.text_left',
                    'center' => 'snipi.memetadata::lang.component.text_center',
                    'right'  => 'snipi.memetadata::lang.component.text_right',
                ]
            ],
            'useDefaultStyles' => [
                'title'   => 'snipi.memetadata::lang.component.prop_useDefaultStyles',
                'type'    => 'checkbox',
                'default' => true,
            ],
        ];
    }



    public function onRender()
    {
        $filepath = ltrim($this->property('image'), '/');
        $this->meta = $file = MediaLibraryItemMetadata::where('filepath', 'like' ,'%' . $this->property('file_path'))->first();
        $this->page['meta'] = $this->meta;
        
        if ($this->property('useDefaultStyles')) {
            $this->addCss('assets/css/imageBlock.css');
        }
        
    }
}
