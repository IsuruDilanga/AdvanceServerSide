<?php

namespace InClass;

class Student extends Person {

    private $course;

    public function __construct($c, $fn, $ln, $a){
        Person::__construct($fn, $ln, $a);
        $this->course = $c;
    }

}