<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DiagnosisController extends Controller
{
    private const SEVERITY_BY_CODE = [
        'G01' => 'Sedang',
        'G02' => 'Sedang',
        'G03' => 'Sedang',
        'G04' => 'Berat',
        'G05' => 'Berat',
        'G06' => 'Ringan',
    ];

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'symptoms' => ['required', 'array', 'min:1', 'max:6'],
            'symptoms.*' => ['required', 'string', 'distinct', Rule::in(array_keys(self::SEVERITY_BY_CODE))],
        ]);

        $severity = collect($validated['symptoms'])
            ->map(fn (string $code): string => self::SEVERITY_BY_CODE[$code])
            ->contains('Berat')
                ? 'Berat'
                : (collect($validated['symptoms'])->contains(fn (string $code): bool => self::SEVERITY_BY_CODE[$code] === 'Sedang')
                    ? 'Sedang'
                    : 'Ringan');

        $diagnosis = Diagnosis::create([
            'user_id' => $request->user()?->id,
            'symptoms' => array_values($validated['symptoms']),
            'severity' => $severity,
        ]);

        return response()->json(['id' => $diagnosis->id], 201);
    }
}
