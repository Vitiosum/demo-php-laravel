<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>RunRank</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #07080C;
            --surface: #0C0E13;
            --border: #1A1D26;
            --text: #E6E8F0;
            --muted: #4E5468;
            --accent: #FF5A1F;
            --accent-dim: rgba(255, 90, 31, 0.1);
            --font-display: 'Bebas Neue', sans-serif;
            --font-body: 'Outfit', sans-serif;
            --font-mono: 'DM Mono', monospace;
        }

        body {
            min-height: 100vh;
            background-color: var(--bg);
            color: var(--text);
            font-family: var(--font-body);
        }

        .container { max-width: 460px; margin: 0 auto; padding: 48px 20px 60px; }

        /* ── HEADER ── */
        .header { margin-bottom: 40px; }

        .logo-line {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 10px;
        }

        .logo-icon {
            width: 46px;
            height: 46px;
            border-radius: 10px;
            background: var(--accent-dim);
            border: 1px solid rgba(255, 90, 31, 0.22);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            flex-shrink: 0;
            color: var(--accent);
        }

        .logo-dot {
            position: absolute;
            top: -3px;
            right: -3px;
            width: 9px;
            height: 9px;
            background: var(--accent);
            border-radius: 50%;
        }

        .logo-dot::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 50%;
            background: var(--accent);
            animation: ping 1.8s ease-in-out infinite;
        }

        @keyframes ping {
            0%   { transform: scale(1);   opacity: 0.6; }
            100% { transform: scale(2.5); opacity: 0; }
        }

        .logo-text {
            font-family: var(--font-display);
            font-size: 54px;
            letter-spacing: 1px;
            line-height: 1;
            color: var(--text);
        }

        .logo-text span { color: var(--accent); }

        .subtitle {
            padding-left: 60px;
            color: var(--muted);
            font-size: 13px;
        }

        /* ── CARD ── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 28px;
            margin-bottom: 14px;
        }

        /* ── FIELD ── */
        .field { margin-bottom: 28px; }
        .field:last-child { margin-bottom: 0; }

        .field-label {
            display: block;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 12px;
        }

        /* ── DISTANCE BUTTONS ── */
        .distance-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }

        .distance-btn {
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--muted);
            cursor: pointer;
            padding: 14px 16px;
            text-align: left;
            transition: all 0.15s ease;
            position: relative;
            overflow: hidden;
        }

        .distance-btn::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 3px;
            background: var(--accent);
            transform: scaleY(0);
            transform-origin: center;
            transition: transform 0.15s ease;
        }

        .distance-btn:hover { border-color: #252830; color: var(--text); background: rgba(255,255,255,0.02); }

        .distance-btn.active {
            border-color: rgba(255, 90, 31, 0.28);
            background: var(--accent-dim);
            color: var(--text);
        }

        .distance-btn.active::before { transform: scaleY(1); }

        .d-label { display: block; font-weight: 600; font-size: 15px; margin-bottom: 3px; }
        .distance-btn.active .d-label { color: var(--accent); }
        .d-sub { display: block; font-family: var(--font-mono); font-size: 11px; opacity: 0.5; }

        /* ── TIME INPUTS ── */
        .time-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; }

        .time-field { display: flex; flex-direction: column; align-items: center; gap: 8px; }

        .time-input {
            width: 100%;
            background: rgba(255,255,255,0.025);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-family: var(--font-mono);
            font-size: 28px;
            font-weight: 500;
            padding: 14px 8px;
            text-align: center;
            transition: border-color 0.15s, box-shadow 0.15s;
            -moz-appearance: textfield;
        }

        .time-input::-webkit-outer-spin-button,
        .time-input::-webkit-inner-spin-button { -webkit-appearance: none; }

        .time-input::placeholder { color: var(--border); }

        .time-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(255, 90, 31, 0.1);
        }

        .time-sub {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
        }

        /* ── ERROR ── */
        .error {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(239,68,68,0.07);
            border: 1px solid rgba(239,68,68,0.18);
            border-radius: 8px;
            color: #F87171;
            font-size: 13px;
            padding: 10px 14px;
            margin-top: 12px;
        }

        /* ── SUBMIT ── */
        .submit-btn {
            width: 100%;
            background: var(--accent);
            border: none;
            border-radius: 10px;
            color: white;
            cursor: pointer;
            font-family: var(--font-body);
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.02em;
            padding: 16px;
            margin-top: 8px;
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .submit-btn:hover {
            background: #E8491A;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(255, 90, 31, 0.22);
        }

        .submit-btn:active { transform: translateY(0); box-shadow: none; }
        .submit-btn:disabled { opacity: 0.55; cursor: not-allowed; transform: none; box-shadow: none; }

        .spinner {
            width: 16px; height: 16px;
            border: 2px solid rgba(255,255,255,0.25);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            display: none;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .hint { text-align: center; color: var(--muted); font-size: 12px; margin-top: 8px; margin-bottom: 16px; }

        /* ── CERT BANNER ── */
        .cert-banner {
            display: flex;
            align-items: center;
            gap: 16px;
            background: rgba(251,191,36,0.055);
            border: 1px solid rgba(251,191,36,0.18);
            border-radius: 14px;
            padding: 18px 22px;
            margin-bottom: 14px;
        }

        .cert-icon { font-size: 26px; flex-shrink: 0; }
        .cert-content { flex: 1; }
        .cert-title { font-size: 14px; font-weight: 600; color: #F5C030; margin-bottom: 3px; }
        .cert-sub { font-size: 12.5px; color: #5C5035; line-height: 1.5; }

        .cert-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #F5C030;
            border-radius: 8px;
            color: #1A1005;
            font-family: var(--font-body);
            font-size: 12px;
            font-weight: 700;
            padding: 9px 16px;
            text-decoration: none;
            transition: all 0.15s;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .cert-btn:hover { background: #E8B428; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(245,192,48,0.22); }

        @media (max-width: 520px) { .cert-banner { flex-direction: column; text-align: center; } }

        /* ── FOOTER ── */
        .footer { border-top: 1px solid var(--border); padding-top: 20px; }

        .footer-links { display: flex; flex-wrap: wrap; gap: 6px; justify-content: center; margin-bottom: 12px; }

        .footer-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border: 1px solid transparent;
            border-radius: 6px;
            font-family: var(--font-body);
            font-size: 11px;
            padding: 5px 10px;
            text-decoration: none;
            transition: all 0.15s;
        }

        .footer-link.cc   { color: #4ADE80; border-color: rgba(74,222,128,0.15); background: rgba(74,222,128,0.05); }
        .footer-link.cc:hover { background: rgba(74,222,128,0.1); }
        .footer-link.li   { color: #60A5FA; border-color: rgba(96,165,250,0.15); background: rgba(96,165,250,0.05); }
        .footer-link.li:hover { background: rgba(96,165,250,0.1); }
        .footer-link.cert { color: #F5C030; border-color: rgba(245,192,48,0.18); background: rgba(245,192,48,0.05); }
        .footer-link.cert:hover { background: rgba(245,192,48,0.1); }
        .footer-link.doc  { color: var(--muted); border-color: var(--border); background: rgba(255,255,255,0.02); }
        .footer-link.doc:hover { color: var(--text); background: rgba(255,255,255,0.04); }

        .footer-copy { text-align: center; color: #252830; font-size: 11px; }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <div class="logo-line">
            <div class="logo-icon">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                <div class="logo-dot"></div>
            </div>
            <div class="logo-text">RUN<span>RANK</span></div>
        </div>
        <p class="subtitle">Classe ton niveau comme sur League of Legends</p>
    </div>

    <div class="card">
        <form method="POST" action="/result" id="run-form">
            @csrf

            <div class="field">
                <label class="field-label">Distance</label>
                <div class="distance-grid">
                    @foreach([['5k','5K','~25–35 min'],['10k','10K','~50–70 min'],['21k','Semi','~1h45–2h30'],['42k','Marathon','~3h30–5h']] as [$val,$label,$sub])
                    <button type="button" class="distance-btn {{ old('distance','10k') === $val ? 'active' : '' }}"
                            onclick="selectDistance('{{ $val }}', this)">
                        <span class="d-label">{{ $label }}</span>
                        <span class="d-sub">{{ $sub }}</span>
                    </button>
                    @endforeach
                </div>
                <input type="hidden" name="distance" id="distance-input" value="{{ old('distance','10k') }}">
            </div>

            <div class="field">
                <label class="field-label">Ton temps</label>
                <div class="time-grid">
                    <div class="time-field">
                        <input type="number" class="time-input" id="hours" min="0" max="24" placeholder="00">
                        <span class="time-sub">Heures</span>
                    </div>
                    <div class="time-field">
                        <input type="number" class="time-input" id="minutes" min="0" max="59" placeholder="00">
                        <span class="time-sub">Minutes</span>
                    </div>
                    <div class="time-field">
                        <input type="number" class="time-input" id="seconds" min="0" max="59" placeholder="00">
                        <span class="time-sub">Secondes</span>
                    </div>
                </div>
                <input type="hidden" name="time" id="time-input">
                @error('time')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="submit-btn" id="submit-btn">
                <span class="spinner" id="spinner"></span>
                <span id="btn-text">Calculer mon rang</span>
            </button>
        </form>
    </div>

    <p class="hint">Laisse les heures à 0 si tu cours moins d'1 heure</p>

    <div class="cert-banner">
        <div class="cert-icon">🎓</div>
        <div class="cert-content">
            <div class="cert-title">Envie de maîtriser Clever Cloud ?</div>
            <div class="cert-sub">Validez vos compétences avec la certification officielle — et devenez expert de la plateforme.</div>
        </div>
        <a class="cert-btn" href="https://academy.clever.cloud/" target="_blank" rel="noopener noreferrer">Obtenir la certification →</a>
    </div>

    <footer class="footer">
        <div class="footer-links">
            <a class="footer-link cc" href="https://www.clever-cloud.com" target="_blank" rel="noopener noreferrer">
                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg>
                clever-cloud.com
            </a>
            <a class="footer-link li" href="https://www.linkedin.com/company/clever-cloud/" target="_blank" rel="noopener noreferrer">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                LinkedIn
            </a>
            <a class="footer-link doc" href="https://developers.clever-cloud.com/doc/applications/php/" target="_blank" rel="noopener noreferrer">
                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                PHP on CC
            </a>
            <a class="footer-link doc" href="https://laravel.com/docs" target="_blank" rel="noopener noreferrer">
                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                Laravel Docs
            </a>
            <a class="footer-link cert" href="https://academy.clever.cloud/" target="_blank" rel="noopener noreferrer">
                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                Certification Clever Cloud
            </a>
        </div>
        <p class="footer-copy">Open source demo &middot; Deployed on Clever Cloud</p>
    </footer>

</div>

<script>
function selectDistance(val, btn) {
    document.querySelectorAll('.distance-btn').forEach(function(b) { b.classList.remove('active'); });
    btn.classList.add('active');
    document.getElementById('distance-input').value = val;
}

document.getElementById('run-form').addEventListener('submit', function(e) {
    var h = parseInt(document.getElementById('hours').value || '0');
    var m = parseInt(document.getElementById('minutes').value || '0');
    var s = parseInt(document.getElementById('seconds').value || '0');
    if (h === 0 && m === 0 && s === 0) {
        e.preventDefault();
        var field = document.getElementById('seconds').closest('.field');
        if (!field.querySelector('.error')) {
            var err = document.createElement('div');
            err.className = 'error';
            err.textContent = 'Veuillez entrer un temps valide';
            field.appendChild(err);
        }
        return;
    }
    var timeStr = h > 0
        ? h + ':' + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0')
        : m + ':' + String(s).padStart(2,'0');
    document.getElementById('time-input').value = timeStr;
    document.getElementById('spinner').style.display = 'block';
    document.getElementById('btn-text').textContent = 'Calcul en cours\u2026';
    document.getElementById('submit-btn').disabled = true;
});

document.getElementById('hours').addEventListener('input', function() {
    if (this.value.length >= 2) document.getElementById('minutes').focus();
});
document.getElementById('minutes').addEventListener('input', function() {
    if (this.value.length >= 2 && parseInt(this.value) >= 10) document.getElementById('seconds').focus();
});
</script>
</body>
</html>
