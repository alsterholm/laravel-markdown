<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Escape output
    |--------------------------------------------------------------------------
    |
    | This option controls whether or not JavaScript in anchor tags should be
    | escaped or not, e.g. markdown like "[Link](javascript:alert('xss'))".
    |
    */

    'xss' => true,

    /*
    |--------------------------------------------------------------------------
    | Automatically link URL:s
    |--------------------------------------------------------------------------
    |
    | This option controls the automatic anchor inserting on URL:s in your
    | markdown. If this option is true, all websites in your markdown
    | will automatically be turned into anchor tags in your output.
    |
    */

    'urls' => true,

];