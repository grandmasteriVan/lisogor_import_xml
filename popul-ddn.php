<?php
header('Content-Type: text/html; charset=utf-8');

define ("host","es835db.mirohost.net");
define ("user", "u_fayni");
define ("pass", "ZID1c0eud3Dc");
define ("db", "ddnPZS");

class Popul
{
    private function getGoods()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goods_id from goods";
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
		return $goods_all;
    }

    private function getFeatures($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT feature_id, goodshasfeature_valueid from goodshasfeature WHERE goods_id=$id";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$features_all[] = $row;
				}
        }
        else
		{
			 echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
		return $features_all;
        mysqli_close($db_connect);
    }

    private function setPopul($id,$pop)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
	    $query="UPDATE goods SET goods_popular=$pop where goods_id=$id";
        mysqli_query($db_connect,$query);
        echo "$query<br>";
	    mysqli_close($db_connect);
    }

    public function doPop()
    {
        $goods=$this->getGoods();
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $features=$this->getFeatures($id);
                if (is_array($features))
                {
                    foreach($features as $feature)
                    {
                        $feature_id=$feature['feature_id'];
                        $feature_val=$feature['goodshasfeature_valueid'];
                        if ($feature_id==14&&($feature_val==91||$feature_val==161||$feature_val==164||$feature_val==163||$feature_val==194||$feature_val==206||$feature_val==94))
                        {
                            echo "by factory<br>";
                            $this->setPopul($id,-400);
                        }
                        elseif ($feature_id==8&&$feature_val==63)
                        {
                            echo "Детский<br>";
                            $this->setPopul($id,-400);
                        }
                    }
                }
            }
        }
        else
        {
            echo "No goods!<br>";
        }
    }
}

$test=new Popul();
$test->doPop();