import { IWebRequest } from "../../../cnccommunity/WebRequest/IWebRequest";
import { WebRequestHandler } from "../../../cnccommunity/WebRequest/WebRequestHandler";
import { ITwitchStreamAPI } from "./ITwitchStreamAPI";

export class GetStreamCount implements ITwitchStreamAPI
{
    private webRequest: IWebRequest;

    constructor(private onComplete: Function)
    {
    }

    public get(): void
    {
        this.webRequest = new WebRequestHandler("/api/twitch/streams/count",
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