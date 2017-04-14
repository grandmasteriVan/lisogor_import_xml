<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 31.03.17
 * Time: 09:29
 */
 
 require 'autoload.php';
class Kidigo_1 extends Universal
{
    public function parse_price($params)
    {
        if ($this->file1)
        {
            $dom = DOMDocument::load($this->file1);
            $rows = $dom->getElementsByTagName('Row');
            //print_r($rows);
            $row_num = 1;
            //полезная инфа начинается с 11 строки!
            //артикул позиции находится в 2 ячейке
            //цена - 7 ячейка
            foreach ($rows as $row)
            {
                if ($row_num>=11)
                {
                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    unset($name);
                    unset($price);
                    foreach ($cells as $cell)
                    {
                        $elem=$cell->nodeValue;
                        if ($cell_num==2)
                        {
                            $name=$elem;
                        }
                        if ($cell_num==7)
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
            //$factory_id=$this->factory_id;
            $strSQL="UPDATE goods SET goods_price=$d_price ".
                "WHERE goods_article_link='$d_name'";
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
class Kidigo_2 extends Universal
{
    public function parse_price($params)
    {
        if ($this->file1)
        {
            $dom = DOMDocument::load($this->file1);
            $rows = $dom->getElementsByTagName('Row');
            //print_r($rows);
            $row_num = 1;
            //полезная инфа начинается с 9 строки!
            //артикул позиции находится в 1 ячейке
            //цена - 3 ячейка
            foreach ($rows as $row)
            {
                if ($row_num>=9)
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
                        if ($cell_num==3)
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
        //echo "<br>GO!!!<br>";
		$db = DB::getInstance();
        $db->debug = true;
		//echo "go less futher<br>";
        //$db_connect=mysqli_connect(host,user,pass,db);
        //echo "<pre>";
		//print_r ($this->data);
		//echo "</pre>";
		//if (is_array ($this->data))
		//{
		//	echo "is array<br>";
		//}
		//else
		//{
		//	echo "No array!";
		//	//return;
		//}
		//echo "go futher<br>";
		foreach ($this->data as $d)
        {
            $d_name=$d['name'];
            //echo $d_name."<br>";
            $d_price=$d['kat0'];
            //$factory_id=$this->factory_id;
            $strSQL="UPDATE goods SET goods_price=$d_price ".
                "WHERE goods_article_link='$d_name'";
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
