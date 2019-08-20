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

class Corners
{
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

    public function getGoodsByFactory($f_id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="select goods_id from goodshasfeature WHERE feature_id=232 AND goodshasfeature_valueid=$f_id";
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
		return $goods;
    }

    private function setComp ($good_id,$comp_id,$count)
   	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="INSERT INTO component (goods_id, component_child, component_in_complect) VALUES ($good_id,$comp_id,$count)";
		echo "$query<br>";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
    }
    
    public function setComponents()
    {
        $goods=$this->getGoodsByFactory(186);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $goods_name=$this->getName($id);
                
                if (strripos($goods_name,"с подъемником")==false)
                {
                    echo "<b>$goods_name</b><br>";
                    foreach ($goods as $good_inner) 
                    {
                        $id_inner=$good_inner['goods_id'];
                        if ($id!=$id_inner)
                        {
                            $goods_name_inner=" ".$this->getName($id_inner);
                            if ((strripos($goods_name_inner,"с подъемником")!=false))
                            {
                                $goods_name_inner=str_ireplace(" с подъемником","",$goods_name_inner)." с подъемником";
                            }
                            
                            //echo "$goods_name-$goods_name_inner ".strripos($goods_name_inner,$goods_name)."<br>";
                            //$goods_name=" ".$goods_name;
                            if ((strripos($goods_name_inner,$goods_name)!=false)&&(strripos($goods_name_inner,"с подъемником")!=false))
                            {
                                
                                echo "$goods_name_inner-$goods_name<br>";
                                $this->setComp($id,$id_inner,1);
                                $this->setComp($id,57595,1);
                                break;
                            }
                        }
                    }
                //break;

                }
                
            }

        }
        else
        {
            echo "No goods!<br>";
        }

    }

    private function get1CCode ($id)
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
        if (is_array($names))
        {
            return $names[0]['goods_article_1c'];
        }
        else
        {
            return null;
        }
    }

    private function setCode1C ($good_id,$code)
   	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="UPDATE goods SET goods_article_1c='$code' WHERE goods_id=$good_id";
		echo "$query<br>";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
    }

    public function Fix1C ()
    {
        $goods=$this->getGoodsByFactory(186);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $code1C=$this->get1CCode($id);
                echo "$code1C-";
                $code1C=str_ireplace(";","/",$code1C);
                echo "$code1C<br>";
                $this->setCode1C($id,$code1C);
            }

        }
        
    }
}

$test=new Corners();
//$test->setComponents();
$test->Fix1C();