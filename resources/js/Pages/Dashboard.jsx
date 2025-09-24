import { Head } from '@inertiajs/react'
import React from 'react'

export default function Dashboard() {
  return (
    <>
      <Head title='Dashboard' />

      <div className='min-h-screen bg-slate-900 flex items-center justify-center p-4'>
        <div className='w-full max-w-md'>
          <h1 className='text-2xl font-semibold text-white text-center mb-8'>
            Welcome! You're Logged In!
          </h1>
        </div>
      </div>
    </>
  )
}
