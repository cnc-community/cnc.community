<?php

namespace App\Http\CustomView\Components;

use App\Http\CustomView\AbstractCustomView;

class Sites extends AbstractCustomView
{
    private $env;
    public function __construct($env)
    {
        $this->env = $env;
        $this->renderContents();
    }

    public function render()
    {
        ?>
            <div class="sites-container">
                <a href="https://cncnet.org" target="_blank" class="site-item" title="CnCNet" rel="nofollow noreferrer">
                    <div class="logo">
                        <img src="assets/images/sites/cncnet.png" loading="lazy" alt="CnCNet Logo" />
                    </div>
                </a>
                <a href="https://w3dhub.org" target="_blank" class="site-item" title="W3DHub" rel="nofollow noreferrer">
                    <div class="logo">
                        <img src="assets/images/sites/w3d.png" loading="lazy" alt="CnCNet Logo" />
                    </div>
                </a>
                <a href="https://w3dhub.org" target="_blank" class="site-item" title="W3DHub" rel="nofollow noreferrer">
                    <div class="logo">
                        <img src="assets/images/sites/cncnz.png" loading="lazy" alt="CnCNet Logo" />
                    </div>
                </a>
                <a href="https://w3dhub.org" target="_blank" class="site-item" title="CNCRemaster" rel="nofollow noreferrer">
                    <div class="logo">
                        <img src="assets/images/sites/cncremaster.png" loading="lazy" alt="CnCNet Logo" />
                    </div>
                </a>
                <a href="https://w3dhub.org" target="_blank" class="site-item" title="CNCRemaster" rel="nofollow noreferrer">
                    <div class="logo">
                        <img src="assets/images/sites/cnconline.png" loading="lazy" alt="CnCNet Logo" />
                    </div>
                </a>
                <a href="https://w3dhub.org" target="_blank" class="site-item" title="CNCRemaster" rel="nofollow noreferrer">
                    <div class="logo">
                        <img src="assets/images/sites/ppm.png" loading="lazy" alt="CnCNet Logo" />
                    </div>
                </a>
            </div>
        <?php 
    }
}