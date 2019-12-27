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
//define ("user", "root");
define ("user", "optmebli");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "VRYA1Q0R");
/**
 * database name
 */
//define ("db", "opt");
define ("db", "optmebli");

class InsVid
{
    private function getGoodsByFactory($fId)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id from goods WHERE goods_factory=$fId";
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

    private function getCont($id,$lang)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goodshaslang_content from goodshaslang WHERE goods_id=$id AND lang_id=$lang";
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
        return $goods[0]['goodshaslang_content'];
    }

    private function writeCont($id,$lang,$cont)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="UPDATE goodshaslang SET goodshaslang_content='$cont' WHERE goods_id=$id AND lang_id=$lang";
        //echo "$query<br>";
        mysqli_query($db_connect,$query);
        mysqli_close($db_connect);
    }

    public function insertVidInFactory($vid,$fId)
    {
        $goods=$this->getGoodsByFactory($fId);
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
            $contRu=$this->getCont($id,1);
            $contUa=$this->getCont($id,3);
            $contRuNew="<p><iframe allowfullscreen=\"\" frameborder=\"0\" height=\"315\" src=\"https://www.youtube.com/embed/".$vid."\" width=\"560\"></iframe></p>".$contRu;
            $contUaNew="<p><iframe allowfullscreen=\"\" frameborder=\"0\" height=\"315\" src=\"https://www.youtube.com/embed/".$vid."\" width=\"560\"></iframe></p>".$contUa;
            $this->writeCont($id,1,$contRuNew);
            $this->writeCont($id,3,$contUaNew);

        }
    }

}

$test=new InsVid();
//$test->insertVidInFactory("Je0jClGqVO8",8);
$test->insertVidInFactory("Je0jClGqVO8",9);
$test->insertVidInFactory("Je0jClGqVO8",10);
echo "Done!";