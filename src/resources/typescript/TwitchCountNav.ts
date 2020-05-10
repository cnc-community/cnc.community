import { GetStreamByGameId } from "./twitch/src/Twitch/GetStreamByGameId";
import { GetStreamCount } from "./twitch/src/Twitch/GetStreamCount";

export class TwitchCountNav
{
    constructor()
    {
        const twitch = new GetStreamCount(this.onComplete.bind(this));
        twitch.get();

        if (window["URLSearchParams"] != null)
        {
            const searchParam = new URLSearchParams(window.location.search);
            const gameId = searchParam.get("game_id");
            this.markActive(gameId);
        }
    }

    private markActive(gameId): void
    {
        let gameEl: HTMLLinkElement = document.getElementById("game-id-" + gameId) as HTMLLinkElement;
        if (gameEl)
        {
            gameEl.classList.add("active");
        }
    }

    private onComplete(counts): void
    {
        for (let gameId in counts)
        {
            let gameEl: HTMLLinkElement = document.getElementById("game-id-" + gameId) as HTMLLinkElement;
            if (gameEl == null)
            {
                continue;
            }
            let count = gameEl.querySelector("span");
            let total = counts[gameId].length;
            count.innerText = total;
            if (total > 0)
            {
                gameEl.classList.add("live");
            }
        }
    }
}

new TwitchCountNav();

