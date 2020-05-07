<?php

namespace App\Http\CustomView;

abstract class AbstractCustomView
{
    public function __construct()
    {
    }

    public function renderContents()
    {
        ob_start();
        $this->render();
        $output = ob_get_contents();
        ob_end_clean();
        print $output;
    }

    abstract protected function render();
}
