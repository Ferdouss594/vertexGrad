<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\AuditLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScannerCallbackController extends Controller
{
    public function handle(Request $request)
    {
        try {
            Log::info('SCANNER CALLBACK RECEIVED', [
                'payload' => $request->all(),
            ]);

            $data = $request->validate([
                'event' => 'required|string|max:100',
                'version' => 'nullable|string|max:20',

                'project.platform_project_id' => 'required|integer',
                'project.scanner_project_id' => 'required|integer',
                'project.scanner_token' => 'nullable|string|max:255',
                'project.name' => 'nullable|string|max:255',
                'project.student_name' => 'nullable|string|max:255',
                'project.student_email' => 'nullable|email|max:255',
                'project.language' => 'nullable|string|max:100',

                'scan.status' => 'required|string|max:50',
                'scan.score' => 'nullable|numeric',
                'scan.grade' => 'nullable|string|max:20',
                'scan.risk_level' => 'nullable|string|max:50',
                'scan.started_at' => 'nullable|string',
                'scan.completed_at' => 'nullable|string',

                'summary.total_files' => 'nullable|integer',
                'summary.issues_total' => 'nullable|integer',
                'summary.critical' => 'nullable|integer',
                'summary.high' => 'nullable|integer',
                'summary.medium' => 'nullable|integer',
                'summary.low' => 'nullable|integer',

                'highlights' => 'nullable|array',
                'highlights.*' => 'nullable|string',

                'recommendations' => 'nullable|array',
                'recommendations.*' => 'nullable|string',
            ]);

            $platformProjectId = data_get($data, 'project.platform_project_id');

            $project = Project::where('project_id', $platformProjectId)->first();

            if (! $project) {
                AuditLogService::log(
                    event: 'scan_callback_project_missing',
                    description: 'Scanner callback received for missing platform project: ' . $platformProjectId,
                    category: 'project_scanner',
                    properties: [
                        'platform_project_id' => $platformProjectId,
                        'scanner_project_id' => data_get($data, 'project.scanner_project_id'),
                        'scanner_status' => data_get($data, 'scan.status'),
                        'event' => data_get($data, 'event'),
                        'payload' => $data,
                    ]
                );

                return response()->json([
                    'success' => false,
                    'message' => 'Platform project not found',
                ], 404);
            }

            $oldValues = $this->auditProjectScannerPayload($project);

            $scannerStatus = data_get($data, 'scan.status', 'unknown');
            $score = data_get($data, 'scan.score');
            $completedAt = data_get($data, 'scan.completed_at');

            $newProjectStatus = $scannerStatus === 'completed'
                ? 'awaiting_manual_review'
                : ($scannerStatus === 'failed' ? 'scan_failed' : 'scan_requested');

            $project->update([
                'scanner_project_id' => data_get($data, 'project.scanner_project_id'),
                'scanner_status' => $scannerStatus,
                'scan_score' => $score,
                'scan_report' => $data,
                'scanned_at' => $completedAt ?: now(),
                'status' => $newProjectStatus,
            ]);

            $project->refresh();

            AuditLogService::log(
                event: $this->resolveScannerEvent($scannerStatus),
                description: $this->resolveScannerDescription($project, $scannerStatus),
                category: 'project_scanner',
                subject: $project,
                oldValues: $oldValues,
                newValues: $this->auditProjectScannerPayload($project),
                properties: [
                    'callback_event' => data_get($data, 'event'),
                    'callback_version' => data_get($data, 'version'),
                    'platform_project_id' => $platformProjectId,
                    'scanner_project_id' => data_get($data, 'project.scanner_project_id'),
                    'scanner_token' => data_get($data, 'project.scanner_token'),
                    'project_name_from_scanner' => data_get($data, 'project.name'),
                    'student_name' => data_get($data, 'project.student_name'),
                    'student_email' => data_get($data, 'project.student_email'),
                    'language' => data_get($data, 'project.language'),
                    'scan_status' => $scannerStatus,
                    'score' => data_get($data, 'scan.score'),
                    'grade' => data_get($data, 'scan.grade'),
                    'risk_level' => data_get($data, 'scan.risk_level'),
                    'started_at' => data_get($data, 'scan.started_at'),
                    'completed_at' => data_get($data, 'scan.completed_at'),
                    'summary' => [
                        'total_files' => data_get($data, 'summary.total_files'),
                        'issues_total' => data_get($data, 'summary.issues_total'),
                        'critical' => data_get($data, 'summary.critical'),
                        'high' => data_get($data, 'summary.high'),
                        'medium' => data_get($data, 'summary.medium'),
                        'low' => data_get($data, 'summary.low'),
                    ],
                    'highlights' => data_get($data, 'highlights', []),
                    'recommendations' => data_get($data, 'recommendations', []),
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Scanner callback processed successfully',
            ]);
        } catch (\Throwable $e) {
            Log::error('SCANNER CALLBACK FAILED', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            AuditLogService::log(
                event: 'scan_callback_failed',
                description: 'Scanner callback processing failed',
                category: 'project_scanner',
                properties: [
                    'error_message' => $e->getMessage(),
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'payload' => $request->all(),
                ]
            );

            return response()->json([
                'success' => false,
                'message' => 'Callback processing failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    protected function resolveScannerEvent(string $scannerStatus): string
    {
        return match ($scannerStatus) {
            'completed' => 'scan_completed',
            'failed' => 'scan_failed',
            'processing' => 'scan_processing',
            'pending' => 'scan_pending',
            default => 'scan_updated',
        };
    }

    protected function resolveScannerDescription(Project $project, string $scannerStatus): string
    {
        return match ($scannerStatus) {
            'completed' => 'Scanner completed analysis for project: ' . $project->name,
            'failed' => 'Scanner failed analysis for project: ' . $project->name,
            'processing' => 'Scanner is processing project: ' . $project->name,
            'pending' => 'Scanner callback marked project as pending: ' . $project->name,
            default => 'Scanner updated project status for: ' . $project->name,
        };
    }

    protected function auditProjectScannerPayload(Project $project): array
    {
        return [
            'project_id' => $project->project_id,
            'name' => $project->name,
            'status' => $project->status,
            'scanner_status' => $project->scanner_status,
            'scanner_project_id' => $project->scanner_project_id,
            'scan_score' => $project->scan_score,
            'scanned_at' => $project->scanned_at,
            'scan_report' => $project->scan_report,
        ];
    }
}