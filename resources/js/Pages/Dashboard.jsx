import { Head, Link, useForm } from '@inertiajs/react'

export default function Dashboard() {
  

  return (
    <>
        <Head title='Dashboard' />
      
        <h1>Welcome to dashboard</h1>

        <Link
          href={route("logout")}
          method='post'
          as="button"
        >
          Logout
        </Link>
    </>
  )
}
