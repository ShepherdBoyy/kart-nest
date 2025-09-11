import { Head } from '@inertiajs/react';

export default function Welcome({ user }) {
    return (
        <>
            <Head title="Welcome" />
            <div className="container mx-auto p-6">
                <h1 className="text-3xl font-bold mb-4">Welcome to Laravel + React + Inertia!</h1>
                {user ? (
                    <p>Hello, {user.name}!</p>
                ) : (
                    <p>Please log in to continue.</p>
                )}
            </div>
        </>
    );
}