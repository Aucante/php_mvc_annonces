<?php

namespace App\Core;

class Form
{
    private $formCode = "";

    /**
     * Generate HTML form
     * @return string
     */
    public function create(){
        return $this->formCode;
    }

    /**
     * Validate if all fields are filled
     * @param array $form
     * @param array $fields
     * @return bool
     */
    public static function validate(array $form, array $fields)
    {
        foreach ($fields as $field){
            if (!isset($form[$field]) || empty($form[$field])){
                return false;
            }
        }
        return true;
    }

    /**
     * Add attributes sent to the html
     * @param array $attributes
     * @return string
     */
    public function addAttributes(array $attributes): string
    {
        $str = '';
        // short attributes
        $shortsAttributes = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus', 'novalidate', 'formnovalidate'];

        // Loop on attributes array
        foreach ($attributes as $attribute => $value){
            // if attribute is short -> in_array is inside?
            if (in_array($attribute, $shortsAttributes) && $value == true){
                $str .= " $attribute";
            }else{
                // add attribute='valeur'
                $str .= " $attribute=\"$value\"";
            }
        }
        return $str;
    }

    /**
     * Open form
     * @param string $method
     * @param string $action
     * @param array $attributes
     * @return $this
     */
    public function startForm(
        string $method = 'post',
        string $action = '#',
        array $attributes = []
    ): self
    {
        //create form
        $this->formCode .= "<form action='$action' method='$method'";

        // add attributes if wanted
        $this->formCode .= $attributes ? $this->addAttributes($attributes).'>' : '>';
        return $this;
    }

    /**
     * End form
     * @return $this
     */
    public function endForm(): self
    {
        $this->formCode .= '</form>';
        return $this;
    }

    /**
     * Add label
     * @param string $for
     * @param string $text
     * @param array $attributes
     * @return $this
     */
    public function addLabelFor(string $for, string $text, array $attributes = []): self
    {
        // Open label
        $this->formCode .= "<label for='$for'";

        // Add attributes
        $this->formCode .= $attributes ? $this->addAttributes($attributes) : '';

        // Add text
        $this->formCode .= ">$text</label>";

        return $this;
    }

    public function addInput(string $type, string $name, array $attributes= []): self
    {
        // Open
        $this->formCode .= "<input type='$type' name='$name'";

        // Add attributes
        $this->formCode .= $attributes ?  $this->addAttributes($attributes).'>' : '>';

        return $this;
    }

    public function addTextArea(string $name, string $value = '', array $attributes = []): self
    {
        // Open label
        $this->formCode .= "<textearea name='$name'";

        // Add attributes
        $this->formCode .= $attributes ? $this->addAttributes($attributes) : '';

        // Add text
        $this->formCode .= ">$value</textarea>";

        return $this;
    }


    public function addSelect(string $name, array $options, array $attributes = []): self
    {

        // Create select
        $this->formCode .= "<select name='$name'";

        // Add attributes
        $this->formCode .= $attributes ? $this->addAttributes($attributes) . '>' : '>';

        // Add options
        foreach ($options as $value => $text){
            $this->formCode .= "<option value=\"$value\">$text</option>";
        }

        // Close select
        $this->formCode .= '</select>';

        return $this;
    }

    public function addButton(string $text, array $attributes = []):self
    {
        // Open button
        $this->formCode .= '<button ';

        // Add attributes
        $this->formCode .= $attributes ? $this->addAttributes($attributes) : '';

        // Add text and close
        $this->formCode .= ">$text</button>";

        return $this;
    }

}