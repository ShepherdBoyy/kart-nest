import { Head, Link, useForm } from '@inertiajs/react';

export default function Signin({ status, resetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false
    })

    const handleSubmit = (e) => {
        e.preventDefault();

        post(route("login"), {
            onFinish: () => reset('password'),
        });
    }

    return (
        <>
            <Head title="Sign in" />
            <div className='min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900'>
                <div className='w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700'>
                    <div className='p-6 space-y-4 md:space-y-6 sm:p-8'>
                        <h1 className='text-xl text-center font-bold leading-tight tracking-tight md:text-2xl dark:text-white'>Sign in to your account</h1>
                        
                        {status && (
                            <div className="mb-4 text-sm font-medium text-green-600">
                                {status}
                            </div>
                        )}
                        
                        <form className='space-y-4 md:space-y-6' onSubmit={handleSubmit}>
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
                            </div>
                            <div>
                                <label htmlFor="password" className='block mb-2 text-sm font-medium text-gray-900 dark:text-white'>Password</label>
                                <input
                                    type='password'
                                    name='password'
                                    id='password'
                                    placeholder='Enter your password'
                                    className='bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'
                                    value={data.password}
                                    onChange={(e) => setData('password', e.target.value)}
                                    required
                                />
                                <p className='text-sm text-red-600 dark:text-red-400 mt-2'>
                                    {errors.password}
                                </p>
                            </div>
                            <div className='flex items-center justify-between'>
                                <div className='flex items-start'>
                                    <div className='flex items-center h-5'>
                                        <input
                                            type='checkbox'
                                            aria-describedby='remember'
                                            name='remember'
                                            id='remember'
                                            checked={data.remember}
                                            onChange={(e) => setData('remember', e.target.checked)}
                                            className='w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800'
                                        />
                                    </div>
                                    <div className='ml-3 text-sm'>
                                        <label htmlFor="remember" className='text-gray-500 dark:text-gray-300'>Remember me</label>
                                    </div>
                                </div>
                                {resetPassword && (
                                    <Link
                                        href={route("password.request")}
                                        className='text-sm font-medium text-blue-600 hover:underline'
                                    >
                                        Forgot password?
                                    </Link>
                                )}
                            </div>
                            <button type='submit' disabled={processing} className='w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center'>Sign in</button>
                            <p className='text-sm font-light text-gray-500 dark:text-gray-400'>
                                Don't have an account yet? <Link href={route("signup")} className='font-medium text-blue-600 hover:underline'>Sign up</Link>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </>
    );
}