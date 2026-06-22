<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cadastro — SquadRun</title>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --deep:#0B2E33;--mid:#4F7C82;--mist:#B8E3E9;--pale:#f4f6f8;
  --white:#ffffff;--error:#d64045;--text:#1a1a1a;--subtle:#555f60;
}
html,body{height:100%;font-family:'Segoe UI',system-ui,-apple-system,sans-serif;background:var(--pale)}
.wrap{display:flex;min-height:100vh}
.panel-brand{
  flex:1 1 55%;background:var(--deep);display:flex;flex-direction:column;
  justify-content:space-between;padding:48px 56px;position:relative;overflow:hidden
}
.panel-brand::before{
  content:'';position:absolute;inset:0;
  background:repeating-linear-gradient(180deg,transparent,transparent 58px,rgba(255,255,255,0.04) 58px,rgba(255,255,255,0.04) 60px);
  pointer-events:none
}
.panel-brand::after{
  content:'';position:absolute;top:0;right:0;width:4px;height:100%;
  background:linear-gradient(to bottom,var(--mist),transparent 60%)
}
.brand-logo{font-size:1.6rem;font-weight:800;color:var(--white);letter-spacing:-0.5px;position:relative;z-index:1}
.brand-logo span{color:var(--mist)}
.brand-main{position:relative;z-index:1}
.brand-eyebrow{font-size:0.72rem;letter-spacing:3px;text-transform:uppercase;color:var(--mist);margin-bottom:20px;opacity:0.8}
.brand-headline{font-size:clamp(2.2rem,4vw,3.4rem);font-weight:900;color:var(--white);line-height:1.1;letter-spacing:-1.5px;margin-bottom:24px}
.brand-headline em{font-style:normal;color:var(--mist)}
.brand-sub{font-size:1rem;color:rgba(255,255,255,0.55);line-height:1.6;max-width:340px}
.brand-stats{display:flex;gap:36px;position:relative;z-index:1}
.stat{border-top:2px solid rgba(184,227,233,0.3);padding-top:14px}
.stat-num{font-size:1.8rem;font-weight:800;color:var(--white);line-height:1;letter-spacing:-1px}
.stat-label{font-size:0.72rem;color:rgba(255,255,255,0.45);letter-spacing:1px;text-transform:uppercase;margin-top:4px}
.panel-form{flex:0 0 460px;display:flex;align-items:center;justify-content:center;padding:48px 40px;background:var(--white)}
.form-inner{width:100%;max-width:380px}
.form-logo{display:none}
.form-title{font-size:1.65rem;font-weight:800;color:var(--deep);letter-spacing:-0.8px;margin-bottom:6px}
.form-subtitle{font-size:0.88rem;color:var(--subtle);margin-bottom:28px}
.field{margin-bottom:16px}
.field label{display:block;font-size:0.78rem;font-weight:600;letter-spacing:0.5px;text-transform:uppercase;color:var(--deep);margin-bottom:7px}
.input-wrap{position:relative}
.input-wrap svg{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--mid);width:16px;height:16px;pointer-events:none}
.field input{
  width:100%;padding:13px 14px 13px 40px;border:1.5px solid #d4dfe0;border-radius:10px;
  font-size:1rem;color:var(--text);background:var(--pale);outline:none;
  transition:border-color 0.2s,box-shadow 0.2s,background 0.2s;-webkit-appearance:none
}
.field input:focus{border-color:var(--mid);background:var(--white);box-shadow:0 0 0 3px rgba(79,124,130,0.12)}
.field input::placeholder{color:#b0babf}
.field input.is-invalid{border-color:var(--error);background:#fff8f8}
.field-error{font-size:0.78rem;color:var(--error);margin-top:5px}
.password-hint{font-size:0.75rem;color:var(--subtle);margin-top:5px}
.role-label{display:block;font-size:0.78rem;font-weight:600;letter-spacing:0.5px;text-transform:uppercase;color:var(--deep);margin-bottom:10px}
.role-group{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:20px}
.role-option{position:relative}
.role-option input[type="radio"]{position:absolute;opacity:0;width:0;height:0}
.role-card{
  display:flex;flex-direction:column;align-items:center;gap:8px;
  padding:16px 12px;border:1.5px solid #d4dfe0;border-radius:12px;
  cursor:pointer;transition:border-color 0.2s,background 0.2s,box-shadow 0.2s;
  background:var(--pale);text-align:center;user-select:none
}
.role-card:hover{border-color:var(--mid);background:var(--white)}
.role-option input[type="radio"]:checked + .role-card{
  border-color:var(--mid);background:rgba(79,124,130,0.06);
  box-shadow:0 0 0 3px rgba(79,124,130,0.12)
}
.role-icon{font-size:1.5rem;line-height:1}
.role-name{font-size:0.88rem;font-weight:700;color:var(--deep)}
.role-desc{font-size:0.72rem;color:var(--subtle);line-height:1.3}
.role-check{
  position:absolute;top:10px;right:10px;width:18px;height:18px;
  border-radius:50%;border:1.5px solid #b0babf;background:var(--pale);
  display:flex;align-items:center;justify-content:center;transition:border-color 0.2s,background 0.2s
}
.role-option input[type="radio"]:checked + .role-card .role-check{background:var(--mid);border-color:var(--mid)}
.role-option input[type="radio"]:checked + .role-card .role-check::after{
  content:'';display:block;width:5px;height:9px;border:2px solid #fff;
  border-top:none;border-left:none;transform:rotate(45deg) translate(-1px,-1px)
}
.btn-submit{
  width:100%;padding:15px;background:var(--deep);color:var(--white);
  font-size:1rem;font-weight:700;border:none;border-radius:10px;cursor:pointer;
  letter-spacing:0.3px;transition:background 0.2s,transform 0.1s;
  position:relative;overflow:hidden;-webkit-tap-highlight-color:transparent;margin-top:4px
}
.btn-submit::after{
  content:'';position:absolute;inset:0;
  background:linear-gradient(90deg,transparent,rgba(255,255,255,0.06),transparent);
  transform:translateX(-100%);transition:transform 0.4s
}
.btn-submit:hover{background:var(--mid)}
.btn-submit:hover::after{transform:translateX(100%)}
.btn-submit:active{transform:scale(0.99)}
.divider{display:flex;align-items:center;gap:12px;margin:20px 0;color:#cdd5d6;font-size:0.75rem}
.divider::before,.divider::after{content:'';flex:1;height:1px;background:#e3eaeb}
.login-cta{text-align:center;font-size:0.88rem;color:var(--subtle)}
.login-cta a{color:var(--mid);font-weight:700;text-decoration:none;transition:color 0.15s}
.login-cta a:hover{color:var(--deep)}
.alert-error{background:rgba(255,255,255,0.1);border-left:4px solid var(--error);border-radius:6px;padding:12px 14px;font-size:0.83rem;color:var(--error);margin-bottom:20px}

@media(max-width:640px){
  html,body{height:100%;background:var(--deep)}
  body::before{content:'';position:fixed;inset:0;background:repeating-linear-gradient(180deg,transparent,transparent 58px,rgba(255,255,255,0.04) 58px,rgba(255,255,255,0.04) 60px);pointer-events:none;z-index:0}
  .wrap{flex-direction:column;min-height:100%;align-items:center;justify-content:center;padding:32px 20px;position:relative;z-index:1}
  .panel-brand{display:none}
  .panel-form{flex:none;width:100%;max-width:400px;background:var(--white);border-radius:20px;padding:32px 24px;box-shadow:0 20px 60px rgba(0,0,0,0.3)}
  .form-inner{max-width:100%}
  .form-logo{display:block;font-size:1.4rem;font-weight:800;color:var(--deep);letter-spacing:-0.4px;margin-bottom:22px}
  .form-logo span{color:var(--mid)}
  .form-title{font-size:1.4rem}
  .field input{padding:15px 14px 15px 44px;border-radius:12px;background:var(--pale)}
  .btn-submit{padding:16px;border-radius:12px}
}
@media(max-width:360px){.panel-form{padding:24px 18px}}
@media(prefers-reduced-motion:reduce){.btn-submit::after{display:none}*{transition:none !important}}
</style>
</head>
<body>
<div class="wrap">

    <!-- Painel esquerdo: branding (tablet/desktop) -->
    <div class="panel-brand">
        <div class="brand-logo">🏃 Squad<span>Run</span></div>

        <div class="brand-main">
            <p class="brand-eyebrow">Bem-vindo à comunidade</p>
            <h1 class="brand-headline">
                Sua jornada<br>
                começa<br>
                <em>agora.</em>
            </h1>
            <p class="brand-sub">
                Crie sua conta, escolha seu perfil e faça parte da maior comunidade de corridas do Brasil.
            </p>
        </div>

        <div class="brand-stats">
            <div class="stat">
                <div class="stat-num">{{ number_format($dados['estatisticas']['corredores'], 0, ',', '.') }}</div>
                <div class="stat-label">Corredores cadastrados</div>
            </div>
            <div class="stat">
                <div class="stat-num">{{ number_format($dados['estatisticas']['eventosRealizados'], 0, ',', '.') }}</div>
                <div class="stat-label">Eventos realizados</div>
            </div>
            <div class="stat">
                <div class="stat-num">{{ $dados['proximoEventos']->count() }}</div>
                <div class="stat-label">Quantidade de eventos a seguir</div>
            </div>
        </div>
    </div>

    <!-- Painel direito: formulário -->
    <div class="panel-form">
        <div class="form-inner">

            <!-- logo só no mobile (dentro do cartão) -->
            <div class="form-logo">🏃 Squad<span>Run</span></div>

            <h2 class="form-title">Criar conta</h2>
            <p class="form-subtitle">Preencha seus dados para começar</p>

            @if ($errors->any())
                <div class="alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}" novalidate>
                @csrf

                <div class="field">
                    <label for="name">Nome completo</label>
                    <div class="input-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                        </svg>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="João Silva"
                            autocomplete="name"
                            autofocus
                            class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                        >
                    </div>
                    @error('name')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label for="email">E-mail</label>
                    <div class="input-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="seu@email.com"
                            autocomplete="email"
                            inputmode="email"
                            class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                        >
                    </div>
                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Senha</label>
                    <div class="input-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            autocomplete="new-password"
                            class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                        >
                    </div>
                    <p class="password-hint">Mínimo de 8 caracteres</p>
                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label for="password_confirmation">Confirmar senha</label>
                    <div class="input-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="••••••••"
                            autocomplete="new-password"
                        >
                    </div>
                </div>

                <span class="role-label">Seu perfil</span>
                <div class="role-group">
                    <label class="role-option">
                        <input type="radio" name="role" value="{{ \App\Enums\UsersRoleEnum::PARTICIPANT->value }}"
                            {{ old('role', 'competitor') === \App\Enums\UsersRoleEnum::PARTICIPANT->value ? 'checked' : '' }}>
                        <div class="role-card">
                            <div class="role-check"></div>
                            <div class="role-icon">🏅</div>
                            <div class="role-name">Competidor</div>
                            <div class="role-desc">Inscreva-se em corridas e acompanhe seus resultados</div>
                        </div>
                    </label>
                    <label class="role-option">
                        <input type="radio" name="role" value="{{ \App\Enums\UsersRoleEnum::ORGANIZATOR->value }}"
                            {{ old('role') === \App\Enums\UsersRoleEnum::ORGANIZATOR->value ? 'checked' : '' }}>
                        <div class="role-card">
                            <div class="role-check"></div>
                            <div class="role-icon">📋</div>
                            <div class="role-name">Organizador</div>
                            <div class="role-desc">Crie e gerencie eventos de corrida para a comunidade</div>
                        </div>
                    </label>
                </div>
                @error('role')
                    <span class="field-error" style="display:block;margin-top:-12px;margin-bottom:14px">{{ $message }}</span>
                @enderror

                <button type="submit" class="btn-submit">
                    Criar minha conta →
                </button>
            </form>

            <div class="divider">ou</div>

            <p class="login-cta">
                Já tem uma conta?
                <a href="{{ route('login') }}">Entrar agora</a>
            </p>

        </div>
    </div>

</div>
</body>
</html>