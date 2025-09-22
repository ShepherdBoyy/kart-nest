import { Head, Link, useForm } from '@inertiajs/react'
import React from 'react'

export default function VerifyEmail() {
    const { post, processing } = useForm({})

    const handleSubmit = (e) => {
        e.preventDefault();
    }

  return (
    <>
        <Head title='Verify Email' />

        <div className='min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900'>
            <div className='w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700'>
                <div className='p-6 space-y-4 md:space-y-6 sm:p-8'>
                    <div className='mb-4 text-sm text-gray-600 dark:text-gray-400'>
                        Thanks for signing up! Before getting started, could you verify
                        your email address by clicking on the link we just emailed to
                        you? If you didn't receive the email, we will gladly send you
                        another.
                    </div>

                    <form onSubmit={handleSubmit}>
                        <div className=''>
                            <button disabled={processing}>
                                Resend Verification Email
                            </button>

                            <Link
                                href={route("logout")}
                                method='post'
                                as="button"
                                className='rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800'
                            >
                                Log Out
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </>
  )
}
