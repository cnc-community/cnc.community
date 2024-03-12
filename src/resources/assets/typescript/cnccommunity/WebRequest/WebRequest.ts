import { IWebRequest } from "./IWebRequest";

export class WebRequest implements IWebRequest
{
    constructor(
        private _path: string,
        private _headers: IHeaders,
        private _onCompleteCallback: IWebRequestResponse
    )
    {
    }

    public get(): void
    {
        let request: XMLHttpRequest = new XMLHttpRequest();
        if (request.overrideMimeType)
        {
            request.overrideMimeType("application/json");
        }

        request.addEventListener("readystatechange", (e: Event) => this.onWebRequestLoaded(e));
        request.open("GET", this._path, true);
        this.addHeaders(request);
        request.send(null);
    }

    public post(formData?: FormData): void
    {
        let request: XMLHttpRequest = new XMLHttpRequest();

        if (request.overrideMimeType)
        {
            request.overrideMimeType("application/json");
        }

        request.addEventListener("readystatechange", (e: Event) => this.onWebRequestLoaded(e));
        request.open("POST", this._path, true);
        this.addHeaders(request);
        request.send(formData);
    }

    private addHeaders(request: XMLHttpRequest): void
    {
        for (let header in this._headers)
        {
            request.setRequestHeader(header, this._headers[header]);
        }
    }

    private onWebRequestLoaded(e: Event): void
    {
        let request: XMLHttpRequest = <XMLHttpRequest>e.target;

        if (request.readyState == 4)
        {
            if (request.status == 200 || request.status == 0)
            {
                try
                {
                    this.onComplete(request.responseText, null);
                }
                catch (e)
                {
                    console.log(e);
                    this.onComplete(null, {
                        errorCode: -1,
                        errorMessage: "Error parsing request",
                    });
                }
            }
            else
            {
                this.onComplete(null, {
                    errorMessage: request.responseText,
                    errorCode: request.status
                });
            }
        }
    }

    private onComplete(response: string, error: IWebRequestError): void
    {
        this._onCompleteCallback(response, error);
    }
}

export interface IWebRequestResponse 
{
    (response: string, error: IWebRequestError): void
}

export interface IWebRequestError
{
    errorMessage: string;
    errorCode: number;
}

export interface IHeaders
{
    [key: string]: string;
}