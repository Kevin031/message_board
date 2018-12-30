import Http from './http'

export default class BaseApi extends Http {
  public register (data: { [key: string]: string }): Promise<void> {
    return this.post(`api/register`, data)
  }
}
