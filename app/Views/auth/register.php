<div class="flex-1 flex items-center justify-center">
    <div class="w-full max-w-lg">
        <div class="card bg-base-100 border border-base-300 shadow-xl rounded-3xl overflow-hidden">
            <div class="card-body p-7 sm:p-8">
                <div class="text-center mb-7">
                    <div class="mx-auto mb-4 w-14 h-14 rounded-2xl bg-primary text-primary-content flex items-center justify-center shadow-md">
                        <span class="text-xl font-black">K</span>
                    </div>
                    <h1 class="text-2xl leading-tight font-black tracking-tight text-base-content">
                        Create an account
                    </h1>
                    <p class="text-sm text-base-content/60 mt-2">Join KartNest and start shopping</p>
                </div>
    
                <form
                    action="<?= $_ENV["APP_URL"] ?>/register"
                    method="POST"
                    novalidate
                    class="space-y-5"
                >
                    <?= csrf_field() ?>
    
                    <div class="form-control">
                        <label class="label py-1" for="name">
                            <span class="label-text text-sm font-medium">Full Name</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="<?= old("name") ?>"
                            placeholder="Type here"
                            class="input input-bordered h-12 rounded-xl w-full text-sm <?= !empty($errors["name"])
                                ? "input-error"
                                : "focus:input-primary"
                            ?>"
                            autocomplete="name"
                        />
                        <?php if (!empty($errors["name"])): ?>
                            <label class="label">
                                <span class="label-text-alt text-error text-xs">
                                    <?= e($errors["name"][0]) ?>
                                </span>
                            </label>
                        <?php endif; ?>
                    </div>
    
                    <div class="form-control">
                        <label class="label py-1" for="email">
                            <span class="label-text text-sm font-medium">Email address</span>
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
                            <label class="label">
                                <span class="label-text-alt text-error text-xs">
                                    <?= e($errors["email"][0]) ?>
                                </span>
                            </label>
                        <?php endif; ?>
                    </div>
    
                    <div class="form-control">
                        <label class="label py-1" for="password">
                            <span class="label-text text-sm font-medium">Password</span>
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            value="<?= old("password") ?>"
                            placeholder="Type here"
                            class="input input-bordered h-12 rounded-xl w-full text-sm  <?= !empty($errors["password"])
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
                        <label class="label py-1" for="password_confirmation">
                            <span class="label-text text-sm font-medium">Confirm Password</span>
                        </label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            value="<?= old("password_confirmation") ?>"
                            placeholder="Type here"
                            class="input input-bordered h-12 rounded-xl w-full text-sm <?= !empty($errors["password_confirmation"])
                                ? "input-error"
                                : "focus:input-prmary"
                            ?>"
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
    
                    <button type="submit" class="btn btn-primary min-h-12 w-full rounded-xl text-sm font-semibold shadow-md hover:scale-[1.01] transition mt-2">
                        Create account
                    </button>
                </form>
    
                <div class="divider text-xs text-base-content/40 my-6">
                    already have an account?
                </div>
    
                <a 
                    href="<?= $_ENV["APP_URL"] ?>/login"
                    class="btn btn-outline h-12 min-h-12 w-full rounded-xl text-sm"
                >
                    Sign in
                </a>
            </div>
        </div>
    </div>
</div>