import { Head, Link, useForm } from "@inertiajs/react";

export default function ForgotPassword({ status }) {
    const { data, setData, post, processing, errors } = useForm({
        email: ""
    })

    const handleSubmit = (e) => {
        e.preventDefault();

        post(route("password.email"))
    }

    return (
        <>
            <Head title="Forgot Password" />

            <div className="min-h-screen bg-slate-900 flex items-center justify-center p-4">
                <div className="w-full max-w-md">
                    <h1 className="text-2xl font-semibold text-white text-center mb-6">
                        Forgot your password?
                    </h1>

                    <div className="bg-slate-800 p-8 rounded-lg border border-slate-700">
                        <form onSubmit={handleSubmit} className='space-y-4'>
                            <p className="text-slate-300 text-sm text-center">
                                Enter your email and we'll send you instructions to reset your password
                            </p>
                            <div>
                                <div className='relative'>
                                    <div className='absolute inset-y-0 pl-3 flex items-center pointer-events-none'>
                                        <svg className='h-5 w-5 text-slate-400' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                            <path strokeLinecap='round' strokeLinejoin='round' strokeWidth={2} d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input
                                        type='email'
                                        id='email'
                                        value={data.email}
                                        onChange={(e) => setData("email", e.target.value)}
                                        className='w-full pl-10 pr-3 py-2 bg-slate-700 border border-slate-600 rounded-md text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'
                                        required
                                        placeholder='Enter your email'
                                    />
                                </div>
                                {errors.email && (
                                    <p className='text-sm text-red-400 mt-2'>
                                        {errors.email}
                                    </p>
                                )}
                            </div>

                            <button
                                disabled={processing}
                                type='submit'
                                className="w-full cursor-pointer py-2.5 mt-5 px-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium rounded-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-slate-800"
                            >
                                Send reset password link
                            </button>
                        </form>
                        <div className='mt-4 text-center'>
                            <Link
                                href={route("login")}
                                className='text-sm text-slate-300 hover:text-red-400 transition-colors cursor-pointer'
                            >
                                Go back to login
                            </Link>
                        </div>
                    </div>

                    {status && (
                        <div className='mt-4 text-sm font-medium text-green-600 dark:text-green-400'>
                            {status}
                        </div>
                    )}
                </div>
            </div>
        </>
    )
}
