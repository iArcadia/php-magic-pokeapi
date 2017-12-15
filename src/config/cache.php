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
     * Your storage path for cached files.
     *
     * Only for: FileCache
     * Value type: string
     */
    'FileCache::storage_path' => 'cache',
    
    /*
     * The extension used by cached files.
     *
     * Only for: FileCache
     * Value type: string
     * - json
     * - yaml
     */
    'FileCache::ext' => 'json',
];