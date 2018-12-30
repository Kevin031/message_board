import Vue from 'vue'
import Component from 'vue-class-component'
import Api from '../apis/index'

@Component
export default class Register extends Vue {
  private formData: { [key: string]: string } = {
    username: '',
    email: '',
    password: ''
  }
  private validPrompt: { [key: string]: boolean } = {
    username: false,
    email: false,
    password: false
  }
  private presetPassword: string = ''

  private handleInput (value: string, key: string): void {
    this.formData[key] = value
  }

  private usernameValid (): boolean {
    const pass: boolean = this.formData.username.length >= 4 && this.formData.username.length <= 20
    this.validator(pass, 'username')
    return pass
  }

  private emailValid (): boolean {
    const pass: boolean = /([\w]+@[\w]+\.[\w]+)/.test(this.formData.email)
    this.validator(pass, 'email')
    return pass
  }

  private passwordValid (): boolean {
    const pass: boolean = this.formData.password.length >= 4 && this.formData.password.length <= 20 && this.formData.password === this.presetPassword
    this.validator(pass, 'password')
    return pass
  }

  private handleSubmit ():void {
    Api.prototype.register(this.formData).then((res: any) => {
      console.log(res)
    }).catch(err => {
      console.log(err)
    })
  }

  private validator (pass: boolean, field: string): void {
    if (pass) {
      this.validPrompt[field] = false
    } else {
      this.validPrompt[field] = true
    }
  }

  private usernameController (): JSX.Element {
    return <div class={{ 'form-group': true, 'has-error': this.validPrompt.username }}>
      <input
        class="login-field form-control"
        type="text"
        placeholder="Enter your username"
        domPropsInnerHTML={ this.formData.user }
        onInput={ (evt: any) => { this.handleInput(evt.target.value, 'username') }}
        onBlur={ this.usernameValid } />
      <span class="form-control-feedback fui-user" />
      {
        this.validPrompt.username ? <span class="help-block">请输入4-20位有效字符</span> : null
      }
    </div>
  }

  private emailController (): JSX.Element {
    return <div class={{ 'form-group': true, 'has-error': this.validPrompt.email }}>
      <input
        class="login-field form-control"
        type="text"
        placeholder="Enter your email"
        domPropsInnerHTML={ this.formData.email }
        onInput={ (evt: any) => { this.handleInput(evt.target.value, 'email') }}
        onBlur={ this.emailValid } />
      <span class="form-control-feedback fui-mail" />
      {
        this.validPrompt.email ? <span class="help-block">请输入正确的邮箱地址</span> : null
      }
    </div>
  }

  handlePasswordBlur (comfirm: boolean): void {
    if (comfirm) {
      this.passwordValid()
    }
  }

  private passwordController (input: number): JSX.Element {
    const comfirm: boolean = input === 2
    return <div class={{ 'form-group': true, 'has-error': this.validPrompt.password }}>
      <input
        class="login-field form-control"
        type="password"
        placeholder={ 'Enter your password' + (comfirm ? ' again' : '') }
        domPropsInnerHTML={ comfirm ? this.formData.password : this.presetPassword }
        onInput={ (evt: any) => { comfirm ? this.handleInput(evt.target.value, 'password') : this.presetPassword = evt.target.value }}
        onBlur={ ():void => this.handlePasswordBlur(comfirm) } />
      <span class="form-control-feedback fui-lock" />
      {
        this.validPrompt.password ? <span class="help-block">请输入4-20位有效字符，且两次输入的密码需一致</span> : null
      }
    </div>
  }

  render (): JSX.Element {
    return <div class="page-register">
      <div class="register-form">
        { this.usernameController() }
        { this.emailController() }
        { this.passwordController(1) }
        { this.passwordController(2) }
        <a
          class="btn btn-primary btn-lg btn-block"
          href="javascript:;"
          onClick={this.handleSubmit}>Register</a>
      </div>
    </div>
  }
}
