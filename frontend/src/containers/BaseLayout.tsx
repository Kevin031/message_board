import Vue from 'vue'
import Component from 'vue-class-component'

@Component
export default class BaseLayout extends Vue {
  render (): JSX.Element {
    return <div class="app-layout">
      <header class="app-layout__header">
        <router-link to="/">Home</router-link>
        <router-link to="/about">About</router-link>
      </header>
      <section class="app-layout__body">
        <router-view />
      </section>
    </div>
  }
}
