<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 15.09.16
 * Time: 14:48
 */
/**
 * database host
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
/**
 *
 */
function copy_review_sof()
{
    //сначала мы выбираем все диваны фабрики софиевка
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM goods WHERE factory_id=4";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            //список всех диванв софиевки
            $divs_sof[] = $row;
        }
		//echo "<pre>";
		//print_r($divs_sof);
		//echo "</pre>";
        foreach ($divs_sof as $div_sof)
        {
            //находим все отзвывы к конкретному дивану
            $id_sof=$div_sof['goods_id'];
            $name_sof=$div_sof['goods_name'];
            $url_sof=$div_sof['goods_url'];
			echo "$url_sof<br>";
            $query="SELECT * FROM review WHERE url_id IN".
                "(SELECT url_id FROM url WHERE url_name='$url_sof')";
			unset ($reviews);
            if ($res=mysqli_query($db_connect,$query))
            {
                
				while ($row = mysqli_fetch_assoc($res))
                {
                    //все отзывы по конкретному дивану
                    $reviews[] = $row;
                }
				echo "<pre>";
				print_r($reviews);
				echo "</pre>";
				//для каждого отзыва
                if (is_array ($reviews))
				{
					foreach ($reviews as $review)
					{
						$rev_id=$review['review_id'];
						$rev_text=$review['review_content'];
						$name_trunc=str_replace(UTF8toCP1251("Диван "),"",$name_sof);
						$name_trunc=preg_replace('/\d/','',$name_trunc);
						//$name_trunc=str_replace(' ','',$name_trunc);
						echo "name_trunc: $name_trunc<br>";
						echo "rev_text: $rev_text<br>";
						//$name_trunc=UTF8toCP1251($name_trunc);
						//проверяем есть ли в тексте отзыва название дивана
						if (mb_strpos ($rev_text,$name_trunc)==false)
						{
                            //копируем поля старого отзыва
						    $rev_active=$review['review_active'];
                            $rev_created=$review['review_created'];
                            $rev_username=$review['review_username'];
                            $rev_mail=$review['review_useremail'];
                            $rev_ip=$review['review_ip'];
                            $rev_rating=$review['review_rating'];
                            $rev_parent=$review['review_parent'];
                            $rev_show=$review['review_showonsite'];
                            $rev_phone=$review['review_phone'];
                            $rev_fio=$review['review_fio'];
                            $rev_money=$review['review_sendmoney'];
                            $rev_money50=$review['review_sendmoney50'];
                            $rev_money70=$review['review_sendmoney70'];
                            
						    //если не встретили название, то добавляем новый отзыв
							$query="SELECT url_id, url_name FROM url WHERE url_name=(SELECT goods_url FROM goods WHERE goods_name_manager='$name_sof' AND factory_id=136)";
							unset ($urls_keiv);
							if ($res=mysqli_query($db_connect,$query))
							{
                                while ($row = mysqli_fetch_assoc($res))
								{
									//
									$urls_keiv[] = $row;
								}
								foreach ($urls_keiv as $url_keiv)
								{
									$new_url=$url_keiv['url_id'];
                                    $name_kiev=str_replace('-',' ',$url_keiv['url_name']);
                                    $name_kiev=str_replace('mod','',$name_kiev);
                                    $name_kiev=preg_replace('/\d/','',$name_kiev);
									$query="INSERT INTO review (review_name, review_active, review_created, review_content, review_username, ".
                                        "review_useremail, review_ip, review_rating, review_parent, review_showonsite, review_phone, ".
                                        "review_fio, review_sendmoney, review_sendmoney50, review_sendmoney70, url_id) ".
                                        "VALUES ('$name_kiev', $rev_active, STR_TO_DATE('$rev_created', '%Y-%m-%d %H:%i:%s'), '$rev_text', '$rev_username', '$rev_mail', ".
                                        "'$rev_ip', $rev_rating, $rev_parent, $rev_show, '$rev_phone', '$rev_fio', $rev_money, $rev_money50, $rev_money70, $new_url)";
									mysqli_query($db_connect,$query);
									echo "$query <br>";
                                    //а теперь копируем рисунки к нему
                                    $new_rev_id=mysqli_insert_id($db_connect);
                                    $query="SELECT * FROM reviewpict WHERE review_id=$rev_id";
                                    unset($old_revs);
                                    if ($res=mysqli_query($db_connect,$query))
                                    {
                                        
										while ($row = mysqli_fetch_assoc($res))
                                        {
                                            //
                                            $old_revs[] = $row;
                                        }
                                        foreach ($old_revs as $old_rev)
                                        {
											
                                            $pict_name=$old_rev['reviewpict_name'];
                                            $pict_active=$old_rev['reviewpict_active'];
                                            $file=$old_rev['reviewpict_filename'];
                                            $file_ext=$old_rev['reviewpict_ext'];
                                            $query="INSERT INTO reviewpict (reviewpict_name, reviewpict_active, ".
                                                "reviewpict_filename, reviewpict_ext, review_id) ".
                                                "VALUES ('$pict_name', $rev_active, '$file', '$file_ext', $new_rev_id)";
                                            mysqli_query($db_connect,$query);
                                            echo "new review pict: $query <br>";
											$new_pict_id=mysqli_insert_id($db_connect);
											echo "new pict id: $new_pict_id";
											$old=$_SERVER['DOCUMENT_ROOT']."/content/review/".$rev_id;
											$new=$_SERVER['DOCUMENT_ROOT']."/content/review/".$new_rev_id;
											mkdir($new."/", 0777);
											$hendle = opendir($old);
											while ($file1 = readdir($hendle))
											{
												echo "$file1<br>";
												if (mb_strpos($file1,"review"))
												{
													if(!copy($old."/".$file1, $new."/".$file1."_$new_pict_id")) 
													{
														print ("при копировании файла $file произошла ошибка...<br>\n");
													}
													else
													{
														echo "файл $new/$file1_$new_pict_id скопирован<br>";
													}
												}
												if (mb_strpos($file1,$file)===0)
												{
													if(!copy($old."/".$file1, $new."/".$file1."_$new_pict_id"))
													{
														print ("при копировании файла $file произошла ошибка...<br>\n");
													}
													else
													{
														echo "файл $new/$file1 скопирован<br>";
													}
												}
											}
											
											closedir($hendle);
											
											
                                        }
										//$old=$_SERVER['DOCUMENT_ROOT']."/content/review/".$rev_id;
										//$new=$_SERVER['DOCUMENT_ROOT']."/content/review/".$new_rev_id;
										//echo "Old: $old<br>";
										//copy_files($old, $new);
										
                                    }
								}
							}
						}
					}
				}
				else
				{
					echo "has not a review!<br>";
				}
				
            }
        }
    }
    mysqli_close($db_connect);
}
$runtime = new Timer();
$runtime->setStartTime();
copy_review_sof();
$runtime->setEndTime();
echo "<br> runtime=".$runtime->getRunTime()." sec <br>";
/**
 * Class Timer
 * замеряем время выполнения скрипта
 */
