<?php

namespace Module;

class ModuleMarkCalculator
{
    private $cw1;
    private $cw2;

    public function __construct($cw1, $cw2){
        $this->cw1 = $cw1;
        $this->cw2 = $cw2;
    }

    public function calculateOverallMark(){
        return ($this->cw1 * 0.4) + ($this->cw2 * 0.6);
    }
}

?>