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

class Add1CCode
{
    public $data;
    public $filename;
    /**
     * Link constructor.
     * @param $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }
    private function ReadFile()
    {
        $handle=fopen($this->filename,"r");
        while (!feof($handle))
        {
            $str=fgets($handle);
			$str=explode(";",$str);
			$arr[]=$str;
        }
        if (!empty($arr))
        {
            $this->data = $arr;
        }
        else
        {
            echo "array is empty in ReadFile";
        }
    }

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
        //var_dump ($goods);
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

    private function getName($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goodshaslang_name from goodshaslang WHERE goods_id=$id AND lang_id=1";
        if ($res=mysqli_query($db_connect,$query))
        {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $names[] = $row;
                }
        }
        else
        {
             echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
        if (is_array($names))
        {
            return $names[0]['goodshaslang_name'];
        }
        else
        {
            return null;
        }
    }

    private function hasCode1C($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_article_1c from goods WHERE goods_id=$id";
        if ($res=mysqli_query($db_connect,$query))
        {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $names[] = $row;
                }
        }
        else
        {
             echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
        //var_dump ($names);
        $name=" ".$names[0]["goods_article_1c"];
        if (($name!=" ")&&(strripos($name,"ФШ")==false))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function setCode1C($id,$code1c)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query = "UPDATE goods SET goods.goods_article_1c='$code1c' WHERE goods_id=$id";
        mysqli_query($db_connect,$query);
        echo "$query<br>";
        mysqli_close($db_connect);
    }

    public function setGarant()
    {
        $goods=$this->getGoodsByCatAndFactory(9,101);
        $this->ReadFile();
        if (is_array ($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good;
                $name=$this->getName($id);
                //$code_tmp=$this->getCode1C($id);
                //echo "$code_tmp<br>";
                if ($this->hasCode1C($id))
                {
                    echo "$id $name<br><br>";
                    foreach ($this->data as $code1C)
                    {
                        //echo "$name<br>";
                        $code=$code1C[1];
                        $name_1c=$code1C[0];
                        $name_1c="Шкаф-купе ".$name_1c;
                        //echo "$code - $name_1c<br>";
                        $name1=str_replace("Орех болонья","Орех болонья темный",$name);

                        if ($name1==$name_1c)
                        {
                            $this->setCode1C($id,$code);
                            break;
                        }
                    }
                    //break;

                }
                else
                {
                    //echo "$code_tmp not int<br>";
                }

                

            }

        }
        else
        {
            echo "No goods array";
        }
    }

    private function get1C($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_article_1c from goods WHERE goods_id=$id";
        if ($res=mysqli_query($db_connect,$query))
        {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $names[] = $row;
                }
        }
        else
        {
             echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
        //var_dump ($names);
        return $names[0]["goods_article_1c"];
        
    }

    private function SetOn($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query = "UPDATE goodshaslang SET goodshaslang_active=1 WHERE goods_id=$id";
        mysqli_query($db_connect,$query);
        echo "$query<br>";
        mysqli_close($db_connect);
    }

    public function onGarant()
    {
        $goods=$this->getGoodsByCatAndFactory(9,101);
        $this->ReadFile();
        if (is_array ($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good;
                $name=$this->getName($id);
                $code1=$this->get1C($id);
                //$code_tmp=$this->getCode1C($id);
                //echo "$code_tmp<br>";
                echo "$id $name<br><br>";
                foreach ($this->data as $code1C)
                {
                    //echo "$name<br>";
                    $code=$code1C[1];
                   if ($code==$code1)
                   {
                        $this->SetOn($id);
                        break;
                    }
               
                    //break;

                }
                

                

            }

        }
        else
        {
            echo "No goods array";
        }
    }

}

$test = new Add1CCode("garant-sklad1.txt");
//$test->setGarant();
$test->onGarant();