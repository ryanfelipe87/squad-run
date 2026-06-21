<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SquadRun — Sua corrida começa aqui</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --deep:   #0B2E33;
            --mid:    #4F7C82;
            --mist:   #B8E3E9;
            --pale:   #f4f6f8;
            --white:  #ffffff;
            --text:   #1a1a1a;
            --subtle: #556268;
            --border: #d4dfe0;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--white);
            color: var(--text);
            overflow-x: hidden;
        }

        /* ══════════════════════════════
           NAV
        ══════════════════════════════ */
        .nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            height: 64px;
            background: rgba(11,46,51,0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(184,227,233,0.1);
        }

        .nav-logo {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--white);
            letter-spacing: -0.4px;
            text-decoration: none;
        }

        .nav-logo span { color: var(--mist); }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link {
            font-size: 0.88rem;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 8px;
            transition: color 0.15s, background 0.15s;
        }

        .nav-link:hover {
            color: var(--white);
            background: rgba(255,255,255,0.07);
        }

        .nav-btn {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--deep);
            background: var(--mist);
            text-decoration: none;
            padding: 9px 20px;
            border-radius: 8px;
            transition: background 0.15s, transform 0.1s;
        }

        .nav-btn:hover { background: var(--white); }
        .nav-btn:active { transform: scale(0.98); }

        /* hamburger (mobile) */
        .nav-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 6px;
            background: none;
            border: none;
        }

        .nav-toggle span {
            display: block;
            width: 22px;
            height: 2px;
            background: var(--white);
            border-radius: 2px;
            transition: transform 0.25s, opacity 0.25s;
        }

        .nav-toggle.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .nav-toggle.open span:nth-child(2) { opacity: 0; }
        .nav-toggle.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        /* mobile menu */
        .nav-mobile {
            display: none;
            position: fixed;
            top: 64px; left: 0; right: 0;
            background: var(--deep);
            border-bottom: 1px solid rgba(184,227,233,0.1);
            padding: 16px 24px 24px;
            z-index: 99;
            flex-direction: column;
            gap: 4px;
        }

        .nav-mobile.open { display: flex; }

        .nav-mobile .nav-link {
            font-size: 1rem;
            padding: 12px 16px;
            color: rgba(255,255,255,0.75);
        }

        .nav-mobile .nav-btn {
            margin-top: 8px;
            text-align: center;
            padding: 13px 20px;
            font-size: 1rem;
        }

        /* ══════════════════════════════
           HERO
        ══════════════════════════════ */
        .hero {
            min-height: 100vh;
            background: var(--deep);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 120px 24px 80px;
            position: relative;
            overflow: hidden;
        }

        /* pista de corrida decorativa */
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(
                180deg,
                transparent,
                transparent 70px,
                rgba(255,255,255,0.03) 70px,
                rgba(255,255,255,0.03) 72px
            );
            pointer-events: none;
        }

        /* arco de luz */
        .hero::after {
            content: '';
            position: absolute;
            top: -200px;
            left: 50%;
            transform: translateX(-50%);
            width: 900px;
            height: 600px;
            background: radial-gradient(ellipse at center, rgba(79,124,130,0.18) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-inner {
            position: relative;
            z-index: 1;
            max-width: 780px;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.72rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--mist);
            margin-bottom: 28px;
            opacity: 0.9;
        }

        .hero-eyebrow::before,
        .hero-eyebrow::after {
            content: '';
            display: block;
            width: 28px;
            height: 1px;
            background: var(--mist);
            opacity: 0.5;
        }

        .hero-headline {
            font-size: clamp(3rem, 8vw, 6rem);
            font-weight: 900;
            color: var(--white);
            line-height: 1.0;
            letter-spacing: -3px;
            margin-bottom: 28px;
        }

        .hero-headline em {
            font-style: normal;
            color: var(--mist);
        }

        .hero-sub {
            font-size: clamp(1rem, 2.5vw, 1.2rem);
            color: rgba(255,255,255,0.5);
            line-height: 1.7;
            max-width: 520px;
            margin: 0 auto 48px;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .btn-primary {
            display: inline-block;
            padding: 15px 32px;
            background: var(--mist);
            color: var(--deep);
            font-size: 1rem;
            font-weight: 800;
            text-decoration: none;
            border-radius: 10px;
            letter-spacing: -0.2px;
            transition: background 0.15s, transform 0.1s;
        }

        .btn-primary:hover { background: var(--white); }
        .btn-primary:active { transform: scale(0.98); }

        .btn-ghost {
            display: inline-block;
            padding: 15px 32px;
            color: rgba(255,255,255,0.7);
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            border-radius: 10px;
            border: 1.5px solid rgba(255,255,255,0.15);
            transition: border-color 0.15s, color 0.15s;
        }

        .btn-ghost:hover {
            border-color: rgba(184,227,233,0.5);
            color: var(--mist);
        }

        /* contador de KM */
        .hero-km {
            display: inline-flex;
            align-items: baseline;
            gap: 6px;
            margin-top: 56px;
            padding: 14px 28px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(184,227,233,0.15);
            border-radius: 100px;
        }

        .km-num {
            font-size: 1.6rem;
            font-weight: 900;
            color: var(--mist);
            letter-spacing: -1px;
            font-variant-numeric: tabular-nums;
        }

        .km-label {
            font-size: 0.78rem;
            color: rgba(255,255,255,0.4);
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* seta de scroll */
        .scroll-hint {
            position: absolute;
            bottom: 32px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            color: rgba(255,255,255,0.25);
            font-size: 0.7rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            animation: bounce 2s ease-in-out infinite;
        }

        .scroll-hint svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
        }

        @keyframes bounce {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50%       { transform: translateX(-50%) translateY(6px); }
        }

        /* ══════════════════════════════
           STATS BAR
        ══════════════════════════════ */
        .stats-bar {
            background: var(--pale);
            border-bottom: 1px solid var(--border);
        }

        .stats-bar-inner {
            max-width: 960px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            divide: var(--border);
        }

        .stat-item {
            padding: 36px 24px;
            text-align: center;
            border-right: 1px solid var(--border);
        }

        .stat-item:last-child { border-right: none; }

        .stat-item-num {
            font-size: 2.4rem;
            font-weight: 900;
            color: var(--deep);
            letter-spacing: -2px;
            line-height: 1;
            margin-bottom: 6px;
        }

        .stat-item-label {
            font-size: 0.78rem;
            color: var(--subtle);
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* ══════════════════════════════
           COMO FUNCIONA
        ══════════════════════════════ */
        .section {
            padding: 96px 24px;
        }

        .section-inner {
            max-width: 960px;
            margin: 0 auto;
        }

        .section-label {
            font-size: 0.72rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--mid);
            margin-bottom: 14px;
            font-weight: 600;
        }

        .section-title {
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            font-weight: 900;
            color: var(--deep);
            letter-spacing: -1.5px;
            line-height: 1.1;
            margin-bottom: 56px;
        }

        .steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2px;
            background: var(--border);
            border-radius: 16px;
            overflow: hidden;
        }

        .step {
            background: var(--white);
            padding: 40px 32px;
            position: relative;
        }

        .step-icon {
            width: 48px;
            height: 48px;
            background: var(--deep);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 20px;
        }

        .step-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--deep);
            letter-spacing: -0.4px;
            margin-bottom: 10px;
        }

        .step-desc {
            font-size: 0.92rem;
            color: var(--subtle);
            line-height: 1.65;
        }

        /* seta entre steps */
        .step:not(:last-child)::after {
            content: '→';
            position: absolute;
            top: 40px;
            right: -14px;
            width: 28px;
            height: 28px;
            background: var(--pale);
            border: 1px solid var(--border);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            color: var(--mid);
            z-index: 1;
            line-height: 28px;
            text-align: center;
        }

        /* ══════════════════════════════
           PRÓXIMOS EVENTOS
        ══════════════════════════════ */
        .section-events {
            background: var(--pale);
        }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .event-card {
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .event-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(11,46,51,0.1);
        }

        .event-card-top {
            background: var(--deep);
            padding: 24px;
            position: relative;
            overflow: hidden;
        }

        .event-card-top::before {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(
                90deg,
                transparent,
                transparent 18px,
                rgba(255,255,255,0.03) 18px,
                rgba(255,255,255,0.03) 20px
            );
        }

        .event-distance {
            font-size: 2.8rem;
            font-weight: 900;
            color: var(--mist);
            letter-spacing: -2px;
            line-height: 1;
            position: relative;
        }

        .event-distance span {
            font-size: 1rem;
            letter-spacing: 0;
            font-weight: 600;
            color: rgba(184,227,233,0.6);
        }

        .event-card-body {
            padding: 20px 24px 24px;
        }

        .event-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--deep);
            letter-spacing: -0.3px;
            margin-bottom: 10px;
        }

        .event-meta {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-bottom: 20px;
        }

        .event-meta-item {
            font-size: 0.82rem;
            color: var(--subtle);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .event-meta-item svg {
            width: 13px;
            height: 13px;
            stroke: var(--mid);
            flex-shrink: 0;
        }

        .event-tag {
            display: inline-block;
            padding: 4px 10px;
            background: rgba(11,46,51,0.06);
            color: var(--mid);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            border-radius: 100px;
            text-transform: uppercase;
        }

        .event-cta {
            display: block;
            width: 100%;
            padding: 11px;
            background: var(--deep);
            color: var(--white);
            font-size: 0.88rem;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            border-radius: 9px;
            margin-top: 16px;
            transition: background 0.15s;
        }

        .event-cta:hover { background: var(--mid); }

        /* ══════════════════════════════
           CTA FINAL
        ══════════════════════════════ */
        .section-cta {
            background: var(--deep);
            padding: 100px 24px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .section-cta::before {
            content: '';
            position: absolute;
            bottom: -100px;
            left: 50%;
            transform: translateX(-50%);
            width: 700px;
            height: 400px;
            background: radial-gradient(ellipse at center, rgba(79,124,130,0.2) 0%, transparent 70%);
            pointer-events: none;
        }

        .section-cta .section-inner { position: relative; z-index: 1; }

        .cta-headline {
            font-size: clamp(2rem, 5vw, 3.6rem);
            font-weight: 900;
            color: var(--white);
            letter-spacing: -2px;
            line-height: 1.05;
            margin-bottom: 20px;
        }

        .cta-headline em {
            font-style: normal;
            color: var(--mist);
        }

        .cta-sub {
            font-size: 1.05rem;
            color: rgba(255,255,255,0.45);
            margin-bottom: 44px;
            max-width: 440px;
            margin-left: auto;
            margin-right: auto;
        }

        /* ══════════════════════════════
           FOOTER
        ══════════════════════════════ */
        .footer {
            background: var(--deep);
            border-top: 1px solid rgba(184,227,233,0.1);
            padding: 32px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .footer-logo {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--white);
            letter-spacing: -0.3px;
        }

        .footer-logo span { color: var(--mist); }

        .footer-copy {
            font-size: 0.78rem;
            color: rgba(255,255,255,0.3);
        }

        /* ══════════════════════════════
           MOBILE ≤ 640px
        ══════════════════════════════ */
        @media (max-width: 640px) {
            .nav { padding: 0 20px; }
            .nav-links { display: none; }
            .nav-toggle { display: flex; }

            .hero { padding: 100px 20px 80px; }
            .hero-km { margin-top: 40px; }
            .scroll-hint { display: none; }

            .stats-bar-inner {
                grid-template-columns: 1fr;
            }

            .stat-item {
                border-right: none;
                border-bottom: 1px solid var(--border);
                padding: 28px 24px;
            }

            .stat-item:last-child { border-bottom: none; }

            .section { padding: 64px 20px; }

            .steps {
                grid-template-columns: 1fr;
                gap: 2px;
            }

            .step:not(:last-child)::after { display: none; }

            .events-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .section-cta { padding: 72px 20px; }

            .footer {
                padding: 24px 20px;
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
        }

        /* tablet 641–960px */
        @media (min-width: 641px) and (max-width: 960px) {
            .steps { grid-template-columns: 1fr; }
            .step:not(:last-child)::after { display: none; }
            .events-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (prefers-reduced-motion: reduce) {
            .scroll-hint { animation: none; }
            * { transition: none !important; }
        }
    </style>
</head>
<body>

<!-- ══════════ NAV ══════════ -->
<nav class="nav">
    <a href="{{ route('home.page') }}" class="nav-logo">🏃 Squad<span>Run</span></a>

    <div class="nav-links">
        <a href="#como-funciona" class="nav-link">Como funciona</a>
        <a href="{{ route('events.index') }}" class="nav-link">Eventos</a>
        <a href="{{ route('login') }}" class="nav-link">Entrar</a>
        <a href="{{ route('register') }}" class="nav-btn">Criar conta</a>
    </div>

    <button class="nav-toggle" id="navToggle" aria-label="Menu">
        <span></span><span></span><span></span>
    </button>
</nav>

<!-- mobile menu -->
<div class="nav-mobile" id="navMobile">
    <a href="#como-funciona" class="nav-link">Como funciona</a>
    <a href="{{ route('events.index') }}" class="nav-link">Eventos</a>
    <a href="{{ route('login') }}" class="nav-link">Entrar</a>
    <a href="{{ route('register') }}" class="nav-btn">Criar conta grátis</a>
</div>

<!-- ══════════ HERO ══════════ -->
<section class="hero">
    <div class="hero-inner">
        <div class="hero-eyebrow">Comunidade de corredores</div>

        <h1 class="hero-headline">
            Corra.<br>
            <em>Chegue</em><br>
            mais longe.
        </h1>

        <p class="hero-sub">
            Encontre corridas perto de você, faça sua inscrição em segundos e acompanhe cada resultado com a sua comunidade.
        </p>

        <div class="hero-actions">
            <a href="{{ route('register') }}" class="btn-primary">Quero participar →</a>
            <a href="#como-funciona" class="btn-ghost">Saiba mais</a>
        </div>

        <div class="hero-km">
            <span class="km-num" id="kmCounter" data-target="{{ $dados['estatisticas']['kmPercorridos'] }}">0</span>
            <span class="km-label">km percorridos pela comunidade</span>
        </div>
    </div>

    <div class="scroll-hint">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 5v14M5 12l7 7 7-7"/>
        </svg>
        scroll
    </div>
</section>

<!-- ══════════ STATS BAR ══════════ -->
<div class="stats-bar">
    <div class="stats-bar-inner">
        <div class="stat-item">
            <div class="stat-item-num">{{ number_format($dados['estatisticas']['corredores'], 0, ',', '.') }}</div>
            <div class="stat-item-label">Corredores cadastrados</div>
        </div>
        <div class="stat-item">
            <div class="stat-item-num">{{ number_format($dados['estatisticas']['eventosRealizados'], 0, ',', '.') }}</div>
            <div class="stat-item-label">Eventos realizados</div>
        </div>
        <div class="stat-item">
            <div class="stat-item-num">{{ $dados['proximoEventos']->count() }}</div>
            <div class="stat-item-label">Quantidade de eventos a seguir</div>
        </div>
    </div>
</div>

<!-- ══════════ COMO FUNCIONA ══════════ -->
<section class="section" id="como-funciona">
    <div class="section-inner">
        <p class="section-label">Como funciona</p>
        <h2 class="section-title">Da inscrição à linha de chegada</h2>

        <div class="steps">
            <div class="step">
                <div class="step-icon">🔍</div>
                <div class="step-title">Encontre um evento</div>
                <p class="step-desc">Filtre por cidade, distância ou data e descubra corridas feitas para o seu nível — do iniciante ao maratonista.</p>
            </div>
            <div class="step">
                <div class="step-icon">✅</div>
                <div class="step-title">Faça sua inscrição</div>
                <p class="step-desc">Crie sua conta, escolha a categoria e confirme. Em menos de 2 minutos você já está na lista de largada.</p>
            </div>
            <div class="step">
                <div class="step-icon">🏅</div>
                <div class="step-title">Corra e acompanhe</div>
                <p class="step-desc">No dia do evento, veja o placar ao vivo e confira seu tempo, posição e histórico completo de participações.</p>
            </div>
        </div>
    </div>
</section>

<!-- ══════════ PRÓXIMOS EVENTOS ══════════ -->
<section class="section section-events" id="eventos">
    <div class="section-inner">
        <p class="section-label">Agenda</p>
        <h2 class="section-title">Próximos eventos</h2>

        <div class="events-grid">
            @forelse($dados['proximoEventos'] as $evento)
                <div class="event-card">
                    <div class="event-card-top">
                        <div class="event-distance">
                            {{ $evento->route_km }}
                            <span>KM</span>
                        </div>
                    </div>
                    <div class="event-card-body">
                        <div class="event-title">
                            {{ $evento->title }}
                        </div>
                        <div class="event-meta">
                            <div class="event-meta-item">
                                {{ \Carbon\Carbon::parse($evento->event_date)->translatedFormat('d M Y · H\hi') }}
                            </div>
                            <div class="event-meta-item">
                                {{ $evento->route_description }}
                            </div>
                        </div>
                        <span class="event-tag">
                            {{ $evento->vacancies }}
                        </span>
                        <a href="{{ route('events.show', $evento->id) }}" class="event-cta">Ver detalhes</a>
                    </div>
                </div>
            @empty
                <p>Nenhum evento disponível.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- ══════════ CTA FINAL ══════════ -->
<section class="section-cta">
    <div class="section-inner">
        <h2 class="cta-headline">
            Sua próxima corrida<br>
            começa com <em>um clique.</em>
        </h2>
        <p class="cta-sub">
            Crie sua conta grátis, explore os eventos e junte-se a milhares de corredores em todo o Brasil.
        </p>
        <a href="{{ route('register') }}" class="btn-primary">Criar conta →</a>
    </div>
</section>

<!-- ══════════ FOOTER ══════════ -->
<footer class="footer">
    <div class="footer-logo">🏃 Squad<span>Run</span></div>
    <div class="footer-copy">© {{ date('Y') }} SquadRun · Todos os direitos reservados</div>
</footer>

<script>
    // ── Menu mobile ──────────────────────────────
    const toggle = document.getElementById('navToggle');
    const menu   = document.getElementById('navMobile');

    toggle.addEventListener('click', () => {
        const open = menu.classList.toggle('open');
        toggle.classList.toggle('open', open);
    });

    // Fechar menu ao clicar em link interno
    menu.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', () => {
            menu.classList.remove('open');
            toggle.classList.remove('open');
        });
    });

    // ── Contador de KM (animado ao entrar na tela) ──
    const el      = document.getElementById('kmCounter');
    const target  = parseInt(el.dataset.target);
    let started   = false;

    function formatNum(n) {
        return n.toLocaleString('pt-BR');
    }

    function animateCount() {
        const duration = 2200;
        const start    = performance.now();

        function tick(now) {
            const elapsed  = now - start;
            const progress = Math.min(elapsed / duration, 1);
            // easing out expo
            const eased    = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
            el.textContent = formatNum(Math.floor(eased * target));
            if (progress < 1) requestAnimationFrame(tick);
        }

        requestAnimationFrame(tick);
    }

    const obs = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting && !started) {
            started = true;
            animateCount();
        }
    }, { threshold: 0.5 });

    obs.observe(el);
</script>

</body>
</html>
