import { IWebRequest } from "../WebRequest/IWebRequest";
import { WebRequestHandler } from "../WebRequest/WebRequestHandler";
import { ITwitchStreamAPI } from "./ITwitchStreamAPI";

export class GetStreamByGameId implements ITwitchStreamAPI
{
    private webRequest: IWebRequest;

    constructor(private onComplete: Function)
    {
    }

    public get(streamId: string): void
    {
        this.webRequest = new WebRequestHandler("/api/twitch/stream/" + streamId,
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