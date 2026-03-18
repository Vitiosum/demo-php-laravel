<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\CarbonInterval;

class RunController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function result(Request $request)
    {
        $validated = $request->validate([
            'distance' => 'required|in:5k,10k,21k,42k',
            'time' => 'required|string',
        ]);

        $rawTime = trim($validated['time']);

        if (preg_match('/^\d+$/', $rawTime)) {
            $interval = CarbonInterval::minutes((int) $rawTime);
        } elseif (preg_match('/^\d+:\d{2}$/', $rawTime)) {
            [$m, $s] = explode(':', $rawTime);
            $interval = CarbonInterval::minutes((int) $m)->seconds((int) $s);
        } elseif (preg_match('/^\d+:\d{2}:\d{2}$/', $rawTime)) {
            [$h, $m, $s] = explode(':', $rawTime);
            $interval = CarbonInterval::hours((int) $h)
                ->minutes((int) $m)
                ->seconds((int) $s);
        } else {
            return back()->withErrors([
                'time' => 'Format invalide (ex : 20, 20:00, 1:20:00)',
            ]);
        }

        $totalSeconds = $interval->totalSeconds;

        $distanceKm = [
            '5k'  => 5,
            '10k' => 10,
            '21k' => 21.1,
            '42k' => 42.195,
        ];

        $referencePace = [
            '5k'  => 240,
            '10k' => 255,
            '21k' => 270,
            '42k' => 300,
        ];

        $km = $distanceKm[$validated['distance']];
        $paceSeconds = $totalSeconds / $km;

        $score = $referencePace[$validated['distance']] / $paceSeconds;
        $percentile = max(0, min(100, round($score * 50)));

        // Rank based on pace (sec/km)
        if ($paceSeconds <= 180)      $rank = 'Challenger';
        elseif ($paceSeconds <= 210)  $rank = 'Grandmaster';
        elseif ($paceSeconds <= 240)  $rank = 'Master';
        elseif ($paceSeconds <= 270)  $rank = 'Diamond';
        elseif ($paceSeconds <= 300)  $rank = 'Platinum';
        elseif ($paceSeconds <= 330)  $rank = 'Gold';
        elseif ($paceSeconds <= 390)  $rank = 'Silver';
        elseif ($paceSeconds <= 450)  $rank = 'Bronze';
        else                          $rank = 'Iron';

        $nextRanks = [
            'Iron'        => ['name' => 'Bronze',      'pace' => '7:30'],
            'Bronze'      => ['name' => 'Silver',      'pace' => '6:30'],
            'Silver'      => ['name' => 'Gold',        'pace' => '5:30'],
            'Gold'        => ['name' => 'Platinum',    'pace' => '5:00'],
            'Platinum'    => ['name' => 'Diamond',     'pace' => '4:30'],
            'Diamond'     => ['name' => 'Master',      'pace' => '4:00'],
            'Master'      => ['name' => 'Grandmaster', 'pace' => '3:30'],
            'Grandmaster' => ['name' => 'Challenger',  'pace' => '3:00'],
        ];

        $distanceLabels = [
            '5k'  => '5 km',
            '10k' => '10 km',
            '21k' => '21 km (Semi)',
            '42k' => '42 km (Marathon)',
        ];

        return view('result', [
            'distance'      => $distanceLabels[$validated['distance']],
            'time'          => $interval->cascade()->forHumans(['short' => true]),
            'pace'          => gmdate('i:s', (int) $paceSeconds),
            'percentile'    => $percentile,
            'rank'          => $rank,
            'nextRank'      => $nextRanks[$rank] ?? null,
        ]);
    }
}
