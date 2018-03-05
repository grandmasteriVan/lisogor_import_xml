<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 02.03.2018
 * Time: 14:00
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
class listDDN
{
    private function getAllGoods()
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT goods_id, cachegoods_minprice FROM cachegoods WHERE cachegoods_minprice<15001";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[]=$row;
            }
            //var_dump ($query);
            //var_dump ($tovByFactory);
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
		if (is_array($goods))
		{
			return $goods;
		}
		else
		{
			return null;
		}
    }
    private function getUrlsById($id)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT goodshaslang_url FROM goodshaslang WHERE goods_id=$id";
        if ($res=mysqli_query($db_connect,$query))
        {
            unset($goods);
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[]=$row;
            }
            //var_dump ($query);
            //var_dump ($tovByFactory);
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        if (!is_null($goods))
        {
            return $goods;
        }
        else
        {
            return null;
        }
    }
    private function getUrlidByUrl($url)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT url_id FROM url WHERE url_name='$url'";
        if ($res=mysqli_query($db_connect,$query))
        {
            unset($goods);
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[]=$row;
            }
            //var_dump ($query);
            //var_dump ($tovByFactory);
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        if (!is_null($goods))
        {
            return $goods;
        }
        else
        {
            return null;
        }
    }
    private function findRewiev($id)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT review_id FROM review WHERE url_id=$id";
        if ($res=mysqli_query($db_connect,$query))
        {
            unset($goods);
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[]=$row;
            }
            //var_dump ($query);
            //var_dump ($tovByFactory);
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        if (!is_null($goods))
        {
            return true;
        }
        else
        {
            return null;
        }
    }
    private function isStraight($id)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT goodshasfeature_valueid FROM goodshasfeature WHERE goods_id=$id AND feature_id=6 AND goodshasfeature_valueid=55";
        if ($res=mysqli_query($db_connect,$query))
        {
            unset($goods);
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods=$row;
            }
            //var_dump ($query);
            //var_dump ($goods);
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        if (!is_null($goods))
        {
            return true;
        }
        else
        {
            return null;
        }
    }
    private function isUgol($id)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT goodshasfeature_valueid FROM goodshasfeature WHERE goods_id=$id AND feature_id=6 AND goodshasfeature_valueid=56";
        if ($res=mysqli_query($db_connect,$query))
        {
            unset($goods);
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods=$row;
            }
            //var_dump ($query);
            //var_dump ($tovByFactory);
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        if (!is_null($goods))
        {
            return true;
        }
        else
        {
            return null;
        }
    }
    private function getNameById($id)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT goodshaslang_name FROM goodshaslang WHERE goods_id=$id AND lang_id=1";
        if ($res=mysqli_query($db_connect,$query))
        {
            unset($goods);
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods=$row;
            }
            //var_dump ($query);
            //var_dump ($tovByFactory);
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        if (!is_null($goods))
        {
            return $goods['goodshaslang_name'];
        }
        else
        {
            return null;
        }
    }
    private function getFactoryIdById($id)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT goodshasfeature_valueid FROM goodshasfeature WHERE goods_id=$id AND feature_id=14";
        if ($res=mysqli_query($db_connect,$query))
        {
            unset($goods);
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods=$row;
            }
            //var_dump ($query);
            //var_dump ($tovByFactory);
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        if (!is_null($goods))
        {
            return $goods['goodshasfeature_valueid'];
        }
        else
        {
            return null;
        }
    }
    private function getFactoryByFactoryId($id)
    {
        $db_connect=mysqli_connect(host_ddn,user_ddn,pass_ddn,db_ddn);
        $query="SELECT fvalue_nameru FROM fvalue WHERE fvalue_id=$id";
        if ($res=mysqli_query($db_connect,$query))
        {
            unset($goods);
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods=$row;
            }
            //var_dump ($query);
            //var_dump ($tovByFactory);
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        if (!is_null($goods))
        {
            return $goods['fvalue_nameru'];
        }
        else
        {
            return null;
        }
    }
    public function getList()
    {
        $goods=$this->getAllGoods();
		//var_dump($goods);
		//break;
		if (is_array($goods))
		{
			$i=1;
			foreach ($goods as $good)
			{
				//var_dump($good);
				$id=$good['goods_id'];
				$price=intval($good['cachegoods_minprice']);
				//echo "$price <br>";
				$i++;
				//echo "$i";
				
				if ($this->isStraight($id)&&$price<=10000)
				{
					$straight[]=$good;
					//break;
				}
				if ($this->isUgol($id)&&$price<=15000)
				{
					$ugol[]=$good;
				}
				
				
			}
			//echo "i=$i";
			
			if (is_array($straight))
			{
				foreach ($straight as $item)
				{
					$id=$item['goods_id'];
					$url=$this->getUrlsById($id);
					$ulr_ua=$url[0]['goodshaslang_url'];
					//echo "$ulr_ua<br>";
					$ulr_ru=$url[1]['goodshaslang_url'];
					//echo "$ulr_ru<br>";
					$urlId_ua=$this->getUrlidByUrl($ulr_ua);
					$urlId_ua=$urlId_ua[0]['url_id'];
					$urlId_ru=$this->getUrlidByUrl($ulr_ru);
					$urlId_ru=$urlId_ru[0]['url_id'];
					//var_dump($url);
					//var_dump($urlId_ua);
					//var_dump($urlId_ru);
					
					
					
					if($this->findRewiev($urlId_ru)||$this->findRewiev($urlId_ua))
					{
						$straigthWihtRew[]=$item;
					}
					//break;
				}
			}
			else
			{
				echo "No array straight";
			}
			//var_dump($straigthWihtRew);
			if (is_array($straigthWihtRew))
			{
				foreach ($straigthWihtRew as $good)
				{
					$id=$good['goods_id'];
					$f_id=$this->getFactoryIdById($id);
					//echo "$f_id<br>";
					$factory=$this->getFactoryByFactoryId($f_id);
					//echo ""
					$name=$this->getNameById($id);
					echo "$id; $name; $factory<br>";
					//break;
				}
			}
			echo "<br>угловые<br>";
			
			if (is_array($ugol))
			{
				foreach ($ugol as $item)
				{
					$id=$item['goods_id'];
					$url=$this->getUrlsById($id);
					$ulr_ua=$url[0]['goodshaslang_url'];
					//echo "$ulr_ua<br>";
					$ulr_ru=$url[1]['goodshaslang_url'];
					//echo "$ulr_ru<br>";
					$urlId_ua=$this->getUrlidByUrl($ulr_ua);
					$urlId_ua=$urlId_ua[0]['url_id'];
					$urlId_ru=$this->getUrlidByUrl($ulr_ru);
					$urlId_ru=$urlId_ru[0]['url_id'];
					if($this->findRewiev($urlId_ru)||$this->findRewiev($urlId_ua))
					{
						$ugolWihtRew[]=$item;
					}
				}
			}
			else
			{
				echo "No array ugol";
			}
			//var_dump($ugolWihtRew);
			if (is_array($ugolWihtRew))
			{
				foreach ($ugolWihtRew as $good)
				{
					$id=$good['goods_id'];
					$f_id=$this->getFactoryIdById($id);
					//echo "$f_id<br>";
					$factory=$this->getFactoryByFactoryId($f_id);
					//echo ""
					$name=$this->getNameById($id);
					echo "$id; $name; $factory;<br>";
					//break;
				}
			}
			
		}
		else
		{
			echo "No goods array!";
		}
        
    }
}
class listFM
{
    private function countRewiev($url_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT count(review_id) FROM review WHERE url_id='$url_id'";
        if ($res=mysqli_query($db_connect,$query))
        {
            unset($goods);
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods=$row;
            }
            //var_dump ($query);
            //var_dump ($goods);
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        if (!is_null($goods))
        {
            return $goods['count(review_id)'];
        }
        else
        {
            return null;
        }
    }
    private function getGoods()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_url, goods_name, factory_id, goodskind_id FROM goods WHERE (goodskind_id=23 OR goodskind_id=26) AND goods_videoreview=1 AND goods_active=1 AND goods_noactual=0";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[]=$row;
            }
            //var_dump ($query);
            //var_dump ($tovByFactory);
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        if (is_array($goods))
        {
            return $goods;
        }
        else
        {
            return null;
        }
    }
    private function getUrlIdByUrl($url)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT url_id FROM url WHERE url_name='$url'";
        if ($res=mysqli_query($db_connect,$query))
        {
            unset($goods);
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods=$row;
            }
            //var_dump ($query);
            //var_dump ($tovByFactory);
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        if (!is_null($goods))
        {
            return $goods['url_id'];
        }
        else
        {
            return null;
        }
    }
	private function getFactory($f_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT factory_name FROM factory WHERE factory_id=$f_id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods=$row;
            }
            //var_dump ($query);
            //var_dump ($tovByFactory);
        }
        else
        {
            echo "error in SQL: $query<br>";
        }
        mysqli_close($db_connect);
        if (is_array($goods))
        {
            return $goods['factory_name'];
        }
        else
        {
            return null;
        }
	}
	
    public function getList()
    {
        $goods=$this->getGoods();
        if (is_array($goods))
        {
            foreach ($goods as $good)
			{
				if ($good['goodskind_id']==23)
				{
					$starit[]=$good;
				}
				if ($good['goodskind_id']==26)
				{
					$ugol[]=$good;
				}
			}	
        }
        else
        {
            echo "Not an array!";
        }
		if (is_array($starit))
		{
			foreach ($starit as $good)
            {
                $id=$good['goods_id'];
                $name=$good['goods_name'];
                $url=$good['goods_url'];
                $url_id=$this->getUrlIdByUrl($url);
                $count_rew=$this->countRewiev($url_id);
				$f_id=$good['factory_id'];
				$factory=$this->getFactory($f_id);
				echo "$id; $name; $factory; $count_rew;<br>";
				
            }
		}
		echo "<br><br>Угловые<br><br>";
		if (is_array($ugol))
		{
			foreach ($ugol as $good)
            {
                $id=$good['goods_id'];
                $name=$good['goods_name'];
                $url=$good['goods_url'];
                $url_id=$this->getUrlIdByUrl($url);
                $count_rew=$this->countRewiev($url_id);
				$f_id=$good['factory_id'];
				$factory=$this->getFactory($f_id);
				echo "$id; $name; $factory; $count_rew;<br>";
				
					
            }
		}
    }
}
$test=new listDDN();
//$test=new listFM();
$test->getList();
