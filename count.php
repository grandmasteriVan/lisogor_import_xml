<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 27.01.17
 * Time: 09:55
 */
header('Content-Type: text/html; charset=utf-8');
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
 * Class countTov
 */
class countTov
{
    /**
     * @param $factory_id
     * @return null
     */
    private function countPerFactoryAll($factory_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT count(goods_id) FROM goods WHERE factory_id=$factory_id";
		//echo "$q"
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods=$row;
            }
            mysqli_close($db_connect);
			//print_r ($goods);
			//echo "Y!<br>";
            return $goods['count(goods_id)'];
        }
        else
        {
            mysqli_close($db_connect);
			echo "Error<br>";
            return null;
        }
    }

    /**
     * @param $factory_id
     * @return null
     */
    private function countPerFactoryActive($factory_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT count(goods_id) FROM goods WHERE factory_id=$factory_id AND goods_active=1 AND goods_noactual=0";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods=$row;
            }
            mysqli_close($db_connect);
            //print_r ($goods);
            //echo "Y!<br>";
            return $goods['count(goods_id)'];
        }
        else
        {
            mysqli_close($db_connect);
            echo "Error<br>";
            return null;
        }
    }

    /**
     *
     */
    public function countTovFM()
    {
        echo "<b>На ФМ:</b><br>";
		$db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT factory_id, factory_name FROM factory WHERE factory_active=1 AND factory_soft=1";
        if ($res=mysqli_query($db_connect,$query))
        {
            unset($factoryes);
            while ($row = mysqli_fetch_assoc($res))
            {
                $factoryes[]=$row;
            }
            //var_dump($factoryes);
			if (is_array($factoryes))
            {
                foreach ($factoryes as $factory)
                {
                    $id=$factory['factory_id'];
                    $count_tov_all=$this->countPerFactoryAll($id);
                    $count_tov_active=$this->countPerFactoryActive($id);
                    $name=$factory['factory_name'];
                    //if (!is_null($count_tov))
						echo "Фабрика  <b>$name</b> Всего товаров: <b>$count_tov_all</b>, Из них активых: <b>$count_tov_active</b><br>";
                }
            }
			else
			{
				echo "No factory array";
			}
        }
        mysqli_close($db_connect);
		echo "<br><br><br>";
    }
}

/**
 * Class CountDDN
 */
class CountDDN
{
    /**
     * @return array|null
     */
    private function getFactoryisId()
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT fvalue_id, fvalue_nameru FROM fvalue WHERE fkind_id=17";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $factoryes[]=$row;
            }
        }
        else
        {
            echo "Error in SQL ".mysqli_error($db_connect)."<br>";
        }
        mysqli_close($db_connect);
        if (is_array($factoryes))
        {
            return $factoryes;
        }
        else
        {
            return null;
        }
    }

    /**
     * @param $f_id
     * @return mixed
     */
    private function getCountByFactoryAll($f_id)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="select count(goods_id) FROM goodshasfeature WHERE feature_id=14 AND goodshasfeature_valueid=$f_id";
		//echo "$query<br>";
        if ($res=mysqli_query($db_connect,$query))
        {
            unset ($good);
			while ($row = mysqli_fetch_assoc($res))
            {
                //var_dump($row);
				$good=$row['count(goods_id)'];
				//var_dump($good);
            }
        }
		
        else
        {
            echo "Error in SQL ".mysqli_error($db_connect)."<br>";
        }
        return $good;
    }

    /**
     * @param $f_id
     * @return mixed
     */
    private function getCountByFactoryActual($f_id)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="select count(goodshasfeature.goods_id) FROM goods join goodshasfeature on goods.goods_id=goodshasfeature.goods_id WHERE goodshasfeature.feature_id=14 AND goodshasfeature.goodshasfeature_valueid=$f_id AND goods.goods_noactual=0";
		//echo "$query<br>";
        if ($res=mysqli_query($db_connect,$query))
        {
            unset ($good);
			while ($row = mysqli_fetch_assoc($res))
            {
                //var_dump($row);
				$good=$row['count(goodshasfeature.goods_id)'];
				//var_dump($good);
            }
        }
		
        else
        {
            echo "Error in SQL ".mysqli_error($db_connect)."<br>";
        }
        return $good;
    }

    /**
     *
     */
    public function getCount()
    {
        echo "<b>На ДДН:</b><br>";
        $factoryes=$this->getFactoryisId();
        if(is_array($factoryes))
        {
            foreach ($factoryes as $factory)
            {
                $id=$factory['fvalue_id'];
                $name=$factory['fvalue_nameru'];
                $countAll=$this->getCountByFactoryAll($id);
                $countActual=$this->getCountByFactoryActual($id);
				
				
                echo "Фабрика <b>$name</b> всего товаров: <b>$countAll</b>  из них актуальных: <b>$countActual</b><br>";
            }
        }
        else
        {
            echo "No factory array";
        }
    }
}

/**
 * Class Timer
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
$runtime = new Timer();
$runtime->setStartTime();
//echo "test";
$test=new countTov();
$test->countTovFM();

$test1=new CountDDN();
$test1->getCount();
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";
