import { Head, Link } from '@inertiajs/react';

export default function Welcome({ user }) {
    return (
        <>
            <Head title="Welcome" />
            <div className='min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900'>
                <div className='w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700'>
                    <div className='p-6 space-y-4 md:space-y-6 sm:p-8'>
                        <h1 className='text-xl text-center font-bold leading-tight tracking-tight md:text-2xl dark:text-white'>Sign in to your account</h1>
                        <form className='space-y-4 md:space-y-6' action="#">
                            <div>
                                <label for="email" className='block mb-2 text-sm font-medium text-gray-900 dark:text-white'>Email</label>
                                <input type='email' name='email' id='email' placeholder='Enter your email' className='bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' required />
                            </div>
                            <div>
                                <label for="password" className='block mb-2 text-sm font-medium text-gray-900 dark:text-white'>Password</label>
                                <input type='password' name='email' id='email' placeholder='Enter your password' className='bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' required />
                            </div>
                            <div className='flex items-center justify-between'>
                                <div className='flex items-start'>
                                    <div className='flex items-center h-5'>
                                        <input type='checkbox'aria-describedby='remember' name='remember' id='remember' className='w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800' />
                                    </div>
                                    <div className='ml-3 text-sm'>
                                        <label for="remember" className='text-gray-500 dark:text-gray-300'>Remember me</label>
                                    </div>
                                </div>
                                <Link href="#">Forgot password?</Link>
                            </div>
                            <button>Sign in</button>
                            <p>
                                Don't have an account yet? <Link href="#">Sign up</Link>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </>
    );
}