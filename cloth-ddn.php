<?php 

/**
 * Скрипт для изменений фоток галереи (для конкретного товара)
 * параметр ID обязательный
 */
header('Content-type: text/html; charset=UTF-8');
//require 'autoload.php';
ini_set('display_errors', 1);
ini_set('max_execution_time', 720000);

define ("host","localhost");
define ("user", "u_ddnPZS");
define ("pass", "A8mnsoHf");
define ("db", "ddnPZS");

class Cloth

{
    private function delCloth($cloth_id)
	{
        $db_connect=mysqli_connect(host,user,pass,db);
        //удаляем ткань
		$query="DELETE FROM cloth WHERE cloth_id=$cloth_id";
		//echo "$query<br>";
        mysqli_query($db_connect,$query);
        //удаляем файлы
        $query="DELETE FROM clothfile WHERE cloth_id=$cloth_id";
		//echo "$query<br>";
        mysqli_query($db_connect,$query);
        //удаляем связанные категории
        $query="DELETE FROM clothhastissue WHERE cloth_id=$cloth_id";
		//echo "$query<br>";
        mysqli_query($db_connect,$query);
        //удаляем связанные языки
        $query="DELETE FROM clothhaslang WHERE cloth_id=$cloth_id";
		//echo "$query<br>";
		mysqli_query($db_connect,$query);
		mysqli_close($db_connect);
    }

    private function getClothes()
    {
        $db_connect=mysqli_connect(host,user,pass,db);
		$query="SELECT cloth_id, clothtype_id from cloth";
		if ($res=mysqli_query($db_connect,$query))
		{
				while ($row = mysqli_fetch_assoc($res))
				{
					$cloth_all[] = $row;
				}
		}
		else
		{
			 echo "Error in SQL: $query<br>";		
        }
        mysqli_close($db_connect);
        return $cloth_all;
    }

    public function test()
    {
        $clothes=$this->getClothes();
        //var_dump ($clothes);
        $currentType=1;
        $count=0;
        foreach ($clothes as $cloth)
        {
            $id=$cloth['cloth_id'];
            $type=$cloth['clothtype_id'];
            if ($type==$currentType)
            {
                echo "<pre>";
                print_r($cloth);
                echo "/<pre>";
                //var_dump ($cloth);
                //$count++;
                $currentType++;
            }
            else
            {
                $this->delCloth($id);
            }
            if ($currentType==16)
            {
                $currentType=17;
            }
            if ($currentType==20)
            {
                $currentType=22;
            }
            
        }
    }
    

}

$test = new Cloth();
$test->test();
