<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public $label;
    public $error;
    public $id;
    public $type;
    public $placeholder;
    public $name;
    public $value;
    public $required;
    public $message;
    public $require;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $type, $name, $id, $placeholder, $value = null, $required = "", $error = null, $message = null, $require = '<span class="text-danger">*</span>')
    {
        $this->label = $label;
        // $this->error = $error;
        $this->id = $id;
        $this->type = $type;
        $this->placeholder = $placeholder;
        $this->name = $name;
        $this->value = $value;
        $this->required = $required;
        $this->message = $message;
        $this->require = $require;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input');
    }
}
