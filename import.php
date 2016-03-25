<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 01.02.16
 * Time: 10:18
 */
/**
 * database host
 */
//define ("host","localhost");
define ("host","10.0.0.2");
/**
 * database username
 */
//define ("user", "root");
define ("user", "uh333660_mebli");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "Z7A8JqUh");
/**
 * database name
 */
//define ("db", "mebli");
define ("db", "uh333660_mebli");
/** @var array $data */
$data= array();

$selectedFactory=$_POST["factory"];
switch ($selectedFactory)
{
    case "AMF":
        set_time_limit(200);
        $test = new AMF($_FILES['file']['tmp_name']);
        $test->parse_price_amf();
        $test->test_data();
        $test->add_db_afm();
        break;
    case "Poparada":
        break;
    case "BRW":
        parse_price_brw();
        test_data_arr();
		//print_r($data);
        add_db_brw_gerbor($data);
        break;
    case "Gerbor":
        parse_price_gerbor();
        test_data_arr();
        add_db_brw_gerbor($data);
        break;
    case "Lisogor":
        parse_price_lisogor();
        test_data_arr();
        add_db_lisogor($data);
        break;
    case "Vika":
        parse_price_vika();
        test_data_arr();
        add_db_vika($data);
        break;
    case "Domini":
        //echo "In progress";
        $test = new Domini($_FILES['file']['tmp_name']);
        $test->parce_price_domini();
        $test->test_data();
        $test->add_db_domini();
        break;
    case "SidiM":
        echo "In progress";
        break;
    default:
        echo "Выберите фабрику и повторите";
        break;
}
/**
 * записывает полученные из XML значения в ассоциативный массив
 * @param $name - название или id позиции в прайсе поставщика
 * @param $kat1 - цена за первую категорию или цена за товар
 * @param $kat2 - цена за втрую категорию
 * @param $kat3 - цена за третью категорию
 * @param $kat4 - цена за четвертую категорию
 * @param $kat5 - цена за пятую категорию
 * @param $kat6 - цена за шестую категорию
 * @param $kat7 - цена за седьмую категорию
 * @param $kat8 - цена за восьмую категорию
 * @param $kat9 - цена за девятую категорию
 * @param $kat10 - цена за десятую категорию
 */
function add_price($name, $kat1=0, $kat2=0, $kat3=0, $kat4=0, $kat5=0, $kat6=0, $kat7=0, $kat8=0, $kat9=0, $kat10=0)
{
    global $data;
    //echo "test!<br>";
	$data[]=array(
        'name'=>$name,
        'kat1'=>$kat1,
        'kat2'=>$kat2,
        'kat3'=>$kat3,
        'kat4'=>$kat4,
        'kat5'=>$kat5,
        'kat6'=>$kat6,
        'kat7'=>$kat7,
        'kat8'=>$kat8,
        'kat9'=>$kat9,
        'kat10'=>$kat10
    );
	//print_r($data);
}
/**
 * Class Sidim
 */
