<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Confirme seu e-mail</title>
    </head>
    <body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f4f6f8;">
        <table width="100%" cellpadding="0" cellspacing="0" style="padding: 20px;">
            <tr>
                <td align="center">
                    <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 5px 15px rgba(0,0,0,0.1);">
                        <tr>
                            <td style="background:#0B2E33; padding:30px; text-align:center; color:#ffffff;">
                                <h1 style="margin:0;">🏃 SquadRun</h1>
                                <p style="margin:5px 0 0;">Confirme sua conta</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:30px;">
                                <h2 style="color:#0B2E33; margin-top:0;">
                                    Bem-vindo, {{ $user->name }} 🎉
                                </h2>
                                <p style="color:#333;">
                                    Falta só mais um passo para ativar sua conta na SquadRun.
                                </p>
                                <p style="color:#333;">
                                    Clique no botão abaixo para confirmar seu e-mail e começar a usar a plataforma.
                                </p>
                                <div style="text-align:center; margin:30px 0;">
                                    <a href="{{ $verifyUrl }}" style="
                                        background:#4F7C82;
                                        color:#ffffff;
                                        padding:12px 25px;
                                        text-decoration:none;
                                        border-radius:5px;
                                        font-weight:bold;
                                        display:inline-block;
                                    ">
                                        Confirmar E-mail
                                    </a>
                                </div>
                                <p style="color:#777; font-size:13px;">
                                    Se você não criou essa conta, ignore este e-mail.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td style="background:#B8E3E9; padding:20px; text-align:center; font-size:12px; color:#0B2E33;">
                                © {{ date('Y') }} SquadRun • Todos os direitos reservados
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>