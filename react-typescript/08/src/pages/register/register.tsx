import React, { Component } from 'react'
import { connect } from 'react-redux'
import { authOperations } from '../../redux/auth'

import s from './register.module.scss'

interface State {
  name: string
  email: string
  password: string
}

const INITIALREGISTERSTATE: State = {
  name: '',
  email: '',
  password: '',
}

interface Props {
  onRegister: ({ name, email, password }: State) => void
}

class Register extends Component<Props, State> {
  state = {
    ...INITIALREGISTERSTATE
  }

  handleChange = ({ target }: React.ChangeEvent<HTMLInputElement>): void => {
    const { name, value } = target
    this.setState({ [name]: value } as Pick<State, keyof State>)
  }

  handleSubmit = (e: React.FormEvent<HTMLFormElement>): void => {
    e.preventDefault()

    this.props.onRegister(this.state)

    this.setState({ name: '', email: '', password: '' })
  }

  render() {
    const { name, email, password } = this.state

    return (
      <div>
        <h1>Registration page</h1>

        <form
          className={s.form}
          onSubmit={this.handleSubmit}
          autoComplete="off"
        >
          <label className={s.label}>
            Имя
            <input
              type="text"
              name="name"
              value={name}
              onChange={this.handleChange}
            />
          </label>

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

          <button type="submit">Зарегистрироваться</button>
        </form>
      </div>
    )
  }
}

const mapDispatchToProps = {
  onRegister: authOperations.register,
}

export default connect(null, mapDispatchToProps)(Register)