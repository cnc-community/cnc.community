import { GetStreamByGameId } from "./twitch/src/Twitch/GetStreamByGameId";

export interface IStream
{
    game_id: string;
    user_id: string;
    user_name: string;
    viewer_count: number;
    title: string;
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
        if (streams.length > 0)
        {
            this.container.innerHTML = "";
        }

        for (let i = 0; i < streams.length; i++)
        {
            const stream = streams[i];
            this.container.appendChild(this.createResult(stream.title, stream.user_name, stream.viewer_count));
        }
    }

    private createResult(streamTitle: string, username: string, viewerCount: number): HTMLDivElement
    {
        let resultItem = document.createElement("div");
        resultItem.classList.add("twitch-embed");

        resultItem.innerHTML += `
            <div class="stream-header">
                <div class="stream-title">
                    ${username}
                </div>
                <div class="viewer-count">
                    ${viewerCount} viewers
                </div>
            </div>
            <div class="embed-responsive embed-responsive-4by3">
                <iframe
                    src="https://player.twitch.tv/?channel=${username}&muted=true&autoplay=false"
                    frameborder="0"
                    scrolling="no"
                    allowfullscreen="true"
                    class="embed-responsive-item">
                </iframe>
            </div>
        `;
        return resultItem;
    }
}

new TwitchStreamByGameId("streams");

