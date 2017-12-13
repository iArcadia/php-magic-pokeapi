<?php

/**
 * A class which includes all files of a given directory.
 *
 * @author Kévin Bibollet <bibollet.kevin@gmail.com>
 * @license MIT
 */
class Autoload
{
    /**
     * Autoloads all files of the given directory.
     *
     * @param string The given directory.
     *
     * @return array
     */
    public static function load(string $dir)
    {
        $content = scandir($dir);
        $toLoad = [];
        
        for ($i = 2 ; $i < sizeof($content) ; $i++)
        {
            if (is_dir($dir . $content[$i]))
            {
                $toLoad = array_merge($toLoad, self::load($dir . $content[$i] . '/'));
            }
            else
            {
                array_push($toLoad, $dir . $content[$i]);
            }
        }
        
        return $toLoad;
    }
}