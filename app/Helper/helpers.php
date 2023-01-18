<?php
  
use Carbon\Carbon;
  
/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('convertDmyToYmd')) {
    function convertDmyToYmd($date)
    {
        return Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
    }
}
  
/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('convertYdmToMdy')) {
    function convertYdmToMdy($date)
    {
        return Carbon::createFromFormat('Y-d-m', $date)->format('m-d-Y');
    }
}

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('publicPath')) {
    function publicPath()
    {
        

        return  asset('backend');
    }
}