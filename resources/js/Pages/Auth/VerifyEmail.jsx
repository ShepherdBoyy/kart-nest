import { Head, Link, useForm } from "@inertiajs/react";

export default function VerifyEmail({ status }) {
    const { post, processing } = useForm({});

    const handleSubmit = (e) => {
        e.preventDefault();

        post(route("verification.send"));
    };
    return (
        <>
            <Head title="Verify Email" />

            <p>
                Thanks for signing up! Before getting started, please verify
                your email address by clicking on the link we just sent you. If
                you didn't receive the email, we can send you another.
            </p>

            {status && (
              <p>{status}</p>
            )}

            <form onSubmit={handleSubmit}>
                <button type="submit">Resend Verification Email</button>
            </form>

            <Link href={route("logout")} method="post" as="button">
                Logout
            </Link>
        </>
    );
}
