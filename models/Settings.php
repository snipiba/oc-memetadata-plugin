<?php 
namespace SNiPI\MEMetadata\Models;

use October\Rain\Database\Model;
use System\Models\MailTemplate;

/**
 * WpContentImporter settings
 */
class Settings extends Model
{

    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'snipi_memetadata';

    public $settingsFields = 'fields.yaml';
    
}