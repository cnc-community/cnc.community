<?php

namespace App\Http\CustomView\Components;

use App\Http\CustomView\AbstractCustomView;

class Sites extends AbstractCustomView
{
    public function __construct()
    {
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
                <a href="https://w3dhub.com" target="_blank" class="site-item" title="W3DHub" rel="nofollow noreferrer">
                    <div class="logo">
                        <img src="assets/images/sites/w3d.png" loading="lazy" alt="W3DHub Logo" />
                    </div>
                </a>
                <a href="https://cncnz.com" target="_blank" class="site-item" title="CNCNZ" rel="nofollow noreferrer">
                    <div class="logo">
                        <img src="assets/images/sites/cncnz.png" loading="lazy" alt="CNCNZ Logo" />
                    </div>
                </a>
                <a href="https://cncremaster.com/" target="_blank" class="site-item" title="CNCRemaster" rel="nofollow noreferrer">
                    <div class="logo">
                        <img src="assets/images/sites/cncremaster.png" loading="lazy" alt="CNCRemaster Site Logo" />
                    </div>
                </a>
                <a href="https://cnc-online.net/en/" target="_blank" class="site-item" title="C&C Online" rel="nofollow noreferrer">
                    <div class="logo">
                        <img src="assets/images/sites/cnconline.png" loading="lazy" alt="C&C Online Logo" />
                    </div>
                </a>
                <a href="https://www.ppmsite.com/" target="_blank" class="site-item" title="PPMsite" rel="nofollow noreferrer">
                    <div class="logo">
                        <img src="assets/images/sites/ppm.png" loading="lazy" alt="PPMSite Logo" />
                    </div>
                </a>
                <a href="https://imperium-ww.pl/" target="_blank" class="site-item" title="Imperium Westwood" rel="nofollow noreferrer">
                    <div class="logo">
                        <img src="assets/images/sites/iw.png" loading="lazy" alt="PPMSite Logo" />
                    </div>
                </a>
            </div>
        <?php 
    }
}