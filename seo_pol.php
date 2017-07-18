<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 20.07.16
 * Time: 10:10
 */
//header('Content-Type: text/html; charset=utf-8');
//define ("host","localhost");
define ("host","10.0.0.2");
/**
 * database username
 */
//define ("user", "root");
define ("user", "uh333660_mebli");
/**
 * database password
 */
//define ("pass", "");
define ("pass", "Z7A8JqUh");
/**
 * database name
 */
//define ("db", "mebli");
define ("db", "uh333660_mebli");
/**
 * заполняет СЕО поля по фабрике Velam
 */
 
function seo_velam_matr()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM goods WHERE goodskind_id=40 AND factory_id=137";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[]=$row;
        }
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
            $name=$good['goods_name'];
            $header=$good['goods_name'];
            $name_trunc=str_replace(UTF8toCP1251("Матрас "),"",$name);
            $title=$name_trunc.UTF8toCP1251(" матрас. Купить матрасы со склада в Киеве");
            $keywords=UTF8toCP1251("матрасы, ").$name.UTF8toCP1251(", склад мебели, купить матрас, интернет магазин мебели, недорогие матрасы, цены, фото, отзывы.");
            $key_h=UTF8toCP1251("Фабрика Velam. ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
            $key_f=UTF8toCP1251("Фабрика Velam. ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
            $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
            $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
            mysqli_query($db_connect,$query);
            //echo $query."<br>";
            //$header=$good['goods_header'];
            /*$title=$good['goods_title'];
            $keywords=$good['goods_keyw'];
            $key_h=$good['goods_hkeyw'];
            $key_f=&$good['goods_fkeyw'];
            $desc=$good['goods_desc'];*/
            //break;
        }
    }
    $query="SELECT * FROM goods WHERE goodskind_id=88 AND factory_id=137";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[]=$row;
        }
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
            $name=$good['goods_name'];
            $header=$good['goods_name'];
            $name_trunc=str_replace(UTF8toCP1251("Наматрасник "),"",$name);
            $title=$name_trunc.UTF8toCP1251(" наматрасник. Купить наматрасники со склада в Киеве");
            $keywords=UTF8toCP1251("наматрасники, ").$name.UTF8toCP1251(", склад мебели, купить наматрасник, интернет магазин мебели, недорогие наматрасники, цены, фото, отзывы.");
            $key_h=UTF8toCP1251("Фабрика Velam. ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
            $key_f=UTF8toCP1251("Фабрика Velam. ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
            $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
            $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
            mysqli_query($db_connect,$query);
            //echo $query."<br>";
            //$header=$good['goods_header'];
            /*$title=$good['goods_title'];
            $keywords=$good['goods_keyw'];
            $key_h=$good['goods_hkeyw'];
            $key_f=&$good['goods_fkeyw'];
            $desc=$good['goods_desc'];*/
            //break;
        }
    }
    mysqli_close($db_connect);
}
/**
 *заполняет СЕО поля по фабрике ДОМ
 */
function seo_kupe_dom()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM goods WHERE goodskind_id=35 AND factory_id=47";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[]=$row;
        }
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
            $name=$good['goods_name'];
            
            $header=$good['goods_name'];
            $name_trunc=str_replace(UTF8toCP1251("Шкаф-купе "),"",$name);
			$title=$name_trunc.UTF8toCP1251(" шкаф-купе. Купить шкафы-купе со склада в Киеве");
			$keywords=UTF8toCP1251("шкафы-купе, ").$name.UTF8toCP1251(", склад мебели, купить шкаф-купе, интернет магазин мебели, недорогие шкафы-купе, цены, фото, отзывы.");
			$key_h=UTF8toCP1251("Фабрика ДОМ. ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
			$key_f=UTF8toCP1251("Фабрика ДОМ. ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
			$desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
            
			$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
			mysqli_query($db_connect,$query);
			//echo $query."<br>";
			//$header=$good['goods_header'];
			/*$title=$good['goods_title'];
            $keywords=$good['goods_keyw'];
            $key_h=$good['goods_hkeyw'];
            $key_f=&$good['goods_fkeyw'];
            $desc=$good['goods_desc'];*/
			//break;
        }
    }
    mysqli_close($db_connect);
}
/**
 * Заполняет СЕО поля по фабрике Софиевка (Киев)
 */
function seo_kiev_sofievka()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM goods WHERE factory_id=136";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[]=$row;
        }
        foreach ($goods as $good)
        {
            $goods_kind=$good['goodskind_id'];
            $id=$good['goods_id'];
            //$name=$good['goods_name'];
			////echo "Goods name: $name<br>";
			
			$name=UTF8toCP1251("Диван ").$header;
            //переименовываем диваны
            if ($goods_kind==23||$goods_kind==26)
            {
                $name=str_replace(UTF8toCP1251("Диван "),"",$good['goods_name']);
				$name=UTF8toCP1251("Диван ").$name;
				//echo "name changed :$name <br>";
				$header=$name;
				
				$name_trunc=str_replace(UTF8toCP1251("Диван "),"",$name);
                $title=$name_trunc.UTF8toCP1251(" диван. Купить диван со склада в Киеве");
                $keywords=UTF8toCP1251("диваны, ").$name.UTF8toCP1251(", склад мебели, купить диван, интернет магазин мебели, недорогие диваны, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика Киев. ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика Киев. ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
                //$header=$good['goods_header'];
                /*$title=$good['goods_title'];
                $keywords=$good['goods_keyw'];
                $key_h=$good['goods_hkeyw'];
                $key_f=&$good['goods_fkeyw'];
                $desc=$good['goods_desc'];*/
                //break;
            }
            //переименовываем кресла
            if ($goods_kind==24)
            {
				$name=str_replace(UTF8toCP1251("Кресло "),"",$good['goods_name']);
				$name=UTF8toCP1251("Кресло ").$name;
				//echo "name changed :$name <br>";
				$header=$name;
                $name_trunc=str_replace(UTF8toCP1251("Кресло "),"",$name);
                $title=$name_trunc.UTF8toCP1251(" кресло. Купить кресло со склада в Киеве");
                $keywords=UTF8toCP1251("кресла, ").$name.UTF8toCP1251(", склад мебели, купить кресла, интернет магазин мебели, недорогие кресла, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика Киев. ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика Киев. ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
            }
        }
    }
    mysqli_close($db_connect);
}
/**
 * заполняет СЕО поля по фабрике МКС
 */
function seo_mks()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM goods WHERE factory_id=134";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[]=$row;
        }
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
            $name=$good['goods_name'];
            $header=$good['goods_name'];
            $name_trunc=str_replace(UTF8toCP1251("Диван "),"",$name);
            $title=$name_trunc.UTF8toCP1251(" диван. Купить диван со склада в Киеве");
            $keywords=UTF8toCP1251("диваны, ").$name.UTF8toCP1251(", склад мебели, купить диван, интернет магазин мебели, недорогие диваны, цены, фото, отзывы.");
            $key_h=UTF8toCP1251("Фабрика МКС. ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
            $key_f=UTF8toCP1251("Фабрика МКС. ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
            $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
            $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
            mysqli_query($db_connect,$query);
            //echo $query."<br>";
            //$header=$good['goods_header'];
            /*$title=$good['goods_title'];
            $keywords=$good['goods_keyw'];
            $key_h=$good['goods_hkeyw'];
            $key_f=&$good['goods_fkeyw'];
            $desc=$good['goods_desc'];*/
			//break;
        }
    }
    mysqli_close($db_connect);
}
/**
 * заполняет СЕО поля по фабрике ЛВС
 */
