<?php

/**
 * This is a translation module wich can translate static words
 * User: munis
 * Date: 7/11/17
 * Time: 4:02 PM
 */
class Language
{
    private $languageArray;
    private $userLanguage;

    public function __construct($language)
    {
        $this->userLanguage = $language;
        $this->languageArray = self::userLanguage();
    }

    private function userLanguage()
    {
        $file = $_SERVER['DOCUMENT_ROOT'] . '/language/config/' . $this->userLanguage . '.txt';
        if(!file_exists($file))
        {
            echo "File not exist";
        }
        $fh = fopen($file, 'r');
        $theData = fread($fh, filesize($file));
        $assoc_array = array();
        $my_array = explode("\n", $theData);
        foreach($my_array as $line)
        {
            $tmp = explode("=", $line);
            $assoc_array[$tmp[0]] = "$tmp[1]";
        }
        fclose($fh);
        return $assoc_array;
    }

    public function getPageTitle()
    {
        return $this->languageArray['WEBSITE_NAME'];
    }
}
?>