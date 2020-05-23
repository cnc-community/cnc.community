export class NavBarJs 
{
    constructor()
    {
        let navItems = document.querySelectorAll(".nav-item") as NodeListOf<HTMLDivElement>;

        for (let i = 0; i < navItems.length; i++)
        {
            const navItem = navItems[i];
            const navItemChildren = navItem.querySelector(".nav-dropdown-contents");

            navItem.addEventListener("mouseenter", this.onNavItemMouseEnter.bind(this, navItem), false);

            if (navItemChildren == null) 
            {
                continue;
            }
            navItemChildren.addEventListener("mouseenter", this.onNavDropDownMouseEnter.bind(this, navItem), false);
        }
    }

    private onNavItemMouseEnter(navItem: HTMLDivElement): void
    {
        if (navItem.classList.contains("open"))
        {
            return;
        }
        this.openDropDown(navItem);
    }

    private onNavDropDownMouseEnter(navItem: HTMLDivElement): void
    {
        navItem.addEventListener("mouseleave", () => this.closeDropDown(navItem), false);
    }

    private closeDropDown(navItem: HTMLDivElement): void
    {
        navItem.classList.remove("open");
        navItem.classList.add("close");
    }

    private openDropDown(navItem: HTMLDivElement): void
    {
        navItem.classList.add("open");
        navItem.classList.remove("close");
    }
}

new NavBarJs();