function seo_lvs()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM goods WHERE factory_id=138";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[]=$row;
        }
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
            $name=$good['goods_name'];
            $header=$good['goods_name'];
            $tcharter=$good['goods_maintcharter'];
            if ($tcharter==1)
            {
                $name_trunc=str_replace(UTF8toCP1251("Диван "),"",$name);
                $title=$name_trunc.UTF8toCP1251(" диван. Купить диван со склада в Киеве");
                $keywords=UTF8toCP1251("диваны, ").$name.UTF8toCP1251(", склад мебели, купить диван, интернет магазин мебели, недорогие диваны, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика ЛВС. ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика ЛВС. ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
            }
            if ($tcharter==2)
            {
                $name_trunc=str_replace(UTF8toCP1251("Кресло "),"",$name);
                $title=$name_trunc.UTF8toCP1251(" кресло. Купить кресло со склада в Киеве");
                $keywords=UTF8toCP1251("кресла, ").$name.UTF8toCP1251(", склад мебели, купить кресло, интернет магазин мебели, недорогие кресла, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика ЛВС. ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика ЛВС. ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
            }
            //$header=$good['goods_header'];
            /*$title=$good['goods_title'];
            $keywords=$good['goods_keyw'];
            $key_h=$good['goods_hkeyw'];
            $key_f=&$good['goods_fkeyw'];
            $desc=$good['goods_desc'];*/
            //break;
        }
    }
    mysqli_close($db_connect);
}
/**
 * Заполняет СЕО поля по фабрике ФанДеск
 */
