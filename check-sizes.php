<?php
header('Content-Type: text/html; charset=utf-8');
/**
 * database host
 */
//define ("host","localhost");
define ("host","localhost");
/**
 * database username
 */
//define ("user", "root");
define ("user", "newfm");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "N0r7F8g6");
/**
 * database name
 */
//define ("db", "fm_new");
define ("db", "newfm");
/**
 * Class checkSizes
 */
class checkSizes
{
    /**
     * @var int айди категории
     */
    private $cat_id = 1;
    /**
     * @var string размерности, которые проверяме
     */
    public $need_string = 'ff';
    /**
     * Записываем получаемые значения в поля лкасса
     * checkSizes constructor.
     */
    function __construct()
    {
        //var_dump ($_GET);
        $sizes=$_GET['sizes'];
        $cat_id=$_GET["cat_id"];
        //echo gettype($this->need_string);
       //echo "$sizes $cat_id";
        $this->cat_id=$cat_id;
        $this->need_string=" ".$sizes;
        //$this->$cat_id=$_GET["cat_id"];
        //$this->$need_string=$_GET['sizes'];
    }
    /**
     * получаем размеры товаров
     * @param $id int ид товара
     * @return array|null массив с размерами товара
     */
    private function getSizes($id)
    {
       
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_length, goods_width, goods_height, goods_depth from goods WHERE goods_id=$id";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$sizes[] = $row;
				}
		}
		else
		{
			 echo "Error in SQL: $query<br>";		
		}
		mysqli_close($db_connect);
		if (is_array($sizes))
		{
			return $sizes;
		}
		else
		{
			return null;
		}
	
    }
    /**
     * получаем список ид товаров в категрии
     * @param $cat_id int айди категории
     * @return array массив с ид товаров принадлежщих данной категории
     */
    private function getGoodsByCategory($cat_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_id from goodshascategory WHERE category_id=$cat_id";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$goods_all[] = $row;
				}
		}
		else
		{
			 echo "Error in SQL: $query<br>";		
		}
		return $goods_all;
    }
    /**
     * проверяем размерности товаров по категориям
     */
    public function test()
    {
        $goods=$this->getGoodsByCategory($this->cat_id);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $sizes=$this->getSizes($id);
                $size_string="";
                //var_dump ($sizes[0]['goods_width']);
                if (strrpos($this->need_string,"width"))
                {
                    if (!($sizes[0]['goods_width']>0))
                    {
                        $size_string.="нет ширины ";
                    }
                }
                if (strrpos($this->need_string,"length"))
                {
                    if (!($sizes[0]['goods_height']>0))
                    {
                        $size_string.="нет длины  ";
                    }
                }
                if (strrpos($this->need_string,"depth"))
                {
                    if (!($sizes[0]['goods_depth']>0))
                    {
                        $size_string.="нет глубины  ";
                    }
                }
                if (strrpos($this->need_string,"height"))
                {
                    if (!($sizes[0]['goods_height']>0))
                    {
                        $size_string.="нет высоты  ";
                    }
                }
                if (!strrpos($this->need_string,"width"))
                {
                    if ($sizes[0]['goods_width']>0)
                    {
                        $size_string.="но есть ширина ";
                    }
                }
                if (!strrpos($this->need_string,"length"))
                {
                    if ($sizes[0]['goods_length']>0)
                    {
                        $size_string.="но есть длина ";
                    }
                }
                if (!strrpos($this->need_string,"depth"))
                {
                    if ($sizes[0]['goods_depth']>0)
                    {
                        $size_string.="но есть глубина ";
                    }
                }
                if (!strrpos($this->need_string,"height"))
                {
                    if ($sizes[0]['goods_height']>0)
                    {
                        $size_string.="но есть высота ";
                    }
                }
                //var_dump($sizes);
                //echo"<br><br>";
                //echo "$size_string";
               // break;
                if ($size_string!="")
                {
                    $size_string="у товара с ид=$id ".$size_string;
                    echo $size_string."<br>";
                }
            }
        }
    }
}
$test = new checkSizes();
//echo "шкафы распашные:<br>";
$test->test();
/*https://fayni-mebli.com/check-sizes.php?cat_id=10&sizes=width,height,depth
https://fayni-mebli.com/check-sizes.php?cat_id=10&sizes=width,height,depth
10 - это ид категории, меняешь на любую другую по необходимости
width,height,depth - это размерности, которые скрипт проверяет в категории. можешь сюда вписать любые из набора: length, width, height, depth
*/