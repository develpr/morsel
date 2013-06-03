<?php

namespace Morsel;


class Decoder extends \Eloquent{

	protected $rawInput = '';
	protected $arrayInput = array();
	protected $averageDownTime;
	protected $averageUpTime;

	public function __construct()
	{

	}

	public function decode()
	{

	}

	/**
	 * Set the raw input that is sent to the morsel API
	 *
	 * Expects a string something like
	 *
	 * 0,320
	 * 1,232
	 * 0,132
	 * 1,194
	 * 0,289
	 *
	 * @param string $rawInput
	 */
	public function setRawInput($rawInput)
	{
		$this->rawInput = $rawInput;

		$this->arrayInput = $this->_parseInput($this->rawInput);

		$this->_calculateRate();
	}

	/**
	 *
	 * @param string $rawInput
	 */
	protected function _parseInput($rawInput)
	{
		$final = array();

		//Here is a temp array - we will need to further split these all by
		//todo: probably some magic php method that will do this, or regex perhaps, but it's the weekend
		$tempArray = explode('a', $rawInput);
		//$tempArray = preg_split("/((\r?\n)|(\r\n?))/", $rawInput);

		foreach($tempArray as $part)
		{
			//Here we have a string of the form 0,123 so we need to further break it down
			$tempValue = explode('b', $part);

			//In some cases, in particular the edge case at the end of input, we may have an incomplete pair
			if(array_key_exists(1, $tempValue))
			{
				$final[] = array(
					'key' 	=> (boolean)$tempValue[0],
					'time'	=> $tempValue[1]
				);
			}
		}

		return $final;
	}

	
	public function processRawInput()
	{
		$output = '';
		foreach($this->arrayInput as $input)
		{
			if($input['key'] == false)
			{
				if($input['time'] < ($this->averageDownTime * .7))
				{
					$output .= '.';
				}
				else
				{
					$output .= '_';
				}
			}
			else
			{
				if($input['time'] < ($this->averageUpTime / 2))
				{
					$output .= ' ';
				}
				else
				{
					$output .= ' ';
				}
			}
		}

		return $output;
	}

	private function _calculateRate()
	{
		$totalDownTime = 0;
		$totalDowns = 0;

		$totalUpTime = 0;
		$totalUps = 0;


		foreach($this->arrayInput as $input)
		{
			if($input['key'] == false)
			{
				$totalDowns++;
				$totalDownTime += $input['time'];
			}
			else
			{
				$totalUps++;
				$totalUpTime += $input['time'];
			}
		}

		$this->averageDownTime = $totalDownTime / $totalDowns;
		$this->averageUpTime = $totalUpTime / $totalUps;
	}

}