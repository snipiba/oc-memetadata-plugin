<?php
namespace SNiPI\MEMetadata\Models;

use Model;
use BackendAuth;
use Carbon\Carbon;
use Backend\Models\User as BackendUser;


class MediaLibraryItemMetadata extends Model {
	
	protected $table = 'snipi_memetadata';
	protected $primaryKey = 'id';

	protected $fillable = ['title','keywords','filepath','description','user_id'];

	public $belongsTo = [
		'user' => ['Backend\Models\User']
	];


}