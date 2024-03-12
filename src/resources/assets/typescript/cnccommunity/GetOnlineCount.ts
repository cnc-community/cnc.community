import { IWebRequest } from "./WebRequest/IWebRequest";
import { WebRequestHandler } from "./WebRequest/WebRequestHandler";

export class GetOnlineCount
{
    private webRequest: IWebRequest;

    constructor(private onComplete: Function)
    {
    }

    public get(): void
    {
        this.webRequest = new WebRequestHandler("/api/game-count/total",
            null,
            this.onRequestComplete.bind(this)
        );
        this.webRequest.get();
    }

    private onRequestComplete(response, error): void
    {
        if (error != null)
        {
            console.log("Error fetching online count");
            return;
        }

        this.onComplete(JSON.parse(response));
    }
}