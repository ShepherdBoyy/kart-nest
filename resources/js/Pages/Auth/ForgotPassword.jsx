import { Head } from '@inertiajs/react'
import React from 'react'

export default function ForgotPassword() {
  return (
    <>
        <Head title="Forgot Password" />

        <div className='min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900'>
            <div className='w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700'>
                <div className='p-6 space-y-4 md:space-y-6 sm:p-8'>
                    <h1 className='text-xl text-center font-bold leading-tight tracking-tight md:text-2xl dark:text-white'>Forgot Password?</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Enter your email to reset your password
                    </p>
                    <form className='space-y-4 md:space-y-6'>

                    </form>
                </div>
            </div>
        </div>
    </>
  )
}
