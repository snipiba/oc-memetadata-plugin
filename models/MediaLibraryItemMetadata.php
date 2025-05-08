<?php
namespace SNiPI\MEMetadata\Models;

use Model;
use BackendAuth;
use Config;
use Carbon\Carbon;
use Backend\Models\User as BackendUser;


class MediaLibraryItemMetadata extends Model {
	
	protected $table = 'snipi_memetadata';
	protected $primaryKey = 'id';

	protected $fillable = ['title','keywords','filepath','description','user_id','source','source_url','author','author_url'];

	public $belongsTo = [
		'user' => ['Backend\Models\User']
	];

	public function getImageAttribute($value){
		$mediaFolder = Config::get('cms.storage.media.path');

		return '<img src="' . $mediaFolder . $this->filepath .'" alt="'.$this->title.'" class="w-full img-thumbnail"/>';
	}
}