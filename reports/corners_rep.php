<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 21.06.2018
 * Time: 10:08
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
class Corners
{
    private function getGoods()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT  goods_id,  goods_maintcharter, goods_content FROM goods WHERE factory_id=202";
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
        else
        {
            return 0;
        }
    }
    private function setActive($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="update goods SET goods_active=1 where goods_id=$id";
        mysqli_query($db_connect,$query);
		//echo "$query<br>";
        mysqli_close($db_connect);
    }
    private function addVid($id,$cont,$charter)
    {
        $add="<p style=\"text-align: center;\"><iframe allow=\"encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" gesture=\"media\" height=\"214\" src=\"https://www.youtube.com/embed/EoGsmck1bZI\" style=\"text-align: center;\" width=\"380\"></iframe></p>";
		if ($charter==33)
        {
            $add.="<p>Цена указана за кровать без матраса и подъемного механизма. За дополнительной информацией обращайтесь к менеджерам нашего магазина</p>";
        }
        $cont=$add.$cont;
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="update goods SET goods_content='$cont' where goods_id=$id";
        mysqli_query($db_connect,$query);
		//echo "$query<br>";
        mysqli_close($db_connect);
    }
    public function checkCorners()
    {
        $goods=$this->getGoods();
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $charter=$good['goods_maintcharter'];
                $cont=$good['goods_content'];
				//$cont="";
                $this->setActive($id);
                $this->addVid($id,$cont,$charter);
            }
        }
        else
        {
            echo "No goods!<br>";
        }
    }
}
$test=new Corners();
$test->checkCorners();
