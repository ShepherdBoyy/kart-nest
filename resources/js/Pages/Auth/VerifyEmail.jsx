import { Head, Link, useForm } from '@inertiajs/react'

export default function VerifyEmail({ status }) {
    const { post, processing } = useForm({})

    const handleSubmit = (e) => {
        e.preventDefault()

        post(route("verification.send"))
    }

  return (
    <>
        <Head title='Verify Email' />
        <div className='min-h-screen bg-slate-900 flex items-center justify-center p-4'>
            <div className='w-full max-w-md'>
                <h1 className='text-2xl font-semibold text-white text-center mb-6'>
                    Verify Your Email
                </h1>

                <div className='bg-slate-800 rounded-lg p-8 border border-slate-700'>
                    <p className='text-slate-300 text-sm mb-6 text-center'>
                        Thanks for signing up! Before getting started, please verify your email
                        address by clicking on the link we just sent you. If you didn't receive
                        the email, we can send you another.
                    </p>

                    {status === 'verification-link-sent' && (
                        <div className="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
                            A new verification link has been sent to the email address
                            you provided during registration.
                        </div>
                    )}

                    <form onSubmit={handleSubmit} className='space-y-4'>
                        <button
                            type='submit'
                            className="w-full py-2.5 px-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium rounded-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-slate-800"
                        >
                            Resend Verification Email
                        </button>
                    </form>

                    <div className='mt-4 text-center'>
                        <Link
                            href={route("logout")}
                            method='post'
                            as="button"
                            className='text-sm text-slate-300 hover:text-red-400 transition-colors'
                        >
                            Logout
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </>
  )
}
