import axios from 'axios';

export default class Api {

    /**
     * @type {Api|null}
     */
    static _instance = null;

    // noinspection JSValidateJSDoc
    /**
     * @type {AxiosInstance}
     * @private
     */
    _axiosInstance;

    constructor() {
        this._axiosInstance = axios.create({
            baseURL: `${window.location.protocol}//${window.location.hostname}:${window.location.port}/`,
            responseType: "json",
            headers: {
                "Accept": "application/json",
                "Content-Type": "application/json",
            },
        });

        console.log(this._axiosInstance);
    };

    /**
     * @returns {Api}
     */
    static getInstance() {
        if (Api._instance === null) {
            Api._instance = new Api();
        }

        return Api._instance;
    }

    /**
     *
     * @param {number|null} workDays
     * @param {boolean|null} partially
     * @param {int[]|null} languageIds
     * @return {Promise<Object>}
     */
    async getEmployees(
        workDays = null,
        partially = null,
        languageIds = null,
    )
    {
        return await this.request('GET', 'employees', {
            'work_days': workDays,
            'partially': partially,
            'languages': languageIds,
        });
    }

    async getLanguages()
    {
        return await this.request('GET', 'languages', {});
    }

    /**
     * Отправка запроса к API
     * @param {string} method HTTP-метод
     * @param {string} path Метод API
     * @param {object} data Данные
     * @return {Promise<Object>}
     */
    async request(method, path, data) {
        const url = 'http://localhost:8080/' + path;
        let response = await this._axiosInstance.get(url, {
            params: data,
        });

        return response.data;
    };
}

