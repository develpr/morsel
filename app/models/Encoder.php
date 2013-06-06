<?php

namespace Morsel;


class Encoder extends \Eloquent{

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
	public function encode()
	{
		$this->_translateCharactersToMorse();
		$this->_translateMorseToDitsAndDahs();

		return $this->morseMessage;
	}

	public function setTextMessage($text)
	{
		$this->characterMessage = $text;
	}

	public function _translateMorseToDitsAndDahs()
	{
		$this->inputRaw = 'a0b291a1b300a0b93a1b341a0b223';
		return;
		$morseMessage = '';
		foreach($this->morseMessage as $character)
		{
			$morseMessage[] = $this->forwardMorseMap[$character];
		}

		$this->morseMessage = $morseMessage;
	}

	public function getRaw()
	{
		return $this->inputRaw;
	}

	public function getMorse()
	{
		$simpleMorse = implode('a', $this->morseMessage);

		return $simpleMorse;
	}


	public function getAverageDit()
	{
		//We are faking this, because it is fake!
		return '100';
	}

	public function getAverageDah()
	{
		//Faking this!
		return '300';
	}

	public function getLongestMidCharacterPause()
	{
		return '100';
	}



	public function getInputArray()
	{
		return $this->inputArray;
	}

	public function _translateCharactersToMorse()
	{
		$morseMessage = array();
		foreach(str_split($this->characterMessage) as $character)
		{
			$morseMessage[] = $this->forwardMorseMap[strtoupper($character)];
		}

		$this->morseMessage = $morseMessage;
	}



}