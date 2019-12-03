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
//define ("db", "fm_new");
define ("db", "newfm");

class SetProdOut
{
    private $file;
	
	function __construct($file)
    {
		$this->file=file_get_contents($file);
    }
	
	private function get1C()
	{
        $price=explode(PHP_EOL,$this->file);
        foreach ($price as $p)
        {
            $code=explode(";",$p);
            $codes1c[]=$code[1];
        }
		return $codes1c;	
    }
    
    private function setOut($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="UPDATE goods SET goods_productionout=1 WHERE goods_id=$id";
		echo "$query<br>";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
    }

    private function getCode1C($id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_article_1c  FROM goods WHERE goods_id=$id";
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
            return $goods[0]['goods_article_1c'];
        }
        else
        {
            return null;
        }    
    }

    private function getGoodsByFactory ($f_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
        $query="SELECT goods_id FROM goodshasfeature WHERE feature_id=232 AND goodshasfeature_valueid=$f_id";
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

    public function test($fId)
    {
        $goods=$this->getGoodsByFactory($fId);
        $goods1c=$this->get1C();
        //var_dump ($goods1c);
        
        foreach ($goods as $good)
        {
            $prodOut=true;
            $code1C=" ".$this->getCode1C($good['goods_id']);
            foreach ($goods1c as $good1C)
            {
                if (strripos($code1C,$good1C))
                {
                    $prodOut=false;
                    //echo "$code1C-$good1C<br>";
                    //break;
                }
            }
            if ($prodOut)
            {
                $this->setOut($good['goods_id']);
                echo "$code1C<br>";
            }
        }
    }
}

$test= new SetProdOut('test.txt');
$test->test(181);