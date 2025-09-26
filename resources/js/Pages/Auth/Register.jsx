import { Head, Link, useForm } from '@inertiajs/react'

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: "",
        email: "",
        password: "",
        password_confirmation: ""
    })

    const handleSubmit = (e) => {
        e.preventDefault();

        post(route("register"), {
            onFinish: () => reset("password", "password_confirmation")
        })
    }

    return (
        <>
            <Head title='Register' />

            <div className='min-h-screen bg-slate-900 flex items-center justify-center p-4'>
                <div className='w-full max-w-md'>
                    <h1 className='text-2xl font-semibold text-white text-center mb-8'>
                        Register an account
                    </h1>

                    <form onSubmit={handleSubmit} className='bg-slate-800 rounded-lg p-8 border border-slate-700'>
                        <div className='space-y-6'>
                            <div>
                                <label
                                    htmlFor='name'
                                    className='block text-sm font-medium text-slate-300 mb-2'
                                >
                                    Name:
                                </label>
                                <div className='relative'>
                                    <div className='absolute inset-y-0 pl-3 flex items-center pointer-events-none'>
                                        <svg className="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5.121 17.804A9 9 0 1118.879 17.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <input
                                        type='name'
                                        id='name'
                                        value={data.name}
                                        onChange={(e) => setData("name", e.target.value)}
                                        className='w-full pl-10 pr-3 py-2 bg-slate-700 border border-slate-600 rounded-md text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent'
                                        required
                                        placeholder='Enter your name'
                                    />
                                </div>
                                <p className='text-sm text-red-400 mt-2'>
                                    {errors.name}
                                </p>
                            </div>

                            <div>
                                <label
                                    htmlFor='email'
                                    className='block text-sm font-medium text-slate-300 mb-2'
                                >
                                    Email address:
                                </label>
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
                                <p className='text-sm text-red-400 mt-2'>
                                    {errors.email}
                                </p>
                            </div>

                            <div>
                                <label
                                    htmlFor='password'
                                    className='block text-sm font-medium text-slate-300 mb-2'
                                >
                                    Password:
                                </label>
                                <div className="relative">
                                    <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg className="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <input
                                        type="password"
                                        id="password"
                                        value={data.password}
                                        onChange={(e) => setData("password", e.target.value)}
                                        className="w-full pl-10 pr-3 py-2 bg-slate-700 border border-slate-600 rounded-md text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        required
                                        placeholder='Enter your password'
                                    />
                                </div>
                                <p className='text-sm text-red-400 mt-2'>
                                    {errors.password}
                                </p>
                            </div>

                            <div>
                                <label
                                    htmlFor='password_confirmation'
                                    className='block text-sm font-medium text-slate-300 mb-2'
                                >
                                    Confirm Password:
                                </label>
                                <div className="relative">
                                    <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg className="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 13l2 2 4-4" />
                                        </svg>
                                    </div>
                                    <input
                                        type="password"
                                        id="password_confirmation"
                                        value={data.password_confirmation}
                                        onChange={(e) => setData("password_confirmation", e.target.value)}
                                        className="w-full pl-10 pr-3 py-2 bg-slate-700 border border-slate-600 rounded-md text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        required
                                        placeholder='Re-enter your password'
                                    />
                                </div>
                                <p className='text-sm text-red-400 mt-2'>
                                    {errors.password_confirmation}
                                </p>
                            </div>

                            <button
                                className='w-full mt-5 py-2.5 px-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:from-blue-700 hover:to-purple-700 text-white font-medium rounded-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-slate-800'
                            >
                                Register
                            </button>

                            <p className='text-sm text-center text-slate-300'>
                                Already have an account?
                                <Link
                                    href={route("login")}
                                    className='ml-1 text-blue-400 hover:text-blue-300 transition-colors'
                                >
                                    Login here
                                </Link>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </>
    )
}
