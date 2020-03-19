<?php
header('Content-Type: text/html; charset=utf-8');
/**
 * database host
 */
//define ("host","localhost");
/**
 *
 */
define ("host","localhost");
/**
 * database username
 */
define ("user", "root");
//define ("user", "optmebli");
/**
 * database password
 */
define ("pass", "");
//define ("pass", "VRYA1Q0R");
/**
 * database name
 */
define ("db", "opt");
//define ("db", "optmebli");

class Hotline
{
    private function getParamsHotline()
    {
        $categories=$this->getCategories();
        $catXML="<categories>".PHP_EOL;
        foreach ($categories as $categoty)
        {
            $catXML.="<category>".PHP_EOL;
            $catId=$categoty['category_id'];
            $catName=$categoty['categoryhaslang_name'];
            $catXML.="<id>".$catId."</id>".PHP_EOL."<name>".$catName."</name>".PHP_EOL;
            $catXML.="</category>".PHP_EOL;
        }
        $catXML.="</categories>".PHP_EOL;
        //var_dump ($catXML);
        return $catXML;
    }

    private function getParamsProm()
    {
        $categories=$this->getCategories();
        $catXML="<catalog>".PHP_EOL;
        foreach ($categories as $categoty)
        {
            $catId=$categoty['category_id'];
            $catName=$categoty['categoryhaslang_name'];
            $catXML.="<category id=\"". $catId."\">".$catName."</category>".PHP_EOL;
        }
        $catXML.="</catalog>".PHP_EOL;
        //var_dump ($catXML);
        return $catXML;
    }

    private function getParamsRozetka()
    {
        $categories=$this->getCategories();
        $catXML="<categories>".PHP_EOL;
        foreach ($categories as $categoty)
        {
            $catId=$categoty['category_id'];
            $catName=$categoty['categoryhaslang_name'];
            $catXML.="<category id=\"". $catId."\">".$catName."</category>".PHP_EOL;
        }
        $catXML.="</categories>".PHP_EOL;
        //var_dump ($catXML);
        return $catXML;
    }

    private function getCategories()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT category_id, categoryhaslang_name FROM categoryhaslang WHERE categoryhaslang_active=1 AND lang_id=1";
		if ($res=mysqli_query($db_connect,$query))
		{		
            while ($row = mysqli_fetch_assoc($res))
			{
				$cat_all[] = $row;
			}
		}
		else
		{
			 echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
		return $cat_all;
    }

    private function getProductsHotline()
    {
        $goods=$this->getGoods();
        //var_dump ($goods);
        $prodXML="<items>".PHP_EOL;
        foreach ($goods as $good)
        {
            $prodXML.="<item>".PHP_EOL;
            $prodXML.="<id>".$good."</id>".PHP_EOL;
            $prodXML.="<categoryId>".$this->getCat($good)."</categoryId>".PHP_EOL;
            $prodXML.="<vendor>".$this->getVendor($good)."</vendor>".PHP_EOL;
            $prodXML.="<name>".$this->getName($good)."</name>".PHP_EOL;
            $prodXML.="<url>".$this->getURL($good)."</url>".PHP_EOL;
            $prodXML.="<image>".$this->getImg($good)."</image>".PHP_EOL;
            if ($this->getStock($good))
            {
                $prodXML.="<stock>В наличии</stock>".PHP_EOL;
            }
            $prodXML.="</item>".PHP_EOL;
            //break;
        }
        $prodXML.="</items>".PHP_EOL;
        //var_dump ($prodXML);
        return $prodXML;

    }

    private function getProductsProm()
    {
        $goods=$this->getGoods();
        //var_dump ($goods);
        $prodXML="<items>".PHP_EOL;
        foreach ($goods as $good)
        {
            $prodXML.="<item id=\"".$good."\">".PHP_EOL;
            $prodXML.="<name>".$this->getName($good)."</name>".PHP_EOL;
            $prodXML.="<categoryId>".$this->getCat($good)."</categoryId>".PHP_EOL;
            $prodXML.="<image>".$this->getImg($good)."</image>".PHP_EOL;
            $prodXML.="<vendor>".$this->getVendor($good)."</vendor>".PHP_EOL;   
            if ($this->getStock($good))
            {
                $prodXML.="<available>true</available>".PHP_EOL;
            }
            else
            {
                $prodXML.="<available>false</available>".PHP_EOL;
            }
            $prodXML.="</item>".PHP_EOL;
            //break;
        }
        $prodXML.="</items>".PHP_EOL;
        //var_dump ($prodXML);
        return $prodXML;

    }

    private function getProductsRozetka()
    {
        $goods=$this->getGoods();
        //var_dump ($goods);
        $prodXML="<offers>".PHP_EOL;
        foreach ($goods as $good)
        {
            $prodXML.="<offer id=\"".$good."\"";
            if ($this->getStock($good))
            {
                $prodXML.=" available=\"true\">".PHP_EOL;
            }
            else
            {
                $prodXML.=" available=\"false\">".PHP_EOL;
            }
            $prodXML.="<url>".$this->getURL($good)."</url>".PHP_EOL;
            $prodXML.="<categoryId>".$this->getCat($good)."</categoryId>".PHP_EOL;
            $prodXML.="<picture>".$this->getImg($good)."</picture>".PHP_EOL;
            $prodXML.="<vendor>".$this->getVendor($good)."</vendor>".PHP_EOL;
            $prodXML.="<name>".$this->getName($good)."</name>".PHP_EOL;
            $prodXML.="</offer>".PHP_EOL;
            //break;
        }
        $prodXML.="</offers>".PHP_EOL;
        //var_dump ($prodXML);
        return $prodXML;

    }

