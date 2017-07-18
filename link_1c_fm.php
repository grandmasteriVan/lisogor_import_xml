<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 18.07.17
 * Time: 16:42
 */

class Link
{
    private $data;
    private function ReadFile1()
    {
        $handle=fopen("list.txt","r");
        while (!feof($handle))
        {
            $arr[]=fgets($handle);
        }
        if (!empty($arr))
        {
            $this->data = $arr;
        }
    }
    public function printData()
    {
        var_dump($this->data);
    }
}