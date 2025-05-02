<?php
namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    /**
     * Create a new report.
     */
    public function store(Request $request)
    {
        // Define validation rules
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'crime_type' => ['required', 'string', 'in:Theft,Vandalism,Harassment,Fraud,Other'],
            'incident_date' => ['required', 'date'],
            'incident_location' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'attachments' => ['nullable', 'array', 'max:5'],
            'attachments.*' => ['file', 'mimes:jpg,jpeg,png,mp4,pdf', 'max:10240'], // 10MB
            'witness_name' => ['nullable', 'string', 'max:255'],
            'witness_contact' => ['nullable', 'string', 'max:255'],
            'allow_contact' => ['boolean'],
            'consent' => ['required', 'accepted'],
        ]);

        try {
            // Prepare data for storage
            $data = $request->all();
            $attachmentPaths = [];

            // Handle file uploads
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('uploads', 'public');
                    $attachmentPaths[] = $path;
                }
            }

            // Store attachment paths in data
            $data['attachments'] = $attachmentPaths;

            // Create report in database
            $report = Report::create($data);

            return response()->json([
                'success' => true,
                'data' => $report,
                'message' => 'Report submitted successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error submitting report: ' . $e->getMessage()
            ], 500);
        }
    }
}