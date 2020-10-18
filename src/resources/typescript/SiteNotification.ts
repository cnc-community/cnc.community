export class SiteNotification 
{
    constructor(private notificationContainer: HTMLElement)
    {
        if (notificationContainer == null)
        {
            console.warn("No container found for notification");
            return;
        }

        this.checkToShowNotification();

        var closeNotificationBtns = this.notificationContainer.querySelectorAll(".js-site-notification-close");
        for (let i = 0; i < closeNotificationBtns.length; i++)
        {
            closeNotificationBtns[i].addEventListener("click", this.closeNotification.bind(this), false);
        }
    }

    private checkToShowNotification()
    {
        let hidden = localStorage.getItem("donateSiteNotificationHidden");
        if (hidden === "true")
        {
            this.closeNotification();
        }
        else
        {
            this.showNotification();
        }
    }

    private closeNotification()
    {
        this.notificationContainer.classList.add("hidden");
        localStorage.setItem("donateSiteNotificationHidden", "true");
    }

    private showNotification()
    {
        this.notificationContainer.classList.remove("hidden");
    }
}

new SiteNotification(document.querySelector(".js-site-notification"));