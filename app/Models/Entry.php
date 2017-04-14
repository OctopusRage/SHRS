<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Entry extends Model {

	use CrudTrait;

    /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

	protected $table = 'entries';
	// protected $primaryKey = 'id';
	// protected $guarded = [];
	// protected $hidden = ['id'];
	protected $fillable = ['registration_id', 'room_id', 'entry_date', 'leave_date', 'status'];
	public $timestamps = true;

	/*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

	/*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

	// public function articles()
  //   {
  //       return $this->hasMany('App\Models\Article', 'article_tag');
  //   }

	/*
	|--------------------------------------------------------------------------
	| SCOPES
	|--------------------------------------------------------------------------
	*/

	/*
	|--------------------------------------------------------------------------
	| ACCESORS
	|--------------------------------------------------------------------------
	*/
	public function getStatusAttribute($value) {
		switch ($value) {
			case 1:
				return 'new';
				break;
			default:
				return 'moved';
		}
	}
	/*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
	public function setDatetimeAttribute($value) {
		$this->attributes['datetime'] = \Date::parse($value);
	}
}