class Sidim
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
     * Sidim constructor.
     * @param \$f передаем файл с прайсом в конструктор
     */
    function __construct($f)
    {
        if ($f)
            $this->file1=$f;
    }
    /**
     * @param $name string[] название (код) товара
     * @param $kat1 integer цена в первой категории ткани
     * @param $kat2 integer цена в второй категории ткани
     * @param $kat3 integer цена в третьей категории ткани
     * @param $kat4 integer цена в четвертой категории ткани
     * @param $kat5 integer цена в пятой категории ткани
     * @param $kat6 integer цена в шестой категории ткани
     * @param $kat7 integer цена в седьмой категории ткани
     * @param $kat8 integer цена в восьмой категории ткани
     * записывает в поле $data наименование товара и его цену
     */
    private function add_price ($name, $kat1, $kat2, $kat3, $kat4, $kat5, $kat6, $kat7, $kat8)
    {
        $this->data[]=array(
            'name'=>$name,
            'kat1'=>$kat1,
            'kat2'=>$kat2,
            'kat3'=>$kat3,
            'kat4'=>$kat4,
            'kat5'=>$kat5,
            'kat6'=>$kat6,
            'kat7'=>$kat7,
            'kat8'=>$kat8);
        //var_dump($this->data);
        //echo "test!";
    }
    public function parce_price_sidim()
    {
        if ($this->file1)
        {
            $dom=DOMDocument::load($this->file1);
            //print_r($dom);
            $worksheets=$dom->getElementsByTagName('Worksheet');
            foreach ($worksheets as $worksheet)
            {
                $ws_name=$worksheet->getAttribute('ss:Name');
                //echo "$ws_name vkladka <br>";
                if ($ws_name=="Розница грн.")
                {
                    //echo "need vkladka <br>";
                    $rows=$dom->getElementsByTagName('Row');
                    //print_r($rows);
                    $row_num=1;
                    //полезная инфа начинается с 10 строки!
                    //название дивана находиться в первой ячейке
                    //цены - с 4 ячейки через одну (4,6,8 и т.д.)
                    foreach($rows as $row)
                    {
                        //print_r($row);
                        if ($row_num>=10)
                        {
                            $cells=$row->getElementsByTagName('Cell');
                            $cell_num=1;
                            $kat_num=1;
                            foreach ($cells as $cell)
                            {
                                $elem=$cell->nodeValue;
                                //echo "$elem $cell_num <br>";
                                if ($cell_num==1)
                                {
                                    $name=$elem;
                                }
                                if (($cell_num>=4)&&(!empty($elem)))
                                {
                                    if ($cell_num%2==0)
                                    {
                                        $kat[$kat_num]=$cell->nodeValue;
                                        $kat_num++;
                                    }
                                }
                                $cell_num++;
                            }
                            if (($name!="Назва виробу")&&(!empty($name))&&(!empty($kat[1]))&&(!empty($kat[2]))&&(!empty($kat[3]))&&(!empty($kat[4]))&&(!empty($kat[5]))&&(!empty($kat[6]))&&(!empty($kat[7]))&&(!empty($kat[8])))
                                add_price($name,$kat[1],$kat[2],$kat[3],$kat[4],$kat[5],$kat[6],$kat[7],$kat[8]);
                        }
                        $row_num++;
                    }
                    /*echo '<pre>';
                 print_r($data);
                 echo '</pre>';*/
                }
            }
        }
    }
    /**
     * для тестов
     * красиво выводим поле $data в котором лежат наименование товара и его цены
     */
    public function test_data()
    {
        ?>
        <!--<html>
        <body> -->
        <table>
            <tr>
                <th>Диван</th>
                <th>kat 1</th>
                <th>kat 2</th>
                <th>kat 3</th>
                <th>kat 4</th>
                <th>kat 5</th>
                <th>kat 6</th>
                <th>kat 7</th>
                <th>kat 8</th>
            </tr>
            <?php foreach($this->data as $row)
            {?>
                <tr>
                    <td><?php echo ($row['name']); ?></td>
                    <td><?php echo ($row['kat1']); ?></td>
                    <td><?php echo ($row['kat2']); ?></td>
                    <td><?php echo ($row['kat3']); ?></td>
                    <td><?php echo ($row['kat4']); ?></td>
                    <td><?php echo ($row['kat5']); ?></td>
                    <td><?php echo ($row['kat6']); ?></td>
                    <td><?php echo ($row['kat7']); ?></td>
                    <td><?php echo ($row['kat8']); ?></td>

                </tr>

            <?php } ?>

        </table>
        <!-- </body>
        </html> --> <?php
    }
}
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
                    $isModuleTov=false;
                    foreach ($cells as $cell)
                    {
                        $elem=$cell->nodeValue;
                        if (($cell_num==1)&&(intval($elem)))
                        {
                            $name=$elem;
                        }
                        if (($cell_num==2)&&(!intval($elem)))
                        {
                            $name=$elem;
                        }
                        if ($cell_num==9)
                        {
                            $price=$elem;
                        }
                        $cell_num++;
                    }
                    if (!empty($name))
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
                    "SET goods_price=$d_price ".
                    "WHERE goods.goods_article_link=$d_name AND factory_id=$factory_id";
                //echo $strSQL."<br>";
                //break;
                mysqli_query($db_connect, $strSQL);
                //break;
            }
        }
        //потом проставляем цены модулей
        foreach ($this->data as $d)
        {
            if ($d['price']==0)
            {
                //считаем цену позиции суммируя цены ее составляющих
                $name=$d['name'];
                //echo $name."<br>";
                $strSQL="SELECT SUM(goods_price) FROM goods WHERE goods_id IN(".
                    "SELECT component_child FROM component WHERE component_in_complect=1 AND goods_id=(".
                    "SELECT goods_id FROM goods WHERE goods_article_link=$name AND factory_id=78))";
                $res=mysqli_query($db_connect,$strSQL);
                $price=mysqli_fetch_assoc($res);
                //проставляем цену позиции
                $strSQL="UPDATE goods ".
                    "SET goods_price=$price ".
                    "WHERE goods.goods_article_link= $name";
                //echo $strSQL."<br>";
                //break;
                mysqli_query($db_connect, $strSQL);
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
/**
 * Class AMF
 */
class AMF
{
    /**
     * AMF constructor.
     * @param $f
     */
    function __construct($f)
	{
		//echo $f;
		if ($f)
			$this->file1=$f;
	}
    /**
     * @var
     */
    private $file1;
	/**
     * @var - ассоциативный массив, содержащий название позиции и цены, прочитаные из прайса
     */
    /*private*/
    /**
     * @var
     */
    protected $data;
    /**
     * записывает артикул и цену позиции в ассоциативный массив $data
     * @param $name - артикул позиции
     * @param $price - цена
     */
    private function add_price ($name, $price)
    {
        $this->data[]=array(
            'name'=>$name,
            'price'=>$price);
			//var_dump($this->data);
		//echo "test!";
    }
    /**
     *вынимает нужную информацию из XML в прайсе АМФ
     */
    public function parse_price_amf()
    {
        if ($this->file1)
		{
			$dom = DOMDocument::load($this->file1);
			$rows=$dom->getElementsByTagName('Row');
			//print_r($rows);
			$row_num=1;
			//полезная инфа начинается с 12 строки!
			//артикул позиции находится в 3 ячейке
			//цена - 7 ячейка умноженная на 1.3 (+30% к оптовой цене в прайсе)
			foreach ($rows as $row)
			{
				if ($row_num>=12)
				{
					$cells=$row->getElementsByTagName('Cell');
					$cell_num=1;
					foreach ($cells as $cell)
					{
						if ($cell_num==3)
						{
							$name=$cell->nodeValue;
							//echo "name: ".$name."<br>";
						}
						if ($cell_num==7)
						{
							$price=round($cell->nodeValue*1.3);
							//echo "price: ".$price."<br>";
						}
						$cell_num++;
					}
					if ((!empty($name))AND(!empty($price)))
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
		//print_r($this->data);
    }
    /**
     *
     */
    public function add_db_afm()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        foreach ($this->data as $d)
        {
            $d_name=$d['name'];
            //echo $d_name."<br>";
            $d_price=$d['price'];
            $factory_id=34;
            $strSQL="UPDATE goods ".
                "SET goods_price=$d_price ".
                "WHERE goods.goods_article_link=$d_name AND factory_id=$factory_id";
                //echo $strSQL."<br>";
                //break;
            mysqli_query($db_connect, $strSQL);
            //break;
        }
    }
    /**
     *Для тесоитрования, генерит HTML код для вывода $data в виде таблицы
     */
    public function test_data()
    {
        ?>
        <!--<html>
        <body> -->
        <table>
            <tr>
                <th>Артикул</th>
                <th>цена</th>
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
/**
 * Class Poparada
 */
class Poparada
{
    /**
     * @var ассоциативный массив, содержащий название позиции и цены, прочитаные из прайса
     */
    private $data;
    /**
     * записывает полученные из XML значения в ассоциативный массив
     * @param $name - название или id позиции в прайсе поставщика
     * @param $kat1 - цена за первую категорию или цена за товар
     * @param $kat2 - цена за втрую категорию
     * @param $kat3 - цена за третью категорию
     * @param $kat4 - цена за четвертую категорию
     * @param $kat5 - цена за пятую категорию
     * @param $kat6 - цена за шестую категорию
     * @param $kat7 - цена за седьмую категорию
     * @param $kat8 - цена за восьмую категорию
     * @param $kat9 - цена за девятую категорию
     * @param $kat10 - цена за десятую категорию
     */
    private function add_price($name, $kat1=0, $kat2=0, $kat3=0, $kat4=0, $kat5=0, $kat6=0, $kat7=0, $kat8=0, $kat9=0, $kat10=0)
    {
        $this->data[]=array(
            'name'=>$name,
            'kat1'=>$kat1,
            'kat2'=>$kat2,
            'kat3'=>$kat3,
            'kat4'=>$kat4,
            'kat5'=>$kat5,
            'kat6'=>$kat6,
            'kat7'=>$kat7,
            'kat8'=>$kat8,
            'kat9'=>$kat9,
            'kat10'=>$kat10
        );
    }
    /**
     *вынимает нужную информацию из XML в прайсе Попарада
     */
    public function parse_price_poparada()
    {
        if ($_FILES['file']['tmp_name'])
        {
            $dom = DOMDocument::load($_FILES['file']['tmp_name']);
            $rows=$dom->getElementsByTagName('Row');
            //print_r($rows);
            $row_num=1;
            //полезная инфа начинается с 7 строки!
            //название позиции находится в первой ячейке
            //цены в 4,5,6 и 7 ячейках
            foreach ($rows as $row)
            {
                if ($row_num>=7)
                {
                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    $kat_num=1;
                    foreach ($cells as $cell)
                    {
                        if ($cell_num==1)
                        {
                            $name=$cell->nodeValue;
                        }
                        if (($cell_num>=4)&&($cell_num<=7))
                        {
                            $kat[$kat_num]=$cell->nodeValue;
                            $kat_num++;
                        }
                        $cell_num++;
                    }
                    if (!empty($name))
                        add_price($name,$kat[1],$kat[2],$kat[3],$kat[4]);
                }
                $row_num++;
            }
        }
    }
    /**
     * записывает информацию из ассоциативного массива с ценами в базу данных сайта
     * (id фабрики=17)
     * id категории начинается с 500
     */
    public function add_db_poparada()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        foreach ($this->data as $d)
        {
            $d_name=$d['name'];
            //echo $d_name."<br>";
            for ($i=1;$i<=4;$i++)
            {
                //echo "inner";
                $kat_name="kat".strval($i);
                //echo $kat_name."<br>";
                $d_cat=$d[$kat_name];
                $cat_id=499+$i;
                $factory_id=17;
                $strSQL="UPDATE goodshascategory ".
                    "SET goodshascategory_price=$d_cat ".
                    "WHERE goodshascategory.goods_id= ".
                    "(SELECT goods_id FROM goods WHERE (goods.goods_article_link='$d_name') AND (goods.factory_id=$factory_id)) ".
                    "AND (goodshascategory.category_id=$cat_id)";
                //echo $strSQL."<br>";
                //break;
                mysqli_query($db_connect, $strSQL);
            }
            //break;
        }
    }
    /**
     *Для теситрования, генерит HTML код для вывода $data в виде таблицы
     */
    public function test_data()
    {
        ?>
        <!--<html>
        <body> -->
        <table>
            <tr>
                <th>Диван</th>
                <th>kat 1</th>
                <th>kat 2</th>
                <th>kat 3</th>
                <th>kat 4</th>
                <th>kat 5</th>
                <th>kat 6</th>
                <th>kat 7</th>
                <th>kat 8</th>
                <th>kat 9</th>
                <th>kat 10</th>
            </tr>
            <?php foreach($this->data as $row)
            {?>
                <tr>
                    <td><?php echo ($row['name']); ?></td>
                    <td><?php echo ($row['kat1']); ?></td>
                    <td><?php echo ($row['kat2']); ?></td>
                    <td><?php echo ($row['kat3']); ?></td>
                    <td><?php echo ($row['kat4']); ?></td>
                    <td><?php echo ($row['kat5']); ?></td>
                    <td><?php echo ($row['kat6']); ?></td>
                    <td><?php echo ($row['kat7']); ?></td>
                    <td><?php echo ($row['kat8']); ?></td>
                    <td><?php echo ($row['kat9']); ?></td>
                    <td><?php echo ($row['kat10']); ?></td>
                </tr>

            <?php } ?>

        </table>
        <!-- </body>
        </html> --> <?php
    }
}
/**
 *вынимает нужную информацию из XML в прайсе БРВ
 */
function parse_price_brw()
{
    if ($_FILES['file']['tmp_name'])
    {
        $dom=DOMDocument::load($_FILES['file']['tmp_name']);
        //print_r($dom);
        $rows=$dom->getElementsByTagName('Row');
        //print_r($rows);
        $row_num=1;
        //полезная инфа начинается с 5 строки!
        //если первая ячейка в строке - не цыфра, значит это название системы (goods.goods_article_link)
        //и ее цена находиться в в 6 ячейке строки
        //
        //если первая ячейка строки - цифра, то это элемент системы
        //3 ячейка в строке - это ее goods.goods_article_link (id товара в парйсе)
        //6 ячейка - цена
        foreach($rows as $row)
        {
            if ($row_num>=5)
            {
                $cells=$row->getElementsByTagName('Cell');
                $cell_num=1;
				$isModule=false;
                foreach ($cells as $cell)
                {
                    $elem=$cell->nodeValue;
					//echo $cell_num." $elem<br>";
                    
                    if (($cell_num==1)&&(!(intval($elem))))
                    {
                        $name=$elem;
                        $isModule=true;
						//echo "enter NAME cel num:".$cell_num." $row_num <br>";
                    }
                    
					if (($isModule==false)and($cell_num==3))
                    {
                        $name=$elem;
						//echo "enter ID cel num:".$cell_num."<br>";
                    }
                    if ($cell_num==6)
                    {
                        $price=$elem;
						//echo "price=".$price."<br>";
                    }
                    $cell_num++;
                }
				//echo "name=".$name." price=".$price."<br>";
                add_price($name,$price);
			}
            $row_num++;
        }
    }
}
/**
 *вынимает нужную информацию из XML в прайсе Гербор
 */
function parse_price_gerbor()
{
    if ($_FILES['file']['tmp_name'])
    {
        $dom=DOMDocument::load($_FILES['file']['tmp_name']);
        //print_r($dom);
        $rows=$dom->getElementsByTagName('Row');
        //print_r($rows);
        $row_num=1;
        //полезная инфа начинается с 10 строки!
        //если вторая ячейка в строке - пустая, значит 3 ячейка это название системы (goods.goods_article_link)
        //и ее цена находиться в 6 ячейке строки
        //
        //если первая ячейка строки - цифра, то это элемент системы
        //4 ячейка в строке - это ее goods.goods_article_link (id товара в парйсе)
        //6 ячейка - цена
        foreach($rows as $row)
        {
            if ($row_num>=10)
            {
                $cells=$row->getElementsByTagName('Cell');
                $cell_num=1;
				$isModule=false;
                foreach ($cells as $cell)
                {
                    $elem=$cell->nodeValue;
                    
                    if (($cell_num==2)and(empty($elem)))
                    {
                        $isModule=true;
						//echo "enter NAME $row_num $cell_num $elem<br>";
                    }
                    if (($isModule==true)and($cell_num==3))
                    {
                        $name=$elem;
                    }
                    if (($isModule==false)and($cell_num==4))
                    {
                        $name=$elem;
						//echo "enter ID $row_num $cell_num $elem<br>";
                    }
                    if($cell_num==6)
                    {
                        $price=$elem;
                    }
                    $cell_num++;
                }
                add_price($name,$price);
            }
            $row_num++;
        }
    }
}
/**
 *вынимает нужную информацию из XML в прайсе Лисогор
 */
function parse_price_lisogor()
{
    if ($_FILES['file']['tmp_name'])
    {
        $dom=DOMDocument::load($_FILES['file']['tmp_name']);
        //print_r($dom);
        $rows=$dom->getElementsByTagName('Row');
        //print_r($rows);
        $row_num=1;
        //полезная инфа начинается с 5 строки!
        //в нечетной строке у нас идет название дивана во второй ячейке
        //в четной, с 3 по 21 идут цены (при этом они идут через одну ячейку, например 3,5,8 и т.д.
        foreach($rows as $row)
        {
            //print_r($row);
            if ($row_num>=5)
            {
                if (!($row_num%2==0))
                {
                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    foreach ($cells as $cell)
                    {
                        if ($cell_num==2)
                        {
                            $name=$cell->nodeValue;
                            //echo " name=".$name;
                            //имя дивана находится во второй ячейке
                        }
                        $cell_num++;
                    }
                }
                else
                {
                    //начиная с третей ячейки через одну читаем цены
                    $cells=$row->getElementsByTagName('Cell');
                    $cell_num=1;
                    $kat_num=1;
                    foreach ($cells as $cell)
                    {
                        if ($cell_num>=3)
                        {
                            if (!($cell_num%2==0))
                            {
                                $kat[$kat_num]=round($cell->nodeValue);
                                $kat_num++;
                            }
                        }
                        $cell_num++;
                    }
                    add_price($name,$kat[1],$kat[2],$kat[3],$kat[4],$kat[5],$kat[6],$kat[7],$kat[8],$kat[9],$kat[10]);
                }
            }
            $row_num++;
        }
        /*echo '<pre>';
     print_r($data);
     echo '</pre>';*/
    }
}
/**
 *вынимает нужную информацию из XML в прайсе Вика
 */
function parse_price_vika()
{
    if ($_FILES['file']['tmp_name'])
    {
        $dom=DOMDocument::load($_FILES['file']['tmp_name']);
        //print_r($dom);
        $worksheets=$dom->getElementsByTagName('Worksheet');
        foreach ($worksheets as $worksheet)
        {
            $ws_name=$worksheet->getAttribute('ss:Name');
			//echo "$ws_name vkladka <br>";
			
            if ($ws_name=="Розница грн.")
            {
				//echo "need vkladka <br>";
                $rows=$dom->getElementsByTagName('Row');
                //print_r($rows);
                $row_num=1;
                //полезная инфа начинается с 4 строки!
                //если первая ячейка не пустая, то название дивана находится во второй ячейке
                //цены идус с 6 ячейки через одну ячейку (6, 8, 10 и т.д.)
                foreach($rows as $row)
                {
                    //print_r($row);
                    if ($row_num>=4)
                    {
                        $cells=$row->getElementsByTagName('Cell');
                        $cell_num=1;
                        $kat_num=1;
                        $pass=false;
                        foreach ($cells as $cell)
                        {
                            $elem=$cell->nodeValue;
							//echo "$elem $cell_num <br>";
                            if (($cell_num==1)&&(empty($elem)))
                            {
                                $pass=true;
                            }
                            if(($pass==false)&&($cell_num==2))
                            {
                                $name=$elem;
                            }
                            if (($pass==false)&&($cell_num>=6))
                            {
                                if ($cell_num%2==0)
                                {
                                    $kat[$kat_num]=$cell->nodeValue;
                                    $kat_num++;
                                }
                            }
                            $cell_num++;
                        }
                        if (($name!="Назва виробу")&&(!empty($name))&&(!empty($kat[1]))&&(!empty($kat[2]))&&(!empty($kat[3]))&&(!empty($kat[4]))&&(!empty($kat[5]))&&(!empty($kat[6]))&&(!empty($kat[7]))&&(!empty($kat[8]))&&(!empty($kat[9]))&&(!empty($kat[10])))
							add_price($name,$kat[1],$kat[2],$kat[3],$kat[4],$kat[5],$kat[6],$kat[7],$kat[8],$kat[9],$kat[10]);
                    }
                    $row_num++;
                }
                /*echo '<pre>';
             print_r($data);
             echo '</pre>';*/
            }
        }
    }
}
/**
 * записывает информацию из ассоциативного массива с ценами в базу данных сайта
 * (id фабрики=56)
 * первым прогодом по массиву записываем цены составных компонентов
 * вторым проходом - считаем цену систем
 * @param $data1 - ассоциативный массив с данными, получеными из XML
 */
function add_db_brw_gerbor($data1)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    //print_r($data1);
	foreach ($data1 as $d)
    {
        if (intval($d['name']))
        {
            $name=$d['name'];
            //echo $name."<br>";
            $price=$d['kat1'];
            $strSQL="UPDATE goods ".
                "SET goods_price=$price ".
                "WHERE goods.goods_article_link= $name AND factory_id=56";
            //echo $strSQL."<br>";
            //break;
            mysqli_query($db_connect, $strSQL);
        }
        //break;
    }
    foreach ($data1 as $d)
    {
        if (!intval($d['name']))
        {
            //считаем цену позиции суммируя цены ее составляющих
            $name=$d['name'];
            //echo $name."<br>";
            $strSQL="SELECT SUM(goods_price) FROM goods WHERE goods_id IN(".
                "SELECT component_child FROM component WHERE component_in_complect=1 AND goods_id=(".
                    "SELECT goods_id FROM goods WHERE goods_article_link=$name AND factory_id=56))";
            $res=mysqli_query($db_connect,$strSQL);
            $price=mysqli_fetch_assoc($res);
            //проставляем цену позиции
            $strSQL="UPDATE goods ".
                "SET goods_price=$price ".
                "WHERE goods.goods_article_link= $name";
            //echo $strSQL."<br>";
            //break;
            mysqli_query($db_connect, $strSQL);
        }
    }
	echo"End!";
}
/**
 * записывает информацию из ассоциативного массива с ценами в базу данных сайта
 * (id фабрики=66, id категорий начинаются с 628)
 * @param $data1 - ассоциативный массив с данными, получеными из XML
 */
function add_db_lisogor($data1)
{
	$db_connect=mysqli_connect(host,user,pass,db);
	foreach ($data1 as $d)
	{
		$d_name=$d['name'];
		//echo $d_name."<br>";
		for ($i=1;$i<=10;$i++)
		{
			//echo "inner";
			$kat_name="kat".strval($i);
			//echo $kat_name."<br>";
			$d_cat=$d[$kat_name];
			$cat_id=627+$i;
			$strSQL="UPDATE goodshascategory ".
					"SET goodshascategory_price=$d_cat ".
					"WHERE goodshascategory.goods_id= ".
					"(SELECT goods_id FROM goods WHERE (goods.goods_article_link='$d_name') AND (goods.factory_id=66)) ".
					"AND (goodshascategory.category_id=$cat_id)";
			//echo $strSQL."<br>";
			//break;
			mysqli_query($db_connect, $strSQL);
		}
		//break;
	}
}
/**
 * записывает информацию из ассоциативного массива с ценами в базу данных сайта
 * (id фабрики=33, id категорий начинаются с 119)
 * @param $data1 - ассоциативный массив с данными, получеными из XML
 */
function add_db_vika($data1)
{
    $db_connect=mysqli_connect(host,user,pass,db);
    foreach ($data1 as $d)
    {
        $d_name=$d['name'];
        //echo $d_name."<br>";
        for ($i=1;$i<=10;$i++)
        {
            //echo "inner";
            $kat_name="kat".strval($i);
            //echo $kat_name."<br>";
            $d_cat=$d[$kat_name];
            $cat_id=627+$i;
            $strSQL="UPDATE goodshascategory ".
                "SET goodshascategory_price=$d_cat ".
                "WHERE goodshascategory.goods_id= ".
                "(SELECT goods_id FROM goods WHERE (goods.goods_article_link='$d_name') AND (goods.factory_id=33)) ".
                "AND (goodshascategory.category_id=$cat_id)";
            //echo $strSQL."<br>";
            //break;
            mysqli_query($db_connect, $strSQL);
        }
        //break;
    }
}
?>
<?php
/**
 *
 */
function test_data_arr()
{
    global $data
	?>
    <html>
    <body>
    <table>
        <tr>
            <th>Диван</th>
            <th>kat 1</th>
            <th>kat 2</th>
            <th>kat 3</th>
            <th>kat 4</th>
            <th>kat 5</th>
            <th>kat 6</th>
            <th>kat 7</th>
            <th>kat 8</th>
            <th>kat 9</th>
            <th>kat 10</th>
        </tr>
        <?php foreach ($data as $row) {
            ?>
            <tr>
                <td><?php echo($row['name']); ?></td>
                <td><?php echo($row['kat1']); ?></td>
                <td><?php echo($row['kat2']); ?></td>
                <td><?php echo($row['kat3']); ?></td>
                <td><?php echo($row['kat4']); ?></td>
                <td><?php echo($row['kat5']); ?></td>
                <td><?php echo($row['kat6']); ?></td>
                <td><?php echo($row['kat7']); ?></td>
                <td><?php echo($row['kat8']); ?></td>
                <td><?php echo($row['kat9']); ?></td>
                <td><?php echo($row['kat10']); ?></td>
            </tr>

        <?php } ?>

    </table>
    </body>
    </html>
    <?php
}
?>