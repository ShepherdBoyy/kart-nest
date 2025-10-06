import { Head, Link, useForm } from "@inertiajs/react";
import { useEffect, useState } from "react";

export default function Login({ status }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: "",
        password: "",
        remember: false,
    });

    const [lockoutSeconds, setLockoutSeconds] = useState(null);

    useEffect(() => {
        if (errors.email && errors.email.includes("seconds")) {
            const match = errors.email.match(/(\d+)\s*seconds?/);
            if (match) {
                setLockoutSeconds(parseInt(match[1], 10));
            }
        }
    }, [errors.email]);

    useEffect(() => {
        let timer;

        if (lockoutSeconds && lockoutSeconds > 0) {
            timer = setInterval(() => {
                setLockoutSeconds((prev) => (prev > 0 ? prev - 1 : 0));
            }, 1000);
        }

        return () => clearInterval(timer);
    }, [lockoutSeconds]);

    const handleSubmit = (e) => {
        e.preventDefault();

        post(route("login"), {
            onFinish: () => reset("password"),
        });
    };

    return (
        <>
            <Head title="Login" />

            <div className="min-h-screen bg-slate-900 flex items-center justify-center p-4">
                <div className="w-full max-w-md">
                    <h1 className="text-2xl font-semibold text-white text-center mb-8">
                        Sign in to your account
                    </h1>

                    {status && (
                        <div className="mb-4 text-sm font-medium text-green-600">
                            {status}
                        </div>
                    )}

                    <form
                        onSubmit={handleSubmit}
                        className="bg-slate-800 rounded-lg p-8 border border-slate-700"
                    >
                        <div className="space-y-6">
                            <div>
                                <label
                                    htmlFor="email"
                                    className="block text-sm font-medium text-slate-300 mb-2"
                                >
                                    Email address:
                                </label>
                                <div className="relative">
                                    <div className="absolute inset-y-0 pl-3 flex items-center pointer-events-none">
                                        <svg
                                            className="h-5 w-5 text-slate-400"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                                strokeWidth={2}
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                            />
                                        </svg>
                                    </div>
                                    <input
                                        type="email"
                                        id="email"
                                        value={data.email}
                                        onChange={(e) =>
                                            setData("email", e.target.value)
                                        }
                                        className="w-full pl-10 pr-3 py-2 bg-slate-700 border border-slate-600 rounded-md text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        required
                                        placeholder="Enter your email"
                                    />
                                </div>
                                {errors.email && (
                                    <p className="text-sm text-red-400 mt-2">
                                        {lockoutSeconds
                                            ? `Too many attempts. Please try again in ${lockoutSeconds} seconds.`
                                            : errors.email}
                                    </p>
                                )}
                            </div>

                            <div>
                                <label
                                    htmlFor="password"
                                    className="block text-sm font-medium text-slate-300 mb-2"
                                >
                                    Password:
                                </label>
                                <div className="relative">
                                    <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg
                                            className="h-5 w-5 text-slate-400"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                                strokeWidth={2}
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                            />
                                        </svg>
                                    </div>
                                    <input
                                        type="password"
                                        id="password"
                                        value={data.password}
                                        onChange={(e) =>
                                            setData("password", e.target.value)
                                        }
                                        className="w-full pl-10 pr-3 py-2 bg-slate-700 border border-slate-600 rounded-md text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        required
                                        placeholder="Enter your password"
                                    />
                                </div>
                                {errors.password && (
                                    <p className="text-sm text-red-400 mt-2">
                                        {errors.password}
                                    </p>
                                )}
                            </div>

                            <div className="flex items-center justify-between">
                                <div className="flex items-center">
                                    <input
                                        type="checkbox"
                                        id="remember-me"
                                        className="w-4 h-4 rounded focus:ring-blue-500 focus:ring-2"
                                        checked={data.remember}
                                        onChange={(e) =>
                                            setData(
                                                "remember",
                                                e.target.checked
                                            )
                                        }
                                    />
                                    <label
                                        htmlFor="remember-me"
                                        className="ml-2 text-sm text-slate-300"
                                    >
                                        Remember me
                                    </label>
                                </div>

                                <Link
                                    href={route("password.request")}
                                    className="text-sm text-blue-400 hover:text-blue-300 transition-colors"
                                >
                                    Forgot password?
                                </Link>
                            </div>

                            <button
                                disabled={processing || lockoutSeconds > 0}
                                className={`w-full mt-5 py-2.5 px-4 text-white font-medium rounded-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-800
                                ${
                                    lockoutSeconds > 0
                                        ? "bg-gray-500 cursor-not-allowed"
                                        : "bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 focus:ring-blue-500"
                                }`}
                            >
                                {lockoutSeconds > 0
                                    ? `Locked (${lockoutSeconds}s)`
                                    : processing
                                    ? "Logging in..."
                                    : "Login"}
                            </button>

                            <p className="text-sm text-center text-slate-300">
                                Don't have an account?
                                <Link
                                    href={route("register")}
                                    className="ml-1 text-blue-400 hover:text-blue-300 transition-colors"
                                >
                                    Register here
                                </Link>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </>
    );
}
