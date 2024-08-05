<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_full_no_rawat'))
{
    function get_full_no_rawat($segments)
    {
        // Gabungkan segmen URI untuk mendapatkan nomor rawat lengkap
        return implode('/', $segments);
    }
}
