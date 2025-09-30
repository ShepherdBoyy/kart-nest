import { Head, useForm } from '@inertiajs/react'
import React from 'react'

export default function Register() {
  const { data, setData, post, errors, processing, reset } = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: ""
  })

  const handleSubmit = (e) => {
    e.preventDefault()

    post(route("register"), {
      onFinish: () => reset("password", "password_confirmation")
    })
  }

  return (
    <>
        <Head title='Register' />

        <h1>Register your account</h1>
        <form onSubmit={handleSubmit}>
          <label htmlFor='name'>Name:</label>
          <input
            name='name'
            type='name' 
            value={data.name}
            onChange={(e) => setData("name", e.target.value)} 
            placeholder='Enter your name'
          />
          {errors.name && (
            <p>{errors.name}</p>
          )}

          <label htmlFor='email'>Email:</label>
          <input
            name='email'
            type='email' 
            value={data.email}
            onChange={(e) => setData("email", e.target.value)}
            placeholder='Enter your email address'
          />
          {errors.email && (
            <p>{errors.email}</p>
          )}

          <label htmlFor='password'>Password:</label>
          <input
            name='password'
            type='password'
            value={data.password}
            onChange={(e) => setData("password", e.target.value)}
            placeholder='Enter your password'
          />
          {errors.password && (
            <p>{errors.password}</p>
          )}

          <label htmlFor='password_confirmation'>Confirm Password:</label>
          <input
            name='password_confirmation' 
            type='password'
            value={data.password_confirmation}
            onChange={(e) => setData("password_confirmation", e.target.value)}
            placeholder='Re-enter your password'
          />
          {errors.password_confirmation && (
            <p>{errors.password_confirmation}</p>
          )}

          <button disabled={processing}>Register</button>
        </form>
    </>
  )
}
