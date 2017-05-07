<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if (!function_exists('get_random_string')) {

    /**
     * Generate a random password. 
     * 
     * get_random_password() will return a random password with length 6-8 of lowercase letters only.
     *
     * @access    public
     * @param    $chars_min the minimum length of password (optional, default 6)
     * @param    $chars_max the maximum length of password (optional, default 8)
     * @param    $upper_case boolean use upper case for letters, means stronger password (optional, default false)
     * @param    $include_numbers boolean include numbers, means stronger password (optional, default false)
     * @param    $include_specials include special characters, means stronger password (optional, default false)
     *
     * @return    string containing a random password 
     */
    function get_random_string($chars_min = 6, $chars_max = 8, $upper_case = TRUE, $include_numbers = TRUE, $include_specials = FALSE) {
        $selection = 'abcdefghijklmnopqrstuvwxyz';
        if ($include_numbers) {
            $selection .= "0123456789";
        }
        if ($include_specials) {
            $selection .= "!@\"#$%&[]{}?|";
        }

        $password = "";
        $length = rand($chars_min, $chars_max);
        for ($i = 0; $i < $length; $i++) {
            if ($upper_case) {
                $current_letter = strtoupper($selection[(rand() % strlen($selection))]);
            } else {
                $current_letter = $selection[(rand() % strlen($selection))];
            }
            $password .= $current_letter;
        }
        return $password;
    }

}