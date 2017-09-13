<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 30.08.16
 * Time: 14:45
 */

class A_Class extends Universal
{
    /**
     * парсим прайс
     */
    public function parse_price($params)
    {
        if($this->file1)
        {
            $dom = DOMDocument::load($this->file1);
            $rows=$dom->getElementsByTagName('Row');
            //print_r($rows);
            $row_num=1;
            //полезная инфа начинается с 3 строки!
            //название позиции находится в 1 ячейке
            //цена - 4 ячейка
            foreach ($rows as $row)
            {
                if ($row_num>=3)
                {
                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    foreach ($cells as $cell)
                    {
                        $elem=$cell->nodeValue;
                        if ($cell_num==1)
                        {
                            $name=$elem;
                        }
                        if ($cell_num==4)
                        {
                            $price=$elem;
                        }
                        $cell_num++;
                    }
                    if ((!empty($name))&&(!empty($price)))
                    {
                        $this->add_price($name,$price);
                        //echo "Yay!";
                    }
                }
                $row_num++;
            }
        }
        else
        {
            echo "No file, no life!";
            return;
        }
    }

    /**
     *записываем распарсеный прайс в БД
     */
    public function add_db()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        foreach ($this->data as $d)
        {
            $d_name=$d['name'];
            //echo $d_name."<br>";
            $d_price=$d['price'];
            $factory_id=$this->factory_id;
            $strSQL="UPDATE goods ".
                "SET goods_price=$d_price ".
                "WHERE goods.goods_article_link='$d_name' AND factory_id=$factory_id";
            echo $strSQL."<br>";
            //break;
            mysqli_query($db_connect, $strSQL);
            //break;
        }
        mysqli_close($db_connect);
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
                <th>Цена </th>
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
    }
}

?>