<?php

namespace Morsel;


class Decoder extends \Eloquent{

	//The original input string
	protected $inputRaw = '';

	//The input string parsed into an array with TIME and KEY
	protected $inputArray = array();

	//The MORSE - and . representation of the input
	protected $input = array();

	//The average .
	protected $averageDitTime = 0;

	//The average -
	protected $averageDahTime = 0;

	//The breakpoint - the longest . or dit
	protected $longestDit = 0;

	//The longest character pause
	protected $longestMidCharacterPause = 0;

	//The longest letter pause
	protected $longestLetterPause = 10000;

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
		$this->_processRawInput();
		$this->_translateMorseToCharacters();

		return $this->characterMessage;
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
		$this->inputRaw = $rawInput;

		//Convert the raw input to an array
		$this->inputArray = $this->_parseInput($this->inputRaw);
		$this->_calculateDitsAndDasAndShhh();
	}


	public function _translateMorseToCharacters()
	{
		foreach($this->morseMessage as $morseCode)
		{
			if(key_exists($morseCode, $this->reverseMorseMap))
				$this->characterMessage .= $this->reverseMorseMap[$morseCode];
			else
				$this->characterMessage .= '*';
		}
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
		foreach($this->inputArray as $input)
		{

			if($input['key'] == false)
			{
				if($input['time'] <= $this->longestDit)
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
				if($input['time'] > $this->longestMidCharacterPause)
				{
					$output[] = $buffer;
					$buffer = '';
				}
				//else if it's around normal, then it's a new character
				else if($input['time'] > ($this->longestLetterPause))
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
	private function _calculateDitsAndDasAndShhh()
	{
		$totalDit = 0;
		$totalDah = 0;
		$downs = array();
		$ups = array();

		$result = array();
		$previousUnknown = '';

		//Seperate out the ups and downs
		foreach($this->inputArray as $input)
		{
			if($input['key'] == false)
			{
				$downs[] = $input['time'];
			}
			else
			{
				$ups[] = $input['time'];
			}
		}

		sort($downs);
		sort($ups);

		//Initial case
		$previous = $downs[0];

		foreach($downs as $down)
		{
			$this->averageDitTime += $down;
			$totalDit++;
			if($down > $previous*1.9)
			{
				$this->longestDit = $previous;
				break;
			}
			$previous = $down;
		}

		$this->averageDitTime = $this->averageDitTime / $totalDit;

		foreach($downs as $down)
		{
			if($down < $this->longestDit)
				continue;

			$totalDah++;
			$this->averageDahTime += $down;
		}

		$this->averageDahTime = $this->averageDahTime / $totalDah;


		//calculate the ups
		//todo: we need to calculate the average for all previous, else we'll end up with a linear line without
		//todo: 	deviations from the normal
		$previous = $ups[0];
		$upsCount = 1;
		$upsTotal = $previous;
		foreach($ups as $up)
		{
			$upsAverage = $upsTotal / $upsCount;

			if($up > ($upsAverage*1.8))
			{
				$this->longestMidCharacterPause = $previous;
				break;
			}
			$previous = $up;
			$upsTotal += $up;
			$upsCount++;

		}

		if($this->longestMidCharacterPause == 0)
			$this->longestMidCharacterPause = $previous;

		$previous = $ups[0];
		foreach($ups as $up)
		{
			if($up <= $this->longestMidCharacterPause)
			{
				$previous = $up;
				continue;
			}

			if($up > $previous*2.9)
			{
				$this->longestLetterPause = $up;
				break;
			}
		}

		$hi = "HI";

	}

}