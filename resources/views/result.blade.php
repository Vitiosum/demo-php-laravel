<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultat – RunRank</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    @php
    $rankColors = [
        'Iron'        => '#6E7179',
        'Bronze'      => '#CD7F32',
        'Silver'      => '#B0B8C0',
        'Gold'        => '#FFD700',
        'Platinum'    => '#00CED1',
        'Diamond'     => '#4169E1',
        'Master'      => '#9B30FF',
        'Grandmaster' => '#DC143C',
        'Challenger'  => '#00FFFF',
    ];
    $rankMessages = [
        'Iron'        => 'Débute ton aventure — continue de courir !',
        'Bronze'      => 'Tu progresses bien — garde le rythme !',
        'Silver'      => 'Coureur régulier — beau travail !',
        'Gold'        => 'Performance solide — tu t\'améliores !',
        'Platinum'    => 'Coureur avancé — excellent niveau !',
        'Diamond'     => 'Coureur d\'élite — impressionnant !',
        'Master'      => 'Performance exceptionnelle — athlète confirmé !',
        'Grandmaster' => 'Athlète de très haut niveau — remarquable !',
        'Challenger'  => 'Élite absolue — tu es exceptionnel !',
    ];
    $rankEmojis = [
        'Iron' => '🏅', 'Bronze' => '🥉', 'Silver' => '🥈',
        'Gold' => '🥇', 'Platinum' => '🏆', 'Diamond' => '💎',
        'Master' => '👑', 'Grandmaster' => '⭐', 'Challenger' => '⚡',
    ];
    $color   = $rankColors[$rank]    ?? '#FF5A1F';
    $message = $rankMessages[$rank]  ?? '';
    $emoji   = $rankEmojis[$rank]    ?? '🏅';
    $progressPercent = 100 - $percentile;
    @endphp
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #07080C;
            --surface: #0C0E13;
            --border: #1A1D26;
            --text: #E6E8F0;
            --muted: #4E5468;
            --accent: {{ $color }};
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

        .container { max-width: 460px; margin: 0 auto; padding: 32px 20px 60px; }

        /* ── RANK HERO ── */
        .rank-hero {
            background: var(--surface);
            border: 1px solid var(--border);
            border-top: 3px solid {{ $color }};
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .rank-hero-inner {
            padding: 36px 28px 28px;
            text-align: center;
            background: radial-gradient(ellipse at 50% 0%, {{ $color }}12 0%, transparent 65%);
        }

        .rank-emoji { font-size: 44px; line-height: 1; display: block; margin-bottom: 16px; }

        .rank-name {
            font-family: var(--font-display);
            font-size: 84px;
            letter-spacing: 4px;
            line-height: 0.9;
            color: {{ $color }};
            text-shadow: 0 0 40px {{ $color }}45;
            margin-bottom: 12px;
        }

        .rank-message { color: var(--muted); font-size: 13.5px; }

        /* ── CARD BASE ── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px 22px;
            margin-bottom: 10px;
        }

        /* ── PERCENTILE ── */
        .percentile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .percentile-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .percentile-value { font-family: var(--font-mono); font-size: 14px; font-weight: 500; color: {{ $color }}; }

        .bar-bg { height: 6px; background: rgba(255,255,255,0.06); border-radius: 99px; overflow: hidden; margin-bottom: 8px; }

        .bar-fill {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, {{ $color }}50, {{ $color }});
            box-shadow: 0 0 10px {{ $color }}40;
            width: {{ $progressPercent }}%;
        }

        .bar-ends { display: flex; justify-content: space-between; font-size: 10px; color: var(--muted); opacity: 0.6; }

        /* ── STATS ── */
        .stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px; }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 18px 20px;
        }

        .stat-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 10px;
        }

        .stat-value {
            font-family: var(--font-mono);
            font-size: 30px;
            font-weight: 500;
            color: var(--text);
            line-height: 1;
            margin-bottom: 6px;
        }

        .stat-sub { font-size: 11px; color: var(--muted); }

        /* ── NEXT RANK ── */
        .next-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .next-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .next-info { display: flex; align-items: center; gap: 8px; font-size: 14px; }
        .next-pace { font-family: var(--font-mono); font-size: 13px; color: var(--muted); }

        /* ── ACTIONS ── */
        .actions { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 14px; }

        .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 10px;
            font-family: var(--font-body);
            font-size: 14px;
            font-weight: 500;
            padding: 13px;
            text-decoration: none;
            transition: all 0.15s;
            border: 1px solid;
            cursor: pointer;
            background: none;
        }

        .btn-share { background: rgba(255,255,255,0.025); border-color: var(--border); color: var(--text); }
        .btn-share:hover { background: rgba(255,255,255,0.05); border-color: #252830; }

        .btn-back { background: {{ $color }}14; border-color: {{ $color }}35; color: {{ $color }}; }
        .btn-back:hover { background: {{ $color }}22; }

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

        .cert-btn:hover { background: #E8B428; transform: translateY(-1px); }

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

    <!-- Rank Hero -->
    <div class="rank-hero">
        <div class="rank-hero-inner">
            <span class="rank-emoji">{{ $emoji }}</span>
            <div class="rank-name">{{ $rank }}</div>
            <p class="rank-message">{{ $message }}</p>
        </div>
    </div>

    <!-- Percentile -->
    <div class="card">
        <div class="percentile-header">
            <span class="percentile-label">Position parmi les coureurs</span>
            <span class="percentile-value">Top {{ $percentile }}%</span>
        </div>
        <div class="bar-bg">
            <div class="bar-fill"></div>
        </div>
        <div class="bar-ends">
            <span>Iron</span>
            <span>Challenger</span>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">
                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
                Temps
            </div>
            <div class="stat-value">{{ $time }}</div>
            <div class="stat-sub">{{ $distance }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">
                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                </svg>
                Allure
            </div>
            <div class="stat-value">{{ $pace }}</div>
            <div class="stat-sub">min / km</div>
        </div>
    </div>

    <!-- Next Rank -->
    @if($nextRank)
    <div class="next-card">
        <div>
            <div class="next-label">Prochain rang</div>
            <div class="next-info">
                <span style="color: {{ $rankColors[$nextRank['name']] ?? '#fff' }}; font-weight: 600">{{ $nextRank['name'] }}</span>
                <span style="color: var(--muted)">›</span>
                <span class="next-pace">pace &lt; {{ $nextRank['pace'] }}/km</span>
            </div>
        </div>
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#4E5468" stroke-width="2">
            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/>
        </svg>
    </div>
    @endif

    <!-- Actions -->
    <div class="actions">
        <button class="btn btn-share" id="share-btn" onclick="shareResult()">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/>
                <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
                <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
            </svg>
            <span id="share-text">Partager</span>
        </button>
        <a href="/" class="btn btn-back">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <polyline points="1 4 1 10 7 10"/>
                <path d="M3.51 15a9 9 0 1 0 .49-3.28"/>
            </svg>
            Recalculer
        </a>
    </div>

    <!-- Cert Banner -->
    <div class="cert-banner">
        <div class="cert-icon">🎓</div>
        <div class="cert-content">
            <div class="cert-title">Envie de maîtriser Clever Cloud ?</div>
            <div class="cert-sub">Validez vos compétences avec la certification officielle — et devenez expert de la plateforme.</div>
        </div>
        <a class="cert-btn" href="https://academy.clever.cloud/" target="_blank" rel="noopener noreferrer">Obtenir la certification →</a>
    </div>

    <!-- Footer -->
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
function shareResult() {
    var text = '🏃 {{ $distance }} en {{ $time }} \u00b7 Allure {{ $pace }}/km \u00b7 Rang {{ $rank }} (Top {{ $percentile }}%) #RunRank';
    if (navigator.share) {
        navigator.share({ title: 'Mon rang RunRank', text: text });
    } else {
        navigator.clipboard.writeText(text).then(function() {
            var el = document.getElementById('share-text');
            el.textContent = 'Copié !';
            setTimeout(function() { el.textContent = 'Partager'; }, 2000);
        });
    }
}
</script>
</body>
</html>
