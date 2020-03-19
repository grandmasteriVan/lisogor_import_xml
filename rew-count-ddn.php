<?php
header('Content-type: text/html; charset=UTF-8');
//require 'autoload.php';
//ini_set('display_errors', 1);
ini_set('max_execution_time', 720000);

define ("host","localhost");
define ("user", "u_ddnPZS");
define ("pass", "A8mnsoHf");
define ("db", "ddnPZS");

/*define ("host","localhost");
define ("user", "root");
define ("pass", "");
define ("db", "ddn");*/

class RevCount
{
    private function getAllRev()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT url_id from review WHERE review_active=1";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$goods_all[] = $row['url_id'];
				}
		}
		else
		{
			 echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
        //echo "<pre>"; print_r ($goods_all); echo "</pre>";
        return $goods_all;
    }

    private function getItemByUrlId($urlId)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT url_name, url_itemid FROM url WHERE url_id=$urlId";
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
        //echo "<pre>"; print_r ($goods_all); echo "</pre>";
        return $goods_all;
    }

    private function getIdByItem($url_itemid)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goods_id FROM goodshaslang WHERE goodshaslang_id=$url_itemid";
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
        //echo "<pre>"; print_r ($goods_all); echo "</pre>";
        return $goods_all[0]['goods_id'];
    }

    public function test()
    {
        $reviews=$this->getAllRev();

        /*foreach ($reviews as $rev)
        {
            $id=$rev['review_id'];
            $prod=$rev['review_goods'];
            //$
            if ($prod==3575)
            {
                echo "$id<br>";
                echo "<pre>"; print_r ($rev); echo "</pre>";
            }
            if ($id==4819)
            {
                echo "yay $id<br>";
                echo "<pre>"; print_r ($rev); echo "</pre>";
            }
            //$co=array_count_values()
        }*/
        $co=array_count_values($reviews);
        //var_dump
        arsort($co);
        //echo "<pre>"; print_r ($co); echo "</pre>";
        $i=0;
        foreach ($co as $key => $value)
        {
            if ($i>0)
            {
                //echo "$key-$value<br>";

                $temp=$this->getItemByUrlId($key);
                //echo "<pre>"; print_r ($temp); echo "</pre>";
                $id=$this->getIdByItem($temp[0]['url_itemid']);
                echo "id=$id Количество отзывов=$value<br>";
            }
            $i++;
        }
    }
}

$test = new RevCount();
$test->test();