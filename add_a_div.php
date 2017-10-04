<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 04.10.2017
 * Time: 14:32
 */
define ("host","es835db.mirohost.net");
define ("user", "u_fayni");
define ("pass", "ZID1c0eud3Dc");
define ("db", "ddnPZS");

class MakeActive
{
    private $f_id;

    /**
     * MakeActive constructor.
     * @param $f_id
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
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
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
     * @param $id - айди категории
     * @return bool true - если запись есть, false - если нет
     */
    private function checkDuplicate($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goodshastissue_id FROM goodshastissue_id WHERE tissue_id=$id";
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
    private function insertGoodsHasTissue($issue_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $all_divs=$this->getGoodsByFactory($this->f_id);
        foreach ($all_divs as $div)
        {
            if ($this->checkDuplicate($div))
            {
                $query="INSERT INTO goodshastissue (goodshastissue_price, goodshastissue_pricecur, goodshastissue_active, goods_id,tissue_id)".
                    " VALUES (0,0,1,$div,$issue_id)";
                mysqli_query($db_connect, $query);
                echo "$query<br>";
            }
        }
    }
    private function getGoodsHasTissueId($goods_id, $tissue_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goodshastissue_id FROM goodshastissue_id WHERE tissue_id=$tissue_id AND goods_id=$goods_id";
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
    private function setGoodsMainCat($goods_id,$maincat_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="UPDATE goods SET goods_maincategory=$maincat_id WHERE goods_id=$goods_id";
        mysqli_query($db_connect,$query);
        echo "$query<br>";
        mysqli_close($db_connect);
    }

    public function makeA($issue_id)
    {
        //добавляем в каждый диван нужную категорию
        $this->insertGoodsHasTissue($issue_id);
        $all_div=$this->getGoodsByFactory($this->f_id);
        foreach ($all_div as $div)
        {
            $goods_maincategory=$this->getGoodsHasTissueId($div,$issue_id);
            $this->setGoodsMainCat($div,$goods_maincategory);
        }
    }
}

$test=new MakeActive(82);
$test->makeA(299);