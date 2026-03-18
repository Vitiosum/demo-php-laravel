<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultat – RunRank</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
    $rankColors = [
        'Iron'        => '#6b6b6b',
        'Bronze'      => '#CD7F32',
        'Silver'      => '#C0C0C0',
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
    $color = $rankColors[$rank] ?? '#00CED1';
    $message = $rankMessages[$rank] ?? '';
    $emoji = $rankEmojis[$rank] ?? '🏅';
    $progressPercent = 100 - $percentile;
    @endphp
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #09090b 0%, #18181b 50%, #09090b 100%);
            color: white;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        .container { max-width: 440px; margin: 0 auto; padding: 40px 16px 60px; }
        .card {
            background: rgba(24,24,27,0.7); backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.08); border-radius: 20px;
            margin-bottom: 12px; overflow: hidden;
        }
        .rank-badge { padding: 32px; text-align: center; }
        .rank-circle {
            width: 120px; height: 120px; border-radius: 50%;
            margin: 0 auto 20px; position: relative;
            display: flex; align-items: center; justify-content: center;
            font-size: 52px;
        }
        .rank-circle-ring {
            position: absolute; inset: 0; border-radius: 50%;
            animation: ping 2s cubic-bezier(0,0,0.2,1) infinite; opacity: 0.2;
        }
        @keyframes ping { 75%, 100% { transform: scale(1.4); opacity: 0; } }
        .rank-name { font-size: 42px; font-weight: 300; letter-spacing: 4px; text-transform: uppercase; margin-bottom: 8px; }
        .rank-message { color: #71717a; font-size: 14px; }
        .percentile-card { padding: 20px 24px; }
        .percentile-header { display: flex; justify-content: space-between; align-items: center; font-size: 13px; margin-bottom: 10px; }
        .percentile-label { color: #71717a; }
        .bar-bg { height: 8px; background: rgba(255,255,255,0.08); border-radius: 99px; overflow: hidden; }
        .bar-fill { height: 100%; border-radius: 99px; }
        .bar-ends { display: flex; justify-content: space-between; font-size: 10px; color: #52525b; margin-top: 6px; }
        .stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px; }
        .stat-card { background: rgba(24,24,27,0.7); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 18px; }
        .stat-label { font-size: 10px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: #71717a; margin-bottom: 8px; }
        .stat-value { font-size: 28px; font-weight: 300; color: white; }
        .stat-sub { font-size: 11px; color: #52525b; margin-top: 4px; }
        .next-card { background: rgba(24,24,27,0.7); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .next-label { font-size: 10px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: #71717a; margin-bottom: 6px; }
        .next-info { display: flex; align-items: center; gap: 8px; font-size: 14px; }
        .actions { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .btn { display: flex; align-items: center; justify-content: center; gap: 8px; border-radius: 14px; font-size: 14px; font-weight: 500; padding: 14px; text-decoration: none; transition: all 0.2s; border: 1px solid; cursor: pointer; background: none; }
        .btn-share { background: rgba(39,39,42,0.8); border-color: rgba(255,255,255,0.1); color: white; }
        .btn-share:hover { background: rgba(63,63,70,0.8); }
    </style>
</head>
<body>
<div class="container">

    <div class="card">
        <div class="rank-badge">
            <div class="rank-circle" style="background: linear-gradient(135deg, {{ $color }}25, {{ $color }}08); box-shadow: 0 0 60px {{ $color }}25">
                <div class="rank-circle-ring" style="background: {{ $color }}"></div>
                {{ $emoji }}
            </div>
            <div class="rank-name" style="color: {{ $color }}; text-shadow: 0 0 20px {{ $color }}50">{{ $rank }}</div>
            <p class="rank-message">{{ $message }}</p>
        </div>
    </div>

    <div class="card">
        <div class="percentile-card">
            <div class="percentile-header">
                <span class="percentile-label">Position parmi les coureurs</span>
                <span style="font-weight: 600; color: {{ $color }}">Top {{ $percentile }}%</span>
            </div>
            <div class="bar-bg">
                <div class="bar-fill" style="width: {{ $progressPercent }}%; background: linear-gradient(90deg, {{ $color }}60, {{ $color }}); box-shadow: 0 0 8px {{ $color }}50"></div>
            </div>
            <div class="bar-ends"><span>Iron</span><span>Challenger</span></div>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">⏱ Temps</div>
            <div class="stat-value">{{ $time }}</div>
            <div class="stat-sub">{{ $distance }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">⚡ Allure</div>
            <div class="stat-value">{{ $pace }}</div>
            <div class="stat-sub">min/km</div>
        </div>
    </div>

    @if($nextRank)
    <div class="next-card">
        <div>
            <div class="next-label">Prochain rang</div>
            <div class="next-info">
                <span style="color: {{ $rankColors[$nextRank['name']] ?? '#fff' }}; font-weight: 600">{{ $nextRank['name'] }}</span>
                <span style="color: #52525b">›</span>
                <span style="color: #a1a1aa; font-size: 13px">pace &lt; {{ $nextRank['pace'] }}/km</span>
            </div>
        </div>
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#52525b" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
    </div>
    @endif

    <div class="actions">
        <button class="btn btn-share" onclick="shareResult()">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
            <span id="share-text">Partager</span>
        </button>
        <a href="/" class="btn" style="background: {{ $color }}15; border-color: {{ $color }}40; color: {{ $color }}">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.28"/></svg>
            Recalculer
        </a>
    </div>
</div>

<script>
function shareResult() {
    const text = '🏃 {{ $distance }} en {{ $time }} · Allure {{ $pace }}/km · Rang {{ $rank }} (Top {{ $percentile }}%) #RunRank';
    if (navigator.share) {
        navigator.share({ title: 'Mon rang RunRank', text });
    } else {
        navigator.clipboard.writeText(text).then(() => {
            const el = document.getElementById('share-text');
            el.textContent = 'Copié !';
            setTimeout(() => el.textContent = 'Partager', 2000);
        });
    }
}
</script>
</body>
</html>
