import React, { Component } from 'react'
import { connect } from 'react-redux'
import { authOperations } from '../../redux/auth'

import s from './login.module.scss'

interface Props {
  onLogin: ({ email, password }: State) => void
}

interface State {
  email: string
  password: string
}

class Login extends Component<Props, State> {
  state = {
    email: '',
    password: '',
  }

  handleChange = ({ target }: React.ChangeEvent<HTMLInputElement>): void => {
    const { name, value } = target
    this.setState({ [name]: value } as Pick<State, keyof State>)
  }

  handleSubmit = (e: React.FormEvent<HTMLFormElement>): void => {
    e.preventDefault()

    this.props.onLogin(this.state)

    this.setState({ email: '', password: '' })
  }

  render() {
    const { email, password } = this.state

    return (
      <div>
        <h1>Login page</h1>

        <form
          className={s.form}
          onSubmit={this.handleSubmit}
          autoComplete="off"
        >
          <label className={s.label}>
            Почта
            <input
              type="email"
              name="email"
              value={email}
              onChange={this.handleChange}
            />
          </label>

          <label className={s.label}>
            Пароль
            <input
              type="password"
              name="password"
              value={password}
              onChange={this.handleChange}
            />
          </label>

          <button type="submit">Войти</button>
        </form>
      </div>
    )
  }
}

const mapDispatchToProps = {
  onLogin: authOperations.logIn,
}

export default connect(null, mapDispatchToProps)(Login)