function seo_fundesk()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM goods WHERE factory_id=139";
	if ($res=mysqli_query($db_connect,$query))
	{
		while ($row = mysqli_fetch_assoc($res))
        {
            $goods[]=$row;
        }
		foreach ($goods as $good)
		{
			$id=$good['goods_id'];
            $name=$good['goods_name'];
            $header=$good['goods_name'];
            $tcharter=$good['goods_maintcharter'];
			if ($tcharter==63)
			{
				$name_trunc=str_replace(UTF8toCP1251("Детская парта "),"",$name);
				$name_trunc=str_replace(UTF8toCP1251("Детская парта-"),"",$name);
                $title=$name_trunc.UTF8toCP1251(" парта. Купить парту со склада в Киеве");
                $keywords=UTF8toCP1251("парты, ").$name.UTF8toCP1251(", склад мебели, купить парту, интернет магазин мебели, недорогие парты, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика FunDesk. ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика FunDesk. ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
			}
			if ($tcharter==2)
			{
				$name_trunc=str_replace(UTF8toCP1251("Детское кресло "),"",$name);
				$title=$name_trunc.UTF8toCP1251(" кресло. Купить кресло со склада в Киеве");
                $keywords=UTF8toCP1251("кресла, ").$name.UTF8toCP1251(", склад мебели, купить кресло, интернет магазин мебели, недорогие кресла, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика FunDesk. ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика FunDesk. ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
			}
		}
	}
	mysqli_close($db_connect);
}
function seo_brw()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM goods WHERE factory_id=56";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[]=$row;
        }
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
            $name=$good['goods_name'];
            $header=$good['goods_name'];
            $tcharter=$good['goods_maintcharter'];
            if ($tcharter==126)
            {
                $name_trunc=str_replace(UTF8toCP1251("Стол "),"",$name);
                $name_trunc=str_replace(UTF8toCP1251("детский "),"",$name_trunc);
                $name_trunc=str_replace(UTF8toCP1251("письменный "),"",$name_trunc);
                $title=$name_trunc.UTF8toCP1251(" стол. Купить стол со склада в Киеве");
                $keywords=UTF8toCP1251("столы, ").$name.UTF8toCP1251(", склад мебели, купить стол, интернет магазин мебели, недорогие столы, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика BRW. ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика BRW. ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
            }
            if ($tcharter==33)
            {
                $name_trunc=str_replace(UTF8toCP1251("Детская "),"",$name);
                $name_trunc=str_replace(UTF8toCP1251("кровать "),"",$name_trunc);
                $title=$name_trunc.UTF8toCP1251(" кровать детская. Купить детскую кровать со склада в Киеве");
                $keywords=UTF8toCP1251("детские кровати, ").$name.UTF8toCP1251(", склад мебели, купить кровать детскую, интернет магазин мебели, недорогие детские кровати, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика BRW. ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика BRW. ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
            }
            if ($tcharter==74)
            {
                $name_trunc=str_replace(UTF8toCP1251("Шкаф "),"",$name);
                $name_trunc=str_replace(UTF8toCP1251("угловой "),"",$name_trunc);
                $name_trunc=str_replace(UTF8toCP1251("детский "),"",$name_trunc);
                $name_trunc=str_replace(UTF8toCP1251("Детский "),"",$name_trunc);
                $name_trunc=str_replace(UTF8toCP1251("детский "),"",$name_trunc);
                $title=$name_trunc.UTF8toCP1251(" детский шкаф. Купить детский шкаф со склада в Киеве");
                $keywords=UTF8toCP1251("детские шкафы, ").$name.UTF8toCP1251(", склад мебели, купить детский шкаф, интернет магазин мебели, недорогие детские шкафы, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика BRW. ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика BRW. ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
            }
            if ($tcharter==32)
            {
                $name_trunc=str_replace(UTF8toCP1251("Шкаф "),"",$name);
                $name_trunc=str_replace(UTF8toCP1251("Комод "),"",$name_trunc);
                $name_trunc=str_replace(UTF8toCP1251("комод "),"",$name_trunc);
                $name_trunc=str_replace(UTF8toCP1251("Детский "),"",$name_trunc);
                $name_trunc=str_replace(UTF8toCP1251("детский "),"",$name_trunc);
                $title=$name_trunc.UTF8toCP1251(" детский комод. Купить детский комод со склада в Киеве");
                $keywords=UTF8toCP1251("детские комоды, ").$name.UTF8toCP1251(", склад мебели, купить детский комод, интернет магазин мебели, недорогие детские комоды, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика BRW. ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика BRW. ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
            }
        }
    }
    mysqli_close($db_connect);
}
function seo_karkas()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM goods WHERE goods_maintcharter=98";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[]=$row;
        }
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
            $name=$good['goods_name'];
            $header=$good['goods_name'];
            $factory=$good['factory_id'];
            if ($factory==56)
            {
                $name_trunc=str_replace(UTF8toCP1251("Каркас для кровати "),"",$name);
                $title=$name_trunc.UTF8toCP1251(" каркас для кровати. Купить каркас для кровати со склада в Киеве");
                $keywords=UTF8toCP1251("каркасы, ").$name.UTF8toCP1251(", склад мебели, купить каркас для кровати, интернет магазин мебели, недорогие каркасы, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика BRW. ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика BRW. ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
            }
            if ($factory==123)
            {
                $name_trunc=str_replace(UTF8toCP1251("Каркас для кровати "),"",$name);
                $title=$name_trunc.UTF8toCP1251(" каркас для кровати. Купить каркас для кровати со склада в Киеве");
                $keywords=UTF8toCP1251("каркасы, ").$name.UTF8toCP1251(", склад мебели, купить каркас для кровати, интернет магазин мебели, недорогие каркасы, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика  Мебель сервис. ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика Мебель сервис. ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
            }
            if ($factory==15)
            {
                $name_trunc=str_replace(UTF8toCP1251("Каркас для кровати "),"",$name);
                $title=$name_trunc.UTF8toCP1251(" каркас для кровати. Купить каркас для кровати со склада в Киеве");
                $keywords=UTF8toCP1251("каркасы, ").$name.UTF8toCP1251(", склад мебели, купить каркас для кровати, интернет магазин мебели, недорогие каркасы, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика  Свит меблив. ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика Свит меблив. ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
            }
            if ($factory==16)
            {
                $name_trunc=str_replace(UTF8toCP1251("Каркас для кровати "),"",$name);
                $title=$name_trunc.UTF8toCP1251(" каркас для кровати. Купить каркас для кровати со склада в Киеве");
                $keywords=UTF8toCP1251("каркасы, ").$name.UTF8toCP1251(", склад мебели, купить каркас для кровати, интернет магазин мебели, недорогие каркасы, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика  Сокме. ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика Сокме. ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
            }
        }
    }
    mysqli_close($db_connect);
}
function seo_mej_dveri()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods.goods_id, goods.goods_name, factory.factory_name ".
        "FROM goods JOIN factory ON goods.factory_id=factory.factory_id ".
        "WHERE goods.goods_maintcharter=76";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[] = $row;
        }
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $name=$good['goods_name'];
                $header=$good['goods_name'];
                $factory=$good['factory_name'];
                $factory=str_replace(UTF8toCP1251("Фабрика "),"",$factory);
                $name_trunc=str_replace(UTF8toCP1251("Дверь "),"",$name);
                $name_trunc=str_replace(UTF8toCP1251("межкомнатная "),"",$name_trunc);
                $title=$name_trunc.UTF8toCP1251(" межкомнатная дверь. Купить межкомнатную дверь со склада в Киеве");
                $keywords=UTF8toCP1251("межкомнатные двери, ").$name.UTF8toCP1251(", склад мебели, купить межкомнатную дверь, интернет магазин мебели, недорогие межкомнатные двери, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
                //break;
            }
        }
        else
        {
            //echo "No array to work with!";
        }
    }
    mysqli_close($db_connect);
}
function seo_detskaj()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods.goods_id, goods.goods_name, goods.goods_maintcharter, factory.factory_name ".
        "FROM goods JOIN factory ON goods.factory_id=factory.factory_id ".
        "WHERE goods.goods_maintcharter=135 OR goods.goods_maintcharter=134 OR goods.goods_maintcharter=133 ".
        "OR goods.goods_maintcharter=132 OR goods.goods_maintcharter=131 OR goods.goods_maintcharter=130 ".
        "OR goods.goods_maintcharter=129 OR goods.goods_maintcharter=128 OR goods.goods_maintcharter=127 ".
        "OR goods.goods_maintcharter=33 OR goods.goods_maintcharter=74 OR goods.goods_maintcharter=16 ".
        "OR goods.goods_maintcharter=32 OR goods.goods_maintcharter=34 OR goods.goods_maintcharter=63 ".
        "OR goods.goods_maintcharter=71 OR goods.goods_maintcharter=126 OR goods.goods_maintcharter=137 ".
        "OR goods.goods_maintcharter=138 OR goods.goods_maintcharter=140 OR goods.goods_maintcharter=142";
    
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[] = $row;
        }
        if (is_array($goods))
        {
            /*//echo "<pre>";
			print_r ($goods);
			//echo "</pre>";*/
			foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $name=$good['goods_name'];
                $header=$good['goods_name'];
                $factory=$good['factory_name'];
                $factory=str_replace(UTF8toCP1251("Фабрика "),"",$factory);
                $tcharter=$good['goods_maintcharter'];
                //кроватки для новорожденных
                if ($tcharter==127)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Дверь "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("межкомнатная "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" межкомнатная дверь. Купить межкомнатную дверь со склада в Киеве");
                    $keywords=UTF8toCP1251("межкомнатные двери, ").$name.UTF8toCP1251(", склад мебели, купить межкомнатную дверь, интернет магазин мебели, недорогие межкомнатные двери, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                    //break;
                }
                //детские стульчики
                if ($tcharter==128)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Стул "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("стул "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("-трансформер "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("Детский "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("Детское "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("кресло "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" детский стул. Купить детский стул со склада в Киеве");
                    $keywords=UTF8toCP1251("десткие стулья, ").$name.UTF8toCP1251(", склад мебели, купить детский стул, интернет магазин мебели, недорогие детские стулья, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                    //break;
                }
                //Мольберты
                if ($tcharter==129)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Мольберт "),"",$name);
                    $title=$name_trunc.UTF8toCP1251(" мольберт. Купить мольберты со склада в Киеве");
                    $keywords=UTF8toCP1251("десткие мольберты, ").$name.UTF8toCP1251(", склад мебели, купить детский мольберт, интернет магазин мебели, недорогие детские мольберты, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                    //break;
                }
                //Песочницы
                if ($tcharter==130)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Детская "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("Песочница "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("песочница "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" песочница. Купить пеосчницы со склада в Киеве");
                    $keywords=UTF8toCP1251("десткие песочницы, ").$name.UTF8toCP1251(", склад мебели, купить детскую песочницу, интернет магазин мебели, недорогие детские пеосчницы, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                    //break;
                }
                //сухие бассейны
                if ($tcharter==131)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Сухой "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("басейн "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" сухой басейн. Купить сухие басейны со склада в Киеве");
                    $keywords=UTF8toCP1251("сухие басейны, ").$name.UTF8toCP1251(", склад мебели, купить сухой басейн, интернет магазин мебели, недорогие сухие басейны, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                    //break;
                }
                //качели
                if ($tcharter==132)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Качеля "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("Качель "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("Карусель "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("Детская "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" качель. Купить качели со склада в Киеве");
                    $keywords=UTF8toCP1251("десткие качели, ").$name.UTF8toCP1251(", склад мебели, купить детскую качелю, интернет магазин мебели, недорогие детские качели, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                    //break;
                }
                //детские горки
                if ($tcharter==133)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Детская "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("Горка "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("горка "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" горка. Купить горки со склада в Киеве");
                    $keywords=UTF8toCP1251("десткие горки, ").$name.UTF8toCP1251(", склад мебели, купить детскую горку, интернет магазин мебели, недорогие детские горки, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                    //break;
                }
                //детские спортивные комплексы
                if ($tcharter==135)
                {
                    $title=$name_trunc.UTF8toCP1251(" спортивный комплекс. Купить спортивные комплексы со склада в Киеве");
                    $keywords=UTF8toCP1251("десткие спортивные комплексы, ").$name.UTF8toCP1251(", склад мебели, купить детский спортивный комплекс, интернет магазин мебели, недорогие детские спортивные комплексы, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                    //break;
                }
                //игровые комплексы
                if ($tcharter==130)
                {
                    $name_trunc=str_replace(UTF8toCP1251("игровой "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("комплекс "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("песочница "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("Детская "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("Детский "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("площадка "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" игровой комплекс. Купить игровой комплекс со склада в Киеве");
                    $keywords=UTF8toCP1251("десткие игровые комплексы, ").$name.UTF8toCP1251(", склад мебели, купить детский игровой комплекс, интернет магазин мебели, недорогие детские игровые комплексы, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                    //break;
                }
                //пеленаторы
                if ($tcharter==138)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Пеленатор "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("комод-пеленатор "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" пеленатор. Купить пеленаторы со склада в Киеве");
                    $keywords=UTF8toCP1251("пеленаторы, ").$name.UTF8toCP1251(", склад мебели, купить пеленатор, интернет магазин мебели, недорогие пеленаторы, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                    //break;
                }
                //детские домики
                if ($tcharter==140)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Домик "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("Детский "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("домик "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" детские домик. Купить детские домики со склада в Киеве");
                    $keywords=UTF8toCP1251("десткие домики, ").$name.UTF8toCP1251(", склад мебели, купить детский домик, интернет магазин мебели, недорогие детские домики, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                    //break;
                }
                //стульчики для кормления
                if ($tcharter==142)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Стульчик "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("для кормления "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" стульчик для кормления. Купить стульчики для кормления со склада в Киеве");
                    $keywords=UTF8toCP1251("стульчики для кормления, ").$name.UTF8toCP1251(", склад мебели, купить стульчик для кормления, интернет магазин мебели, недорогие стульчики для кормления, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                    //break;
                }
                //Песочницы
                if ($tcharter==130)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Детская "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("Песочница "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("песочница "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" песочница. Купить пеосчницы со склада в Киеве");
                    $keywords=UTF8toCP1251("десткие песочницы, ").$name.UTF8toCP1251(", склад мебели, купить детскую песочницу, интернет магазин мебели, недорогие детские пеосчницы, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                    //break;
                }
                //детские кровати
                if ($tcharter==33)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Детская "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("кровать "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" кровать детская. Купить детскую кровать со склада в Киеве");
                    $keywords=UTF8toCP1251("детские кровати, ").$name.UTF8toCP1251(", склад мебели, купить кровать детскую, интернет магазин мебели, недорогие детские кровати, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу Києві. Доставка по Україні");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                }
                //батуты детские
                if ($tcharter==130)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Батут "),"",$name);
                    $title=$name_trunc.UTF8toCP1251(" батут. Купить батуты со склада в Киеве");
                    $keywords=UTF8toCP1251("десткие батуты, ").$name.UTF8toCP1251(", склад мебели, купить детский батут, интернет магазин мебели, недорогие детские бвтуты, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                    //break;
                }
                //детские шкафы
                if ($tcharter==74)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Шкаф "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("угловой "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("детский "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("Детский "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("детский "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" детский шкаф. Купить детский шкаф со склада в Киеве");
                    $keywords=UTF8toCP1251("детские шкафы, ").$name.UTF8toCP1251(", склад мебели, купить детский шкаф, интернет магазин мебели, недорогие детские шкафы, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                }
                //детские комнаты
                if ($tcharter==16)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Детская "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("комната "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" детская комната. Купить детскую комнату со склада в Киеве");
                    $keywords=UTF8toCP1251("детские комнаты, ").$name.UTF8toCP1251(", склад мебели, купить детскую комнату, интернет магазин мебели, недорогие детские комнаты, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                }
            }
        }
        else
        {
            //echo "No array to work with!<br>";
        }
    }
	else
	{
		//echo "error in SQL<br>";
	}
	mysqli_close($db_connect);
}
function seo_ent_door()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods.goods_id, goods.goods_name, factory.factory_name ".
        "FROM goods JOIN factory ON goods.factory_id=factory.factory_id ".
        "WHERE goods.goods_maintcharter=77";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[] = $row;
        }
        if (is_array($goods))
        {
            foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $name=$good['goods_name'];
                $header=$good['goods_name'];
                $factory=$good['factory_name'];
                $factory=str_replace(UTF8toCP1251("Фабрика "),"",$factory);
                $name_trunc=str_replace(UTF8toCP1251("дверь "),"",$name);
                $name_trunc=str_replace(UTF8toCP1251("Входная "),"",$name_trunc);
                $title=$name_trunc.UTF8toCP1251(" входная дверь. Купить входную дверь со склада в Киеве");
                $keywords=UTF8toCP1251("входные двери, ").$name.UTF8toCP1251(", склад мебели, купить входную дверь, интернет магазин мебели, недорогие входные двери, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
                //break;
            }
        }
        else
        {
            //echo "No array to work with!";
        }
    }
    mysqli_close($db_connect);
}
function seo_dalio()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM goods WHERE factory_id=153";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[]=$row;
        }
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
            $name=$good['goods_name'];
            $header=$good['goods_name'];
            $tcharter=$good['goods_maintcharter'];
            if ($tcharter==1||$tcharter==38)
            {
                $name_trunc=str_replace(UTF8toCP1251("Диван "),"",$name);
                $name_trunc=str_replace(UTF8toCP1251(" угловой"),"",$name_trunc);
                $title=$name_trunc.UTF8toCP1251(" диван. Купить диван со склада в Киеве");
                $keywords=UTF8toCP1251("диваны, ").$name.UTF8toCP1251(", склад мебели, купить диван, интернет магазин мебели, недорогие диваны, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика ")."Dalio. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика ")."Dalio. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
            }
            if ($tcharter==2)
            {
                $name_trunc=str_replace(UTF8toCP1251("Кресло "),"",$name);
                $title=$name_trunc.UTF8toCP1251(" кресло. Купить кресло со склада в Киеве");
                $keywords=UTF8toCP1251("кресла, ").$name.UTF8toCP1251(", склад мебели, купить кресло, интернет магазин мебели, недорогие кресла, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика ")."Dalio. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика ")."Dalio. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
            }
            if ($tcharter==13)
            {
                $name_trunc=str_replace(UTF8toCP1251("Кровать "),"",$name);
                $title=$name_trunc.UTF8toCP1251(" кровать. Купить кровать со склада в Киеве");
                $keywords=UTF8toCP1251("кровати, ").$name.UTF8toCP1251(", склад мебели, купить кровати, интернет магазин мебели, недорогие кровати, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика ")."Dalio. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика ")."Dalio. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
            }
            
        }
    }
    mysqli_close($db_connect);
}
function seo_vesta()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM goods WHERE factory_id=156";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[]=$row;
        }
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
            $name=$good['goods_name'];
            $header=$good['goods_name'];
            $tcharter=$good['goods_maintcharter'];
            if ($tcharter==1||$tcharter==38)
            {
                $name_trunc=str_replace(UTF8toCP1251("Диван "),"",$name);
                $name_trunc=str_replace(UTF8toCP1251(" угловой"),"",$name_trunc);
                $title=$name_trunc.UTF8toCP1251(" диван. Купить диван со склада в Киеве");
                $keywords=UTF8toCP1251("диваны, ").$name.UTF8toCP1251(", склад мебели, купить диван, интернет магазин мебели, недорогие диваны, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика Веста ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика Веста ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
            }
            if ($tcharter==2)
            {
                $name_trunc=str_replace(UTF8toCP1251("Кресло "),"",$name);
                $title=$name_trunc.UTF8toCP1251(" кресло. Купить кресло со склада в Киеве");
                $keywords=UTF8toCP1251("кресла, ").$name.UTF8toCP1251(", склад мебели, купить кресло, интернет магазин мебели, недорогие кресла, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика Веста ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика Веста ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
            }
            if ($tcharter==13)
            {
                $name_trunc=str_replace(UTF8toCP1251("Кровать "),"",$name);
                $title=$name_trunc.UTF8toCP1251(" кровать. Купить кровать со склада в Киеве");
                $keywords=UTF8toCP1251("кровати, ").$name.UTF8toCP1251(", склад мебели, купить кровати, интернет магазин мебели, недорогие кровати, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика Веста ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика Веста ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
            }
        }
    }
    mysqli_close($db_connect);
}
function seo_galichina()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM goods WHERE factory_id=157";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[]=$row;
        }
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
            $name=$good['goods_name'];
            $header=$good['goods_name'];
            $tcharter=$good['goods_maintcharter'];
            if ($tcharter==1||$tcharter==38)
            {
                $name_trunc=str_replace(UTF8toCP1251("Диван "),"",$name);
                $name_trunc=str_replace(UTF8toCP1251(" угловой"),"",$name_trunc);
                $title=$name_trunc.UTF8toCP1251(" диван. Купить диван со склада в Киеве");
                $keywords=UTF8toCP1251("диваны, ").$name.UTF8toCP1251(", склад мебели, купить диван, интернет магазин мебели, недорогие диваны, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика Шик Галичина ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика Шик Галичина ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
            }
            if ($tcharter==2)
            {
                $name_trunc=str_replace(UTF8toCP1251("Кресло "),"",$name);
                $title=$name_trunc.UTF8toCP1251(" кресло. Купить кресло со склада в Киеве");
                $keywords=UTF8toCP1251("кресла, ").$name.UTF8toCP1251(", склад мебели, купить кресло, интернет магазин мебели, недорогие кресла, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика Шик Галичина ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика Шик Галичина ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
            }
            if ($tcharter==13)
            {
                $name_trunc=str_replace(UTF8toCP1251("Кровать "),"",$name);
                $title=$name_trunc.UTF8toCP1251(" кровать. Купить кровать со склада в Киеве");
                $keywords=UTF8toCP1251("кровати, ").$name.UTF8toCP1251(", склад мебели, купить кровати, интернет магазин мебели, недорогие кровати, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика Шик Галичина ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика Шик Галичина ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
            }
        }
    }
    mysqli_close($db_connect);
}
function seo_bekker()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT * FROM goods WHERE factory_id=152";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[]=$row;
        }
        foreach ($goods as $good)
        {
            $id=$good['goods_id'];
            $name=$good['goods_name'];
            $header=$good['goods_name'];
            $tcharter=$good['goods_maintcharter'];
            if ($tcharter==124)
            {
                $name_trunc=str_replace(UTF8toCP1251("Тумба "),"",$name);
                $title=$name_trunc.UTF8toCP1251(" тумба под тв. Купить тумбу под тв со склада в Киеве");
                $keywords=UTF8toCP1251("тумбы под тв, ").$name.UTF8toCP1251(", склад мебели, купить тумбу под тв, интернет магазин мебели, недорогие тумбы под тв, цены, фото, отзывы.");
                $key_h=UTF8toCP1251("Фабрика ")."Bekker. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                $key_f=UTF8toCP1251("Фабрика ")."Bekker. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc', goods_active=1 WHERE goods_id=$id";
                mysqli_query($db_connect,$query);
                //echo $query."<br>";
            }
        }
    }
    mysqli_close($db_connect);
}


