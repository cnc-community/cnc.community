// https://laravel.com/docs/10.x/vite#blade-processing-static-assets
// @ts-ignore
import.meta.glob([
    '../images/**',
    '../fonts/**',
    '../vendor/**',
], { eager: true });

import { TwitchCountNav } from "./TwitchCountNav";
import { NavBarJs } from "./navbar/NavBarJs";

new NavBarJs();
new TwitchCountNav();