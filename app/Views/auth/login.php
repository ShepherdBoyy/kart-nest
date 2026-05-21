<div class="flex-1 flex items-center justify-center py-18">
    <div class="w-full max-w-lg">
        <div class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden">
            <div class="card-body p-7 sm:p-8">
                <div class="text-center mb-7">
                    <div class="mx-auto mb-4 w-14 h-14 bg-primary rounded-2xl text-primary-content flex items-center justify-center shadow-md">
                        <span class="text-xl font-black">K</span>
                    </div>

                    <h1 class="text-2xl leading-tight font-black tracking-tight text-base-content">
                        Welcome Back!
                    </h1>

                    <p class="text-base-content/60 mt-2 text-sm">
                        Sign in to your KartNest account
                    </p>
                </div>
    
                <form
                    action="<?= $_ENV["APP_URL"] ?>/login"
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
    
                    <div class="form-control">
                        <div class="flex items-center justify-between">
                            <label class="label py-1" for="password">
                                <span class="label-text text-sm font-semibold">
                                    Password
                                </span>
                            </label>
                            <a
                                href="<?= e($_ENV["APP_URL"]) ?>/forgot-password"
                                class="text-sm text-primary hover:underline"
                            >
                                Forgot your password?
                            </a>
                        </div>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            value="<?= old("password") ?>"
                            placeholder="Type here"
                            class="input input-bordered h-12 rounded-xl w-full text-sm <?= !empty($errors["password"])
                                ? "input-error"
                                : "focus:input-primary"
                            ?>"
                            autocomplete="current-password"
                        />
                        <?php if (!empty($errors["password"])): ?>
                            <label class="label pt-2">
                                <span class="label-text-alt text-error text-xs">
                                    <?= e($errors["password"][0]) ?>
                                </span>
                            </label>
                        <?php endif; ?>
                    </div>
    
                    <label class="label cursor-pointer gap-2">
                        <input
                            type="checkbox"
                            name="remember_me"
                            value="1"
                            class="checkbox checkbox-primary checkbox-sm rounded-md"
                        />
                        <span class="label-text text-sm">Remember me</span>
                    </label>
    
                    <button
                        type="submit"
                        class="btn btn-primary h-12 min-h-12 w-full rounded-xl text-sm font-semibold shadow-md hover:scale-[1.01] transition mt-2"
                    >
                        Sign in
                    </button>
                </form>
    
                <div class="divider text-xs text-base-content/40 my-6">
                    new to KartNest?
                </div>
    
                <a
                    href="<?= $_ENV["APP_URL"] ?>/register"
                    class="btn btn-outline h-12 min-h-12 w-full rounded-xl text-sm"
                >
                    Create account
                </a>
            </div>
        </div>
    </div>
</div>