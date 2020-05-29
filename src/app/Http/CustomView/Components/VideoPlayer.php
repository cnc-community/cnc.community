<?php

namespace App\Http\CustomView\Components;

use App\Http\CustomView\AbstractCustomView;

class VideoPlayer extends AbstractCustomView
{
    private $_video;

    public function __construct($video)
    {
        $this->_video = $video;
        $this->renderContents();
    }

    public function render()
    {
        ?>
            <div class="video" style="background-image: url('<?php echo $this->_video["poster"]; ?>')">
                <video autoplay="true" loop muted preload="none"
                    poster="<?php echo $this->_video["poster"]; ?>"
                    src="<?php echo $this->_video["src"]; ?>">
                </video>
            </div>
        <?php 
    }
}