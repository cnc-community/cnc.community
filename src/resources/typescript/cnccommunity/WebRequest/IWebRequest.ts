export interface IWebRequest
{
    get(): void;
    post(formData?: FormData): void;
}