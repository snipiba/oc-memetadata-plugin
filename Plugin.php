<?php 
namespace SNiPI\MEMetadata;

use Config;
use Illuminate\Filesystem\Filesystem;
use Backend\Widgets\MediaManager;
use System\Classes\PluginBase;
use SNiPI\MEMetadata\Classes\MEMetadata as MetadataController;
use SNiPI\MEMetadata\Models\MediaLibraryItemMetadata;

class Plugin extends PluginBase
{

    public function pluginDetails()
    {
        return [
            'name'        => 'Media Editor Metadata',
            'description' => 'Handle file metadata for media manager',
            'author'      => 'SNiPI',
            'icon'        => 'icon-picture-o',
            'iconSvg'     => 'plugins/snipi/uniquemdiafinder/assets/img/search.svg',
            'homepage'    => 'https://github.com/snipiba/oc-memetadata-plugin'
        ];
    }

    public function registerSettings()
    {
        return [
            'config' => [
                'label'       => 'Media metadata',
                'icon'        => 'icon-picture-o',
                'category'    => 'Tools',
                'description' => 'Provide SEO and metadata to your files in media library.',
                'class'       => 'SNiPI\MEMetadata\Models\Settings',
                'order'       => 600
            ]
        ];
    }

    public function registerMarkupTags()
    {
        return [
            'filters' => [
                'metadata' => [$this, 'getMediaInfo'],
            ]
        ];
    }

    public function getMediaInfo($value) {

        $mediaFolder = Config::get('cms.storage.media.folder', 'media');
        $data = MediaLibraryItemMetadata::where('filepath', '/' . $value)->first();
        if($data) {
            return $data;
        }        
    }

    public function boot() {
    	
    	$manager = new MetadataController;
	}

    public function registerPageSnippets() {
        return [
            'SNiPI\MEMetadata\Components\Metadata' => 'metaInfo'
        ];
    }
    
    public function registerComponents() {
        return [
            'SNiPI\MEMetadata\Components\Metadata' => 'metaInfo'
        ];
    }
    
}