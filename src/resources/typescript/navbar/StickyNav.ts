export class StickyNav 
{
    private lastScrollTopPosition: number = -1;

    constructor(public nav: HTMLElement)
    {
        this.lastScrollTopPosition = window.pageYOffset || document.documentElement.scrollTop;
        window.addEventListener("scroll", this.onWindowScrolled.bind(this), false);
        this.onWindowScrolled();
    }

    private onWindowScrolled(): void
    {
        let newPageYPosition: number = window.pageYOffset || document.documentElement.scrollTop;

        if (this.nav.classList.contains("nav-open")) return;

        if (newPageYPosition > this.lastScrollTopPosition)
        {
            this.nav.setAttribute("hidden", "true");
        }
        else if (newPageYPosition < this.lastScrollTopPosition)
        {
            this.nav.setAttribute("hidden", "false");
        }

        if (newPageYPosition === 0)
        {
            this.nav.setAttribute("isAtTopOfThePage", "true");
        }
        else
        {
            this.nav.setAttribute("isAtTopOfThePage", "false");
        }

        this.lastScrollTopPosition = newPageYPosition <= 0 ? 0 : newPageYPosition;
    }
}