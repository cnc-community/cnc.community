<?php

namespace App\Http\CustomView\Components;

use App\Http\CustomView\AbstractCustomView;

class GameSlider extends AbstractCustomView
{
    private $env;
    private $howToPlayLinks;

    public function __construct($env, $howToPlayLinks = false)
    {
        $this->env = $env;
        $this->howToPlayLinks = $howToPlayLinks;
        $this->renderContents();
    }

    public function render()
    {
?>
        
<?php
    }
}
