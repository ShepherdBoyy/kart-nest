import { Head, Link, useForm } from "@inertiajs/react";

export default function ForgotPassword({ status }) {
    const { data, setData, post, processing, errors } = useForm({
        email: "",
    });

    const handleSubmit = (e) => {
        e.preventDefault();

        post(route("password.email"));
    };

    return (
        <>
            <Head title="Forgot Password" />

            <div>
                <form onSubmit={handleSubmit}>
                    <label htmlFor="email">
                        Enter your email and we'll send you instructions to
                        reset your password
                    </label>

                    <br />

                    <input
                        name="email"
                        type="email"
                        id="email"
                        required
                        placeholder="Enter your email"
                        value={data.email}
                        onChange={(e) => setData("email", e.target.value)}
                    />
                    {errors.email && <p>{errors.email}</p>}

                    <br />
                    <br />

                    <button disabled={processing}>Send reset password link</button>
                </form>

                <br />
                <br />

                <Link href={route("login")}>Go back to login</Link>

                {status && (
                    <p>{status}</p>
                )}
            </div>
        </>
    );
}
