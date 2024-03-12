import { IWebRequest } from "./IWebRequest";
import { WebRequest, IHeaders, IWebRequestResponse } from "./WebRequest";

export class WebRequestHandler
{
    private _parser: IWebRequest;

    constructor(path: string, headers: IHeaders, onCompleteCallback: IWebRequestResponse)
    {
        this._parser = new WebRequest(path, headers, onCompleteCallback.bind(this));
    }

    public get(): void
    {
        this._parser.get();
    }

    public post(formData?: FormData): void
    {
        this._parser.post(formData);
    }
}