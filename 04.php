<?php

    $input = file_get_contents('./inputs/04.txt');
    $arr = array_filter(explode("\n", $input));
    $result = 0;
    $result2 = 0;

    function sortLetters($str) {
        $parts = str_split($str);

        sort($parts);

        return implode('', $parts);
    }

    foreach ($arr as $line) {
        $words = explode(" ", $line);
        $isValid = true;
        $isValid2 = true;

        foreach ($words as $key => $value) {
            $value2 = sortLetters($value);

            foreach ($words as $oKey => $oValue) {
                if ($oKey === $key) {
                    continue;
                }

                $oValue2 = sortLetters($oValue);

                if ($value === $oValue) {
                    $isValid = false;
                }

                if ($value2 === $oValue2) {
                    $isValid2 = false;
                }
            }
        }

        if ($isValid) {
            ++$result;
        }

        if ($isValid2) {
            ++$result2;
        }
    }

    echo 'Result: '.$result.'<br>';
    echo 'Result2: '.$result2;
