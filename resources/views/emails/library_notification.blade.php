<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mailSubject }}</title>
</head>

<body style="margin:0; padding:0; background-color:#f1f5f9; font-family:'Segoe UI', Arial, sans-serif; color:#0f172a;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="padding: 24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                    style="max-width:560px; background:#ffffff; border-radius:14px; overflow:hidden; box-shadow:0 4px 16px rgba(15,23,42,0.06);">
                    {{-- Header --}}
                    <tr>
                        <td style="background:#0f172a; padding:22px 24px; text-align:left;">
                            <span
                                style="display:inline-block; background:{{ $badgeColor }}; color:#ffffff; font-size:11px; font-weight:700; letter-spacing:0.06em; padding:4px 10px; border-radius:999px; text-transform:uppercase;">
                                {{ $badgeText }}
                            </span>
                            <h2 style="margin:10px 0 0; color:#ffffff; font-size:20px; font-weight:700;">
                                {{ $libraryName }}
                            </h2>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:24px;">
                            <p style="margin:0 0 12px; font-size:15px;">
                                Hello <strong>{{ $recipientName }}</strong>,
                            </p>
                            <p style="margin:0 0 20px; font-size:14px; line-height:1.6; color:#334155;">
                                {{ $introMessage }}
                            </p>

                            @if (!empty($details))
                                <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                                    style="border:1px solid #e2e8f0; border-radius:10px; overflow:hidden; font-size:13px;">
                                    @foreach ($details as $label => $value)
                                        <tr>
                                            <td
                                                style="padding:10px 14px; background:#f8fafc; color:#64748b; border-bottom:1px solid #e2e8f0; width:42%; font-weight:600;">
                                                {{ $label }}
                                            </td>
                                            <td
                                                style="padding:10px 14px; background:#ffffff; color:#0f172a; border-bottom:1px solid #e2e8f0; font-weight:600;">
                                                {{ $value }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif

                            @if ($footerNote)
                                <p
                                    style="margin:18px 0 0; font-size:13px; color:#475569; background:#f8fafc; padding:12px 14px; border-left:3px solid {{ $badgeColor }}; border-radius:6px;">
                                    {{ $footerNote }}
                                </p>
                            @endif
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td
                            style="background:#f8fafc; padding:16px 24px; border-top:1px solid #e2e8f0; font-size:12px; color:#64748b; text-align:center;">
                            Sent automatically by <strong>{{ $libraryName }}</strong> via LMSP
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
