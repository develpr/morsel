<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
    protected $softDelete = true;

	//todo: Additional attributes should probably be gaurded at some point - these can't be set via mass assignment
	protected $guarded = array('');

	//todo: eventually this will be a good way to use the status mutator without
	//protected $attributes = array('status' => null);

	public $rules = array(
		'first_name'		=> 'between:2,30|alpha',
		'last_name' 		=> 'between:1,30|alpha',
		'email'				=> 'required|email|unique:users,email',
		'username'      	=> 'required|unique:users,username',
	);

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * @return mixed
	 */
	public function validate()
	{
		return Validator::make($this->toArray(), $this->rules);
	}

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function messages()
	{
		return $this->hasMany('Morsel\Message');
	}

    public function receivedTransmissions()
    {
        return $this->hasMany('Morsel\Transmission', 'receiver_id');
    }

    public function sentTransmissions()
    {
        return $this->hasMany('Morsel\Transmission', 'sender_id');
    }

	public function recipients()
	{
		return $this->belongsToMany('User', 'recipient_sender', 'recipient_id', 'sender_id');
	}

	public function senders()
	{
		return $this->belongsToMany('User', 'recipient_sender', 'sender_id', 'recipient_id');
	}


}