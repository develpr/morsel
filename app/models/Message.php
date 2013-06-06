<?php

namespace Morsel;
use \Eloquent;
use \Validator;
use \stdClass;
use \SoapClient;

/**
 *  A server store
 *
 * Class Store
 * todo: need to encrypt the sensitive data
 */
class Message extends Eloquent {

    protected $table = 'messages';

    //todo: Additional attributes should probably be gaurded at some point
    protected $guarded = array('');

    public $rules = array(
    );

    /**
     * @return mixed
     */
    public function validate()
    {
        return Validator::make($this->toArray(), $this->rules);
    }

    public function user()
    {
        return $this->belongsTo('\User');
    }

	public function transmission()
	{
		//Would need to update this relationship to support multiple sending users
		return $this->hasOne('Morsel\Transmission');
	}

	//We are going to serialize this array
	public function setArrayAttribute($value)
	{
		$this->attributes['array'] = serialize($value);
	}

	//We are going to unserialize this array
	public function getArrayAttribute($value)
	{
		return unserialize($value);
	}

}