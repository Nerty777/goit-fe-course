import React, { useState } from 'react'
import { useDispatch } from 'react-redux'
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

export default function Register() {
  const dispatch = useDispatch()
  const [form, setForm] = useState({
    name: '',
    email: '',
    password: '',
  })

  const handleChange = ({ target }: React.ChangeEvent<HTMLInputElement>): void => {
    const { name, value } = target
    setForm(prevState => ({ ...prevState, [name]: value }))
  }

  const handleSubmit = (e: React.FormEvent<HTMLFormElement>): void => {
    e.preventDefault()
    dispatch(authOperations.register(form))
    setForm(INITIALREGISTERSTATE)
  }

  return (
    <div>
      <h1>Registration page</h1>

      <form
        className={s.form}
        onSubmit={handleSubmit}
        autoComplete="off"
      >
        <label className={s.label}>
          Имя
            <input
            type="text"
            name="name"
            value={form.name}
            onChange={handleChange}
          />
        </label>

        <label className={s.label}>
          Почта
            <input
            type="email"
            name="email"
            value={form.email}
            autoComplete="username"
            onChange={handleChange}
          />
        </label>

        <label className={s.label}>
          Пароль
            <input
            type="password"
            name="password"
            autoComplete="new-password"
            value={form.password}
            onChange={handleChange}
          />
        </label>

        <button type="submit">Зарегистрироваться</button>
      </form>
    </div>
  )
}
