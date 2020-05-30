<?php

namespace App;

class HowToContentSeed
{
    public static function Renegade()
    {
        ob_start();
        ?>

        <h2>Step 1: Download &amp; Install Renegade</h2>
        <p>
            You can now buy a digital copy of all 12 Command &amp; Conquer games from the EA Origin Store. If you have a
            physical copy of Renegade already, skip this step.
        </p>	

        <p>
            More information on which C&amp;C games have been officially been released as freeware 
            <a href="https://cncnet.org/buy" target="_blank">can be found here.</a>
        </p>

        <p>
            <a href="https://www.origin.com/gbr/en-us/store/command-and-conquer/command-and-conquer-the-ultimate-collection" target="_blank">
                Click here to purchase via EA Origin
            </a>
        </p>

        <h2>Step 2: Install the latest Patch</h2>
        <p>
            The Tiberian Technologies patch is the most popular community update for Renegade. It contains many bug fixes and
            makes the game compatible with the latest versions of Windows.

            <a href="http://www.tiberiantechnologies.org/files/scripts-4.6.exe" target="_blank">Click here to Download</a>
        </p>
                        
        <h2>Step 3:&nbsp;Install W3D Hub Launcher</h2>
        <p>The W3D Hub launcher is an all-in-one solution for finding Renegade servers and mods.</p>
        <p>
            <a href="https://w3dhub.com/forum/files/file/10-w3d-hub-launcher/" title="W3D Hub Launcher">Click here to Download</a>
            <br />
            Once the W3D Hub launcher has been installed, follow the instructions below.

            <ul>
                <li>
                    Run the W3D Hub Launcher
                </li>
                <li>Click the "Games" tab in the menu bar.</li>
                <li>Click C&amp;C Renegade in the left menu.</li>
            </ul>
        </p>

        <p>
            If the launcher hasn't found your Game automatically, click "Import" and browse to "Game.exe". (Found where Renegade
            is installed).
        </p>
            
        <h2>Step 4: Play Single Player and Online!</h2>
        <p>
            Using the W3D Hub Launcher, you are now able to play Single Player or battle it out against others Online.
            To look for online games, go to the Server Browser and click the Join Server button.
        </p>

        <h3>Known Issues</h3>
        <p>This section is for known compatibility issues that affect C&amp;C Renegade.</p>
        <ul>
            <li>If Renegade is installed via Origin, you will be unable to apply your game settings using the W3D Hub
                Launcher. Use WWConfig.exe, found in the game install folder, instead.</li>
            <li>Renegade has visual issues when running with an un-capped framerate, to fix this, make sure that vsync is
                enabled in the game settings.</li>
        </ul>
        <a href="https://www.origin.com/gbr/en-us/store/command-and-conquer/command-and-conquer-the-ultimate-collection"></a>

        <?php

        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}
