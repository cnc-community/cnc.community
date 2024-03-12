export class NavBarHamburger
{
    private navToggleBtn: HTMLElement;

    constructor(public nav: HTMLElement)
    {
        this.navToggleBtn = document.getElementById("mobileMenuToggle");
        this.navToggleBtn.addEventListener("click", this.onNavToggled.bind(this), false);
    }

    private onNavToggled(): void
    {
        this.navToggleBtn.classList.toggle("is-active");
        this.nav.classList.toggle("nav-open");
        document.body.classList.toggle("nav-open");
    }
}