<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 29.06.17
 * Time: 12:36
 */
header('Content-type: text/html; charset=UTF-8');

//define ("host","localhost");
//define ("host_ddn","localhost");
define ("host_ddn","es835db.mirohost.net");
define ("host","10.0.0.2");
/**
 * database username
 */
//define ("user", "root");
//define ("user_ddn", "root");
define ("user_ddn", "u_fromfayni");
define ("user", "uh333660_mebli");
/**
 * database password
 */
//define ("pass", "");
//define ("pass_ddn", "");
define ("pass_ddn", "");
define ("pass", "ZID1c0eud3Dc");
/**
 * database name
 */
//define ("db", "mebli");
//define ("db_ddn", "ddn_new");
define ("db_ddn", "ddn_new");
define ("db", "divaniE");

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

class FM
{
    /*private $factory_equal = array(
	(fm=>82,ddn=>7),
	(fm=>83,ddn=>88),
	(fm=>84,ddn=>66),
	(fm=>85,ddn=>4),
	(fm=>86,ddn=>52),
	(fm=>87,ddn=>6),
	(fm=>88,ddn=>5),
	(fm=>89,ddn=>2),
	(fm=>90,ddn=>1),
	(fm=>91,ddn=>25),
	(fm=>92,ddn=>19),
	(fm=>94,ddn=>12),
	(fm=>95,ddn=>17),
	(fm=>96,ddn=>33),
	(fm=>97,ddn=>16),
	(fm=>98,ddn=>95),
	(fm=>123,ddn=>125),
	(fm=>124,ddn=>26),
	(fm=>125,ddn=>123),
	(fm=>134,ddn=>136),
	(fm=>145,ddn=>138),
	(fm=>153,ddn=>8),
	(fm=>157,ddn=>114),
	(fm=>161,ddn=>134),
	(fm=>162,ddn=>157),
	(fm=>163,ddn=>156),
	(fm=>164,ddn=>153),
	(fm=>166,ddn=>173),
	(fm=>168,ddn=>174));*/

