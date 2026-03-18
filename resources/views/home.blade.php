<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>RunRank</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #09090b 0%, #18181b 50%, #09090b 100%);
            color: white;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        .container { max-width: 440px; margin: 0 auto; padding: 40px 16px 60px; }
        .header { text-align: center; margin-bottom: 32px; }
        .logo { display: inline-flex; align-items: center; gap: 12px; margin-bottom: 10px; }
        .logo-icon { position: relative; color: #00CED1; }
        .logo-icon svg { display: block; }
        .logo-ping {
            position: absolute; top: -2px; right: -2px;
            width: 10px; height: 10px; background: #00CED1; border-radius: 50%;
            animation: ping 1.5s cubic-bezier(0,0,0.2,1) infinite;
        }
        @keyframes ping { 75%, 100% { transform: scale(2); opacity: 0; } }
        .logo h1 { font-size: 48px; font-weight: 300; letter-spacing: -1px; line-height: 1; }
        .logo h1 span { color: #00CED1; font-weight: 700; }
        .subtitle { color: #71717a; font-size: 14px; }
        .card {
            background: rgba(24,24,27,0.7);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 28px;
        }
        .field-label { display: block; font-size: 11px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: #71717a; margin-bottom: 10px; }
        .field { margin-bottom: 24px; }
        .distance-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .distance-btn {
            background: rgba(39,39,42,0.8); border: 2px solid #3f3f46; border-radius: 14px;
            color: #a1a1aa; cursor: pointer; padding: 14px 12px; text-align: left; transition: all 0.2s;
        }
        .distance-btn:hover { border-color: #71717a; color: #e4e4e7; background: rgba(63,63,70,0.6); }
        .distance-btn.active { border-color: #00CED1; background: rgba(0,206,209,0.1); color: #00CED1; transform: scale(1.02); }
        .distance-btn .d-label { display: block; font-weight: 600; font-size: 15px; }
        .distance-btn .d-sub { display: block; font-size: 11px; margin-top: 2px; opacity: 0.6; }
        .time-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; }
        .time-field { display: flex; flex-direction: column; gap: 6px; }
        .time-input {
            width: 100%; background: rgba(39,39,42,0.8); border: 2px solid #3f3f46;
            border-radius: 12px; color: white; font-size: 20px; padding: 14px 8px;
            text-align: center; transition: border-color 0.2s, box-shadow 0.2s;
            -moz-appearance: textfield;
        }
        .time-input::-webkit-outer-spin-button, .time-input::-webkit-inner-spin-button { -webkit-appearance: none; }
        .time-input::placeholder { color: #52525b; }
        .time-input:focus { outline: none; border-color: #00CED1; box-shadow: 0 0 0 3px rgba(0,206,209,0.15); }
        .time-sub { text-align: center; font-size: 11px; color: #52525b; }
        .error {
            display: flex; align-items: center; gap: 8px;
            background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25);
            border-radius: 10px; color: #f87171; font-size: 13px; padding: 10px 14px; margin-top: 10px;
        }
        .submit-btn {
            width: 100%; background: linear-gradient(90deg, #00CED1, #00B4D8);
            border: none; border-radius: 14px; color: white; cursor: pointer;
            font-size: 16px; font-weight: 600; padding: 16px; transition: all 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 10px; margin-top: 8px;
        }
        .submit-btn:hover { transform: scale(1.02); filter: brightness(1.1); }
        .submit-btn:active { transform: scale(0.98); }
        .submit-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
        .spinner {
            width: 18px; height: 18px; border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white; border-radius: 50%;
            animation: spin 0.7s linear infinite; display: none;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .hint { text-align: center; color: #52525b; font-size: 12px; margin-top: 20px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="logo">
            <div class="logo-icon">
                <svg width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 21h8M12 17v4M17 8a5 5 0 11-10 0 5 5 0 0110 0z"/>
                </svg>
                <div class="logo-ping"></div>
            </div>
            <h1>Run<span>Rank</span></h1>
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
                        <input type="number" class="time-input" id="hours" min="0" max="24" placeholder="0">
                        <span class="time-sub">heures</span>
                    </div>
                    <div class="time-field">
                        <input type="number" class="time-input" id="minutes" min="0" max="59" placeholder="0">
                        <span class="time-sub">minutes</span>
                    </div>
                    <div class="time-field">
                        <input type="number" class="time-input" id="seconds" min="0" max="59" placeholder="0">
                        <span class="time-sub">secondes</span>
                    </div>
                </div>
                <input type="hidden" name="time" id="time-input">
                @error('time')
                <div class="error">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ $message }}
                </div>
                @enderror
            </div>

            <button type="submit" class="submit-btn" id="submit-btn">
                <span class="spinner" id="spinner"></span>
                <span id="btn-text">Calculer mon rang</span>
            </button>
        </form>
    </div>

    <p class="hint">Laisse les heures à 0 si tu cours moins d'1 heure</p>
</div>

<script>
function selectDistance(val, btn) {
    document.querySelectorAll('.distance-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('distance-input').value = val;
}
document.getElementById('run-form').addEventListener('submit', function(e) {
    const h = parseInt(document.getElementById('hours').value || '0');
    const m = parseInt(document.getElementById('minutes').value || '0');
    const s = parseInt(document.getElementById('seconds').value || '0');
    if (h === 0 && m === 0 && s === 0) {
        e.preventDefault();
        if (!document.querySelector('.error')) {
            const err = document.createElement('div');
            err.className = 'error';
            err.innerHTML = '<svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> Veuillez entrer un temps valide';
            document.getElementById('seconds').closest('.field').appendChild(err);
        }
        return;
    }
    const timeStr = h > 0
        ? h + ':' + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0')
        : m + ':' + String(s).padStart(2,'0');
    document.getElementById('time-input').value = timeStr;
    document.getElementById('spinner').style.display = 'block';
    document.getElementById('btn-text').textContent = 'Calcul en cours…';
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
