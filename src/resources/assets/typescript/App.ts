// https://laravel.com/docs/10.x/vite#blade-processing-static-assets
// @ts-ignore
import.meta.glob([
    '../assets/images/**',
    '../assets/fonts/**',
]);

import { NavBarJs } from "./navbar/NavBarJs";

new NavBarJs();
