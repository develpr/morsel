<?php

namespace Morsel;


class Decoder extends \Eloquent{



	protected $rawInput = '';
	protected $arrayInput = array();
	protected $averageDownTime;
	protected $averageUpTime;
	protected $forwardMorseMap;
	protected $reverseMorseMap;
	protected $morseMessage = '';
	protected $characterMessage;

	public function __construct()
	{
		$this->forwardMorseMap = array(
			'A' => '.-',
			'B' => '-...',
			'C' => '-.-.',
			'D' => '-..',
			'E' => '.',
			'F' => '..-.',
			'G' => '--.',
			'H' => '....',
			'I' => '..',
			'J' => '.---',
			'K' => '-.-',
			'L' => '.-..',
			'M' => '--',
			'N' => '-.',
			'O' => '---',
			'P' => '.--.',
			'Q' => '--.-',
			'R' => '.-.',
			'S' => '...',
			'T' => '-',
			'U' => '..-',
			'V' => '...-',
			'W' => '.--',
			'X' => '-..-',
			'Y' => '-.--',
			'Z' => '--..',
			'0' => '-----',
			'1' => '.----',
			'2' => '..---',
			'3' => '...--',
			'4' => '....-',
			'5' => '.....',
			'6' => '-....',
			'7' => '--...',
			'8' => '---..',
			'9' => '----.',
			'.' => '.-.-.-',
			',' => '--..--',
			'?' => '..--..',
			':' => '---...',
			"'" => '.----.',
			'"' => '.-..-.',
			'-' => '-....-',
			'/' => '-..-.',
			'(' => '-.--.',
			')' => '-.--.-',
			'Ä' => '.-.-',
			'Á' => '.--.-',
			'Å' => '.--.-',
			'Ch' => '----',
			'É' => '..-..',
			'Ñ' => '--.--',
			'Ö' => '---.',
			'Ü' => '..--',
		);

		$this->reverseMorseMap = array_flip($this->forwardMorseMap);


	}

	/**
	 * Do the work
	 * todo: this should probably just be the save or perhaps the validate method
	 */
	public function decode()
	{
		$this->_calculateRate();
		$this->_processRawInput();
		$this->_translateMorseToCharacters();

		return $this->characterMessage;
	}

	public function _translateMorseToCharacters()
	{
		foreach($this->morseMessage as $morseCode)
		{

			$this->characterMessage .= $this->reverseMorseMap[$morseCode];
		}
	}

	/**
	 * Set the raw input that is sent to the morsel API
	 *
	 * Expects a string something like
	 * todo: use laravel mutator
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

		//Convert the raw input to an array
		$this->arrayInput = $this->_parseInput($this->rawInput);
	}

	/**
	 *	Convert raw string to an array
	 *
	 * 	NOTE: 'key' refers to the position of the straight key:
	 * 		false or 0 means that the key is pressed
	 * 		true or 1 means that the key is depressed/not pressed
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


	/**
	 * Take the raw input (in array form) and try to figure out how to convert that to dashes and dots
	 *
	 * @return string
	 */
	protected function _processRawInput()
	{
		$output = array();
		$buffer = '';
		foreach($this->arrayInput as $input)
		{

			if($input['key'] == false)
			{
				if($input['time'] < ($this->averageDownTime * .7))
				{
					$buffer .= '.';
				}
				else
				{
					$buffer .= '-';
				}
			}
			else
			{
				//If it's over 3 times, then it's a space
				if($input['time'] > ($this->averageUpTime * 3.1))
				{
					$output[] = $buffer;
					$buffer = '';
				}
				//else if it's around normal, then it's a new character
				else if($input['time'] > ($this->averageUpTime * 1.1))
				{
					$output[] = $buffer;
					$buffer = '';
				}

			}


		}
		$output[] = $buffer;

		$this->morseMessage = $output;
	}

	/**
	 * Calculate average gaps between beeps and boops and das and dits and pauses
	 */
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