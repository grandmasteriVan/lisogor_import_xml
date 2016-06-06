<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 04.04.16
 * Time: 09:46
 */

/**
 * Class Domini
 */
class Domini
{
    /**
     * @var \$file1 xml файл с прайсом
     */
    private $file1;
    /**
     * @var \$data ассоциативный массив, в котором хранится информация о названии товара из прайса и его цене
     */
    protected $data;
    /**
     * Domini constructor.
     * @param \$f передаем файл с прайсом в конструктор
     */
    function __construct($f)
    {
        if ($f)
            $this->file1=$f;
    }
    /**
     * @param $name string[] название (код) товара
     * @param $price int цена товара
     * записывает в поле $data наименование товара и его цену
     */
    private function add_price ($name, $price)
    {
        if (intval($name)&&$price==0)
		{
			return;
		}
		$this->data[]=array(
            'name'=>$name,
            'price'=>$price);
        //var_dump($this->data);
        //echo "test!";
    }
    /**
     *вынимаем из прайса наименование товара и его цену
     * и записываем их в поле $data
     */
    public function parce_price_domini()
    {
        if ($this->file1)
        {
            $dom = DOMDocument::load($this->file1);
            $rows=$dom->getElementsByTagName('Row');
            //print_r($rows);
            $row_num=1;
            //полезная инфа начинается с 4 строки!
            //артикул позиции находится в 1 ячейке
            //цена - 9 ячейка
            foreach ($rows as $row)
            {
                if ($row_num>=4)
                {
                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    $isModuleTov=true;
                    foreach ($cells as $cell)
                    {
                        //$price=null;
                        $elem=$cell->nodeValue;
                        //обычная позиция
                        if (($cell_num==1)&&(intval($elem)))
                        {
                            $name=$elem;
							$isModuleTov=false;
                        }
                        //составная позиция или название раздела
                        if (($isModuleTov)&&($cell_num==2)&&(!intval($elem)))
                        {
                            $name=$elem;
                        }
                        if ($cell_num==10)
                        {
                            $price=round($elem);
                        }
                        $cell_num++;
                    }
                    //проверяем писать ли позицию в массив или нет (имеет ли она имя)
                    if ((!empty($name))&&(strlen($name)<50))
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
            echo "No file!";
        }
    }
    /**
     *сохраняет информацию из поля $data в базу данных сайта
     */
    public function add_db_domini()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        //сначала проставляем цены элементов
        foreach ($this->data as $d)
        {
            if ($d['price']!=0)
            {
                $d_name=$d['name'];
                //echo $d_name."<br>";
                $d_price=$d['price'];
                $factory_id=78;
                $strSQL="UPDATE goods ".
                    "SET goods_pricecur=$d_price ".
                    "WHERE goods.goods_article_link=$d_name AND factory_id=$factory_id";
                echo $strSQL."<br>";
                //break;
                mysqli_query($db_connect, $strSQL);
                //break;
            }
        }
        //потом проставляем цены модулей
        echo "<br><b>Просчет модулей</b><br>";
		foreach ($this->data as $d)
        {
            if ($d['price']==0)
            {
                //считаем цену позиции суммируя цены ее составляющих
                $name=$d['name'];
				$name=UTF8toCP1251($name);
				//$name=("UTF-8","CP1251",$name)
                //echo $name."<br>";
                $strSQL="SELECT SUM(goods_pricecur) FROM goods WHERE goods_id IN(".
                    "SELECT component_child FROM component WHERE component_in_complect=1 AND goods_id=(".
                    "SELECT goods_id FROM goods WHERE goods_article_link='$name' AND factory_id=78))";
                $res=mysqli_query($db_connect,$strSQL);
				//echo gettype($res);
				var_dump($res);
				echo "<br>";
                //$price=mysqli_fetch_assoc($res);
				while($row = mysqli_fetch_assoc($res)) 
				{
					print_r($row);
					$price=$row['SUM(goods_pricecur)'] ;
				}
                //проставляем цену позиции
                if ($price)
				{
					$strSQL="UPDATE goods ".
						"SET goods_pricecur=$price ".
						"WHERE goods.goods_article_link='$name' AND factory_id=78";
					echo "<br><b>".$strSQL."</b><br>";
					//break;
					mysqli_query($db_connect, $strSQL);
				}
				
            }
        }
    }
    /**
     * для тестов
     * красиво выводим поле $data в котором лежат наименование товара и его цена
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
                    <td><?php echo ($row['price']); ?></td>
                </tr>

            <?php } ?>

        </table>
        <!-- </body>
        </html> --> <?php
    }
}
function UTF8toCP1251($str){ // by SiMM, $table from http://ru.wikipedia.org/wiki/CP1251
    static $table = array("\xD0\x81" => "\xA8", // Ё
                          "\xD1\x91" => "\xB8", // ё
                          // украинские символы
                          "\xD0\x8E" => "\xA1", // Ў (У)
                          "\xD1\x9E" => "\xA2", // ў (у)
                          "\xD0\x84" => "\xAA", // Є (Э)
                          "\xD0\x87" => "\xAF", // Ї (I..)
                          "\xD0\x86" => "\xB2", // I (I)
                          "\xD1\x96" => "\xB3", // i (i)
                          "\xD1\x94" => "\xBA", // є (э)
                          "\xD1\x97" => "\xBF", // ї (i..)
                          // чувашские символы
                          "\xD3\x90" => "\x8C", // &#1232; (А)
                          "\xD3\x96" => "\x8D", // &#1238; (Е)
                          "\xD2\xAA" => "\x8E", // &#1194; (С)
                          "\xD3\xB2" => "\x8F", // &#1266; (У)
                          "\xD3\x91" => "\x9C", // &#1233; (а)
                          "\xD3\x97" => "\x9D", // &#1239; (е)
                          "\xD2\xAB" => "\x9E", // &#1195; (с)
                          "\xD3\xB3" => "\x9F", // &#1267; (у)
                         );
    $str = preg_replace('#([\xD0-\xD1])([\x80-\xBF])#se',
                        'isset($table["$0"]) ? $table["$0"] :
                         chr(ord("$2")+("$1" == "\xD0" ? 0x30 : 0x70))
                        ',
                        $str
                       );
    $str = str_replace("i", "і", $str);
    $str = str_replace("I", "І", $str);
    return $str;
  }

?>
