import { Head, useForm } from '@inertiajs/react'
import React from 'react'

export default function ResetPassword({ email, token }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: email,
        token: token,
        password: "",
        password_confirmation: ""
    })

    const handleSubmit = (e) => {
        e.preventDefault();

        post(route("password.store"), {
            onFinish: () => reset("password", "password_confirmation")
        })
    }

  return (
    <>
        <Head title='Reset Password' />

        <div className='min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900'>
            <div className='w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700'>
                <div className='p-6 space-y-4 md:space-y-6 sm:p-8'>
                    <h1 className='text-xl text-center font-bold leading-tight tracking-tight md:text-2xl dark:text-white'>
                        Reset your password
                    </h1>

                    <form className='space-y-4 md:space-y-6' onSubmit={handleSubmit}>
                        <div>
                            <label htmlFor="email" className='block mb-2 text-sm font-medium text-gray-900 dark:text-white'>Email</label>
                            <input
                                type='email'
                                name='email'
                                id='email'
                                placeholder='Enter your email'
                                className='bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'
                                value={data.email}
                                onChange={(e) => setData('email', e.target.value)}
                                required
                            />
                            <p className='text-sm text-red-600 dark:text-red-400 mt-2'>
                                {errors.email}
                            </p>
                        </div>

                        <div>
                            <label htmlFor="password" className='block mb-2 text-sm font-medium text-gray-900 dark:text-white'>New password</label>
                            <input
                                type='password'
                                name='password'
                                id='password'
                                placeholder='Enter your new password'
                                className='bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'
                                value={data.password}
                                onChange={(e) => setData('password', e.target.value)}
                                required
                            />
                            <p className='text-sm text-red-600 dark:text-red-400 mt-2'>
                                {errors.password}
                            </p>
                        </div>

                        <div>
                            <label htmlFor="password_confirmation" className='block mb-2 text-sm font-medium text-gray-900 dark:text-white'>Confirm new password</label>
                            <input
                                type='password'
                                name='password_confirmation'
                                id='password_confirmation'
                                placeholder='Re-enter your new password'
                                className='bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'
                                value={data.password_confirmation}
                                onChange={(e) => setData('password_confirmation', e.target.value)}
                                required
                            />
                            <p className='text-sm text-red-600 dark:text-red-400 mt-2'>
                                {errors.password_confirmation}
                            </p>
                        </div>

                        <button disabled={processing} className='w-full mt-3 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center'>
                            Reset
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </>
  )
}