    private function getGoods()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $goods=null;
		$query="SELECT goods_id FROM goods WHERE goods_mod<>0 AND goods_noactual=0";
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
        mysqli_close($db_connect);
        foreach ($goods_all as $good)
        {
            $id=$good['goods_id'];
            if ($this->isActive($id))
            {
                $goods[]=$id;
            }

        }
		return $goods;
    }

    private function getCat($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT category_id FROM goods WHERE goods_id=$id";
		if ($res=mysqli_query($db_connect,$query))
		{		
            while ($row = mysqli_fetch_assoc($res))
			{
				$goods_cat[] = $row;
			}
		}
		else
		{
			echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
		return $goods_cat[0]['category_id'];
    }

    private function getVendor($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goods_factory FROM goods WHERE goods_id=$id";
		if ($res=mysqli_query($db_connect,$query))
		{		
            while ($row = mysqli_fetch_assoc($res))
			{
				$goods_factory[] = $row;
			}
		}
		else
		{
			echo "Error in SQL: $query<br>";		
        }
        $factoryId=$goods_factory[0]['goods_factory'];
        $query="SELECT factoryhaslang_name FROM factoryhaslang WHERE factory_id=$factoryId AND lang_id=1";
        if ($res=mysqli_query($db_connect,$query))
		{		
            while ($row = mysqli_fetch_assoc($res))
			{
				$factory_name[] = $row;
			}
		}
		else
		{
			echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
        return $factory_name[0]['factoryhaslang_name'];
    }

    private function getName($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goodshaslang_name FROM goodshaslang WHERE goods_id=$id AND lang_id=1";
        if ($res=mysqli_query($db_connect,$query))
        {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $goods_name[] = $row;
                }
        }
        else
        {
            echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
        return  $goods_name[0]['goodshaslang_name'];
    }

    private function getURL($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT url_name FROM url WHERE url_ctrl LIKE 'goods' AND url_itemid=$id";
        if ($res=mysqli_query($db_connect,$query))
        {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $goods_url[] = $row;
                }
        }
        else
        {
            echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
        return  "https://optmebli.com/".$goods_url[0]['url_name'].".html";
    }

    private function getImg($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goods_pict FROM goods WHERE goods_id=$id";
		if ($res=mysqli_query($db_connect,$query))
		{		
            while ($row = mysqli_fetch_assoc($res))
			{
				$goods_pict[] = $row;
			}
		}
		else
		{
			echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
        $pict="https://optmebli.com/content/goods/".$id."/picture-".$id.".".$goods_pict[0][goods_pict];
        return $pict;
    }

    private function getStock($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goods_avail FROM goods WHERE goods_id=$id";
		if ($res=mysqli_query($db_connect,$query))
		{		
            while ($row = mysqli_fetch_assoc($res))
			{
				$goods_avail[] = $row;
			}
		}
		else
		{
			echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
        if ($goods_avail[0][goods_avail]>0)
        {
            $avail=true;
        }
        else
        {
            $avali=false;
        }
        return $avail;
    }

    private function isActive($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goodshaslang_active from goodshaslang WHERE goods_id=$id AND lang_id=1";
        if ($res=mysqli_query($db_connect,$query))
        {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $goods_active[] = $row;
                }
        }
        else
        {
            echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
        if ($goods_active[0]['goodshaslang_active']==1)
        {
            $active=true;
        }
        else
        {
            $active=false;
        }
        return $active;
    }

    public function hotlineXML()
    {
        $hotlineXML="<?xml version=\"1.0\" encoding=\"UTF-8\"?>".PHP_EOL;
        $hotlineXML.="<price>".PHP_EOL;
        $hotlineXML.="<date>".date("Y-m-d H:i:s")."</date>".PHP_EOL;
        $hotlineXML.="<firmName>Мебель Оптом</firmName>".PHP_EOL;
        $hotlineXML.=$this->getParamsHotline();
        $hotlineXML.=$this->getProductsHotline();
        $hotlineXML.="</price>".PHP_EOL;
        file_put_contents("hotline.xml",$hotlineXML);
        echo "Hotline Done ".date("Y-m-d H:i:s")."<br>";
    }

    public function promXML()
    {
        $promXML="<?xml version=\"1.0\" encoding=\"UTF-8\"?>".PHP_EOL;
        $promXML.="<shop>".PHP_EOL;
        $promXML.=$this->getParamsProm();
        $promXML.=$this->getProductsProm();
        $promXML.="</shop>".PHP_EOL;
        file_put_contents("prom.xml",$promXML);
        echo "Prom.ua Done ".date("Y-m-d H:i:s")."<br>";
    }

    public function rozetkaXML()
    {
        $rozetkaXML="<?xml version=\"1.0\" encoding=\"UTF-8\"?>".PHP_EOL;
        $rozetkaXML.="<!DOCTYPE yml_catalog SYSTEM \"shops.dtd\">".PHP_EOL;
        $rozetkaXML.="<yml_catalog date=\"".date("Y-m-d H:i")."\">".PHP_EOL;
        $rozetkaXML.="<shop>".PHP_EOL;
        $rozetkaXML.=$this->getParamsRozetka();
        $rozetkaXML.=$this->getProductsRozetka();
        $rozetkaXML.="</shop>".PHP_EOL;
        $rozetkaXML.="</yml_catalog>".PHP_EOL;
        file_put_contents("rozetka.xml",$rozetkaXML);
        echo "Rozetka Done ".date("Y-m-d H:i:s")."<br>";
    }
}
ini_set('max_execution_time', '60000');
echo "Start: ".date("Y-m-d H:i:s")."<br>";
$test = new Hotline();
$test->hotlineXML();
$test->promXML();
$test->rozetkaXML();