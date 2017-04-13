<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 13.04.17
 * Time: 14:48
 */

require 'autoload.php';

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
            //полезная инфа начинается с 14 строки!
            //артикул позиции находится в 6 ячейке
            //цена - 12 ячейка
            foreach ($rows as $row)
            {
                if ($row_num>=14)
                {
                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    unset($name);
                    unset($price);
                    foreach ($cells as $cell)
                    {
                        $elem=$cell->nodeValue;
                        if ($cell_num==6)
                        {
                            $name=$elem;
                        }
                        if ($cell_num==12)
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