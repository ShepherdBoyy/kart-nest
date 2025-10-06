import { Head, Link } from '@inertiajs/react'

export default function Dashboard() {
  return (
    <>
      <Head title='Dashboard' />

      <div className='min-h-screen bg-slate-900 flex items-center justify-center relative p-4'>
          <div className='absolute top-4 right-4'>
            <Link
              href={route("logout")}
              method="post"
              className="px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-medium rounded-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-slate-900"
              as="button"
            >
              Logout
            </Link>
          </div>

          <div className='w-full max-w-md mx-auto flex flex-col items-center justify-center h-full'>
            <h1 className='text-2xl font-semibold text-white text-center mb-8'>
              Welcome! You're Logged In!
            </h1>
          </div>

      </div>
    </>
  )
}
