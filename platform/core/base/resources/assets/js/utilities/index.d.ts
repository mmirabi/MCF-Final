import { AxiosError, AxiosRequestConfig, AxiosResponse } from 'axios'

interface HttpClient {
    setup(callback: (request: PendingRequest) => void): HttpClient

    beforeSend(callback: (request: PendingRequest) => void): HttpClient

    completed(callback: (request: PendingRequest) => void): HttpClient

    errorHandlerUsing(callback: (error: Error | AxiosError) => void): HttpClient

    make(): PendingRequest

    makeWithoutErrorHandler(): PendingRequest

    clone(): HttpClient
}

interface PendingRequest {
    constructor(httpClient: HttpClient): void

    setup(callback: (request: PendingRequest) => void): PendingRequest

    baseURL(url: string): PendingRequest

    method(method: 'get' | 'post' | 'put' | 'patch' | 'delete'): PendingRequest

    withCredentials(enabled: boolean): PendingRequest

    withConfig(config: AxiosRequestConfig): PendingRequest

    withHeaders(headers: object): PendingRequest

    withResponseType(type: 'json' | 'text' | 'blob' | 'arraybuffer' | 'document' | 'stream'): PendingRequest

    async get(url: string, params?: object): Promise<AxiosResponse>

    async head(url: string, params?: object): Promise<AxiosResponse>

    async options(url: string, params?: object): Promise<AxiosResponse>

    async post(url: string, data?: object): Promise<AxiosResponse>

    async put(url: string, data?: object): Promise<AxiosResponse>

    async patch(url: string, data?: object): Promise<AxiosResponse>

    async postForm(url: string, data?: FormData): Promise<AxiosResponse>

    async putForm(url: string, data?: FormData): Promise<AxiosResponse>

    async patchForm(url: string, data?: FormData): Promise<AxiosResponse>

    beforeSend(callback: (request: PendingRequest) => void): PendingRequest

    completed(callback: (request: PendingRequest) => void): PendingRequest

    errorHandlerUsing(callback: (error: Error | AxiosError) => void): PendingRequest

    withDefaultErrorHandler(): PendingRequest

    send(): Promise<AxiosResponse>
}

declare global {
    interface Window {
        $httpClient: HttpClient
    }

    const $httpClient: HttpClient
}
