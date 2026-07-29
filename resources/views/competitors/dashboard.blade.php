<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard — SquadRun</title>
        <style>
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

            :root {
                --deep: #0B2E33;
                --mid:  #4F7C82;
                --mist: #B8E3E9;
                --pale: #f4f6f8;
                --white: #ffffff;
                --text:  #1a1a1a;
                --subtle: #555f60;
                --border: #d4dfe0;
            }

            html, body {
                height: 100%;
                font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
                background: var(--pale);
            }

            /* ─── Layout ─────────────────────────────── */
            .wrap { display: flex; min-height: 100vh; }

            /* ─── Sidebar ────────────────────────────── */
            .sidebar {
                width: 220px;
                flex-shrink: 0;
                background: var(--deep);
                display: flex;
                flex-direction: column;
                padding: 28px 0;
                position: fixed;
                top: 0; left: 0; bottom: 0;
                overflow-y: auto;
            }

            .sidebar-logo {
                font-size: 1.4rem;
                font-weight: 800;
                color: #fff;
                letter-spacing: -0.4px;
                padding: 0 24px 28px;
                border-bottom: 1px solid rgba(255,255,255,0.08);
            }
            .sidebar-logo span { color: var(--mist); }

            .sidebar-section {
                font-size: 0.65rem;
                letter-spacing: 2px;
                text-transform: uppercase;
                color: rgba(255,255,255,0.3);
                padding: 20px 24px 8px;
            }

            .nav-link {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 11px 24px;
                color: rgba(255,255,255,0.55);
                text-decoration: none;
                font-size: 0.9rem;
                transition: background 0.15s, color 0.15s;
            }
            .nav-link svg { width: 18px; height: 18px; flex-shrink: 0; }
            .nav-link:hover { background: rgba(255,255,255,0.06); color: #fff; }
            .nav-link.active { background: rgba(184,227,233,0.12); color: var(--mist); border-right: 3px solid var(--mist); }

            .sidebar-bottom {
                margin-top: auto;
                padding: 20px 24px;
                border-top: 1px solid rgba(255,255,255,0.08);
                display: flex;
                align-items: center;
                gap: 10px;
            }
            .sidebar-avatar {
                width: 36px; height: 36px; border-radius: 50%;
                background: var(--mist);
                display: flex; align-items: center; justify-content: center;
                font-weight: 700; font-size: 12px; color: var(--deep);
                flex-shrink: 0;
            }
            .sidebar-user-name { font-size: 0.85rem; font-weight: 600; color: #fff; }
            .sidebar-user-role { font-size: 0.72rem; color: rgba(255,255,255,0.4); }
            .sidebar-logout {
                margin-left: auto;
                color: rgba(255,255,255,0.3);
                background: none; border: none; cursor: pointer;
                transition: color 0.15s;
            }
            .sidebar-logout:hover { color: #fff; }
            .sidebar-logout svg { width: 16px; height: 16px; display: block; }

            /* ─── Content area ───────────────────────── */
            .content {
                margin-left: 220px;
                flex: 1;
                padding: 32px;
                min-width: 0;
            }

            /* ─── Top header ─────────────────────────── */
            .topbar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 28px;
            }
            .topbar-greeting p { font-size: 0.8rem; color: var(--subtle); margin-bottom: 2px; }
            .topbar-greeting h1 { font-size: 1.5rem; font-weight: 800; color: var(--deep); letter-spacing: -0.5px; }
            .topbar-greeting h1 span { color: var(--mid); }
            .topbar-actions { display: flex; align-items: center; gap: 12px; }

            .btn-notif {
                width: 38px; height: 38px; border-radius: 50%;
                background: var(--white); border: 1.5px solid var(--border);
                display: flex; align-items: center; justify-content: center;
                cursor: pointer; position: relative; transition: border-color 0.15s;
            }
            .btn-notif:hover { border-color: var(--mid); }
            .btn-notif svg { width: 18px; height: 18px; color: var(--subtle); }
            .notif-dot {
                position: absolute; top: 7px; right: 7px;
                width: 8px; height: 8px; border-radius: 50%;
                background: #d64045; border: 2px solid var(--pale);
            }

            /* ─── Stat cards ─────────────────────────── */
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
                gap: 16px;
                margin-bottom: 28px;
            }
            .stat-card {
                background: var(--white);
                border: 1.5px solid var(--border);
                border-radius: 14px;
                padding: 20px;
                position: relative;
                overflow: hidden;
            }
            .stat-card::before {
                content: '';
                position: absolute; top: 0; left: 0;
                width: 4px; height: 100%;
                background: var(--deep);
            }
            .stat-card-label {
                font-size: 0.72rem;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                color: var(--subtle);
                margin-bottom: 8px;
            }
            .stat-card-value {
                font-size: 2rem;
                font-weight: 800;
                color: var(--deep);
                letter-spacing: -1px;
                line-height: 1;
            }
            .stat-card-sub {
                font-size: 0.75rem;
                color: var(--mid);
                margin-top: 6px;
            }

            /* ─── Grid 2 colunas ─────────────────────── */
            .main-grid {
                display: grid;
                grid-template-columns: 1fr 340px;
                gap: 20px;
                align-items: start;
            }
            .left-col { display: flex; flex-direction: column; gap: 20px; }
            .right-col { display: flex; flex-direction: column; gap: 20px; }

            /* ─── Card base ──────────────────────────── */
            .card {
                background: var(--white);
                border: 1.5px solid var(--border);
                border-radius: 14px;
                padding: 22px;
            }
            .card-title {
                font-size: 0.72rem;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                color: var(--subtle);
                margin-bottom: 16px;
            }

            /* ─── Próximo evento ─────────────────────── */
            .next-event-banner {
                background: var(--deep);
                border-radius: 14px;
                padding: 22px;
                display: flex;
                align-items: center;
                gap: 20px;
                position: relative;
                overflow: hidden;
            }
            .next-event-banner::after {
                content: '';
                position: absolute; right: -30px; top: -30px;
                width: 130px; height: 130px; border-radius: 50%;
                background: rgba(184,227,233,0.07);
                pointer-events: none;
            }
            .event-date-box {
                background: rgba(184,227,233,0.15);
                border: 1px solid rgba(184,227,233,0.3);
                border-radius: 10px;
                padding: 12px 16px;
                text-align: center;
                flex-shrink: 0;
            }
            .event-date-box .day { font-size: 1.8rem; font-weight: 800; color: #fff; line-height: 1; }
            .event-date-box .month { font-size: 0.65rem; letter-spacing: 1.5px; text-transform: uppercase; color: var(--mist); margin-top: 3px; }
            .event-meta { flex: 1; }
            .event-badge {
                display: inline-block;
                background: rgba(184,227,233,0.2);
                color: var(--mist);
                font-size: 0.72rem; font-weight: 600;
                padding: 3px 10px; border-radius: 20px;
                margin-bottom: 6px;
            }
            .event-name { font-size: 1.1rem; font-weight: 800; color: #fff; margin-bottom: 4px; }
            .event-details { font-size: 0.8rem; color: rgba(255,255,255,0.5); }
            .btn-event {
                background: #fff; color: var(--deep);
                font-size: 0.8rem; font-weight: 700;
                padding: 10px 18px; border-radius: 9px;
                border: none; cursor: pointer;
                flex-shrink: 0; white-space: nowrap;
                transition: background 0.15s;
            }
            .btn-event:hover { background: var(--mist); }

            /* ─── Últimas corridas ───────────────────── */
            .races-list { display: flex; flex-direction: column; gap: 10px; }
            .race-item {
                display: flex; align-items: center; gap: 14px;
                padding: 12px 14px;
                background: var(--pale); border-radius: 10px;
            }
            .race-pos {
                width: 30px; height: 30px; border-radius: 50%;
                background: var(--mid);
                display: flex; align-items: center; justify-content: center;
                font-size: 0.75rem; font-weight: 800; color: #fff;
                flex-shrink: 0;
            }
            .race-pos.gold   { background: #B8860B; }
            .race-pos.silver { background: #888; }
            .race-pos.bronze { background: #7B4E2D; }
            .race-info { flex: 1; }
            .race-name { font-size: 0.88rem; font-weight: 600; color: var(--text); }
            .race-date { font-size: 0.75rem; color: var(--subtle); margin-top: 2px; }
            .race-time { font-size: 0.9rem; font-weight: 700; color: var(--mid); }

            /* ─── Evolução de pace ───────────────────── */
            .pace-rows { display: flex; flex-direction: column; gap: 10px; }
            .pace-row { display: flex; align-items: center; gap: 10px; }
            .pace-label { font-size: 0.78rem; color: var(--subtle); width: 32px; flex-shrink: 0; }
            .pace-track { flex: 1; background: var(--pale); border-radius: 4px; height: 8px; overflow: hidden; }
            .pace-fill { height: 100%; border-radius: 4px; background: var(--deep); }
            .pace-fill.best { background: #B8860B; }
            .pace-val { font-size: 0.78rem; font-weight: 600; color: var(--text); width: 44px; text-align: right; flex-shrink: 0; }

            /* ─── Certificados ───────────────────────── */
            .certs-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
            .cert-card {
                background: var(--pale); border-radius: 10px;
                padding: 12px; display: flex; align-items: center; gap: 10px;
            }
            .cert-icon {
                width: 38px; height: 38px; border-radius: 9px;
                background: var(--white); border: 1.5px solid var(--border);
                display: flex; align-items: center; justify-content: center;
                flex-shrink: 0;
            }
            .cert-icon svg { width: 20px; height: 20px; }
            .cert-cert-name { font-size: 0.8rem; font-weight: 700; color: var(--text); }
            .cert-event { font-size: 0.72rem; color: var(--subtle); margin-top: 2px; }

            /* ─── Responsivo ─────────────────────────── */
            @media (max-width: 1100px) {
                .main-grid { grid-template-columns: 1fr; }
            }
            @media (max-width: 768px) {
                .sidebar { display: none; }
                .content { margin-left: 0; padding: 20px 16px; }
                .stats-grid { grid-template-columns: 1fr 1fr; }
                .next-event-banner { flex-direction: column; align-items: flex-start; }
            }
        </style>
    </head>
    <body>
        <div class="wrap">

            {{-- ─── Sidebar ─────────────────────────────────────────────── --}}
            <aside class="sidebar">
                <div class="sidebar-logo">🏃 Squad<span>Run</span></div>

                <span class="sidebar-section">Principal</span>

                <a href="{{ route('competitors.dashboard') }}" class="nav-link active">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                        <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                    </svg>
                    Início
                </a>
                <a href="{{ route('events.index') }}" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    Eventos
                </a>
                <a href="{{ route('results.index') }}" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/>
                        <line x1="6" y1="20" x2="6" y2="14"/>
                    </svg>
                    Resultados
                </a>

                <span class="sidebar-section">Conquistas</span>

                <a href="{{ route('rankings.index') }}" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/>
                        <path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/>
                        <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/>
                        <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/>
                    </svg>
                    Ranking
                </a>
                <a href="{{ route('certificates.index') }}" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
                    </svg>
                    Certificados
                </a>

                <span class="sidebar-section">Conta</span>

                <a href="{{ route('profile.show') }}" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                    </svg>
                    Perfil
                </a>

                {{-- Usuário + logout --}}
                <div class="sidebar-bottom">
                    <div class="sidebar-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', auth()->user()->name)[1] ?? '', 0, 1)) }}
                    </div>
                    <div>
                        <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                        <div class="sidebar-user-role">Competidor</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="margin-left:auto">
                        @csrf
                        <button type="submit" class="sidebar-logout" title="Sair">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                <polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </aside>

            {{-- ─── Conteúdo principal ───────────────────────────────────── --}}
            <main class="content">

                {{-- Topbar --}}
                <div class="topbar">
                    <div class="topbar-greeting">
                        <p>Bem-vindo de volta</p>
                        <h1>Olá, <span>{{ explode(' ', auth()->user()->name)[0] }}</span> 👋</h1>
                    </div>
                    <div class="topbar-actions">
                        <button class="btn-notif" title="Notificações">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                            </svg>
                            {{-- Exibe bolinha se houver notificações não lidas --}}
                            @if($unreadNotifications ?? 0 > 0)
                                <span class="notif-dot"></span>
                            @endif
                        </button>
                    </div>
                </div>

                {{-- Cards de métricas --}}
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-card-label">Corridas disputadas</div>
                        <div class="stat-card-value">{{ $stats['total_races'] ?? 0 }}</div>
                        <div class="stat-card-sub">+{{ $stats['races_this_month'] ?? 0 }} este mês</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-label">Km acumulados</div>
                        <div class="stat-card-value">{{ number_format($stats['total_km'] ?? 0, 0, ',', '.') }}</div>
                        <div class="stat-card-sub">meta: {{ $stats['km_goal'] ?? 0 }} km</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-label">Melhor pace</div>
                        <div class="stat-card-value">{{ $stats['best_pace'] ?? '--:--' }}</div>
                        <div class="stat-card-sub">min/km</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-label">Pódios</div>
                        <div class="stat-card-value">{{ $stats['podiums'] ?? 0 }}</div>
                        <div class="stat-card-sub">top 3 na categoria</div>
                    </div>
                </div>

                {{-- Grid principal --}}
                <div class="main-grid">

                    {{-- Coluna esquerda --}}
                    <div class="left-col">

                        {{-- Próximo evento --}}
                        @if($nextEvent)
                            <div class="next-event-banner">
                                <div class="event-date-box">
                                    <div class="day">{{ $nextEvent->date->format('d') }}</div>
                                    <div class="month">{{ $nextEvent->date->translatedFormat('M') }}</div>
                                </div>
                                <div class="event-meta">
                                    <span class="event-badge">📍 {{ $nextEvent->city }}, {{ $nextEvent->state }}</span>
                                    <div class="event-name">{{ $nextEvent->name }}</div>
                                    <div class="event-details">
                                        🕕 {{ $nextEvent->start_time }} &nbsp;·&nbsp;
                                        {{ $nextEvent->distance }} km &nbsp;·&nbsp;
                                        Categoria: {{ $nextEvent->category }}
                                    </div>
                                </div>
                                <a href="{{ route('events.show', $nextEvent->id) }}" class="btn-event">Ver mais →</a>
                            </div>
                        @else
                            <div class="card" style="text-align:center;color:var(--subtle);padding:32px">
                                Nenhum evento inscrito ainda.
                                <a href="{{ route('events.index') }}" style="color:var(--mid);font-weight:700;display:block;margin-top:8px">
                                    Explorar eventos →
                                </a>
                            </div>
                        @endif

                        {{-- Últimas corridas --}}
                        <div class="card">
                            <div class="card-title">Últimas corridas</div>
                            @if($recentRaces->isNotEmpty())
                                <div class="races-list">
                                    @foreach($recentRaces as $race)
                                        @php
                                            $posClass = match(true) {
                                                $race->position === 1 => 'gold',
                                                $race->position === 2 => 'silver',
                                                $race->position === 3 => 'bronze',
                                                default               => '',
                                            };
                                        @endphp
                                        <div class="race-item">
                                            <div class="race-pos {{ $posClass }}">{{ $race->position }}º</div>
                                            <div class="race-info">
                                                <div class="race-name">{{ $race->event_name }} — {{ $race->distance }} km</div>
                                                <div class="race-date">
                                                    {{ \Carbon\Carbon::parse($race->date)->translatedFormat('d M Y') }}
                                                    &nbsp;·&nbsp; Categoria {{ $race->category }}
                                                </div>
                                            </div>
                                            <span class="race-time">{{ $race->finish_time }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p style="color:var(--subtle);font-size:0.88rem">Nenhuma corrida registrada ainda.</p>
                            @endif
                        </div>

                    </div>

                    {{-- Coluna direita --}}
                    <div class="right-col">

                        {{-- Evolução de pace --}}
                        <div class="card">
                            <div class="card-title">Evolução de pace</div>
                            <div class="pace-rows">
                                @foreach($paceHistory as $index => $month)
                                    @php $isBest = $index === count($paceHistory) - 1; @endphp
                                    <div class="pace-row">
                                        <span class="pace-label">{{ $month['label'] }}</span>
                                        <div class="pace-track">
                                            <div class="pace-fill {{ $isBest ? 'best' : '' }}"
                                                style="width: {{ $month['pct'] }}%"></div>
                                        </div>
                                        <span class="pace-val" style="{{ $isBest ? 'color:#B8860B' : '' }}">
                                            {{ $month['pace'] }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Certificados --}}
                        <div class="card">
                            <div class="card-title">Certificados &amp; conquistas</div>
                            @if($certificates->isNotEmpty())
                            <div class="certs-grid">
                                @foreach($certificates as $cert)
                                    <div class="cert-card">
                                        <div class="cert-icon">
                                            @if($cert->position === 1)
                                                {{-- Troféu ouro --}}
                                                <svg viewBox="0 0 24 24" fill="none" stroke="#B8860B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/>
                                                    <path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/>
                                                    <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/>
                                                    <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/>
                                                </svg>
                                            @elseif($cert->position <= 3)
                                                {{-- Medalha prata/bronze --}}
                                                <svg viewBox="0 0 24 24" fill="none" stroke="{{ $cert->position === 2 ? '#888' : '#7B4E2D' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
                                                </svg>
                                            @else
                                                {{-- Certificado participação --}}
                                                <svg viewBox="0 0 24 24" fill="none" stroke="#4F7C82" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                                    <path d="M9 12l2 2 4-4"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="cert-cert-name">{{ $cert->title }}</div>
                                            <div class="cert-event">{{ $cert->event_name }}</div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <p style="color:var(--subtle);font-size:0.88rem">Nenhum certificado ainda. Participe de uma corrida!</p>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>