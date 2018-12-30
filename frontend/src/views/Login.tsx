import Vue from 'vue'
import Component from 'vue-class-component'

const logo = require('../assets/images/login-icon.png')

@Component
export default class Login extends Vue {
  private formData: any = {
    user: '',
    password: ''
  }

  handleInput (value: string, key: string): void {
    this.formData[key] = value
  }

  userController (): JSX.Element {
    return <div class="form-group">
      <input
        class="login-field form-control"
        type="text"
        placeholder="Enter your username / email"
        domPropsInnerHTML={ this.formData.user }
        onInput={ (evt: any) => { this.handleInput(evt.target.value, 'user') }} />
      <span class="form-control-feedback fui-user" />
    </div>
  }

  passwordController (): JSX.Element {
    return <div class="form-group">
      <input
        class="login-field form-control"
        type="password"
        placeholder="Enter your password"
        domPropsInnerHTML={ this.formData.password }
        onInput={ (evt: any) => { this.handleInput(evt.target.value, 'password') }} />
      <span class="form-control-feedback fui-lock" />
    </div>
  }

  render (): JSX.Element {
    return <div class="page-login">
      <div class="login-logo">
        <img src={ logo } alt="Welcome to Mail App" />
        <h4>Welcome to <small>Note App</small></h4>
      </div>
      <div class="login-form">
        { this.userController() }
        { this.passwordController() }
        <a class="btn btn-primary btn-lg btn-block" href="javascript:;">Log in</a>
        <div class="clearfix other-options">
          <router-link to='/register' class="float-left">Register</router-link>
          <a class="float-right">Forgot password</a>
        </div>
      </div>
    </div>
  }
}
