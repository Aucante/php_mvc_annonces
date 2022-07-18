<?php

namespace App\Core;

class Form
{
    private $formCode = "";

    /**
     * @return string
     */
    public function create(){
        return $this->formCode;
    }

    public function validate(array $form, array $fields)
    {


    }
}