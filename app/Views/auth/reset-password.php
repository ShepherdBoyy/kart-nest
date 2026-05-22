<div class="flex-1 flex items-center justify-center py-20">
    <div class="w-full max-w-lg">
        <div class="card bg-base-100 border-base-300 shadow-xl rounded-3xl overflow-hidden">
            <div class="card-body p-7 sm:p-8">
                <div class="text-center mb-7">
                    <div class="mx-auto mb-4 w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-timer-reset-icon lucide-timer-reset">
                            <path d="M10 2h4" />
                            <path d="M12 14v-4" />
                            <path d="M4 13a8 8 0 0 1 8-7 8 8 0 1 1-5.3 14L4 17.6" />
                            <path d="M9 17H4v5" />
                        </svg>
                    </div>

                   <h1 class="text-2xl leading-tight font-black tracking-tight text-base-content">
                        Reset Password
                    </h1>
                    <p class="text-sm text-base-content/60 mt-2 leading-relaxed">
                        Create a new secure password for your account
                    </p>
                </div>

                <form
                    action="<?= e($_ENV["APP_URL"]) ?>/reset-password"
                    method="POST"
                    novalidate
                    class="space-y-5"
                >
                    <?= csrf_field() ?>

                    <input type="hidden" name="token" value="<?= e($token ?? "") ?>" />
                    <input type="hidden" name="email" value="<?= e($email ?? "") ?>" />

                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text text-sm font-medium">Password</span>
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Minimum of 8 characters"
                            class="input input-bordered h-12 rounded-xl w-full text-sm <?= !empty($errors["password"])
                                ? "input-error"
                                : "focus:input-primary"
                            ?>"
                            autocomplete="new-password"
                        />
                        <?php if (!empty($errors["password"])): ?>
                            <label class="label pt-2">
                                <span class="label-text-alt text-error text-xs">
                                    <?= e($errors["password"][0]) ?>
                                </span>
                            </label>
                        <?php endif; ?>
                    </div>

                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text text-sm font-medium">Confirm Password</span>
                        </label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Repeat your new password"
                            class="input input-bordered h-12 rounded-xl w-full text-sm <?= !empty($errors["password"])
                                ? "input-error"
                                : "focus:input-primary" ?>"
                            autocomplete="new-password"
                        />
                        <?php if (!empty($errors["password_confirmation"])): ?>
                            <label class="label pt-2">
                                <span class="label-text-alt text-error text-xs">
                                    <?= e($errors["password_confirmation"][0]) ?>
                                </span>
                            </label>
                        <?php endif; ?>
                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary h-12 min-h-12 w-full rounded-xl text-sm font-semibold shadow-md hover:scale-[1.01] transition mt-2"

                    >
                        Reset Password
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