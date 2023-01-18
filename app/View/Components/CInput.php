<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CInput extends Component
{

    public $type;
    public $name;
    public $placeHolder;
    public $errorMsg;
    public $class;
    public $id;
    public $dataAttr;
    public $option;
    public $value;
    public $label;

    /**
     * Create a new component instance.
     *
     * @return void
     */
   


   public function __construct($name,$type="",$placeHolder="",$errorMsg="",$class="",$id="",$dataAttr="",$option=[],$value="",$label="")
   {
       $this->name = $name;
       $this->errorMsg = $errorMsg;
       $this->class = $class ? $class:$name;
       $this->id = $id ? $id:$name;
       $this->type = $type ? $type:"text";
       $this->dataAttr = $dataAttr;
       $this->option = $option;
       $this->value = $value;
       $this->label = $label;
       $this->placeHolder = $placeHolder ? $placeHolder:"Please Enter ".ucwords(str_replace('_', ' ', $name));


   }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.c-input',);
    }
}
