<?php

namespace App\Http\Controllers;

use App\Models\Sos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SosController extends Controller
{
    // Uncomment if you want authentication
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    // Get all SOS reports
    public function index()
    {
        try {
            $sosReports = Sos::with('user')->latest()->get();

            $formatted = $sosReports->map(function ($report) {
                return [
                    'id' => $report->id,
                    'sos_type' => $report->sos_type,
                    'description' => $report->description,
                    'latitude' => $report->latitude,
                    'longitude' => $report->longitude,
                    'created_at' => $report->created_at->toDateTimeString(),
                    'user' => [
                        'id' => $report->user->id ?? null,
                        'name' => $report->user->name ?? null,
                        'email' => $report->user->email ?? null,
                    ]
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $formatted,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch SOS reports.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Store a new SOS report
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'sos_type' => 'required|in:police,ambulance,fire_services',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Create the SOS record
        $sos = Sos::create([
            'user_id' => $user->id,
            'sos_type' => $validated['sos_type'],
            'description' => $validated['description'] ?? null,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        // Format the service name for the response
        $serviceNames = [
            'police' => 'Police',
            'ambulance' => 'Ambulance',
            'fire_services' => 'Fire Services',
        ];
        $serviceName = $serviceNames[$validated['sos_type']] ?? $validated['sos_type'];

        // Return success response
        return response()->json([
            'success' => true,
            'message' => "{$serviceName} has been notified! Help is on the way.",
            'data' => [
                'id' => $sos->id,
                'service' => $serviceName,
                'description' => $sos->description,
                'location' => [
                    'latitude' => $sos->latitude,
                    'longitude' => $sos->longitude,
                ],
                'created_at' => $sos->created_at->toDateTimeString(),
            ]
        ], 201);
    }
}
