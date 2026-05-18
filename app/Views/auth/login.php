<div class="flex-1 flex items-center justify-center">
    <div class="card bg-base-100 shadow-md w-full max-w-md">
        <div class="card-body">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-base-content">Welcome Back!</h1>
                <p class="text-base-content/60 text-sm mt-1">Sign in to your KartNest account</p>
            </div>

            <form
                action="<?= $_ENV["APP_URL"] ?>/login"
                method="POST"
                novalidate
            >
                <?= csrf_field() ?>

                <div class="form-control mb-4">
                    <label class="label" for="email">
                        <span class="label-text font-medium">Email address</span>
                    </label>
                    <input
                        type="text"
                        id="email"
                        name="email"
                        value="<?= old("email") ?>"
                        placeholder="Type here"
                        class="input input-bordered w-full <?= !empty($errors["email"])
                            ? "input-error"
                            : ""
                        ?>"
                        autocomplete="email"
                    />
                    <?php if (!empty($errors["email"])): ?>
                        <label class="label">
                            <span class="label-text-alt text-error">
                                <?= e($errors["email"][0]) ?>
                            </span>
                        </label>
                    <?php endif; ?>
                </div>

                <div class="form-control mb-3">
                    <label class="label" for="password">
                        <span class="label-text font-medium">Password</span>
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        value="<?= old("password") ?>"
                        placeholder="Type here"
                        class="input input-bordered w-full <?= !empty($errors["password"])
                            ? "input-error"
                            : ""
                        ?>"
                        autocomplete="current-password"
                    />
                    <?php if (!empty($errors["password"])): ?>
                        <label class="label">
                            <span class="label-text-alt text-error">
                                <?= e($errors["password"][0]) ?>
                            </span>
                        </label>
                    <?php endif; ?>
                </div>

                <div class="form-control flex justify-between">
                    <label class="label cursor-pointer flex items-center gap-2">
                        <input
                            type="checkbox"
                            name="remember_me"
                            value="1"
                            class="checkbox checkbox-primary checkbox-sm"
                        />
                        <span class="label-text">Remember me</span>
                    </label>
                    <a
                        href="<?= e($_ENV["APP_URL"]) ?>/forgot-password"
                        class="label-text-alt link link-hover text-primary"
                    >
                        Forgot your password?
                    </a>
                </div>

                <button type="submit" class="btn btn-primary w-full mt-8">
                    Sign in
                </button>
            </form>

            <div class="divider text-base-content/40 text-xs">
                don't have an account?
            </div>

            <a href="<?= $_ENV["APP_URL"] ?>/register" class="btn btn-outline w-full">
                Create account
            </a>
        </div>
    </div>
</div>