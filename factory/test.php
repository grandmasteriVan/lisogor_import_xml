<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 17.05.16
 * Time: 11:20
 */
class Animal
{
    private $name;

    public function __construct($name)
    {
        $this->name=$name;
    }

    public function getName()
    {
        return $this->name;
    }
}

class Cat extends Animal
{
    public function meow()
    {
        $name=parent::getName();
        return "Cat $name saying meow";
    }
}

$cat = new Cat ('garfield');

//$cat->getName ();

//echo $cat->meow ();

$cat->meow ();
?>