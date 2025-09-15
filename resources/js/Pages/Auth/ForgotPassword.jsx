import { Head, useForm } from '@inertiajs/react'
import React from 'react'

export default function ForgotPassword({ status }) {
    const { data, setData, post, processing, errors } = useForm({
        email:""
    })

    const handleSubmit = (e) => {
        e.preventDefault();

        post(route("password.email"))
    }

  return (
    <>
        <Head title="Forgot Password" />

        <div className='min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900'>
            <div className='w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700'>
                <div className='p-6 space-y-4 sm:p-8'>
                    <h1 className='text-xl text-center font-bold leading-tight tracking-tight md:text-2xl dark:text-white'>Forgot Password?</h1>
                    <p className="text-sm text-center text-gray-600 dark:text-gray-400">
                        Enter your email to reset your password
                    </p>

                    {status && (
                        <div className='mb-4 text-sm font-medium text-green-600 dark:text-green-400'>
                            {status}
                        </div>
                    )}

                    <form className='space-y-4 md:space-y-6 mt-6' onSubmit={handleSubmit}>
                        <div>
                            <label htmlFor="email" className='block mb-2 text-sm font-medium text-gray-900 dark:text-white'>Email</label>
                            <input
                                type='email'
                                name='email'
                                id='email'
                                placeholder='Enter your email'
                                value={data.email}
                                onChange={(e) => setData('email', e.target.value)}
                                className='bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'
                                required
                            />
                            <p className='text-sm text-red-600 dark:text-red-400 mt-2'>
                                {errors.email}
                            </p>

                            <button disabled={processing} className='w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 mt-5 py-2.5 text-center'>Send Reset Password Link</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </>
  )
}
