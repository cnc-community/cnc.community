import { GetOnlineCount } from "./cnccommunity/GetOnlineCount";

export class OnlineCount
{
    constructor()
    {
        const count = new GetOnlineCount(this.onComplete.bind(this));
        count.get();
    }

    private onComplete(count): void
    {
        let onlineCounts = document.querySelectorAll("span.js-total-online");
        for (let i = 0; i < onlineCounts.length; i++)
        {
            let notification = onlineCounts[i] as HTMLSpanElement;
            if (notification)
            {
                if (count > 0)
                {
                    notification.classList.add("pop-in");
                    notification.innerText = count;
                }
                else if (count == -1)
                {
                    notification.classList.add("pop-in");
                    notification.innerText = "Live";
                }
            }
        }
    }
}

new OnlineCount();

