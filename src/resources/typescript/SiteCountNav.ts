import { GetTotalStreamCount } from "./twitch/src/Twitch/GetTotalStreamCount";

export class SiteCountNav
{
    constructor()
    {
        const twitch = new GetTotalStreamCount(this.onComplete.bind(this));
        twitch.get();
    }

    private onComplete(count): void
    {
        let navCreators = document.querySelectorAll(".nav-creators-count");
        for (let i = 0; i < navCreators.length; i++)
        {
            let notification = navCreators[i];
            if (notification)
            {
                let notificationEl = notification.querySelector("span");
                if (count > 0)
                {
                    notificationEl.classList.add("pop-in");
                    notificationEl.innerText = count;
                }
            }
        }
    }
}

new SiteCountNav();

