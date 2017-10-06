<?php
/*
 * ShortURL (https://github.com/delight-im/ShortURL)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the MIT License (https://opensource.org/licenses/MIT)
 */
/**
 * ShortURL: Bijective conversion between natural numbers (IDs) and short strings
 *
 * ShortURL::encode() takes an ID and turns it into a short string
 * ShortURL::decode() takes a short string and turns it into an ID
 *
 * Features:
 * + large alphabet (51 chars) and thus very short resulting strings
 * + proof against offensive words (removed 'a', 'e', 'i', 'o' and 'u')
 * + unambiguous (removed 'I', 'l', '1', 'O' and '0')
 *
 * Example output:
 * 123456789 <=> pgK8p
 */
class Shorturl {

    public function __construct()
    {

    }

    function _encode_string_array ($stringArray) {
    	$s = strtr(base64_encode(addslashes(gzcompress(serialize($stringArray),9))), '+/=', '-_,');
    	return $s;
	}

	function _decode_string_array ($stringArray) {
    	$s = unserialize(gzuncompress(stripslashes(base64_decode(strtr($stringArray, '-_,', '+/=')))));
    	return $s;
	}


}