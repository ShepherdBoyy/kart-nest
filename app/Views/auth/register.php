<div class="min-h-screen flex items-center justify-center py-12">
    <div class="card bg-base-100 shadow-md w-full max-w-md">
        <div class="card-body gap-6">

            <!-- Header -->
            <div class="text-center">
                <h1 class="text-2xl font-bold text-base-content">
                    Create an account
                </h1>
                <p class="text-base-content/60 text-sm mt-1">
                    Join KartNest and start shopping
                </p>
            </div>

            <!-- Registration Form -->
            <form action="<?= e($_ENV['APP_URL']) ?>/register" method="POST" novalidate>

                <?= csrf_field() ?>

                <!-- Name Field -->
                <div class="form-control mb-4">
                    <label class="label" for="name">
                        <span class="label-text font-medium">
                            Full name
                        </span>
                    </label>
                    <input type="text" id="name" name="name" value="<?= old('name') ?>" placeholder="John Doe" class="input input-bordered w-full
                               <?= !empty($errors['name'])
                                   ? 'input-error'
                                   : '' ?>" autocomplete="name" autofocus>
                    <?php if (!empty($errors['name'])): ?>
                        <label class="label">
                            <span class="label-text-alt text-error">
                                <?= e($errors['name'][0]) ?>
                            </span>
                        </label>
                    <?php endif; ?>
                </div>

                <!-- Email Field -->
                <div class="form-control mb-4">
                    <label class="label" for="email">
                        <span class="label-text font-medium">
                            Email address
                        </span>
                    </label>
                    <input type="email" id="email" name="email" value="<?= old('email') ?>"
                        placeholder="john@example.com" class="input input-bordered w-full
                               <?= !empty($errors['email'])
                                   ? 'input-error'
                                   : '' ?>" autocomplete="email">
                    <?php if (!empty($errors['email'])): ?>
                        <label class="label">
                            <span class="label-text-alt text-error">
                                <?= e($errors['email'][0]) ?>
                            </span>
                        </label>
                    <?php endif; ?>
                </div>

                <!-- Password Field -->
                <div class="form-control mb-4">
                    <label class="label" for="password">
                        <span class="label-text font-medium">
                            Password
                        </span>
                    </label>
                    <input type="password" id="password" name="password" placeholder="Minimum 8 characters" class="input input-bordered w-full
                               <?= !empty($errors['password'])
                                   ? 'input-error'
                                   : '' ?>" autocomplete="new-password">
                    <?php if (!empty($errors['password'])): ?>
                        <label class="label">
                            <span class="label-text-alt text-error">
                                <?= e($errors['password'][0]) ?>
                            </span>
                        </label>
                    <?php endif; ?>
                </div>

                <!-- Confirm Password Field -->
                <div class="form-control mb-6">
                    <label class="label" for="password_confirmation">
                        <span class="label-text font-medium">
                            Confirm password
                        </span>
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="Repeat your password" class="input input-bordered w-full
                               <?= !empty($errors['password_confirmation'])
                                   ? 'input-error'
                                   : '' ?>" autocomplete="new-password">
                    <?php if (!empty($errors['password_confirmation'])): ?>
                        <label class="label">
                            <span class="label-text-alt text-error">
                                <?= e($errors['password_confirmation'][0]) ?>
                            </span>
                        </label>
                    <?php endif; ?>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-full">
                    Create account
                </button>

            </form>

            <!-- Divider -->
            <div class="divider text-base-content/40 text-xs">
                already have an account?
            </div>

            <!-- Login Link -->
            <a href="<?= e($_ENV['APP_URL']) ?>/login" class="btn btn-outline w-full">
                Sign in
            </a>

        </div>
    </div>
</div>