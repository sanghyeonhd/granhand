import axios from 'axios';

const baseUrl = 'http://granhand.kro.kr/api/proajax.php?pid=3';
let onlyAlertOnce = true;

const Axios = {
    async formpost(url, param, okHandler, errHandler) {
        console.log(baseUrl+url);
        axios({
            method: 'post',
            url: `${baseUrl}${url}`,
            data: param,
            headers: {
                "Content-Type": "multipart/form-data",
            }
        })
        .then((response) => {
            if (okHandler) okHandler(response.data);
        })
        .catch((error) => {
            // console.log(error);
            if (errHandler) errHandler(error.response);
        });
    },
    async get(url, okHandler, errHandler) {
        console.log(baseUrl+url);
        try {
            const response = await axios({
                method: 'get',
                url: `${baseUrl}${url}`,
                headers: {
                    "Content-Type": "application/json",
                }
            });

            if (okHandler) okHandler(response.data);
            else return response.data;
        } catch (error) {
            console.log(error);
            if (error.response.status === 401) {
                
            } else if (errHandler) errHandler(error.response);
        }
    },
    async getauth(url,token , okHandler, errHandler) {
        console.log(baseUrl+url);
        try {
            const response = await axios({
                method: 'get',
                url: `${baseUrl}${url}`,
                headers: {"Authorization":"Bearer "+token}
            });

            if (okHandler) okHandler(response.data);
            else return response.data;
        } catch (error) {
            
            if (error.response.status === 401) {
                if (error.response.data && error.response.data.message) {
                    alert(error.response.data.message);
                } else {
                    onlyAlertOnce && alert('세션이 만료됐습니다. 다시 로그인해주세요.');
                    onlyAlertOnce = false;
                }
                
            } else if (errHandler) errHandler(error.response);
        }
    },
    async formpostauth(url, param, token , okHandler, errHandler) {
        console.log(token);
        console.log(baseUrl+url);
        axios({
            method: 'post',
            url: `${baseUrl}${url}`,
            data: param,
            headers: {
                "Content-Type": "multipart/form-data",
                "Authorization":"Bearer "+token
            }
        })
        .then((response) => {
            if (okHandler) okHandler(response.data);
        })
        .catch((error) => {
            if (error.response.status === 401) {
                if (error.response.data && error.response.data.message) {
                    alert(error.response.data.message);
                } else {
                    onlyAlertOnce && alert('세션이 만료됐습니다. 다시 로그인해주세요.');
                    onlyAlertOnce = false;
                }
                
            } else if (errHandler) errHandler(error.response);
        });
    },
    async jsonpost(url, param, okHandler, errHandler) {
        console.log(baseUrl+url);
        axios({
            method: 'post',
            url: `${baseUrl}${url}`,
            data: param,
            headers: {
                "Content-Type": "application/json"
            }
        })
        .then((response) => {
            if (okHandler) okHandler(response.data);
        })
        .catch((error) => {
            // console.log(error);
            if (errHandler) errHandler(error.response);
        });
    },
    async jsonpostauth(url, param, token , okHandler, errHandler) {
        console.log(baseUrl+url);
        if(token)   {
            var headers = {
                "Content-Type": "application/json",
                "Authorization":"Bearer "+token
            }
        }   else    {
            var headers = {
                "Content-Type": "application/json",
            }
        }
        axios({
            method: 'post',
            url: `${baseUrl}${url}`,
            data: param,
            headers: headers
        })
        .then((response) => {
            if (okHandler) okHandler(response.data);
        })
        .catch((error) => {
            // console.log(error);
            if (errHandler) errHandler(error.response);
        });
    },
}
export default Axios;