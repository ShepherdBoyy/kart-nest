import { Head, Link, useForm } from "@inertiajs/react";

export default function Login({ status }) {
  const { data, setData, post, processing, errors, reset } = useForm({
    email: "",
    password: "",
    remember: false
  })

  const handleSubmit = (e) => {
    e.preventDefault()

    post(route("login"), {
      onFinish: () => reset("password")
    })
  }

  return (
      <>
          <Head title="Login" />

          <h1>Login</h1>

          {status && (
            <p>{status}</p>
          )}
          
          <form onSubmit={handleSubmit}>
              <label htmlFor="email">Email:</label>
              <input
                  name="email"
                  type="email"
                  value={data.email}
                  onChange={(e) => setData("email", e.target.value)}
                  placeholder="Enter your email address"
              />
              {errors.email && <p>{errors.email}</p>}

              <br />
              <br />

              <label htmlFor="password">Password:</label>
              <input
                  name="password"
                  type="password"
                  value={data.password}
                  onChange={(e) => setData("password", e.target.value)}
                  placeholder="Enter your password"
              />
              {errors.password && <p>{errors.password}</p>}

              <br/>
              <br/>

              <input
                name="remember"
                type="checkbox"
                checked={data.remember}
                onChange={(e) => setData("remember", e.target.checked)}
              />
              <label htmlFor="remember">Remember me</label>

              <br />
              <br />

              <button disabled={processing}>Login</button>
          </form>

      <p>Don't have an account? <Link href={route("register")}>Register here</Link></p>
      </>
  );
}
