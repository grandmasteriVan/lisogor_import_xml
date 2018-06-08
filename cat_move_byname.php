<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 07.06.2018
 * Time: 16:20
 */
header('Content-type: text/html; charset=UTF-8');
//define ("host","localhost");
define ("host","localhost");
/**
 * database username
 */
//define ("user", "root");
define ("user", "fm");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "T6n7C8r1");
/**
 * database name
 */
//define ("db", "mebli");
define ("db", "fm");
class CatMove
{
    private function getGoods()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id, goods_name FROM goods WHERE goods_active=1 AND goods_noactual=0";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $goods[] = $row;
            }
        }
        else
        {
            echo "Error in SQL ".mysqli_error($db_connect)."<br>";
        }
        mysqli_close($db_connect);
        if (!empty($goods))
        {
            return $goods;
        }
        return 0;
    }
	
	private function getCatsForGood($id)
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT tcharter_id FROM goodshastcharter WHERE goods_id=$id";
        if ($res=mysqli_query($db_connect,$query))
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $tcharters[] = $row;
            }
        }
        else
        {
            echo "Error in SQL ".mysqli_error($db_connect)."<br>";
        }
        mysqli_close($db_connect);
        if (!empty($tcharters))
        {
            return $tcharters;
        }
        return 0;
	}
	
	public function moveModules()
	{
		$db_connect=mysqli_connect(host,user,pass,db);
		$goods=$this->getGoods();
		if (is_array($goods))
		{
			foreach ($goods as $good)
			{
				$id=$good['goods_id'];
				$name=$good['goods_name'];
				$tcharters=$this->getCatsForGood($id);
				if (is_array ($tcharters))
				{
					foreach ($tcharters as $tcharter)
					{
						$charter_id=$tcharter['tcharter_id'];
						//признак того, что товар явлеятеся детским
						$children=false;
						if ($charter_id==16)
						{
							$children==true;
						}
						if ($charter_id==3&&$children==false)
						{
							echo "$name<br>";
							$query="DELETE FROM goodshastcharter WHERE goods_id=$id AND tcharter_id=40";
							mysqli_query($db_connect,$query);
							echo $query."<br>";
							$query="INSERT INTO goodshastcharter (goods_id, tcharter_id) VALUES ($id,40)";
							mysqli_query($db_connect,$query);
							echo $query."<br>";
						}
					}
				}
			}
		}
		else
		{
			echo "No goods!<br>";
		}
		mysqli_close($db_connect);
	}
	
    public function moveCat()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $goods=$this->getGoods();
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $name=" ".$good['goods_name'];
                /*if ((mb_strpos($name, "Пенал")||mb_strpos($name, "пенал")||mb_strpos($name, "Стеллаж")||mb_strpos($name, "стеллаж")||mb_strpos($name, "Витрина")||mb_strpos($name, "витрина")||mb_strpos($name, "Угловой элемент")||mb_strpos($name, "угловой элемент")||mb_strpos($name, "Сервант")||mb_strpos($name, "сервант"))&&(!mb_strpos($name, "Кухня")))
                {
                    echo "$name<br>";
					$query="DELETE FROM goodshastcharter WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    echo $query."<br>";
                    $query="INSERT INTO goodshastcharter (goods_id, tcharter_id) VALUES ($id,10)";
                    mysqli_query($db_connect,$query);
					echo $query."<br>";
                    $query="UPDATE goods SET goods_maintcharter=10 WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    echo $query."<br>";
                }*/
                if (mb_strpos($name, "Полка")||mb_strpos($name, "полка")||mb_strpos($name, "Надставка")||mb_strpos($name, "надставка"))
                {
                    echo "$name<br>";
					$query="DELETE FROM goodshastcharter WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    echo $query."<br>";
                    $query="INSERT INTO goodshastcharter (goods_id, tcharter_id) VALUES ($id,11)";
                    mysqli_query($db_connect,$query);
					echo $query."<br>";
                    $query="UPDATE goods SET goods_maintcharter=11 WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    echo $query."<br>";
                }
                
				/*if (mb_strpos($name, "Бар ")||mb_strpos($name, "бар "))
                {
                    echo "$name<br>";
					$query="DELETE FROM goodshastcharter WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    echo $query."<br>";
                    $query="INSERT INTO goodshastcharter (goods_id, tcharter_id) VALUES ($id,12)";
                    mysqli_query($db_connect,$query);
					echo $query."<br>";
                    $query="UPDATE goods SET goods_maintcharter=12 WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    echo $query."<br>";
                }*/
            }
        }
        else
        {
            echo "No goods!<br>";
        }
        mysqli_close($db_connect);
    }
}

$test=new CatMove();
$test->moveCat();
//$test->moveModules();