class Timer
{
    /**
     * @var время начала выпонения
     */
    private $start_time;
    /**
     * @var время конца выполнения
     */
    private $end_time;
    /**
     * встанавливаем время начала выполнения скрипта
     */
    public function setStartTime()
    {
        $this->start_time = microtime(true);
    }
    /**
     * устанавливаем время конца выполнения скрипта
     */
    public function setEndTime()
    {
        $this->end_time = microtime(true);
    }
    /**
     * @return mixed время выполения
     * возвращаем время выполнения скрипта в секундах
     */
    public function getRunTime()
    {
        return $this->start_time-$this->end_time;
    }
}
/**
 * функция преобразовывает строку в кодировке  UTF-8 в строку в кодировке CP1251
 * @param $str string входящяя строка в кодировке UTF-8
 * @return string строка перобразованная в кодировку CP1251
 */
function UTF8toCP1251($str)
{ // by SiMM, $table from http://ru.wikipedia.org/wiki/CP1251
    static $table = array("\xD0\x81" => "\xA8", // Ё
        "\xD1\x91" => "\xB8", // ё
        // украинские символы
        "\xD0\x8E" => "\xA1", // Ў (У)
        "\xD1\x9E" => "\xA2", // ў (у)
        "\xD0\x84" => "\xAA", // Є (Э)
        "\xD0\x87" => "\xAF", // Ї (I..)
        "\xD0\x86" => "\xB2", // I (I)
        "\xD1\x96" => "\xB3", // i (i)
        "\xD1\x94" => "\xBA", // є (э)
        "\xD1\x97" => "\xBF", // ї (i..)
        // чувашские символы
        "\xD3\x90" => "\x8C", // &#1232; (А)
        "\xD3\x96" => "\x8D", // &#1238; (Е)
        "\xD2\xAA" => "\x8E", // &#1194; (С)
        "\xD3\xB2" => "\x8F", // &#1266; (У)
        "\xD3\x91" => "\x9C", // &#1233; (а)
        "\xD3\x97" => "\x9D", // &#1239; (е)
        "\xD2\xAB" => "\x9E", // &#1195; (с)
        "\xD3\xB3" => "\x9F", // &#1267; (у)
    );
    //цифровая магия
    $str = preg_replace('#([\xD0-\xD1])([\x80-\xBF])#se',
        'isset($table["$0"]) ? $table["$0"] :
                         chr(ord("$2")+("$1" == "\xD0" ? 0x30 : 0x70))
                        ',
        $str
    );
    $str = str_replace("i", "і", $str);
    $str = str_replace("I", "І", $str);
    return $str;
}

/*function copy_files($source, $res, $id)
{ 
	mkdir($res."/", 0777);
    $hendle = opendir($source); // открываем директорию 
    while ($file = readdir($hendle)) { 
        if (($file!=".")&&($file!="..")) { 
            if (is_dir($source."/".$file) == true) { 
                if(is_dir($res."/".$file)!=true) // существует ли папка 
                    mkdir($res."/".$file, 0777); // создаю папку 
                    copy_files ($source."/".$file, $res."/".$file); 
            } 
            else{ 
                if(!copy($source."/".$file, $res."/".$file."_$id")) {  
                    print ("при копировании файла $file произошла ошибка...<br>\n");  
                }// end if copy 
            }  
        } // else $file == .. 
    } // end while 
    closedir($hendle); 
}*/
?>
