<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset your KartNest password</title>
</head>

<body style="margin:0; padding:0; background-color:#f3f4f6; font-family:Arial,sans-serif;">

    <table
        width="100%"
        cellpadding="0"
        cellspacing="0"
        style="background-color:#f3f4f6; padding:40px 16px;"
    >
        <tr>
            <td align="center">
                <table
                    width="100%"
                    cellpadding="0"
                    cellspacing="0"
                    style="max-width:600px; background-color:#ffffff; border-radius:20px; overflow:hidden; box-shadow:0 8px 30px rgba(0,0,0,0.08);"
                >
                    <tr>
                        <td
                            align="center"
                            style="background:linear-gradient(135deg,#570df8,#7c3aed); padding:40px 32px;"
                        >
                            <table 
                                cellpadding="0"
                                cellspacing="0" style="margin-bottom:16px;"
                            >
                                <tr>
                                    <td
                                        align="center"
                                        style="width:56px; height:56px; border-radius:16px; background-color:rgba(255,255,255,0.15); color:#ffffff; font-size:28px; font-weight:800;"
                                    >
                                        K
                                    </td>
                                </tr>
                            </table>

                            <h1 style="
                                color:#ffffff;
                                margin:0;
                                font-size:28px;
                                font-weight:700;
                                letter-spacing:-0.5px;
                            ">
                                Reset Your Password
                            </h1>

                            <p style="
                                color:rgba(255,255,255,0.85);
                                font-size:15px;
                                margin:12px 0 0;
                                line-height:1.6;
                            ">
                                Secure access to your KartNest account
                            </p>

                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:40px 36px;">

                            <p style="
                                color:#111827;
                                font-size:16px;
                                margin:0 0 18px;
                                line-height:1.7;
                            ">
                                Hi
                                <strong>
                                    <?= htmlspecialchars($userName ?? "") ?>
                                </strong>,
                            </p>

                            <p style="
                                color:#4b5563;
                                font-size:15px;
                                margin:0 0 18px;
                                line-height:1.8;
                            ">
                                We received a request to reset the password for your
                                KartNest account. Click the button below to create a
                                new secure password.
                            </p>

                            <!-- Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin:36px 0;">
                                <tr>
                                    <td align="center">

                                        <a href="<?= htmlspecialchars($resetUrl ?? "") ?>" style="
                                                background-color:#570df8;
                                                color:#ffffff;
                                                text-decoration:none;
                                                padding:14px 30px;
                                                border-radius:12px;
                                                display:inline-block;
                                                font-size:15px;
                                                font-weight:700;
                                                box-shadow:0 6px 16px rgba(87,13,248,0.25);
                                            ">
                                            Reset Password
                                        </a>

                                    </td>
                                </tr>
                            </table>

                            <!-- Expiry Notice -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="
                                    background-color:#f9fafb;
                                    border:1px solid #e5e7eb;
                                    border-radius:14px;
                                    margin-bottom:24px;
                                ">
                                <tr>
                                    <td style="padding:18px 20px;">

                                        <p style="
                                            margin:0;
                                            color:#374151;
                                            font-size:14px;
                                            line-height:1.7;
                                        ">
                                            This password reset link will expire in
                                            <strong>
                                                <?= htmlspecialchars($expiry ?? "") ?>
                                            </strong>
                                            hour.
                                        </p>

                                    </td>
                                </tr>
                            </table>

                            <!-- Security Notice -->
                            <p style="
                                color:#6b7280;
                                font-size:14px;
                                line-height:1.8;
                                margin:0 0 24px;
                            ">
                                If you didn't request a password reset, you can safely
                                ignore this email. Your password will remain unchanged.
                            </p>

                            <!-- Fallback Link -->
                            <div style="
                                border-top:1px solid #e5e7eb;
                                padding-top:24px;
                            ">

                                <p style="
                                    color:#9ca3af;
                                    font-size:12px;
                                    line-height:1.7;
                                    margin:0 0 10px;
                                ">
                                    If the button above doesn't work, copy and paste
                                    this link into your browser:
                                </p>

                                <a href="<?= htmlspecialchars($resetUrl ?? "") ?>" style="
                                        color:#570df8;
                                        font-size:12px;
                                        word-break:break-all;
                                        text-decoration:none;
                                    ">
                                    <?= htmlspecialchars($resetUrl ?? "") ?>
                                </a>

                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="
                                background-color:#f9fafb;
                                border-top:1px solid #e5e7eb;
                                padding:24px;
                            ">

                            <p style="
                                margin:0 0 6px;
                                color:#6b7280;
                                font-size:13px;
                                font-weight:600;
                            ">
                                KartNest
                            </p>

                            <p style="
                                margin:0;
                                color:#9ca3af;
                                font-size:12px;
                            ">
                                © <?= date('Y') ?> KartNest. All rights reserved.
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>