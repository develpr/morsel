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
class Transmission extends Eloquent {

	protected $table = 'transmissions';
    protected $softDelete = true;

	//todo: validate this man!
	public $rules = array(
	);

	/**
	 * @return mixed
	 */
	public function validate()
	{
		return Validator::make($this->toArray(), $this->rules);
	}

	/**
	 * The person that sent the message - i.e. the person or device the message originated from
	 *
	 * @return mixed
	 */
	public function sender()
	{
		return $this->belongsTo('\User');
	}

	/**
	 * The person set to receive the message
	 *
	 * @return mixed
	 */
	public function receiver()
	{
		return $this->belongsTo('\User');
	}

	public function message()
	{
		return $this->belongsTo('Morsel\Message');
	}


}