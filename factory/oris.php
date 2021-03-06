<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 27.03.17
 * Time: 09:49
 */
require 'autoload.php';
class OrisInStore extends Universal
{
	public function setNull()
	{
		$db = DB::getInstance();
        $db->debug = true;
        $db_connect=mysqli_connect(host,user,pass,db);
		$strSQL="UPDATE goods SET goods_avail=0 ".
                "WHERE factory_id=151";
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
                if ($row_num>=8)
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
	}
	
	public function add_db()
    {
        //$db = DB::getInstance();
        //$db->debug = true;
        $db_connect=mysqli_connect(host,user,pass,db);
        //echo "";
		if (is_array($this->data))
		{
			foreach ($this->data as $d)
			{
				
				$d_name=$d['name'];
				if (strcasecmp ($d_name,"")!=0)
				//echo $d_name."<br>";
				//$factory_id=$this->factory_id;
				$strSQL="UPDATE goods SET goods_avail=1 WHERE goods_article_link='$d_name' AND factory_id=151";
				// echo $strSQL."<br>";
				//break;
				if (mysqli_query($db_connect, $strSQL))
				{
					echo "$strSQL   OK!<br>";
				}
				else
				{
					echo "$strSQL    not OK ".mysqli_error()."<br>";
				}
				//break;
			}
		}
		else
		{
			echo "No data to write in BD!<br>";
		}
    }
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

class Oris extends Universal
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
            //артикул позиции находится в 2 ячейке
            //цена - 8 ячейка
            foreach ($rows as $row)
            {
                if ($row_num>=14&&$row_num<=242)
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
							//отбрасываем лишние имена
                            if (mb_stripos($name,"ttps:"))
							{
								$name=null;
							}
                        }
                        if ($cell_num==8)
                        {
                            $price=round($elem);
                        }
                        $cell_num++;
						//break;
                    }
                    if ($name)
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
