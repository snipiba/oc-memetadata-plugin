<?php
namespace SNiPI\MEMetadata\Classes;

use Input;
use ApplicationException;
use Exception;
use Lang;
use Cms\Classes\Theme;
use Cms\Classes\Asset;
use Backend\Classes\WidgetBase;
use SNiPI\MEMetadata\Models\MediaLibraryItemMetadata as Metadata;
class MEMetadata {
	

    protected $theme;

	public function  __construct() {
		
        $this->theme = Theme::getEditTheme();
		
		if (class_exists('System'))  {
			$manager = \Media\Widgets\MediaManager::class;
			$libraryItem = \System\Classes\MediaLibraryItem::class;
		} else {
			$manager = \Backend\Widgets\MediaManager::class;
			$libraryItem = \System\Classes\MediaLibraryItem::class;
		}

		
		$manager::extend(function($widget) {

			$widget->addViewPath(plugins_path().'/snipi/memetadata/partials/editor/');
            $widget->addViewPath(plugins_path().'/snipi/memetadata/partials/');
            $widget->addJs('/plugins/snipi/memetadata/assets/js/metadata.js');
            $widget->addCss('/plugins/snipi/memetadata/assets/css/metadata.css');

            $widget->addDynamicMethod('onLoadMetadataPopup', function() use ($widget) {


		        $path = Input::get('path');
		        if (!$this->validatePath($path)) {
		            throw new ApplicationException(Lang::get('cms::lang.asset.invalid_path'));
		        }

		        $metadata = Metadata::where('filepath',$path)->first();

		        $widget->vars['title'] = $metadata->title ?? '';
		        $widget->vars['keywords'] = $metadata->keywords ?? '';
		        $widget->vars['description'] = $metadata->description ?? '';
		        $widget->vars['source'] = $metadata->source ?? '';
		        $widget->vars['source_url'] = $metadata->source_url ?? '';
		        $widget->vars['author'] = $metadata->author ?? '';
		        $widget->vars['author_url'] = $metadata->author_url ?? '';

		        $widget->vars['originalPath'] = $path;
		        $widget->vars['name'] = basename($path);
		        $widget->vars['theme'] = $this->theme;
		        $widget->vars['exif'] = @exif_read_data(storage_path('app/media' . $path));

            	return $widget->makePartial(plugins_path().'/snipi/memetadata/partials/editor/update_metadata.htm', ['data' => Input::all(), 'theme' => $this->theme]);
            });

            $widget->addDynamicMethod('onApplyMetadataUpdate', function() use ($widget){
            	$path = Input::get('path');
            	$metadata = Metadata::where('filepath','like', '%'.$path)->first();
            	if($metadata) {
	        		$metadata->title = Input::get('title');
	        		$metadata->keywords = Input::get('keywords');
	        		$metadata->description = Input::get('description');
	        	} else {
	        		$metadata = new Metadata;
	        		$metadata->filepath = $path;
	        		$metadata->title = Input::get('title');
	        		$metadata->keywords = Input::get('keywords');
	        		$metadata->description = Input::get('description');
	        		$metadata->source = Input::get('source');
	        		$metadata->source_url = Input::get('source_url');
	        		$metadata->author = Input::get('author');
	        		$metadata->author_url = Input::get('author_url');
	        	}
	        	$metadata->save();

            });

            $widget->addDynamicMethod('onLoadCropPopup', function() use ($widget){
            	return $widget->makePartial(plugins_path().'/snipi/memetadata/partials/editor/crop_image', ['data' => Input::all()]);
            });



			$widget->bindEvent('file.rename', function ($originalPath, $newPath) {
		        // Update custom references to path here

		        $origFile = Metadata::where('filepath', 'like', '%'.basename($originalPath))->first();
		        if($origFile) {
			        $origFile->filepath = '/'.basename($newPath);
			        $origFile->save();
			    }
		    });

			$widget->bindEvent('file.move', function ($originalPath, $newPath) {
				$filename = basename($originalPath);
		        $origFile = Metadata::where('filepath', 'like', '%'.basename($originalPath))->first();
		        if($origFile) {
			        $origFile->filepath = $newPath.'/'.$filename;
			        $origFile->save();
			    }
		    });

			$widget->bindEvent('file.delete', function ($originalPath) {
		        // Update custom references to path here
		        $origFile = Metadata::where('filepath', 'like', '%'.basename($originalPath))->first();
		        if($origFile) {
			        $origFile->delete();
			    }
		    });


			$widget->bindEvent('folder.rename', function ($originalPath, $newPath) {

		        $items = Metadata::where('filepath','like', '%'.$originalPath.'%')->get();
		        foreach($items as $item) {
		        	$item->filepath = str_replace($originalPath, $newPath, $item->full_path);
		        	$item->save();
		        }
		        
		    });

			$widget->bindEvent('folder.delete', function ($originalPath) {
		        // Update custom references to path here
		        $items = Metadata::where('filepath','like', '%'.$originalPath.'%')->delete();
		        
		    });

		});
	}


    protected function validatePath($path)
    {
        if (!preg_match('/^[0-9a-z\.\s_\-\/]+$/i', $path)) {
            return false;
        }

        if (strpos($path, '..') !== false || strpos($path, './') !== false) {
            return false;
        }

        return true;
    }
}