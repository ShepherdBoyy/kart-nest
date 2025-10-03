import { Head, useForm } from "@inertiajs/react";

export default function NewPassword({ email, token }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: email,
        token: token,
        password: "",
        password_confirmation: ""
    })

    const handleSubmit = (e) => {
        e.preventDefault()

        post(route("password.store"), {
            onFinish: () => reset("password", "password_confirmation")
        })
    }

    return (    
        <>
            <Head title="Reset Password" />

            <div>
                <h1>Reset your password</h1>

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

                    <br />
                    <br />

                    <label htmlFor="password_confirmation">
                        Confirm Password:
                    </label>
                    <input
                        name="password_confirmation"
                        type="password"
                        value={data.password_confirmation}
                        onChange={(e) =>
                            setData("password_confirmation", e.target.value)
                        }
                        placeholder="Re-enter your password"
                    />
                    {errors.password_confirmation && (
                        <p>{errors.password_confirmation}</p>
                    )}

                    <br />
                    <br />

                    <button type="submit" disabled={processing}>
                        Reset Password
                    </button>
                </form>
            </div>
        </>
    );
}