function seo_all()
{
    $db_connect=mysqli_connect(host,user,pass,db);
    $query="SELECT goods.goods_id, goods.goods_name, goods.goods_maintcharter, factory.factory_name ".
        "FROM goods JOIN factory ON goods.factory_id=factory.factory_id WHERE goods.goods_active=1 AND goods.goods_noactual=0";
    if ($res=mysqli_query($db_connect,$query))
    {
        while ($row = mysqli_fetch_assoc($res))
        {
            $goods[] = $row;
        }
        if (is_array($goods))
        {
            ////echo "<pre>";
			//print_r ($goods);
			////echo "</pre>";
			foreach ($goods as $good)
            {
                $id=$good['goods_id'];
                $name=$good['goods_name'];
                $header=$good['goods_name'];
                $factory=$good['factory_name'];
                $factory=str_replace(UTF8toCP1251("Фабрика "),"",$factory);
				
                $tcharter=$good['goods_maintcharter'];
				echo "$id - $name - $factory - $tcharter<br>";
                //мягкая-диваны|угловой
				
				if ($tcharter==1||$tcharter==38||$tcharter==17)
				{
					$name_trunc=str_replace(UTF8toCP1251("Диван "),"",$name);
					$name_trunc=str_replace(UTF8toCP1251("Детский "),"",$name);
					$name_trunc=str_replace(UTF8toCP1251(" угловой"),"",$name_trunc);
					$title=$name_trunc.UTF8toCP1251(" диван. Купить диван со склада в Киеве");
					$keywords=UTF8toCP1251("диваны, ").$name.UTF8toCP1251(", склад мебели, купить диван, интернет магазин мебели, недорогие диваны, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//мягкая-кресла
				if ($tcharter==2)
				{
					$name_trunc=str_replace(UTF8toCP1251("Кресло "),"",$name);
					$title=$name_trunc.UTF8toCP1251(" кресло. Купить кресло со склада в Киеве");
					$keywords=UTF8toCP1251("кресла, ").$name.UTF8toCP1251(", склад мебели, купить кресло, интернет магазин мебели, недорогие кресла, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//мягкая-бескаркасная
				if ($tcharter==2)
				{
					$name_trunc=str_replace(UTF8toCP1251("Бескаркасная "),"",$name);
					$name_trunc=str_replace(UTF8toCP1251("Бескаркасное "),"",$name_trunc);
					$title=$name_trunc.UTF8toCP1251(" бескаркасное кресло. Купить бескаркасную мебель со склада в Киеве");
					$keywords=UTF8toCP1251("бескаркасная мебель, ").$name.UTF8toCP1251(", склад мебели, купить бескаркасную мебель, интернет магазин мебели, недорогие бескаркасные кресла, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//мягкая-пуф
				if ($tcharter==41)
				{
					$name_trunc=str_replace(UTF8toCP1251("Бескаркасная "),"",$name);
					$name_trunc=str_replace(UTF8toCP1251("Бескаркасное "),"",$name_trunc);
					$name_trunc=str_replace(UTF8toCP1251("кресло "),"",$name_trunc);
					$name_trunc=str_replace(UTF8toCP1251("диван "),"",$name_trunc);
					$name_trunc=str_replace(UTF8toCP1251("Диван "),"",$name_trunc);
					$title=$name_trunc.UTF8toCP1251(" пуф. Купить пуфы со склада в Киеве");
					$keywords=UTF8toCP1251("пуф, ").$name.UTF8toCP1251(", склад мебели, купить пуф, интернет магазин мебели, недорогие пуфы, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//шкаф-купе
				if ($tcharter==9)
				{
					$name_trunc = str_replace(UTF8toCP1251("Шкаф-купе "), "", $name);
					$title = $name_trunc . UTF8toCP1251(" шкаф-купе. Купить шкафы купе со склада в Киеве");
					$keywords = UTF8toCP1251("шкафы-купе, ") . $name . UTF8toCP1251(", склад мебели, купить шкаф-купе, интернет магазин мебели, недорогие шкафы-купе, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc = UTF8toCP1251("Купить ") . $name . UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//стенки
				if ($tcharter==5)
				{
					$name_trunc = str_replace(UTF8toCP1251("Стенка "), "", $name);
					$name_trunc = str_replace(UTF8toCP1251("стенка "), "", $name_trunc);
					$title = $name_trunc . UTF8toCP1251(" стенка. Купить стенки со склада в Киеве");
					$keywords = UTF8toCP1251("стенки, ") . $name . UTF8toCP1251(", склад мебели, купить стенку, интернет магазин мебели, недорогие стенки, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc = UTF8toCP1251("Купить ") . $name . UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//кровати
				if ($tcharter==13)
				{
					$name_trunc = str_replace(UTF8toCP1251("Кровать "), "", $name);
					$title = $name_trunc . UTF8toCP1251(" кровать. Купить кровати со склада в Киеве");
					$keywords = UTF8toCP1251("кровати, ") . $name . UTF8toCP1251(", склад мебели, купить кровать, интернет магазин мебели, недорогие кровати, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc = UTF8toCP1251("Купить ") . $name . UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//комоды
				if ($tcharter==12)
				{
					$name_trunc = str_replace(UTF8toCP1251("Комод "), "", $name);
					$title = $name_trunc . UTF8toCP1251(" комод. Купить комоды со склада в Киеве");
					$keywords = UTF8toCP1251("комоды, ") . $name . UTF8toCP1251(", склад мебели, купить комод, интернет магазин мебели, недорогие комоды, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc = UTF8toCP1251("Купить ") . $name . UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//спальни
				if ($tcharter==3)
				{
					$name_trunc = str_replace(UTF8toCP1251("Спальня "), "", $name);
					$title = $name_trunc . UTF8toCP1251(" спальня. Купить спальни со склада в Киеве");
					$keywords = UTF8toCP1251("спальни, ") . $name . UTF8toCP1251(", склад мебели, купить спальню, интернет магазин мебели, недорогие спальни, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc = UTF8toCP1251("Купить ") . $name . UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//модульные системы
				if ($tcharter==40)
				{
					$name_trunc = str_replace(UTF8toCP1251("Модульная система "), "", $name);
					$title = $name_trunc . UTF8toCP1251(" модульная система. Купить модульную систему со склада в Киеве");
					$keywords = UTF8toCP1251("модульные системы, ") . $name . UTF8toCP1251(", склад мебели, купить модульную систему, интернет магазин мебели, недорогие модульные системы, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc = UTF8toCP1251("Купить ") . $name . UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//шкафы
				if ($tcharter==10)
				{
					$name_trunc = str_replace(UTF8toCP1251("Витрина "), "", $name);
					$name_trunc = str_replace(UTF8toCP1251(" для шкафа "), "", $name_trunc);
					$name_trunc = str_replace(UTF8toCP1251("Шкаф "), "", $name_trunc);
					$title = $name_trunc . UTF8toCP1251(" шкаф. Купить шкаф со склада в Киеве");
					$keywords = UTF8toCP1251("шкафы, ") . $name . UTF8toCP1251(", склад мебели, купить шкаф, интернет магазин мебели, недорогие шкафы, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc = UTF8toCP1251("Купить ") . $name . UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//прихожие
				if ($tcharter==4)
				{
					$name_trunc = str_replace(UTF8toCP1251("Прихожая "), "", $name);
					$name_trunc = str_replace(UTF8toCP1251("Прихожая-купе "), "", $name_trunc);
					$title = $name_trunc . UTF8toCP1251(" прихожая. Купить прихожую со склада в Киеве");
					$keywords = UTF8toCP1251("прихожие, ") . $name . UTF8toCP1251(", склад мебели, купить прихожую, интернет магазин мебели, недорогие прихожие, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc = UTF8toCP1251("Купить ") . $name . UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//полки
				if ($tcharter==11)
				{
					$name_trunc = str_replace(UTF8toCP1251("Полка "), "", $name);
					$name_trunc = str_replace(UTF8toCP1251(" полка"), "", $name_trunc);
					$title = $name_trunc . UTF8toCP1251(" полка. Купить полку со склада в Киеве");
					$keywords = UTF8toCP1251("полки, ") . $name . UTF8toCP1251(", склад мебели, купить полку, интернет магазин мебели, недорогие полки, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc = UTF8toCP1251("Купить ") . $name . UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//матрасы
				if ($tcharter==14)
				{
					$name_trunc = str_replace(UTF8toCP1251("Матрас "), "", $name);
					$title = $name_trunc . UTF8toCP1251(" матрас. Купить матрас со склада в Киеве");
					$keywords = UTF8toCP1251("матрасы, ") . $name . UTF8toCP1251(", склад мебели, купить матрас, интернет магазин мебели, недорогие матрасы, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc = UTF8toCP1251("Купить ") . $name . UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//журнальные столики
				if ($tcharter==7)
				{
					$name_trunc = str_replace(UTF8toCP1251("Журнальный столик "), "", $name);
					$name_trunc = str_replace(UTF8toCP1251("Стол журнальный "), "", $name_trunc);
					$name_trunc = str_replace(UTF8toCP1251("Стол журнальный "), "", $name_trunc);
					$title = $name_trunc . UTF8toCP1251(" матрас. Купить матрас со склада в Киеве");
					$keywords = UTF8toCP1251("матрасы, ") . $name . UTF8toCP1251(", склад мебели, купить матрас, интернет магазин мебели, недорогие матрасы, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc = UTF8toCP1251("Купить ") . $name . UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//зеркала
				if ($tcharter==59)
				{
					$name_trunc = str_replace(UTF8toCP1251("Зеркало "), "", $name);
					$name_trunc = str_replace(UTF8toCP1251(" Зеркало"), "", $name_trunc);
					$name_trunc = str_replace(UTF8toCP1251("Спальня "), "", $name_trunc);
					$name_trunc = str_replace(UTF8toCP1251(" зеркало"), "", $name_trunc);
					$title = $name_trunc . UTF8toCP1251(" зеркало. Купить зеркало со склада в Киеве");
					$keywords = UTF8toCP1251("зеркала, ") . $name . UTF8toCP1251(", склад мебели, купить зеркало, интернет магазин мебели, недорогие зеркала, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc = UTF8toCP1251("Купить ") . $name . UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//вешалки
				if ($tcharter==75)
				{
					$name_trunc = str_replace(UTF8toCP1251("Вешалка "), "", $name);
					$name_trunc = str_replace(UTF8toCP1251(" вешалка"), "", $name_trunc);
					$title = $name_trunc . UTF8toCP1251(" вешалка. Купить вешалку со склада в Киеве");
					$keywords = UTF8toCP1251("вешалки, ") . $name . UTF8toCP1251(", склад мебели, купить вешалку, интернет магазин мебели, недорогие вешалки, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc = UTF8toCP1251("Купить ") . $name . UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//подушки и одеяла
				if ($tcharter==83)
				{
					$name_trunc = str_replace(UTF8toCP1251("	Подушка "), "", $name);
					$title = $name_trunc . UTF8toCP1251(" постельные пренадлежности. Купить постельные пренадлежности со склада в Киеве");
					$keywords = UTF8toCP1251("постельные пренадлежности, ") . $name . UTF8toCP1251(", склад мебели, купить постельные пренадлежности, интернет магазин мебели, недорогие постельные пренадлежности, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc = UTF8toCP1251("Купить ") . $name . UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//каркасы для кроватей
				if ($tcharter==98)
				{
					$name_trunc = str_replace(UTF8toCP1251("Каркас "), "", $name);
					$name_trunc = str_replace(UTF8toCP1251("Кровать "), "", $name_trunc);
					$title = $name_trunc . UTF8toCP1251(" каркас. Купить каркасы для кроватей со склада в Киеве");
					$keywords = UTF8toCP1251("каркасы, ") . $name . UTF8toCP1251(", склад мебели, купить каркасы для кроватей, интернет магазин мебели, недорогие каркасы для кроватей, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc = UTF8toCP1251("Купить ") . $name . UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//тумбы
				if ($tcharter==124)
				{
					$name_trunc = str_replace(UTF8toCP1251("Тумба "), "", $name);
					$title = $name_trunc . UTF8toCP1251(" тумба. Купить тумбы со склада в Киеве");
					$keywords = UTF8toCP1251("тумбы, ") . $name . UTF8toCP1251(", склад мебели, купить тумбы, интернет магазин мебели, недорогие тумбы, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc = UTF8toCP1251("Купить ") . $name . UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//столы
				if ($tcharter==125)
				{
					$name_trunc = str_replace(UTF8toCP1251("Стол "), "", $name);
					$name_trunc = str_replace(UTF8toCP1251("Столик "), "", $name_trunc);
					$name_trunc = str_replace(UTF8toCP1251("Туалетка "), "", $name_trunc);
					$name_trunc = str_replace(UTF8toCP1251("Туалетный столик "), "", $name_trunc);
					$title = $name_trunc . UTF8toCP1251(" стол. Купить столы со склада в Киеве");
					$keywords = UTF8toCP1251("столы, ") . $name . UTF8toCP1251(", склад мебели, купить столы, интернет магазин мебели, недорогие столы, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc = UTF8toCP1251("Купить ") . $name . UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//Аксессуары
				if ($tcharter==109)
				{
					$name_trunc = $name;
					$title = $name_trunc . UTF8toCP1251(" аксессуар. Купить аксессуары со склада в Киеве");
					$keywords = UTF8toCP1251("аксессуары, ") . $name . UTF8toCP1251(", склад мебели, купить аксессуары, интернет магазин мебели, недорогие аксессуары, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc = UTF8toCP1251("Купить ") . $name . UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//детские комнаты
				if ($tcharter==16)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Детская "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("комната "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" детская комната. Купить детскую комнату со склада в Киеве");
                    $keywords=UTF8toCP1251("детские комнаты, ").$name.UTF8toCP1251(", склад мебели, купить детскую комнату, интернет магазин мебели, недорогие детские комнаты, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                }
				//детские комоды
				if ($tcharter==32)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Комод "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("Детский комод "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" детский комод. Купить детский комод со склада в Киеве");
                    $keywords=UTF8toCP1251("детские комоды, ").$name.UTF8toCP1251(", склад мебели, купить детский комод, интернет магазин мебели, недорогие детские комоды, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                }
				//детские стенки
				if ($tcharter==34)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Детская стенка "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251(" стенка детская"),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" детская стенка. Купить детскую стенку со склада в Киеве");
                    $keywords=UTF8toCP1251("детские стенки, ").$name.UTF8toCP1251(", склад мебели, купить детскую стенку, интернет магазин мебели, недорогие детские стенки, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                }
				//детские кровати
				if ($tcharter==33)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Детская "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("кровать "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" кровать детская. Купить детскую кровать со склада в Киеве");
                    $keywords=UTF8toCP1251("детские кровати, ").$name.UTF8toCP1251(", склад мебели, купить кровать детскую, интернет магазин мебели, недорогие детские кровати, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу Києві. Доставка по Україні");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                }
				//детские парты
				if ($tcharter==63)
				{
					$name_trunc=str_replace(UTF8toCP1251("Детская парта "),"",$name);
					$name_trunc=str_replace(UTF8toCP1251("Детская парта-"),"",$name_trunc);
					$title=$name_trunc.UTF8toCP1251(" парта. Купить парту со склада в Киеве");
					$keywords=UTF8toCP1251("парты, ").$name.UTF8toCP1251(", склад мебели, купить парту, интернет магазин мебели, недорогие парты, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу Києві. Доставка по Україні");
					$desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//детские стелажи
				if ($tcharter==71)
				{
					$name_trunc=str_replace(UTF8toCP1251("Стеллаж - "),"",$name);
					$name_trunc=str_replace(UTF8toCP1251("Стеллаж "),"",$name_trunc);
					$name_trunc=str_replace(UTF8toCP1251("Шкаф - стеллаж "),"",$name_trunc);
					$title=$name_trunc.UTF8toCP1251(" стеллаж. Купить стеллаж со склада в Киеве");
					$keywords=UTF8toCP1251("парты, ").$name.UTF8toCP1251(", склад мебели, купить стеллаж, интернет магазин мебели, недорогие стеллажи, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу Києві. Доставка по Україні");
					$desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}	
				//детские шкафы
                if ($tcharter==74)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Шкаф "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("угловой "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("детский "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("Детский "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("детский "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" детский шкаф. Купить детский шкаф со склада в Киеве");
                    $keywords=UTF8toCP1251("детские шкафы, ").$name.UTF8toCP1251(", склад мебели, купить детский шкаф, интернет магазин мебели, недорогие детские шкафы, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                }
				//детские столы
				if ($tcharter==126)
				{
					$name_trunc=str_replace(UTF8toCP1251("Стол "),"",$name);
					$name_trunc=str_replace(UTF8toCP1251("детский "),"",$name_trunc);
					$name_trunc=str_replace(UTF8toCP1251("письменный "),"",$name_trunc);
					$title=$name_trunc.UTF8toCP1251(" стол. Купить стол со склада в Киеве");
					$keywords=UTF8toCP1251("столы, ").$name.UTF8toCP1251(", склад мебели, купить стол, интернет магазин мебели, недорогие столы, цены, фото, отзывы.");
					$key_h=UTF8toCP1251("Фабрика BRW. ").$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
					$key_f=UTF8toCP1251("Фабрика BRW. ").$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
					$desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
					$query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
					mysqli_query($db_connect,$query);
					//echo $query."<br>";
				}
				//кровати для новорожденніх
				if ($tcharter==127)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Кровать-"),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("Кроватка-"),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("Детская кровать "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("Детская кроватка "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" кроватка для новорожденных. Купить кроватку для новорожденных со склада в Киеве");
                    $keywords=UTF8toCP1251("кроватки для новорожденных, ").$name.UTF8toCP1251(", склад мебели, купить кроватку для новорожденных, интернет магазин мебели, недорогие кроватки для новорожденных, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                }
				//детские стульчики
                if ($tcharter==128)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Стул "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("стул "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("-трансформер "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("Детский "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("Детское "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("кресло "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" детский стул. Купить детский стул со склада в Киеве");
                    $keywords=UTF8toCP1251("десткие стулья, ").$name.UTF8toCP1251(", склад мебели, купить детский стул, интернет магазин мебели, недорогие детские стулья, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                }
				//Песочницы
                if ($tcharter==130)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Детская "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("Песочница "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("песочница "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" песочница. Купить пеосчницы со склада в Киеве");
                    $keywords=UTF8toCP1251("десткие песочницы, ").$name.UTF8toCP1251(", склад мебели, купить детскую песочницу, интернет магазин мебели, недорогие детские пеосчницы, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                }
				//сухие бассейны
                if ($tcharter==131)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Сухой "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("басейн "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" сухой басейн. Купить сухие басейны со склада в Киеве");
                    $keywords=UTF8toCP1251("сухие басейны, ").$name.UTF8toCP1251(", склад мебели, купить сухой басейн, интернет магазин мебели, недорогие сухие басейны, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                }
				//качели
                if ($tcharter==132)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Качеля "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("Качель "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("Карусель "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("Детская "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" качель. Купить качели со склада в Киеве");
                    $keywords=UTF8toCP1251("десткие качели, ").$name.UTF8toCP1251(", склад мебели, купить детскую качелю, интернет магазин мебели, недорогие детские качели, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                }
				//детские горки
                if ($tcharter==133)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Детская "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("Горка "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("горка "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" горка. Купить горки со склада в Киеве");
                    $keywords=UTF8toCP1251("десткие горки, ").$name.UTF8toCP1251(", склад мебели, купить детскую горку, интернет магазин мебели, недорогие детские горки, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                }
				//детские батуты
				if ($tcharter==133)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Надувной батут "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("Батут "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" батут. Купить детские батуты со склада в Киеве");
                    $keywords=UTF8toCP1251("десткие батуты, ").$name.UTF8toCP1251(", склад мебели, купить детский батут, интернет магазин мебели, недорогие детские батуты, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                }
				//детские спортивные комплексы
                if ($tcharter==135)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Детский спортивный "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("Спортивная стенка для детей "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("Спорт уголок "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("Спортивный комплекс "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("Спортивный уголок "),"",$name_trunc);
					$title=$name_trunc.UTF8toCP1251(" спортивный комплекс. Купить спортивные комплексы со склада в Киеве");
                    $keywords=UTF8toCP1251("десткие спортивные комплексы, ").$name.UTF8toCP1251(", склад мебели, купить детский спортивный комплекс, интернет магазин мебели, недорогие детские спортивные комплексы, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                }
				//игровые модули
                if ($tcharter==136)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Модульный набор "),"",$name);
                   	$title=$name_trunc.UTF8toCP1251(" игровой модуль. Купить игровые модули со склада в Киеве");
                    $keywords=UTF8toCP1251("десткие игровые модули, ").$name.UTF8toCP1251(", склад мебели, купить детский игровой модуль, интернет магазин мебели, недорогие детские игровые модули, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                }
				//игровые комплексы
                if ($tcharter==137)
                {
                    $name_trunc=str_replace(UTF8toCP1251(" игровой комплекс"),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("Детский комплекс "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("Игровой комплекс "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("к детскому комплексу "),"",$name_trunc);
                   	$title=$name_trunc.UTF8toCP1251(" игрровой комрлекс. Купить игровые комплексы со склада в Киеве");
                    $keywords=UTF8toCP1251("десткие игровые комплексы, ").$name.UTF8toCP1251(", склад мебели, купить детский игровой комплекс, интернет магазин мебели, недорогие детские игровые комплексы, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                }
				//пеленаторы
                if ($tcharter==138)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Пеленатор "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("комод-пеленатор "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" пеленатор. Купить пеленаторы со склада в Киеве");
                    $keywords=UTF8toCP1251("пеленаторы, ").$name.UTF8toCP1251(", склад мебели, купить пеленатор, интернет магазин мебели, недорогие пеленаторы, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                }
				//детские домики
                if ($tcharter==140)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Домик "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("Детский "),"",$name_trunc);
                    $name_trunc=str_replace(UTF8toCP1251("домик "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" детские домик. Купить детские домики со склада в Киеве");
                    $keywords=UTF8toCP1251("десткие домики, ").$name.UTF8toCP1251(", склад мебели, купить детский домик, интернет магазин мебели, недорогие детские домики, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                }
				//стульчики для кормления
                if ($tcharter==142)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Стульчик "),"",$name);
                    $name_trunc=str_replace(UTF8toCP1251("для кормления "),"",$name_trunc);
                    $title=$name_trunc.UTF8toCP1251(" стульчик для кормления. Купить стульчики для кормления со склада в Киеве");
                    $keywords=UTF8toCP1251("стульчики для кормления, ").$name.UTF8toCP1251(", склад мебели, купить стульчик для кормления, интернет магазин мебели, недорогие стульчики для кормления, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                }
				//детские манежи
                if ($tcharter==144)
                {
                    $name_trunc=str_replace(UTF8toCP1251("Манеж "),"",$name);
                    $title=$name_trunc.UTF8toCP1251(" манеж. Купить детские манежи со склада в Киеве");
                    $keywords=UTF8toCP1251("детские манежи, ").$name.UTF8toCP1251(", склад мебели, купить детский манеж, интернет магазин мебели, недорогие детские манежи, цены, фото, отзывы.");
                    $key_h=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(".  Характеристики, фото, цена, отзывы. Купить недорого со склада в Киеве. Доставка по Украине.");
                    $key_f=UTF8toCP1251("Фабрика")." $factory. ".$name.UTF8toCP1251(". Характеристики, фото, ціна, відгуки. Купити недорого зі складу в Києві. Доставка по Україні.");
                    $desc=UTF8toCP1251("Купить ").$name.UTF8toCP1251(" в интернет магазине \"Файні-меблі\", Киев. Большой склад выставка в Киеве. Доставка по Украине, гарантия, лучшие цены.");
                    $query="UPDATE goods SET goods_header='$header', goods_title='$title', goods_keyw='$keywords', goods_hkeyw='$key_h', goods_fkeyw='$key_f', goods_desc='$desc' WHERE goods_id=$id";
                    mysqli_query($db_connect,$query);
                    //echo $query."<br>";
                }
            }
        }
        else
        {
            echo "No array to work with!<br>";
        }
    }
	else
	{
		echo "error in SQL<br>";
	}
	mysqli_close($db_connect);
}

set_time_limit(9000);
$time_start = microtime(true);
//seo_kupe_dom();
//seo_mks();
//seo_kiev_sofievka();
//seo_velam_matr();
//seo_lvs();
//seo_fundesk();
//seo_karkas();
//seo_brw();
//seo_mej_dveri();
//seo_ent_door();
//seo_dalio();
//seo_detskaj();
//seo_bekker();
//seo_vesta();
//seo_galichina();
//seo_detskaj();

seo_all();

$time_end = microtime(true);
$time = $time_end - $time_start;
echo "Runtime: $time sec<br>";
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
?>
