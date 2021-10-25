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

class ReName
{
    private function getGoodsByCat($cat_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goods_id FROM goodshascategory WHERE category_id=$cat_id";
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
        return $goods_all;
    }

    private function getName($id,$lang)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goodshaslang_name FROM goodshaslang WHERE goods_id=$id AND lang_id=$lang";
        //$query="SELECT * FROM goodshaslang WHERE goods_id=$id";
        if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$name[] = $row;
				}
		}
		else
		{
			 echo "Error in SQL: $query<br>";		
        }
        //var_dump ($name);
        //echo "<br>";
        return $name;
    }

    private function setName($id,$name,$lang)
    {
        if (!empty($name))
        {
            $db_connect=mysqli_connect(host,user,pass,db);
            $query="UPDATE goodshaslang SET goodshaslang_name='$name' WHERE goods_id=$id AND lang_id=$lang";
            echo "$query<br>";
            //mysqli_query($db_connect,$query);
            mysqli_close($db_connect);
        }
        
    }

    private function renameGood($name,$lang)
    {
        if (!empty($name))
        {
            if ($lang==1)
            {
                $name_new="Тумба кухонная ".$name;
                if(stripos(" ".$name,"ПУ ")!=null)
                {
                    $name_new="Пенал кухонный ".$name;
                }
                if(stripos(" ".$name,"Фасад ")!=null)
                {
                    $name_new=$name;
                }
                if(stripos(" ".$name,"Цоколь ")!=null)
                {
                    $name_new=$name;
                }
                return $name_new;
            }
            if ($lang==2)
            {
                $name_new="Тумба кухонна ".$name;
                if(stripos(" ".$name,"ПУ ")!=null)
                {
                    $name_new="Пенал кухонний ".$name;
                }
                if(stripos(" ".$name,"Фасад ")!=null)
                {
                    $name_new=$name;
                }
                if(stripos(" ".$name,"Цоколь ")!=null)
                {
                    $name_new=$name;
                }
                return $name_new;
            }
             
        }
        else
        {
            return null;
        }
        
    }

    public function test()
    {
        $goods=$this->getGoodsByCat(148);
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $name_ru=$this->getName($id,1);
                $name_uk=$this->getName($id,2);
                $name_ru=$name_ru[0]['goodshaslang_name'];
                $name_uk=$name_uk[0]['goodshaslang_name'];
                /////////////
                $name_ru_new=$this->renameGood($name_ru,1);
                $name_uk_new=$this->renameGood($name_uk,2);
                
                //echo "$id ru=$name_ru uk=$name_uk <b>//</b> ru=$name_ru_new uk=$name_uk_new<br>";
                
                $this->setName($id,$name_ru_new,1);
                $this->setName($id,$name_uk_new,2);
                //break;
            }
        }
    }

}

echo "<b>Start</b> ".date("Y-m-d H:i:s")."<br>";
$test=new ReName();
$test->test();
echo "<b>Done</b> ".date("Y-m-d H:i:s");