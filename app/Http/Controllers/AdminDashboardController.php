<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class AdminDashboardController extends Controller
{
    private const DIAGNOSIS_NAMES = [
        'G01' => 'Aki drop / lemah',
        'G02' => 'Sistem pengisian',
        'G03' => 'Filter udara / injektor kotor',
        'G04' => 'Ring piston aus',
        'G05' => 'Kekurangan oli mesin',
        'G06' => 'Masalah sistem CVT',
    ];

    public function __invoke(): Response
    {
        $today = CarbonImmutable::today();
        $recentDiagnoses = Diagnosis::with('user')->latest()->limit(100)->get();
        $symptomCounts = $this->symptomCounts($recentDiagnoses);
        $totalSymptomMentions = max($symptomCounts->sum('count'), 1);

        $chart = collect(range(29, 0))->map(function (int $daysAgo) use ($today): array {
            $date = $today->subDays($daysAgo);

            return [
                'label' => $date->locale('id')->isoFormat('ddd'),
                'count' => Diagnosis::whereDate('created_at', $date)->count(),
            ];
        });

        $totalDiagnoses = Diagnosis::count();

        return response()->view('admin-dashboard', [
            'dashboardData' => [
                'totalDiagnoses' => $totalDiagnoses,
                'registeredUsers' => User::where('role', 'user')->count(),
                'todayDiagnoses' => Diagnosis::whereDate('created_at', $today)->count(),
                'knowledgeItems' => count(self::DIAGNOSIS_NAMES),
                'chart' => $chart,
                'recentCount' => $recentDiagnoses->count(),
                'topDiagnoses' => $symptomCounts->take(4)->map(fn (array $item): array => [
                    ...$item,
                    'percentage' => (int) round($item['count'] / $totalSymptomMentions * 100),
                ])->values(),
                'diagnoses' => $recentDiagnoses->take(20)->map(fn (Diagnosis $diagnosis): array => [
                    'name' => $diagnosis->user?->name ?? 'Pengunjung',
                    'email' => $diagnosis->user?->email ?? 'Tanpa akun',
                    'initials' => $diagnosis->user
                        ? mb_strtoupper(mb_substr($diagnosis->user->name, 0, 2))
                        : 'PG',
                    'diagnosis' => collect($diagnosis->symptoms)->map(fn (string $code): string => self::DIAGNOSIS_NAMES[$code])->implode(', '),
                    'code' => implode(', ', $diagnosis->symptoms),
                    'severity' => $diagnosis->severity,
                    'time' => $diagnosis->created_at->locale('id')->diffForHumans(),
                    'status' => 'Selesai',
                ])->values(),
            ],
        ])->header('Cache-Control', 'private, no-store');
    }

    private function symptomCounts(Collection $diagnoses): Collection
    {
        return $diagnoses
            ->flatMap(fn (Diagnosis $diagnosis): array => $diagnosis->symptoms)
            ->countBy()
            ->sortDesc()
            ->map(fn (int $count, string $code): array => [
                'name' => self::DIAGNOSIS_NAMES[$code],
                'count' => $count,
            ])
            ->values();
    }
}
