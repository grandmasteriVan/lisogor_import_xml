<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 13.04.17
 * Time: 10:34
 */

require 'autoload.php';

class VeresActive extends Universal
{
    public function setActual($arr)
    {
        //$db = DB::getInstance();
        //$db->debug = true;
        $db_connect=mysqli_connect(host,user,pass,db);
        if (is_array($arr))
        {
            foreach ($arr as $good)
            {
                $name=$good;
                $f_id=$this->factory_id;
                $query="UPDATE goods SET goods_noactual=1 WHERE goods_article_link='$name' AND factory_id=$f_id";
                echo "$query<br>";
                mysqli_query($db_connect,$query);
            }
        }
        mysqli_close($db_connect);
        //$db->debug = false;

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
                        if ($cell_num==3)
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
        //var_dump($this->data);
    }
    public function findDiff1()
    {
        $db_connect = mysqli_connect(host, user, pass, db);
        if ($this->data) {
            //выбираем все названия товаров в прайсе для фабрики
            $factory_id = $this->factory_id;
            //echo "factory=".$factory_id."<br>";
            $query = "SELECT goods_article_link FROM goods WHERE factory_id=161 or factory_id=163 or factory_id=164 or factory_id=165 or factory_id=166 or factory_id=167" .
                " or factory_id=168 or factory_id=169 or factory_id=170 or factory_id=171";
            if ($res = mysqli_query($db_connect, $query)) {
                unset($site_names);
                while ($row = mysqli_fetch_assoc($res)) {
                    //массив со всеми названиями товара в прайсе
                    $site_names[] = $row['goods_article_link'];
                }
                //дальше просто сравниваем наши загруженные названия и те, что уже есть на сайте и получаем разницу
                //выбираем в отдельный массив только полученные названия с прайса
                unset($price_names);
                foreach ($this->data as $d) {
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
        if ($result || $result2) {
            echo "<p><b>in price but not on site</b></p>";
            echo "<pre>";
            print_r($result);
            echo "</pre>";
            echo "<p><b>on site but not in price</b></p>";
            echo "<pre>";
            print_r($result2);
            echo "</pre>";
            mysqli_close($db_connect);
            $this->setActual($result2);
            return $result;
        } else {
            mysqli_close($db_connect);
            return null;
        }
    }
}

class Veres extends Universal
{
    public function parse_price($params)
    {
        if ($this->file1)
        {
            $dom = DOMDocument::load($this->file1);
            $rows = $dom->getElementsByTagName('Row');
            //print_r($rows);
            $row_num = 1;
            //полезная инфа начинается с 2 строки!
            //артикул позиции находится в 1 ячейке
            //цена - 8 ячейка
            foreach ($rows as $row)
            {
                if ($row_num>=2)
                {
                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    unset($name);
                    unset($price);
                    foreach ($cells as $cell)
                    {
                        $elem=$cell->nodeValue;
                        if ($cell_num==1)
                        {
                            $name=$elem;
                        }
                        if ($cell_num==8)
                        {
                            $price=round($elem);
                        }
                        $cell_num++;
                        //break;
                    }
                    if ($name&&$price)
                    {
                        $this->add_price($name,$price);
                    }
                }
                $row_num++;
            }
        }
        else
        {
            echo "No file, no life!";
        }
    }
    /**
     *сохраняет информацию из поля $data в базу данных сайта
     */
    public function add_db()
    {
        $db = DB::getInstance();
        $db->debug = true;
        $db_connect=mysqli_connect(host,user,pass,db);
        foreach ($this->data as $d)
        {
            $d_name=$d['name'];
            //echo $d_name."<br>";
            $d_price=$d['kat0'];
            $factory_id=$this->factory_id;
            $strSQL="UPDATE goods SET goods_price=$d_price ".
                "WHERE goods_article_link='$d_name' AND factory_id=$factory_id";
            // echo $strSQL."<br>";
            //break;
            if ($db->query($strSQL))
            {
                echo "OK!<br>";
            }
            else
            {
                echo "not OK ".mysqli_error()."<br>";
            }
            //break;
        }
    }
    /**
     * для тестов
     * "красиво" выводим поле $data в котором лежат наименование товара и его цена
     */
    public function test_data()
    {
        ?>
        <!--<html>
        <body> -->
        <table>
            <tr>
                <th>Артикул</th>
                <th>Цена</th>
            </tr>
            <?php foreach($this->data as $row)
            {?>
                <tr>
                    <td><?php echo ($row['name']); ?></td>
                    <td><?php echo ($row['kat0']); ?></td>
                </tr>

            <?php } ?>

        </table>
        <!-- </body>
        </html> --> <?php
        //$this->findDif();
    }
}