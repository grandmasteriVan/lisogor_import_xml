<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 22.11.2017
 * Time: 09:41
 */
header('Content-type: text/html; charset=UTF-8');
//define ("host","localhost");
//define ("host_ddn","localhost");
define ("host_ddn","es835db.mirohost.net");
define ("host","localhost");
/**
 * database username
 */
//define ("user", "root");
//define ("user_ddn", "root");
define ("user_ddn", "u_fayni");
define ("user", "fm");
/**
 * database password
 */
//define ("pass", "");
//define ("pass_ddn", "");
define ("pass_ddn", "ZID1c0eud3Dc");
define ("pass", "T6n7C8r1");
/**
 * database name
 */
//define ("db", "mebli");
//define ("db_ddn", "ddn_new");
define ("db_ddn", "ddnPZS");
define ("db", "fm");
/**
 * Class Timer
 * подсчет времени выполнения скрипта
 */
class Timer
{
    /**
     * @var время начала выпонения
     */
    private $start_time;
    /**
     * @var время конца выполнения
     */
    private $end_time;
    /**
     * встанавливаем время начала выполнения скрипта
     */
    public function setStartTime()
    {
        $this->start_time = microtime(true);
    }
    /**
     * устанавливаем время конца выполнения скрипта
     */
    public function setEndTime()
    {
        $this->end_time = microtime(true);
    }
    /**
     * @return mixed время выполения
     * возвращаем время выполнения скрипта в секундах
     */
    public function getRunTime()
    {
        return $this->end_time-$this->start_time;
    }
}
class FindDiff
{
    private function getDDN($f_id)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT DISTINCT goods.goods_id, goods.goods_article FROM goods join goodshasfeature on goods.goods_id=goodshasfeature.goods_id WHERE goodshasfeature.goods_id in (select goodshasfeature.goods_id from goodshasfeature where feature_id=14 AND goodshasfeature_valueid=$f_id)";
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
    private function getFM($f_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods.goods_id, goodsmirror.goodsmirror_article_ddn FROM goods JOIN goodsmirror ON goods.goods_id=goodsmirror.goods_id ".
            "WHERE goods.factory_id=$f_id AND goods.goods_active=1 AND goods.goods_noactual=0";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $tovByFactory[]=$row;
            }
            //var_dump ($query);
            //var_dump ($tovByFactory);
        }
        else
        {
            echo "error in SQL fm $query<br>";
        }
        mysqli_close($db_connect);
        if (is_array($tovByFactory))
        {
            return $tovByFactory;
        }
        else
        {
            return null;
        }
    }
    public function findDif($fm_id, $ddn_id)
    {
        $ddn=$this->getDDN($ddn_id);
        $fm=$this->getFM($fm_id);
		//var_dump($ddn);
		//var_dump($fm);
		
        if (is_array($ddn))
        {
            foreach ($ddn as $div)
            {
                $ddn_articles[]=$div['goods_article'];
            }
        }
        if (is_array($fm))
        {
            foreach ($fm as $item)
            {
                $fm_articles[]=$item['goodsmirror_article_ddn'];
            }
        }
		//var_dump ($ddn_articles);
		
        $diff_ddn=array_diff($ddn_articles,$fm_articles);
		
        $diff_fm=array_diff($fm_articles,$ddn_articles);
        echo "Диваны на ДДН которых нет на ФМ:<br>";
		var_dump($diff_ddn);
		echo "<br>";
		echo "Диваны на FM которых нет на DDN:<br>";
		var_dump($diff_fm);
    }
}
$runtime = new Timer();
//set_time_limit(9000);
$runtime->setStartTime();
$test = new FindDiff();
$test->findDif(6,87);
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";
