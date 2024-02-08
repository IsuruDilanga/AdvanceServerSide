<?php

namespace InClass;

class Person{

    private $firstname;
    private $lastname;
    private $age;

    public function __construct($fn, $ln, $a){
        $this->firstname = $fn;
        $this->lastname = $ln;
        $this->age = $a;
    }

    public function displayPerson(){
        $name = $this->buildName();
        return "$name is $this->age years old";
    }

    public function buildName(){
        return "$this->firstname $this->lastname";
    }

}