    /**
     * выбираем список айди товаров с сайта ФМ по определенной фабрике
     * @param $f_id integer - айди фабрики на ФМ
     * @return array|null - массив айди товаров
     */
    private function getTovByFactoryFM ($f_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id FROM goods WHERE factory_id=$f_id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $tovByFactoty[]=$row;
            }
			//var_dump ($query);
			//var_dump ($tovByFactoty);
        }
        else
        {
            echo "error in SQL $query<br>";
        }
        mysqli_close($db_connect);
        if (is_array($tovByFactoty))
        {
            return $tovByFactoty;
        }
        else
        {
            return null;
        }
    }

    /**
     * выбираем список айди товаров с сайта ДДН по определенной фабрике
     * @param $f_id integer - айди фабрики на ДДН
     * @return array|null - массив айди товаров
     */
    private function getTovByFactoryDDN ($f_id)
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
            echo "error in SQL $query<br>";
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
     * сравниваем 2 названия дивана.
     * если они равны - возвращаем true, если нет - false
     * @param $div_fm string - название дивана на ФМ
     * @param $div_ddn string - название дивана на ДДН
     * @return bool
     */
    private function getEqual($div_fm, $div_ddn)
    {
        if (strnatcasecmp($div_fm,$div_ddn)==0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * убираем лишние символы и слова из названия
     * @param $div string - имя дивана
     * @return string - обработанное имя дивана
     */
    private function strip($div)
    {
        $div_new=str_replace("Диван","",$div);
        $div_new=str_replace("Угловой","",$div_new);
        //$div_new=str_replace("угловой","",$div_new);
        $div_new=str_replace("диван","",$div_new);
		$div_new=str_replace(" ","",$div_new);
        return $div_new;
    }

    /**
     * выбираем имя дивана по его айди на сайте ФМ
     * @param $id integer - айди дивана
     * @return bool - возвращаем имя дивана или false если не нашли
     */
    private function getNameByIdFM($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goods_name FROM goods WHERE goods_id=$id";
		if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $names[]=$row;
            }
			if (is_array($names))
			{
				foreach ($names as $name)
				{
					$div_name=$name['goods_name'];
				}
			}
        }
		else
		{
			echo "Error in SQL $query<br>";
		}
		mysqli_close($db_connect);
		if (is_string($div_name))
		{
			return $div_name;
		}
		else
		{
			return false;
		}
	}

    /**
     * выбираем имя дивана по его айди на сайте ДДН
     * @param $id integer - айди дивана
     * @return bool - возвращаем имя дивана или false если не нашли
     */
    private function getNameByIdDDN($id)
	{
		$db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT goodshaslang_name FROM goodshaslang WHERE goods_id=$id AND lang_id=1 AND goodshaslang_active=1";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $texts[] = $row;
            }
            if (is_array($texts))
            {
                foreach ($texts as $text)
                {
                    //получаем нужный текст
                    $name=$text['goodshaslang_name'];
                }
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        return $name;
	}

    /**
     * записываем изменения в зазеркалье
     * @param $goods_id_fm integer - айди товара на ФМ
     * @param $goods_article_ddn string - артикул товара на ДДН
     */
    private function setMirror($goods_id_fm, $goods_article_ddn)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		//проверяем естл ли уже щапись, если есть - обновляем ее, если нет - создаем
		if ($this->checkDuplicate($goods_id_fm))
		{
			$query="UPDATE goodsmirror SET goodsmirror_article_ddn='$goods_article_ddn' WHERE goods_id=$goods_id_fm";
		}
		else
		{
			$query="INSERT INTO goodsmirror (goodsmirror_article_ddn,goods_id) VALUES ('$goods_article_ddn',$goods_id_fm)";
		}
		
		mysqli_query($db_connect, $query);
		mysqli_close($db_connect);
	}

    /**
     * находим артикул товара на ДДН по его айди
     * @param $id integer - айди товара на ДДН
     * @return mixed - артикул товара на ДДН
     */
    private function getArticleByIdDDN($id)
	{
		$db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT goods_article FROM goods WHERE goods_id=$id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $articles[] = $row;
            }
            if (is_array($articles))
            {
                foreach ($articles as $article)
                {
                    //получаем нужный текст
                    $art=$article['goods_article'];
                }
            }
        }
        else
        {
            echo "Error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        return $art;
	}

    /**
     * проверяем есть ли в зазеркалье запись для данного дивана
     * @param $id integer - айди дивана
     * @return bool true - если запись есть, false - если нет
     */
    private function checkDuplicate($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goodsmirror_article_ddn FROM goodsmirror WHERE goods_id=$id";
		//echo $query."<br>";
		if ($res=mysqli_query($db_connect,$query))
		{
			while ($row = mysqli_fetch_assoc($res))
            {
                $articles[] = $row;
            }
			if (is_array($articles))
            {
                foreach ($articles as $article)
                {
                    //получаем нужный текст
                    $art=$article['goodsmirror_article_ddn'];
                }
            }
		}
		mysqli_query($db_connect, $query);
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
    /**
     * находит одинаково названные товары по фабрикам
     * @param $f_fm integer - айди фабрики на сайте ФМ
     * @param $f_ddn integer - айди фабрики на ДДН
     */
    public function getEqualFactory($f_fm, $f_ddn)
    {
        $div_fm=$this->getTovByFactoryFM($f_fm);
        $div_ddn=$this->getTovByFactoryDDN($f_ddn);
		//var_dump ($div_ddn);
		//var_dump ($div_fm);
		foreach ($div_fm as $d_fm)
		{
			$id_fm=$d_fm['goods_id'];
			$name_fm=$this->getNameByIdFM($id_fm);
			$name_fm=$this->strip($name_fm);
			//echo $name_fm."<br>";
			$find=false;
			foreach ($div_ddn as $d_ddn)
			{
				$id_ddn=$d_ddn['goods_id'];
				$name_ddn=$this->getNameByIdDDN($id_ddn);
				$name_ddn=$this->strip($name_ddn);
				//echo "$name_fm -> $name_ddn<br>";
				if ($this->getEqual($name_fm,$name_ddn))
				{
					$article_ddn=$this->getArticleByIdDDN($id_ddn);
					$this->setMirror($id_fm,$article_ddn);
					//echo "$article_ddn<br>";
					//echo "$name_fm ($id_fm) - $name_ddn ($id_ddn)<br>";
					$find=true;
				}
				
			}
			if (!$find)
			{
				echo "Диван $name_fm ($id_fm) не найден на диванах!<br>";
			}
			//break;
		}
		
    }
}
//ррр
$runtime = new Timer();
set_time_limit(9000);
$runtime->setStartTime();
$test=new FM();
$test->getEqualFactory(88,83);
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";
