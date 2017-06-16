<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 25.05.17
 * Time: 14:53
 */
 header('Content-type: text/html; charset=UTF-8');
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
class setFilters
{
    /**
     * @param int $goods_maintcharter
     * @return array|bool
     */
    function all_matr($goods_maintcharter=13)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT * FROM goods WHERE goods_maintcharter=$goods_maintcharter AND goods_active=1 AND goods_noactual=0";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $arr[] = $row;
                //print_r($arr);
            }
        }
        else
        {
            echo "ERROR in SQL!";
            return false;
        }
        mysqli_close($db_connect);
        return $arr;
    }

    /**
     * @param int $goods_maintcharter
     * @return array
     */
    private function modBads($goods_maintcharter=13)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_parent, goods_width, goods_height FROM goods WHERE goods_maintcharter=$goods_maintcharter AND goods_parent<>goods_id AND goods_noactual=0 AND goods_active=1";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $arr[] = $row;
            }
        }
        mysqli_close($db_connect);
        return $arr;
    }

    /**
     * @param int $goods_maintcharter
     * @return array
     */
    private function parrentBads($goods_maintcharter=13)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_parent, goods_width, goods_height FROM goods WHERE goods_maintcharter=$goods_maintcharter and goods_parent=goods_id AND goods_noactual=0 AND goods_active=1";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $arr[] = $row;
            }
        }
        mysqli_close($db_connect);
        /*echo "<pre>";
        print_r ($arr);
        echo "</pre>";*/
        return $arr;
    }

    /**
     * @param $filters
     * @param $goods_id
     */
    private function filtersCheck($filters, $goods_id)
	{
		unset ($feature_id);
		foreach ($filters as $filter)
		{
			$feature_id[]=$filter['feature_id'];
		}
		/*echo "<pre>";
		print_r ($feature_id);
		echo "</pre>";*/
		
		if (!in_array(47,$feature_id))
		{
			echo "В товаре с ид=$goods_id не проставлен тип кровати!<br>";
		}
		if (!in_array(50,$feature_id))
		{
			echo "В товаре с ид=$goods_id не проставлен материал кровати!<br>";
		}
		if (!in_array(120,$feature_id))
		{
			echo "В товаре с ид=$goods_id не проставлен вид кровати!<br>";
		}
		if (!in_array(49,$feature_id))
		{
			echo "В товаре с ид=$goods_id не проставлена ниша для белья!<br>";
		}
		if (!in_array(121,$feature_id))
		{
			echo "В товаре с ид=$goods_id не проставлен подбемный механизм!<br>";
		}
		if (!in_array(81,$feature_id))
		{
			echo "В товаре с ид=$goods_id не проставлена форма кровати!<br>";
		}
		if (!in_array(48,$feature_id))
		{
			echo "В товаре с ид=$goods_id не проставлено основание для матраса!<br>";
		}
		if (!in_array(51,$feature_id))
		{
			echo "В товаре с ид=$goods_id не проставлено наличие для матраса!<br>";
		}
		return;
	}

    /**
     *
     */
    public function copyFilters()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $parent_list=$this->parrentBads();
        $mod_list=$this->modBads();
        foreach ($parent_list as $parent)
        {
            $parrent_id=$parent['goods_id'];
            //прописываем тип аровати для родительского товара
            $query="DELETE FROM goodshasfeature WHERE goods_id=$parrent_id AND feature_id=47";
            mysqli_query($db_connect,$query);
			//echo $query."<br>";
            $size=$parent['goods_width'];
            if ($size<=1199)
            {
                $goodshasfeature_valueint=1;
            }
            if ($size>1200&&$size<=1599)
            {
                $goodshasfeature_valueint=4;
            }
            if ($size>1600)
            {
                $goodshasfeature_valueint=2;
            }
            $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                "goodshasfeature_valuetext, goods_id, feature_id) ".
                "VALUES ($goodshasfeature_valueint, 0, ".
                "'', $parrent_id, 47)";
            mysqli_query($db_connect,$query);
            //echo "<br><br>установили размер родителя: ".$query."<br>";
            //выбираем список фич для родительского товара
            $query="SELECT * FROM goodshasfeature WHERE goods_id=$parrent_id";
            if ($res=mysqli_query($db_connect,$query))
            {
                //не забываем обнулять список перед заполнением!
                $features=null;
                while ($row=mysqli_fetch_assoc($res))
                {
                    $features[]=$row;
                }
            }
			$this->filtersCheck($features,$parrent_id);
            /*echo "Список фич родителя:<br>";
			echo "<pre>";
			print_r($features);
			echo "</pre>";*/
            /*print_r($features);
            */
            foreach ($mod_list as $mod)
            {
                if ($parent['goods_id']==$mod['goods_parent'])
                {
                    $mod_id=$mod['goods_id'];
                    $mod_size=$mod['goods_width'];
                    //echo "<br><b>$mod_size</b><br>";
                    //дропаем старые записи
                    $query="DELETE FROM goodshasfeature WHERE goods_id=$mod_id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                    //для каждой фичи записываем ее в БД
                    foreach ($features as $feat)
                    {
                        $goodshasfeature_valueint=$feat['goodshasfeature_valueint'];
                        $goodshasfeature_valuefloat=$feat['goodshasfeature_valuefloat'];
                        $goodshasfeature_valuetext=$feat['goodshasfeature_valuetext'];
                        $feature_id=$feat['feature_id'];
                        //пишем размерность (одно/полтора/двуспальные)
                        if ($feature_id==47)
                        {
                            if ($mod_size<=1199)
                            {
                                $goodshasfeature_valueint=1;
                            }
                            if ($mod_size>1200&&$mod_size<=1599)
                            {
                                $goodshasfeature_valueint=2;
                            }
                            if ($mod_size>1600)
                            {
                                $goodshasfeature_valueint=4;
                            }
                        }
                        //не пишем ненужные значния
                        if ($feature_id==47||$feature_id==50||$feature_id==120||$feature_id==49||$feature_id==121||$feature_id==81||$feature_id==48||$feature_id==51)
                        {
                            $query="INSERT INTO goodshasfeature (goodshasfeature_valueint, goodshasfeature_valuefloat, ".
                                "goodshasfeature_valuetext, goods_id, feature_id) ".
                                "VALUES ($goodshasfeature_valueint, $goodshasfeature_valuefloat, ".
                                "'$goodshasfeature_valuetext', $mod_id, $feature_id)";
                            mysqli_query($db_connect,$query);
                            //echo $query."<br>";
                        }
                    }
                }
            }
			//break;
        }
    }
}

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
$test=new setFilters();
$test->copyFilters();
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";
