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
//define ("db", "new_fm");
define ("db", "newfm");

class ChangeNameClass
{
    /**
     * переводим текст
     * @param $txt string - текст, который нам надо перевести
     * @return string - результат перевода
     */
    private function translateText($txt)
    {
        $ukr_txt=str_replace("Винтаж","Вінтаж",$txt);
        $ukr_txt=str_replace("Элит","Еліт",$ukr_txt);
        $ukr_txt=str_replace("Квадрис","Квадріс",$ukr_txt);
        $ukr_txt=str_replace("(без фасада)","(без фасаду)",$ukr_txt);
        //echo "$txt - $ukr_txt<br>";
        return $ukr_txt;
    }
    
    /**
     * выбираем товары, принадлижащие одной категории и определенной фабрике
     * @param $cat_id int айди категории
     * @param $f_id int айди фабрики
     * @return array масссив ид товаров
     */
    private function getGoodsByCatAndFactory($cat_id, $f_id)
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
        var_dump ($goods);
		if (is_array ($goods_all))
		{
			//var_dump($goods_all);
			foreach ($goods_all as $good)
			{
				$id=$good['goods_id'];
				$features=$this->getFeaturesVal($id);
				if (is_array($features))
				{
					foreach ($features as $feature)
					{
						$feature_id=$feature['feature_id'];
						$val_id=$feature['goodshasfeature_valueid'];
						if ($feature_id==232&&$val_id==$f_id)
						{
							$goods_by_factoty[]=$id;
							break;
						}
					}
				}
				
				//break;
			}
		}
		else
		{
			echo "no goods by category<br>";
		}
		
		mysqli_close($db_connect);
		if (is_array($goods_by_factoty))
		{
			return $goods_by_factoty;
		}
		else
		{
			return null;
		}
    }
    
    /**
     * получаем список фильтров и их значения для товара
     * @param $good_id int айди товара
     * @return array|null массив айди фичей и их значения для товара
     */
    private function getFeaturesVal($good_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="select feature_id,goodshasfeature_valueid from goodshasfeature WHERE goods_id=$good_id";
        if ($res=mysqli_query($db_connect,$query))
        {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $goods[] = $row;
                }
        }
        else
        {
            echo "Error in SQL: $query<br>";		
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

    private function getGoodsName($good_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goodshaslang_name FROM goodshaslang WHERE goods_id=$good_id AND lang_id=1";
        if ($res=mysqli_query($db_connect,$query))
        {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $goods[] = $row;
                }
        }
        else
        {
            echo "Error in SQL: $query<br>";		
        }
        if (is_array($goods))
        {
            return $goods[0]['goodshaslang_name'];
        }
        else
        {
            return null;
        }
    }

    private function changeNameVal($name)
    {
        $name_new=str_replace("-"," ",$name);
        return $name_new;
    }

    private function setGoodName($goods_id, $goods_name, $lang)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="UPDATE goodshaslang SET goodshaslang_name='$goods_name' WHERE goods_id=$goods_id AND lang_id=$lang";
        echo "$query<br>";
        //$file_string="$query".PHP_EOL;
        //file_put_contents("ukr_kichen.txt",$file_string,FILE_APPEND);
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    public function changeNameComp($f_id)
    {
        $goods=$this->getGoodsByCatAndFactory(148,$f_id);
        //var_dump($goods);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $good_id=$good;
                $name=$this->getGoodsName($good_id);
                $name_new=$this->changeNameVal($name);
                $name_new_ukr=$this->translateText($name_new);
                //echo "$name_new - $name_new_ukr<br>"
                $this->setGoodName($good_id,$name_new,1);
                $this->setGoodName($good_id,$name_new_ukr,2);

                //break;

            }

        }
        else
        {
            echo "No goods!";
        }
    }
}
set_time_limit(10000);
$test=new ChangeNameClass();
$test->changeNameComp(86);