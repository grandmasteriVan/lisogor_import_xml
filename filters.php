<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 23.02.17
 * Time: 15:19
 */
define ("host","localhost");
//define ("host","10.0.0.2");
/**
 * database username
 */
define ("user", "root");
//define ("user", "uh333660_mebli");
/**
 * database password
 */
define ("pass", "");
//define ("pass", "Z7A8JqUh");
/**
 * database name
 */
define ("db", "mebli");
//define ("db", "uh333660_mebli");
class Filter
{
    public function test()
    {
        /*$tables=$this->getTables();
        echo "<pre>";
        print_r($tables);
        echo "<pre>";*/
        //$this->getRTables();
        $test=$this->getValues();
        //echo "<pre>";
        //print_r($test);
        //echo "</pre>";
        $this->getEqualInOne($test);
    }
    private function getValues()
    {
        $tables_list=$this->getRTables();
        if (is_array($tables_list))
        {
            $db_connect=&$this->getConnection();
            unset($tab);
            foreach ($tables_list as $table)
            {
                $query="SELECT * FROM $table";
                if ($res=mysqli_query($db_connect,$query))
                {
                    unset ($values);
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        array_push($row,"$table");
						$values[] = $row;
						//array_push($values[],$row);
						//break;
                    }
					/*echo "<pre>";
					print_r($values);
					echo "</pre>";*/
					/*if (is_array($values))
					{
						foreach ($values as $value)
						{
							$val_id=$table."_id";
							$val_name=$table."_name";
							$tab_tmp["$table"]['id']=$value["$val_id"];
							$tab_tmp["$table"]['value']=$value["$val_name"];
							$tab[]=$tab_tmp;
						}	
					}
					else
					{
						echo "table $table is empty! <br>";
					}*/
										
					//echo "table name: $table<br>";
					//$tab[]=array(["$table"],$values);
					//array_push($values,"$table");
                    $tab["$table"]=$values;
                    //$tab[]=$values;
					
                }
				//break;
            }
            return $tab;
        }
        else
        {
            return null;
        }
    }
    private function getEqualInOne($tabs)
    {
        if (is_array($tabs))
        {
            foreach ($tabs as $tab)
            {
                //echo "<pre>";
                //print_r($tab);
                //echo "</pre>";
				//break;
				for ($i=0;$i<count($tab);$i++)
				{
					//print_r ($tab);
					//echo "<br>------------------------------------------<br>";
					//print_r ($tab[$i]);// $tab[i][0]."<br>"; 
					$name_val=$tab[$i][0]."_name";
					$tab[$i]["$name_val"]=ucfirst($tab[$i]["$name_val"]);
					$newArr[]=array($tab[$i][0],$tab[$i]["$name_val"]);
				}
            }
			echo "<pre>";
            print_r($newArr);
            echo "</pre>";
        }
        else
        {
            echo "No Array!";
        }
    }
    private function getTables()
    {
        $db_connect=$this->getConnection();
        $query="show tables";
        if ($res=mysqli_query($db_connect,$query))
        {
            unset($tables);
            while ($row = mysqli_fetch_assoc($res))
            {
                $tables[] = $row;
            }
        }
        $this->breakConnection($db_connect);
		return $tables;
    }
    private function getRTables()
    {
        $tables=$this->getTables();
        unset ($rTables);
		foreach ($tables as $table)
        {
            $table_name=$table['Tables_in_mebli'];
			//echo "$table_name";
			if ((mb_substr($table_name,0,1)=='r')&&(strcasecmp($table_name,'reviewpict')!=0)&&(strcasecmp($table_name,'review')!=0))
            {
                $rTables[]=$table_name;
				//echo $table_name."<br>";
            }
        }
		return $rTables;
    }
    private function getConnection()
    {
        return $db_connect=mysqli_connect(host,user,pass,db);
    }
    private function breakConnection($db_connect)
    {
        mysqli_close($db_connect);
    }
}
$test=new Filter();
$test->test();
