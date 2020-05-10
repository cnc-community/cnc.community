import { GetVideoByGameId } from "./twitch/src/Twitch/GetVideoByGameId";

export interface ITwitchVideo
{
    id: string;
}

export class TwitchStreamByGameId
{
    private container: HTMLDivElement;

    constructor(containerId: string)
    {
        this.container = document.getElementById(containerId) as HTMLDivElement;
        const twitchStreamsByGameId = new GetVideoByGameId(this.onComplete.bind(this));

        if (window["URLSearchParams"] != null)
        {
            const searchParam = new URLSearchParams(window.location.search);
            const gameId = searchParam.get("game_id");
            twitchStreamsByGameId.get(gameId);
        }
    }

    private onComplete(videos: Array<ITwitchVideo>): void
    {
        if (videos.length > 0)
        {
            this.container.innerHTML = "";
        }

        for (let i = 0; i < videos.length; i++)
        {
            this.container.appendChild(this.createResult(videos[i].id));
        }
    }

    private createResult(videoId: string): HTMLDivElement
    {
        let resultItem = document.createElement("div");
        resultItem.classList.add("twitch-embed", "embed-responsive", "embed-responsive-4by3");
        resultItem.innerHTML += `
            <iframe 
                src="https://player.twitch.tv/?autoplay=false&video=v${videoId}" 
                frameborder="0" 
                allowfullscreen="true" 
                scrolling="no"
                class="embed-responsive-item">
            </iframe>
        `;
        return resultItem;
    }
}

new TwitchStreamByGameId("videos");

