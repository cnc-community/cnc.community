import { GetTotalStreamCount } from "./twitch/src/Twitch/GetTotalStreamCount";

export class SiteCountNav
{
    constructor()
    {
        /*
        const twitch = new GetTotalStreamCount(this.onComplete.bind(this));
        twitch.get();
        */
        this.onComplete(-1); // for now
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
                else if (count == -1)
                {
                    notificationEl.classList.add("pop-in");
                    notificationEl.innerText = "Live";
                }
            }
        }
    }
}

new SiteCountNav();

