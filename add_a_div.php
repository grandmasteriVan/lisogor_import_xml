<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 04.10.2017
 * Time: 14:32
 */
define ("host","localhost");
define ("user", "u_ddnPZS");
define ("pass", "A8mnsoHf");
define ("db", "ddnPZS");
//define ("host","localhost");
//define ("user", "root");
//define ("pass", "");
//define ("db", "ddn_new");
class MakeActive
{
    /**
     * @var int фа-ди фабрики
     */
    private $f_id;
    /**
     * MakeActive constructor.
     * @param $f_id int фйди фабрики
     */
    public function __construct($f_id)
    {
        $this->f_id = $f_id;
    }
    /**
     * выбираем список айди товаров с сайта ДДН по определенной фабрике
     * @param $f_id integer - айди фабрики на ДДН
     * @return array|null - массив айди товаров
     */
    private function getGoodsByFactory ($f_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT DISTINCT goods.goods_id FROM goods join goodshasfeature on goods.goods_id=goodshasfeature.goods_id WHERE goodshasfeature.goods_id in (select goodshasfeature.goods_id from goodshasfeature where feature_id=14 AND goodshasfeature_valueid=$f_id)";
        if ($res=mysqli_query($db_connect,$query))
        {
            //var_dump ($query);
            while ($row = mysqli_fetch_assoc($res))
            {
                $idByFactoty[]=$row;
            }
        }
        else
        {
            echo "error in SQL ddn $query<br>";
        }
        mysqli_close($db_connect);
        if (is_array($idByFactoty))
        {
            return $idByFactoty;
        }
        else
        {
            return null;
        }
    }
    /**
     * проверяем есть ли запись для данной категории
     * @param $id int - айди категории
     * @param $t_id int фйди категории
     * @return bool true - если запись есть, false - если нет
     */
    private function checkDuplicate($id,$t_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goodshastissue_id FROM goodshastissue WHERE goods_id=$id AND tissue_id=$t_id";
        //echo $query."<br>";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $ids[] = $row;
            }
            if (is_array($ids))
            {
                foreach ($ids as $article)
                {
                    //получаем нужный текст
                    $art=$article['goodshastissue_id'];
                }
            }
        }
		else
		{
			echo "error in SQL $query<br>";
		}
        //mysqli_query($db_connect, $query);
        //var_dump ($art);
        if ($art==null)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    /** Вставляем категрию в товары
     * @param $issue_id  int  айди категории
     */
    private function insertGoodsHasTissue($issue_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $all_divs=$this->getGoodsByFactory($this->f_id);
		//var_dump($all_divs);
        foreach ($all_divs as $div)
        {
            //var_dump($div);
			$div=$div['goods_id'];
			if (!$this->checkDuplicate($div,$issue_id))
            {
                $query="INSERT INTO goodshastissue (goodshastissue_price, goodshastissue_pricecur, goodshastissue_active, goods_id,tissue_id)".
                    " VALUES (0,0,1,$div,$issue_id)";
                mysqli_query($db_connect, $query);
                echo "$query<br>";
            }
			else
			{
				echo "Find Cat $issue_id in good $div!<br>";
				$query="UPDATE goodshastissue SET goodshastissue_active=1 WHERE goods_id=$div AND tissue_id=$issue_id";
                mysqli_query($db_connect, $query);
			}
        }
    }
    /**
     * @param $goods_id
     * @param $tissue_id
     * @return null
     */
    private function getGoodsHasTissueId($goods_id, $tissue_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goodshastissue_id FROM goodshastissue WHERE tissue_id=$tissue_id AND goods_id=$goods_id";
        //echo $query."<br>";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $ids[] = $row;
            }
            if (is_array($ids))
            {
                foreach ($ids as $article)
                {
                    //получаем нужный текст
                    $art=$article['goodshastissue_id'];
                }
            }
        }
		else
		{
			echo "Error in SQL $query<br>";
		}
        mysqli_close($db_connect);
        if ($art!=null)
        {
            return $art;
        }
        else
        {
            return null;
        }
    }
    /**
     * @param $goods_id
     * @param $maincat_id
     */
    private function setGoodsMainCat($goods_id, $maincat_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="UPDATE goods SET goods_maincategory=$maincat_id WHERE goods_id=$goods_id";
        mysqli_query($db_connect,$query);
        echo "$query<br>";
        mysqli_close($db_connect);
    }
    /**
     * @param $issue_id
     */
    public function makeA($issue_id)
    {
        //добавляем в каждый диван нужную категорию
        $this->insertGoodsHasTissue($issue_id);
        $all_div=$this->getGoodsByFactory($this->f_id);
        foreach ($all_div as $div)
        {
            $div=$div['goods_id'];
			$goods_maincategory=$this->getGoodsHasTissueId($div,$issue_id);
			//var_dump($goods_maincategory);
            $this->setGoodsMainCat($div,$goods_maincategory);
			//break;
        }
    }
}
//
//$test=new MakeActive(82);
//$test->makeA(299);
//Киев (софиевка)
$test=new MakeActive(134);
$test->makeA(293);
//daniro
$test=new MakeActive(87);
$test->makeA(109);
//sidi-m
$test=new MakeActive(83);
$test->makeA(278);
//катунь
$test=new MakeActive(89);
$test->makeA(127);
//лисогор
$test=new MakeActive(84);
$test->makeA(294);
//вика
$test=new MakeActive(96);
$test->makeA(121);
//рата
$test=new MakeActive(90);
$test->makeA(122);
