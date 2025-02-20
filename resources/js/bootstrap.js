import axios from "axios";

export const api = axios.create({
    headers: { Accept: "application/json", "Content-Type": "application/json" },
    timeout: 60000,
});

api.interceptors.response.use(
    function (response) {
        // Any status code that lie within the range of 2xx cause this function to trigger
        return response;
    },
    function (err) {
        // Any status codes that falls outside the range of 2xx cause this function to trigger
        const error = {
            status: err.response?.status,
            original: err,
            msg: null,
            caught: false,
        };

        const defaultMsg = "Algo deu errado! Tente novamente.";

        if (err.code === "ERR_NETWORK") {
            error.msg =
                "Os servidores não estão disponíveis! Contate o administrador do sistema.";
        } else {
            switch (err.response?.status) {
                case 500:
                    error.msg =
                        "Algo deu errado! Contate o administrador do sistema.";
                    break;

                default:
                    error.msg = defaultMsg;
                    break;
            }
        }

        error.caught = error.msg && error.msg !== defaultMsg;

        return Promise.reject(error);
    }
);
