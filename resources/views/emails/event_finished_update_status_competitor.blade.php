<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Evento Finalizado</title>
    </head>

    <body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f4f6f8;">

        <table width="100%" cellpadding="0" cellspacing="0" style="padding: 20px;">
            <tr>
                <td align="center">

                    <table width="600" cellpadding="0" cellspacing="0"
                        style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 5px 15px rgba(0,0,0,0.1);">

                        <!-- HEADER -->
                        <tr>
                            <td style="background:#0B2E33; padding:30px; text-align:center; color:#ffffff;">
                                <h1 style="margin:0;">🏁 SquadRun</h1>
                                <p style="margin:5px 0 0;">Evento finalizado com sucesso</p>
                            </td>
                        </tr>

                        <!-- BODY -->
                        <tr>
                            <td style="padding:30px;">

                                <h2 style="color:#0B2E33; margin-top:0;">
                                    🎉 Parabéns, {{ $competitor->user->name }}!
                                </h2>

                                <p style="color:#333;">
                                    Você concluiu o evento <strong>{{ $event->title }}</strong> com sucesso!
                                </p>

                                <!-- RESULT CARD -->
                                <table width="100%" cellpadding="0" cellspacing="0"
                                    style="background:#f9f9f9; border-radius:8px; padding:15px; margin:20px 0;">
                                    <tr>
                                        <td>

                                            <p style="margin:5px 0; color:#555;">
                                                🏆 Posição:
                                                <strong>#{{ $competitor->registrations->where('id_event', $event->id)->first()->position }}</strong>
                                            </p>

                                            <p style="margin:5px 0; color:#555;">
                                                ⏱️ Tempo total:
                                                <strong>{{ gmdate('H:i:s', $competitor->registrations->where('id_event', $event->id)->first()->total_time) }}</strong>
                                            </p>

                                            <p style="margin:5px 0; color:#555;">
                                                📏 Distância percorrida:
                                                <strong>{{ $competitor->registrations->where('id_event', $event->id)->first()->traveled_km }}
                                                    KM</strong>
                                            </p>

                                        </td>
                                    </tr>
                                </table>

                                <!-- STATS -->
                                @if ($competitor->competitorData)
                                    <table width="100%" cellpadding="0" cellspacing="0" style="margin:20px 0;">
                                        <tr>
                                            <td>

                                                <h3 style="color:#0B2E33;">📊 Seu desempenho geral</h3>

                                                <p style="color:#555;">🏃 Corridas concluídas:
                                                    <strong>{{ $competitor->competitorData->total_runs }}</strong></p>
                                                <p style="color:#555;">📏 Total percorrido:
                                                    <strong>{{ $competitor->competitorData->total_km }} KM</strong></p>
                                                <p style="color:#555;">⚡ Melhor tempo:
                                                    <strong>{{ $competitor->competitorData->best_time }}</strong></p>

                                            </td>
                                        </tr>
                                    </table>
                                @endif

                                <!-- CERTIFICATE -->
                                <div
                                    style="
                                        margin:30px 0;
                                        padding:25px;
                                        border:2px dashed #4F7C82;
                                        border-radius:10px;
                                        text-align:center;
                                        background:#f9f9f9;
                                    ">
                                    <h2 style="color:#0B2E33; margin:0;">🏅 Certificado de Participação</h2>

                                    <p style="margin:15px 0; color:#333;">
                                        Certificamos que
                                    </p>

                                    <h3 style="margin:10px 0; color:#0B2E33;">
                                        {{ $competitor->user->name }}
                                    </h3>

                                    <p style="margin:10px 0; color:#333;">
                                        concluiu com sucesso o evento
                                    </p>

                                    <strong style="color:#4F7C82;">
                                        {{ $event->title }}
                                    </strong>

                                    <p style="margin-top:15px; color:#777; font-size:12px;">
                                        Data: {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}
                                    </p>
                                </div>

                                <!-- MOTIVATION -->
                                <div
                                    style="
                                        background:#B8E3E9;
                                        padding:15px;
                                        border-radius:8px;
                                        text-align:center;
                                        margin:20px 0;
                                        color:#0B2E33;
                                        font-weight:bold;
                                    ">
                                    Continue evoluindo e superando seus limites! 🚀
                                </div>

                            </td>
                        </tr>

                        <!-- FOOTER -->
                        <tr>
                            <td style="background:#0B2E33; padding:20px; text-align:center; font-size:12px; color:#ffffff;">
                                © {{ date('Y') }} SquadRun • Todos os direitos reservados
                            </td>
                        </tr>

                    </table>

                </td>
            </tr>
        </table>
    </body>
</html>
