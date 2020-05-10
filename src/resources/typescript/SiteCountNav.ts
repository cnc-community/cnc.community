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
        console.log(count);
        let navCreators = document.getElementById("navCreators");
        if (navCreators)
        {
            navCreators.querySelector("span").innerHTML = count;
        }
    }
}

new SiteCountNav();

