<div class="flex-1 flex items-center justify-center py-35">
    <div class="w-full max-w-lg">
        <div class="card bg-base-100 border-base-300 shadow-xl rounded-3xl overflow-hidden">
            <div class="card-body p-7 sm:p-8">
                <div class="text-center mb-7">
                    <div class="mx-auto mb-4 w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-rotate-ccw-key-icon lucide-rotate-ccw-key">
                            <path d="M12 7v6" />
                            <path d="M12 9h2" />
                            <path d="M3 12a9 9 0 1 0 9-9 9.74 9.74 0 0 0-6.74 2.74L3 8" />
                            <path d="M3 3v5h5" />
                            <circle cx="12" cy="15" r="2" />
                        </svg>
                    </div>
    
                    <h1 class="text-2xl leading-tight font-black tracking-tight text-base-content">
                        Forgot Password
                    </h1>
    
                    <p class="text-sm text-base-content/60 mt-2 leading-relaxed">
                        Enter your email address and we'll send you a secure reset password link
                    </p>
                </div>
    
                <form
                    action="<?= e($_ENV["APP_URL"]) ?>/forgot-password"
                    method="POST"
                    novalidate
                    class="space-y-5"
                >
                    <?= csrf_field() ?>
    
                    <div class="form-control">
                        <label class="label py-1" for="email">
                            <span class="label-text text-sm font-semibold">
                                Email address
                            </span>
                        </label>
                        <input
                            type="text"
                            id="email"
                            name="email"
                            value="<?= old("email") ?>"
                            placeholder="Type here"
                            class="input input-bordered h-12 rounded-xl w-full text-sm <?= !empty($errors["email"])
                                ? "input-error"
                                : "focus:input-primary"
                            ?>"
                            autocomplete="email"
                        />
    
                        <?php if (!empty($errors["email"])): ?>
    
                            <label class="label pt-2">
                                <span class="label-text-alt text-error text-xs">
                                    <?= e($errors["email"][0]) ?>
                                </span>
                            </label>
    
                        <?php endif; ?>
                    </div>
    
                    <button
                        type="submit"
                        class="btn btn-primary h-12 min-h-12 w-full rounded-xl text-sm font-semibold shadow-md hover:scale-[1.01] transition mt-2"
                    >
                        Send Reset Link
                    </button>
                </form>
    
                <div class="divider text-xs text-base-content/40 my-6">
                    remember your password?
                </div>
    
                <a
                    href="<?= $_ENV["APP_URL"] ?>/login"
                    class="btn btn-outline h-12 min-h-12 w-full rounded-xl text-sm"
                >
                    Back to Sign In
                </a>
            </div>
        </div>
    </div>
</div>