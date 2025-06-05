<?php
namespace SNiPI\MEMetadata\Classes;

use Input;
use ApplicationException;
use Exception;
use Str;
use Lang;
use Request;
use Cms\Classes\Theme;
use Cms\Classes\Asset;
use Backend\Classes\WidgetBase;
use SNiPI\MEMetadata\Models\MediaLibraryItemMetadata;

class MEMetadata {
	
    protected $theme;

	public function  __construct() {
		
		if(!Str::endsWith(Request::path(),'/media')) {
			return;
		}
		
        $this->theme = Theme::getEditTheme();
		
		if (class_exists('System'))  {
			$manager = \Media\Widgets\MediaManager::class;
			$libraryItem = \System\Classes\MediaLibraryItem::class;
		} else {
			$manager = \Backend\Widgets\MediaManager::class;
			$libraryItem = \System\Classes\MediaLibraryItem::class;
		}

		
		$manager::extend(function($widget) {
            $widget->addViewPath(plugins_path().'/snipi/memetadata/partials/');
            $widget->addCss('/plugins/snipi/memetadata/assets/css/metadata.css');
            $widget->addJs('/plugins/snipi/memetadata/assets/js/extend-media.js');
            $widget->addDynamicMethod('onLoadMetadataPopup', function() use ($widget) {


		        $path = $this->safeInput('path');
		        if (!$this->validatePath($path)) {
		            throw new ApplicationException(Lang::get('cms::lang.asset.invalid_path'));
		        }
		        
		        $metadata = MediaLibraryItemMetadata::withoutGlobalScopes()->where('filepath', '=', $path)->first();
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

		        $exif = @exif_read_data(storage_path('app/media' . $path));
				$exif = is_array($exif) ? array_map(fn($v) => is_string($v) ? mb_convert_encoding($v, 'UTF-8', 'UTF-8') : $v, $exif) : [];
				$widget->vars['exif'] = $exif;

                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                $isSvg = in_array($ext, ['svg', 'svgz']);
                $isBitmap = is_array(@getimagesize(storage_path('app/media' . $path)));
                
                $widget->vars['is_image'] = $isSvg || $isBitmap;
                $widget->vars['is_svg'] = $isSvg;
                
				if (class_exists('System'))  {
					return $widget->makePartial(plugins_path().'/snipi/memetadata/partials/editor/update_metadata.htm', ['data' => Input::all(), 'theme' => $this->theme]);
				} else {
					return $widget->makePartial(plugins_path().'/snipi/memetadata/partials/editor/update_metadata', ['data' => Input::all(), 'theme' => $this->theme]);
				}
				

            	
            });

            $widget->addDynamicMethod('onApplyMetadataUpdate', function() use ($widget){
            	$path = $this->safeInput('path');
            	$metadata = MediaLibraryItemMetadata::withoutGlobalScopes()->where('filepath',$path)->first();
            	if($metadata) {
	        		$metadata->title = $this->safeInput('title');
	        		$metadata->keywords = $this->safeInput('keywords');
	        		$metadata->description = $this->safeInput('description');
	        		$metadata->source = $this->safeInput('source');
	        		$metadata->source_url = $this->safeInput('source_url');
	        		$metadata->author = $this->safeInput('author');
	        		$metadata->author_url = $this->safeInput('author_url');
	        	} else {
	        		$metadata = new MediaLibraryItemMetadata;
	        		$metadata->filepath = $path;
	        		$metadata->title = $this->safeInput('title');
	        		$metadata->keywords = $this->safeInput('keywords');
	        		$metadata->description = $this->safeInput('description');
	        		$metadata->source = $this->safeInput('source');
	        		$metadata->source_url = $this->safeInput('source_url');
	        		$metadata->author = $this->safeInput('author');
	        		$metadata->author_url = $this->safeInput('author_url');
	        	}
	        	$metadata->save();

                return [
                    'X_OCTOBER_FLASH_MESSAGES' => [
                        'success' => 'Metadata saved successfully.'
                    ],
                ];

            });

            $widget->addDynamicMethod('onLoadCropPopup', function() use ($widget){

				if (class_exists('System'))  {
            		return $widget->makePartial(plugins_path().'/snipi/memetadata/partials/editor/crop_image.htm', ['data' => Input::all()]);
				} else {
            		return $widget->makePartial(plugins_path().'/snipi/memetadata/partials/editor/crop_image', ['data' => Input::all()]);
				}
            });

            $widget->addDynamicMethod('onGetMediaMetadata', function() use ($widget){
            
                $path = post('path');
                $meta = \SNiPI\MEMetadata\Models\MediaLibraryItemMetadata::where('filepath', $path)->first();
            
                return [
                    'meta' => $meta ? $meta->only(['title','description','author', 'author_url', 'source', 'source_url','keywords']) : null
                ];
            });


			$widget->bindEvent('file.rename', function ($originalPath, $newPath) {
		        // Update custom references to path here

		        $origFile = MediaLibraryItemMetadata::where('filepath', 'like', '%'.basename($originalPath))->first();
		        if($origFile) {
			        $origFile->filepath = '/'.basename($newPath);
			        $origFile->save();
			    }
		    });

			$widget->bindEvent('file.move', function ($originalPath, $newPath) {
				$filename = basename($originalPath);
		        $origFile = MediaLibraryItemMetadata::where('filepath', 'like', '%'.basename($originalPath))->first();
		        if($origFile) {
			        $origFile->filepath = $newPath.'/'.$filename;
			        $origFile->save();
			    }
		    });

			$widget->bindEvent('file.delete', function ($originalPath) {
		        // Update custom references to path here
		        $origFile = MediaLibraryItemMetadata::where('filepath', 'like', '%'.basename($originalPath))->first();
		        if($origFile) {
			        $origFile->delete();
			    }
		    });


			$widget->bindEvent('folder.rename', function ($originalPath, $newPath) {

		        $items = MediaLibraryItemMetadata::where('filepath','like', '%'.$originalPath.'%')->get();
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

    protected function safeInput($key) {
	    $val = Input::get($key);
	    return is_string($val) ? mb_convert_encoding($val, 'UTF-8', 'UTF-8') : $val;
	}
}