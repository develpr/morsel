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
        $raw = '';

		$morseMessage = '';
		foreach($this->morseMessage as $character)
		{

            $individualCharacters = str_split($character);
            $count = 0;
            foreach($individualCharacters as $character)
            {
                $count++;

                if($character == ".")
                    $raw .= "a0b" . $this->getAverageDit();
                else
                    $raw .= "a0b" . $this->getAverageDah();

                if($count < count($individualCharacters))
                    $raw .= "a1b" . $this->getAverageDit();
            }

            $raw .= "a1b" . $this->getAverageDah();
		}

        $this->inputRaw = $raw;

        $this->inputArray = $this->_parseInput($raw);
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