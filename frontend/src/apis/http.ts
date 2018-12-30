import axios from 'axios'

axios.defaults.headers.common['Accept'] = 'application/json'
axios.defaults.baseURL = 'http://phpstudio.cc'
axios.defaults.headers.post['Content-Type'] = 'application/json; charset=utf-8'
axios.defaults.withCredentials = true

export default class Http {
  public get (url: string, params: { [key: string]: any }): Promise<void> {
    return axios.get(url, params).then(resp => resp.data).catch(err => {
      console.error('Get Server Data Error' + err)
      return err
    })
  }

  public post (url: string, data: { [key: string]: any }): Promise<void> {
    return axios.post(url, data).then(resp => resp.data).catch(err => console.error('Get Server Data Error' + err))
  }
}
