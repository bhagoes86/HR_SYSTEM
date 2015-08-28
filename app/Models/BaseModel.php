<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\MessageBag;

abstract class BaseModel extends Eloquent {
	
	protected $errors;

	function __construct() 
	{
		parent::__construct();

		$this->errors = new MessageBag;

		// run traits constructor
		$methods = get_class_methods(get_class($this));
		foreach ($methods as $method)
		{
			if (str_is('*traitconstructor', strtolower($method)))
			{
				call_user_func([$this, $method], $this);
			}
		}
	}


	/* ---------------------------------------------------------------------------- ERRORS ----------------------------------------------------------------------------*/
	/**
	 * return errors
	 *
	 * @return MessageBag
	 * @author 
	 **/
	function getError()
	{
		return $this->errors;
	}

	/* ---------------------------------------------------------------------------- RELATIONSHIP ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- QUERY BUILDER ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- MUTATOR ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- ACCESSOR ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- FUNCTIONS ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- SCOPES ----------------------------------------------------------------------------*/

	public function scopeWithTrashed($query, $variable)
	{
		return $query->withtrashed();
	}

	public function scopeNotID($query, $variable)
	{
		return $query->where('id', '<>',$variable);
	}

	public function scopeWithAttributes($query, $variable)
	{
		if(!is_array($variable))
		{
			$variable 			= [$variable];
		}

		return $query->with($variable);
	}
}