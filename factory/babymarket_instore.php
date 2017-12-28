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

    public function findDiff1()
    {
        $db_connect = mysqli_connect(host, user, pass, db);
        if ($this->data)
        {
            //выбираем все названия товаров в прайсе для фабрики
            $factory_id = $this->factory_id;
            //echo "factory=".$factory_id."<br>";
            $query = "SELECT goods_article_link FROM goods WHERE factory_id=$factory_id";
            if ($res = mysqli_query($db_connect, $query))
            {
                unset($site_names);
                while ($row = mysqli_fetch_assoc($res))
                {
                    //массив со всеми названиями товара в прайсе
                    $site_names[] = $row['goods_article_link'];
                }
                //дальше просто сравниваем наши загруженные названия и те, что уже есть на сайте и получаем разницу
                //выбираем в отдельный массив только полученные названия с прайса
                unset($price_names);
                foreach ($this->data as $d)
                {
                    //те названия, что мы прочитали в прайсе
                    $price_names[] = $d['name'];
                }
                //echo "<b>names</b><pre>";
                //print_r ($site_names);
                //echo "</pre>";
                //сравниваем 2 массива и получаем массив, в котором есть названия товаров, которые есть в прайсе, но нет на сайте
                $result = array_diff($price_names, $site_names);

                //сравниваем 2 массива и получаем массив, в котором есть названия товаров, которые есть на сайте, но нет в прайсе
                $result2 = array_diff($site_names, $price_names);
            }
        }
        if ($result||$result2)
        {
            echo "<p><b>in price but not on site</b></p>";
            echo "<pre>";
            print_r($result);
            echo "</pre>";


            echo "<p><b>on site but not in price</b></p>";
            echo "<pre>";
            print_r($result2);
            echo "</pre>";
            mysqli_close($db_connect);
            return $result;
        }
        else
        {
            mysqli_close($db_connect);
            return null;
        }
    }

}