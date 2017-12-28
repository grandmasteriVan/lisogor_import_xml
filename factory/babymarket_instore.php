<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 28.12.2017
 * Time: 12:10
 */
class BabymarketInStore
{
    public function setNoactual()
    {
        $db = DB::getInstance();
        $db->debug = true;
        $db_connect=mysqli_connect(host,user,pass,db);
        $strSQL="UPDATE goods SET goods_noactual=1 ".
            "WHERE factory_id=161 or factory_id=163 or factory_id=164 or factory_id=165 or factory_id=166 or factory_id=167".
        " or factory_id=168 or factory_id=169 or factory_id=170 or factory_id=171";
        if ($db->query($strSQL))
        {
            echo "OK!<br>";
        }
        else
        {
            echo "not OK ".mysqli_error()."<br>";
        }
        $db->debug = false;
    }

    public function parse_price($params)
    {
        //echo "Enter price!";
        if ($this->file1)
        {
            $dom = DOMDocument::load($this->file1);
            $rows = $dom->getElementsByTagName('Row');
            //print_r($rows);
            $row_num = 1;
            //полезная инфа начинается с 8 строки!
            //артикул позиции находится в 3 ячейке

            foreach ($rows as $row)
            {
                if ($row_num>=10)
                {
                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    unset($name);
                    foreach ($cells as $cell)
                    {
                        //echo "$cell->nodeValue is $cell_num<br>";
                        $elem=$cell->nodeValue;
                        if ($cell_num==1)
                        {
                            $name=$elem;
                        }
                        $cell_num++;
                    }
                    if ($name)
                    {
                        $this->add_price($name);
                    }
                }
                $row_num++;
            }
        }
        else
        {
            echo "No file, no life!";
        }
        var_dump($this->data);
    }


}