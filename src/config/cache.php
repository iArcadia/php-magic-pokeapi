<?php

return
[
    /*
     * Do you want to use the caching system?
     * (Please, says yes.)
     *
     * Value type: boolean
     * - true
     * - false
     */
    'use' => true,
    
    /*
     * The caching system (or class) your want to use.
     *
     * Value type: string
     * - 'FileCache' for storing parsed data in files.
     */
    'class' => 'FileCache',
    
    /*
     * The amount of time before a file update.
     *
     * Value type: int (in seconds)
     */
    'expiration_time' => 60 * 60 * 24 * 30,
    
    /*
     * Configuration of file system.
     */
    'file' =>
    [
        /*
         * Your storage path for cached files.
         *
         * Value type: string
         */
        'storage_path' => 'cache',

        /*
         * The format used by cached files.
         *
         * Value type: string
         * - json
         * - yaml
         */
        'format' => 'json',
        
        /*
         * The extension used by cached files.
         *
         * Value type: string
         */
        'extension' => 'json',
    ],
];