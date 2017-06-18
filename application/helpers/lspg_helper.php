<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function doone2($onestr,$answer) {
        $tsingle = array("","satu ","dua ","tiga ","empat ","lima ",
        "enam ","tujuh ","delapan ","sembilan ");
           return strtoupper($tsingle[$onestr] );
    }

    function doone($onestr,$answer) {
        $tsingle = array("","se","dua ","tiga ","empat ","lima ", "enam ","tujuh ","delapan ","sembilan ");
           return strtoupper($tsingle[$onestr] );
    }

    function dotwo($twostr,$answer) {
        $tdouble = array("","puluh ","dua puluh ","tiga puluh ","empat puluh ","lima puluh ", "enam puluh ","tujuh puluh ","delapan puluh ","sembilan puluh ");
        $teen = array("sepuluh ","sebelas ","dua belas ","tiga belas ","empat belas ","lima belas ", "enam belas ","tujuh belas ","delapan belas ","sembilan belas ");
        if ( substr($twostr,1,1) == '0') {
            $ret = doone2(substr($twostr,0,1),$answer);
        } else if (substr($twostr,1,1) == '1') {
            $ret = $teen[substr($twostr,0,1)];
        } else {
            $ret = $tdouble[substr($twostr,1,1)] . doone2(substr($twostr,0,1),$answer);
        }
        return strtoupper($ret);
    }

    function convertAngka($num) {
        $tdiv = array("","","ratus ","ribu ", "ratus ", "juta ", "ratus ","miliar ");
        $divs = array( 0,0,0,0,0,0,0);
        $pos = 0; // index into tdiv;
        // make num a string, and reverse it, because we run through it backwards
        // bikin num ke string dan dibalik, karena kita baca dari arah balik
        $num=strval(strrev(number_format($num,2,'.','')));
        $answer = ""; // mulai dari sini
        while (strlen($num)) {
            if ( strlen($num) == 1 || ($pos >2 && $pos % 2 == 1))  {
                $answer = doone(substr($num,0,1),$answer) . $answer;
                $num= substr($num,1);
            } else {
                $answer = dotwo(substr($num,0,2),$answer) . $answer;
                $num= substr($num,2);
                if ($pos < 2)
                    $pos++;
            }
            if (substr($num,0,1) == '.') {
                if (! strlen($answer))
                    $answer = "";
                $answer = "" . $answer . "";
                $num= substr($num,1);
                // kasih tanda "nol" jika tidak ada
                if (strlen($num) == 1 && $num == '0') {
                    $answer = "" . $answer;
                    $num= substr($num,1);
                }
            }
            // add separator
            if ($pos >= 2 && strlen($num)) {
                if (substr($num,0,1) != 0  || (strlen($num) >1 && substr($num,1,1) != 0
                    && $pos %2 == 1)  ) {
                    // check for missed millions and thousands when doing hundreds
                    // cek kalau ada yg lepas pada juta, ribu dan ratus
                    if ( $pos == 4 || $pos == 6 ) {
                        if ($divs[$pos -1] == 0)
                            $answer = $tdiv[$pos -1 ] . $answer;
                    }
                    // standard
                    $divs[$pos] = 1;
                    $answer = $tdiv[$pos++] . $answer;
                } else {
                    $pos++;
                }
            }
        }
        return strtoupper($answer);
    }