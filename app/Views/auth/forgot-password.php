<div class="flex-1 flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="card bg-base-100 shadow-xl border border-base-200">
            <div class="card-body p-8 gap-4">

                <!-- Header -->
                <div class="text-center space-y-2">
                    <div class="w-14 h-14 mx-auto rounded-full bg-primary/10 flex items-center justify-center">
                        <!-- Mail Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="w-6 h-6 text-primary" 
                             fill="none" 
                             viewBox="0 0 24 24" 
                             stroke="currentColor">
                            <path stroke-linecap="round" 
                                  stroke-linejoin="round" 
                                  stroke-width="2" 
                                  d="M16 12H8m8 0l-4-4m4 4l-4 4m12-4a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>

                    <h1 class="text-2xl font-bold text-base-content">
                        Forgot your password?
                    </h1>
                    <p class="text-sm text-base-content/60">
                        Enter your email address and we’ll send you a secure reset link.
                    </p>
                </div>

                <!-- Form -->
                <form
                    action="<?= e($_ENV["APP_URL"]) ?>/forgot-password"
                    method="POST"
                    novalidate
                    class="space-y-6"
                >
                    <?= csrf_field() ?>

                    <!-- Email Input -->
                    <div class="form-control">
                        <label class="label" for="email">
                            <span class="label-text font-medium">
                                Email Address
                            </span>
                        </label>

                        <div class="relative">
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="<?= old("email") ?>"
                                placeholder="you@example.com"
                                class="input input-bordered w-full pl-10 
                                <?= !empty($errors["email"]) ? "input-error" : "" ?>"
                                autocomplete="email"
                            />

                            <!-- Input Icon -->
                            <span class="absolute inset-y-0 left-3 flex items-center text-base-content/40">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                     class="w-4 h-4" 
                                     fill="none" 
                                     viewBox="0 0 24 24" 
                                     stroke="currentColor">
                                    <path stroke-linecap="round" 
                                          stroke-linejoin="round" 
                                          stroke-width="2" 
                                          d="M16 12H8m8 0l-4-4m4 4l-4 4m12-4a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </span>
                        </div>

                        <?php if (!empty($errors["email"])): ?>
                            <label class="label">
                                <span class="label-text-alt text-error">
                                    <?= e($errors["email"][0]) ?>
                                </span>
                            </label>
                        <?php endif; ?>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="btn btn-primary w-full tracking-wide shadow-md hover:shadow-lg transition-all duration-200"
                    >
                        Send Reset Link
                    </button>
                </form>

                <!-- Divider -->
                <div class="divider text-xs text-base-content/40">OR</div>

                <!-- Back to Login -->
                <div class="text-center">
                    <a
                        href="<?= e($_ENV["APP_URL"]) ?>/login"
                        class="text-sm font-medium text-base-content/60 hover:text-primary transition-colors"
                    >
                        ← Back to Sign In
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>