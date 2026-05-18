<div class="flex-1 flex items-center justify-center">
    <div class="card bg-base-100 shadow-md w-full max-w-md">
        <div class="card-body">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-base-content">Create an account</h1>
                <p class="text-base-content/60 text-sm mt-1">Join KartNest and start shopping</p>
            </div>

            <form
                action="<?= $_ENV["APP_URL"] ?>/register"
                method="POST"
                novalidate
            >
                <?= csrf_field() ?>

                <div class="form-control mb-4">
                    <label class="label" for="name">
                        <span class="label-text font-medium">Full Name</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="<?= old("name") ?>"
                        placeholder="Type here"
                        class="input input-bordered w-full <?= !empty($errors["name"])
                            ? "input-error"
                            : ""
                        ?>"
                        autocomplete="name"
                    />
                    <?php if (!empty($errors["name"])): ?>
                        <label class="label">
                            <span class="label-text-alt text-error">
                                <?= e($errors["name"][0]) ?>
                            </span>
                        </label>
                    <?php endif; ?>
                </div>

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

                <div class="form-control mb-4">
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
                        autocomplete="new-password"
                    />
                    <?php if (!empty($errors["password"])): ?>
                        <label class="label">
                            <span class="label-text-alt text-error">
                                <?= e($errors["password"][0]) ?>
                            </span>
                        </label>
                    <?php endif; ?>
                </div>

                <div class="form-control mb-4">
                    <label class="label" for="password_confirmation">
                        <span class="label-text font-medium">Confirm Password</span>
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        value="<?= old("password_confirmation") ?>"
                        placeholder="Type here"
                        class="input input-bordered w-full <?= !empty($errors["password_confirmation"])
                            ? "input-error"
                            : ""
                        ?>"
                        autocomplete="new-password"
                    />
                    <?php if (!empty($errors["password_confirmation"])): ?>
                        <label class="label">
                            <span class="label-text-alt text-error">
                                <?= e($errors["password_confirmation"][0]) ?>
                            </span>
                        </label>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary w-full">
                    Create account
                </button>
            </form>

            <div class="divider text-base-content/40 text-xs">
                already have an account?
            </div>

            <a href="<?= $_ENV["APP_URL"] ?>/login" class="btn btn-outline w-full">
                Sign in
            </a>
        </div>
    </div>
</div>