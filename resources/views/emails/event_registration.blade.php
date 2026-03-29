<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Inscrição Confirmada</title>
    </head>
    <body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f4f6f8;">

        <table width="100%" cellpadding="0" cellspacing="0" style="padding: 20px;">
            <tr>
                <td align="center">

                    <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 5px 15px rgba(0,0,0,0.1);">

                        <!-- HEADER -->
                        <tr>
                            <td style="background:#0B2E33; padding:30px; text-align:center; color:#ffffff;">
                                <h1 style="margin:0;">🏃 SquadRun</h1>
                                <p style="margin:5px 0 0;">Sua corrida começa aqui</p>
                            </td>
                        </tr>

                        <!-- BODY -->
                        <tr>
                            <td style="padding:30px;">

                                <h2 style="color:#0B2E33; margin-top:0;">
                                    🎉 Inscrição Confirmada!
                                </h2>

                                <p style="color:#333;">
                                    Olá <strong>{{ $competitor->user->name }}</strong>,
                                </p>

                                <p style="color:#333;">
                                    Sua inscrição foi realizada com sucesso no evento:
                                </p>

                                <!-- EVENT CARD -->
                                <table width="100%" cellpadding="0" cellspacing="0" style="background:#f9f9f9; border-radius:8px; padding:15px; margin:20px 0;">
                                    <tr>
                                        <td>
                                            <h3 style="margin:0; color:#0B2E33;">
                                                {{ $event->title }}
                                            </h3>

                                            <p style="margin:5px 0; color:#555;">
                                                📅 Data: {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y H:i') }}
                                            </p>

                                            <p style="margin:5px 0; color:#555;">
                                                📍 Percurso: {{ $event->route_km }} KM
                                            </p>

                                            <p style="margin:5px 0; color:#555;">
                                                🛣️ {{ $event->route_description }}
                                            </p>
                                        </td>
                                    </tr>
                                </table>

                                <p style="color:#333;">
                                    Prepare-se e dê o seu melhor! 💪🔥
                                </p>

                                <!-- BUTTON -->
                                <div style="text-align:center; margin:30px 0;">
                                    <a href="#" style="
                                        background:#4F7C82;
                                        color:#ffffff;
                                        padding:12px 25px;
                                        text-decoration:none;
                                        border-radius:5px;
                                        font-weight:bold;
                                        display:inline-block;
                                    ">
                                        Ver Evento
                                    </a>
                                </div>

                                <p style="color:#777; font-size:14px;">
                                    Boa sorte na corrida! 🚀
                                </p>

                            </td>
                        </tr>

                        <!-- FOOTER -->
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
