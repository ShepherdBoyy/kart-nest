import { Head, Link } from '@inertiajs/react'

export default function Dashboard() {
  return (
    <>
      <Head title='Dashboard' />

      <div className='min-h-screen bg-slate-900 relative p-4'>
          <div className='absolute top-4 right-4'>
            <Link
              href={route("logout")}
              method="post"
              className='text-blue-400 hover:text-blue-300 transition-colors'
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
