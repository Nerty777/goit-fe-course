import React, { useState } from 'react'
import { useDispatch } from 'react-redux'
import { authOperations } from '../../redux/auth'

import s from './login.module.scss'

export default function Login() {
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const dispatch = useDispatch()

  const handleEmailChange = ({ target }: React.ChangeEvent<HTMLInputElement>): void => {
    const { value } = target
    setEmail(value)
  }

  const handlePasswordChange = ({ target }: React.ChangeEvent<HTMLInputElement>): void => {
    const { value } = target
    setPassword(value)
  }

  const handleSubmit = (e: React.FormEvent<HTMLFormElement>): void => {
    e.preventDefault()

    dispatch(authOperations.logIn({ email, password }))
    setEmail('')
    setPassword('')
  }

  return (
    <div>
      <h1>Login page</h1>

      <form
        className={s.form}
        onSubmit={handleSubmit}
        autoComplete="off"
      >
        <label className={s.label}>
          Почта
            <input
            type="email"
            name="email"
            value={email}
            autoComplete="username"
            onChange={handleEmailChange}
          />
        </label>

        <label className={s.label}>
          Пароль
            <input
            type="password"
            name="password"
            value={password}
            autoComplete="current-password"
            onChange={handlePasswordChange}
          />
        </label>

        <button type="submit">Войти</button>
      </form>
    </div>
  )

}
