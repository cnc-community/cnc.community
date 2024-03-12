import { GetStreamByGameId } from "./GetStreamByGameId";

export interface IStream
{
    game_id: string;
    user_id: string;
    user_name: string;
}

export class TwitchStreamByGameId
{
    private container: HTMLDivElement;

    constructor(containerId: string)
    {
        this.container = document.getElementById(containerId) as HTMLDivElement;
        const twitchStreamsByGameId = new GetStreamByGameId(this.onComplete.bind(this));

        if (window["URLSearchParams"] != null)
        {
            const searchParam = new URLSearchParams(window.location.search);
            const gameId = searchParam.get("game_id");
            twitchStreamsByGameId.get(gameId);
        }
    }

    private onComplete(streams: Array<IStream>): void
    {
        for (let i = 0; i < streams.length; i++)
        {
            this.container.appendChild(this.createResult(streams[i].user_name));
        }
    }

    private createResult(username: string): HTMLDivElement
    {
        let resultItem = document.createElement("div");
        resultItem.classList.add("stream-embed");
        resultItem.innerHTML += `
            <iframe
                src="https://player.twitch.tv/?channel=${username}&muted=true&autoplay=false"
                height="500"
                width="500"
                frameborder="0"
                scrolling="no"
                allowfullscreen="true">
            </iframe>
        `;
        return resultItem;
    }
}

new TwitchStreamByGameId("streams");

