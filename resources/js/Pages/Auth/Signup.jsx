import { Head, Link, useForm } from '@inertiajs/react';

export default function Signup() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
    })

    const handleSubmit = (e) => {
        e.preventDefault();

        // post(route("login"), {
        //     onFinish: () => reset('password'),
        // });
    }

    return (
        <>
            <Head title="Sign in" />
            <div className='min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900'>
                <div className='w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700'>
                    <div className='p-6 space-y-4 md:space-y-6 sm:p-8'>
                        <h1 className='text-xl text-center font-bold leading-tight tracking-tight md:text-2xl dark:text-white'>Create an account</h1>
                        <form className='space-y-4 md:space-y-6' onSubmit={handleSubmit}>

                            <div>
                                <label htmlFor="name" className='block mb-2 text-sm font-medium text-gray-900 dark:text-white'>Name</label>
                                <input
                                    type='name'
                                    name='name'
                                    id='name'
                                    placeholder='Enter your name'
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    className='bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'
                                    required
                                />
                                <p className='text-sm text-red-600 dark:text-red-400 mt-2'>
                                    {errors.name}
                                </p>
                            </div>

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

                            <button type='submit' disabled={processing} className='w-full mt-3 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center'>Sign up</button>
                            <p className='text-sm font-light text-gray-500 dark:text-gray-400'>
                                Already have an account? <Link href={route("login")} className='font-medium text-blue-600 hover:underline'>Login here</Link>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </>
    );
}
