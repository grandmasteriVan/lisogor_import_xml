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

class Analitcs
{
    private function ReadFile ($name)
    {
        $file=file_get_contents($name);
        $fileArr=explode(PHP_EOL,$file);
        //var_dump ($fileArr);
        foreach ($fileArr as $record)
        {
            $tmp=explode(';',$record);
            if (strripos($tmp[0],".html")!=false)
            {
                $tmp[0]=str_ireplace("/","",$tmp[0]);
                $tmp1=explode('.html',$tmp[0]);
                //$tmp1=$tmp1[0].".html";
                $tmp[0]=$tmp1[0];
                $returnArr[]=$tmp;
            }
            //break;
            
        }
        return $returnArr;
    }

    public function getLinks()
    {
        $list=$this->ReadFile('Analytics.txt');
        //echo "<pre>";
        //print_r($list);
        //echo "</pre>";
        $urls=$this->getURLSByCat(20);
        //echo "<pre>";
        //print_r($urls);
        //echo "</pre>";
        foreach ($urls as $url)
        {
            //echo "<b>".$url['goodshaslang_url']."</b><br>";
            foreach ($list as $entry)
            {
                //echo $entry[0]."<br>";
                if ($url['goodshaslang_url']==$entry[0])
                {
                    echo "https://fayni-mebli.com/".$entry[0].".html;".$entry[1].";<br>";
                    //break;
                }
            }
            //break;
        }
        

    }

    private function getURLSByCat($cat_id)
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT goodshaslang_url, goods_id FROM goodshaslang WHERE lang_id=1 AND goods_id in (SELECT goods_id from goodshascategory WHERE category_id=$cat_id)";
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
}

$test=new Analitcs();
$test->getLinks();