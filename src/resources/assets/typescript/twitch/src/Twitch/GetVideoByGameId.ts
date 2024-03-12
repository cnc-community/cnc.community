import { ITwitchStreamAPI } from "./ITwitchStreamAPI";
import { IWebRequest } from "../../../cnccommunity/WebRequest/IWebRequest";
import { WebRequestHandler } from "../../../cnccommunity/WebRequest/WebRequestHandler";

export class GetVideoByGameId implements ITwitchStreamAPI
{
    private webRequest: IWebRequest;

    constructor(private onComplete: Function)
    {
    }

    public get(streamId: string): void
    {
        this.webRequest = new WebRequestHandler("/api/twitch/video/" + streamId,
            null,
            this.onRequestComplete.bind(this)
        );
        this.webRequest.get();
    }

    private onRequestComplete(response, error): void
    {
        if (error != null)
        {
            console.log("Error fetching streams");
            return;
        }

        this.onComplete(JSON.parse(response));
    }
}