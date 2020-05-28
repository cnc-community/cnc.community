export class NavBarJs 
{
    private cachedNavItem: HTMLDivElement = null;

    constructor()
    {
        let navItems = document.querySelectorAll(".nav-item-dropdown") as NodeListOf<HTMLDivElement>;

        for (let i = 0; i < navItems.length; i++)
        {
            const navItem = navItems[i];
            const navLink = navItem.querySelector(".nav-link");
            const navItemChildren = navItem.querySelector(".dropdown-container");

            navLink.addEventListener("click", (e) => this.onNavItemMouseClicked(e, navItem), false);
            navLink.addEventListener("touchstart", (e) => this.onNavItemMouseClicked(e, navItem), true);

            if (navItemChildren == null)
            {
                continue;
            }
            navItemChildren.addEventListener("mouseenter", this.onNavDropDownMouseEnter.bind(this, navItem), false);
        }
    }

    private onNavItemMouseEnter(event: Event, navItem: HTMLDivElement): void
    {
        this.handleDropdownMenu(navItem);
    }

    private onNavItemMouseClicked(event: Event, navItem: HTMLDivElement): void
    {
        event.preventDefault();
        if (this.dropdownOpen == true)
        {
            this.closeDropDown(this.cachedNavItem);
            return;
        }

        this.handleDropdownMenu(navItem);
    }

    private handleDropdownMenu(navItem: HTMLDivElement): void
    {
        this.cachedNavItem = navItem;
        const navItemChildren = navItem.querySelector(".nav-dropdown-contents");
        if (navItemChildren == null)
        {
            this.closeDropDown(navItem);
        }

        if (navItem.classList.contains("open") === true)
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
        this.cachedNavItem = null;
    }

    private openDropDown(navItem: HTMLDivElement): void
    {
        navItem.classList.add("open");
        navItem.classList.remove("close");
    }

    private get dropdownOpen(): boolean 
    {
        if (this.cachedNavItem == null) return false;
        return this.cachedNavItem.classList.contains("open");
    }
}

new NavBarJs();