<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DynamicReportExport;
use App\Http\Controllers\Controller;
use App\Models\ReportTemplate;
use App\Models\ScheduledReport;
use App\Services\Reports\ReportBuilderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Models\ReportExport;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    protected ReportBuilderService $reportBuilder;

    public function __construct(ReportBuilderService $reportBuilder)
    {
        $this->reportBuilder = $reportBuilder;
    }

    protected function currentManager()
    {
        $user = auth('admin')->user();

        abort_unless($user && in_array($user->role, ['Manager', 'Admin']), 403);

        return $user;
    }

    public function index()
    {
        $this->currentManager();

        $entities = [
            'projects'  => 'Projects',
            'students'  => 'Students',
            'investors' => 'Investors',
            'platform'  => 'Platform Summary',
        ];

        $periods = [
            'daily'   => 'Daily',
            'weekly'  => 'Weekly',
            'monthly' => 'Monthly',
            'yearly'  => 'Yearly',
            'custom'  => 'Custom Range',
        ];

        $availableColumns = [
            'projects' => [
                'project_id'       => 'Project ID',
                'name'             => 'Project Name',
                'category'         => 'Category',
                'status'           => 'Status',
                'final_decision'   => 'Final Decision',
                'budget'           => 'Budget',
                'created_at'       => 'Created At',
                'student_name'     => 'Student Name',
                'student_email'    => 'Student Email',
                'supervisor_name'  => 'Supervisor Name',
                'manager_name'     => 'Manager Name',
                'investors_count'  => 'Investors Count',
                'average_score'    => 'Average Score',
            ],
            'students' => [
                'id'               => 'Student ID',
                'name'             => 'Name',
                'email'            => 'Email',
                'created_at'       => 'Created At',
                'projects_count'   => 'Projects Count',
                'latest_project'   => 'Latest Project',
            ],
            'investors' => [
                'id'               => 'Investor ID',
                'name'             => 'Name',
                'email'            => 'Email',
                'created_at'       => 'Created At',
                'projects_count'   => 'Projects Count',
                'project_names'    => 'Projects',
            ],
            'platform' => [
                'total_students'     => 'Total Students',
                'total_investors'    => 'Total Investors',
                'total_projects'     => 'Total Projects',
                'published_projects' => 'Published Projects',
                'revision_projects'  => 'Revision Requested',
                'rejected_projects'  => 'Rejected Projects',
            ],
        ];

        return view('admin.reports.index', compact('entities', 'periods', 'availableColumns'));
    }

    public function preview(Request $request)
    {
        $this->currentManager();

        $payload = $this->validatedPayload($request);
        $report = $this->reportBuilder->build($payload);

        return view('admin.reports.result', [
            'report' => $report,
            'filters' => $payload,
        ]);
    }

    public function exportPdf(Request $request)
    {
        $this->currentManager();

        $payload = $this->validatedPayload($request);
        $report = $this->reportBuilder->build($payload);

        $fileName = 'report_' . $payload['entity'] . '_' . now()->format('Ymd_His') . '.pdf';

        return Pdf::view('admin.reports.pdf', [
                'report' => $report,
                'filters' => $payload,
            ])
            ->format('a4')
            ->landscape()
            ->name($fileName);
    }

    public function exportExcel(Request $request)
    {
        $this->currentManager();

        $payload = $this->validatedPayload($request);
        $report = $this->reportBuilder->build($payload);

        $fileName = 'report_' . $payload['entity'] . '_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new DynamicReportExport($report), $fileName);
    }

    protected function validatedPayload(Request $request): array
    {
        $validated = $request->validate([
            'entity' => ['required', 'in:projects,students,investors,platform'],
            'period' => ['required', 'in:daily,weekly,monthly,yearly,custom'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
            'columns' => ['nullable', 'array'],
            'columns.*' => ['string'],
            'status' => ['nullable', 'string'],
            'final_decision' => ['nullable', 'string'],
            'category' => ['nullable', 'string'],
            'student_name' => ['nullable', 'string'],
            'investor_name' => ['nullable', 'string'],
        ]);

        $validated['columns'] = $validated['columns'] ?? [];

        return $validated;
    }

    public function saveTemplate(Request $request)
    {
        $manager = $this->currentManager();

        $validated = $request->validate([
            'template_name' => ['required', 'string', 'max:255'],
            'entity' => ['required', 'in:projects,students,investors,platform'],
            'period' => ['required', 'in:daily,weekly,monthly,yearly,custom'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
            'columns' => ['nullable', 'array'],
            'columns.*' => ['string'],
            'status' => ['nullable', 'string'],
            'final_decision' => ['nullable', 'string'],
            'category' => ['nullable', 'string'],
            'student_name' => ['nullable', 'string'],
            'investor_name' => ['nullable', 'string'],
        ]);

        ReportTemplate::create([
            'name' => $validated['template_name'],
            'entity' => $validated['entity'],
            'period' => $validated['period'],
            'filters_json' => [
                'from' => $validated['from'] ?? null,
                'to' => $validated['to'] ?? null,
                'status' => $validated['status'] ?? null,
                'final_decision' => $validated['final_decision'] ?? null,
                'category' => $validated['category'] ?? null,
                'student_name' => $validated['student_name'] ?? null,
                'investor_name' => $validated['investor_name'] ?? null,
            ],
            'columns_json' => $validated['columns'] ?? [],
            'created_by' => $manager->id,
        ]);

        return redirect()
            ->route('admin.reports.templates')
            ->with('success', 'Report template saved successfully.');
    }

    public function templates()
    {
        $manager = $this->currentManager();

        $templates = ReportTemplate::with('creator')
            ->where(function ($query) use ($manager) {
                $query->where('created_by', $manager->id)
                    ->orWhere('is_system', true);
            })
            ->latest()
            ->paginate(12);

        return view('admin.reports.templates', compact('templates'));
    }

    public function runTemplate(ReportTemplate $template)
    {
        $this->currentManager();

        $filters = array_merge(
            [
                'entity' => $template->entity,
                'period' => $template->period,
                'columns' => $template->columns_json ?? [],
            ],
            $template->filters_json ?? []
        );

        $report = $this->reportBuilder->build($filters);

        return view('admin.reports.result', [
            'report' => $report,
            'filters' => $filters,
        ]);
    }

    public function deleteTemplate(ReportTemplate $template)
    {
        $manager = $this->currentManager();

        abort_unless($template->created_by === $manager->id || $manager->role === 'Admin', 403);

        $template->delete();

        return redirect()
            ->route('admin.reports.templates')
            ->with('success', 'Report template deleted successfully.');
    }

    public function scheduled()
    {
        $manager = $this->currentManager();

        $scheduledReports = ScheduledReport::with(['template', 'creator'])
            ->where('created_by', $manager->id)
            ->latest()
            ->paginate(12);

        $templates = ReportTemplate::where('created_by', $manager->id)
            ->orWhere('is_system', true)
            ->latest()
            ->get();

        return view('admin.reports.scheduled', compact('scheduledReports', 'templates'));
    }

    public function storeScheduled(Request $request)
    {
        $manager = $this->currentManager();

        $validated = $request->validate([
            'report_template_id' => ['required', 'exists:report_templates,id'],
            'frequency' => ['required', 'in:daily,weekly,monthly,yearly'],
            'run_time' => ['required', 'date_format:H:i'],
            'start_date' => ['required', 'date'],
            'days_of_week' => ['nullable', 'array'],
            'days_of_week.*' => ['string'],
            'day_of_month' => ['nullable', 'integer', 'min:1', 'max:31'],
            'month_of_year' => ['nullable', 'integer', 'min:1', 'max:12'],
            'delivery_type' => ['nullable', 'in:email,email_excel,both'],
            'notes' => ['nullable', 'string'],
            'email' => ['required', 'email'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $nextRunAt = $this->calculateInitialNextRun($validated);

        ScheduledReport::create([
            'report_template_id' => $validated['report_template_id'],
            'frequency' => $validated['frequency'],
            'run_time' => $validated['run_time'],
            'start_date' => $validated['start_date'],
            'days_of_week' => $validated['days_of_week'] ?? null,
            'day_of_month' => $validated['day_of_month'] ?? null,
            'month_of_year' => $validated['month_of_year'] ?? null,
            'delivery_type' => $validated['delivery_type'] ?? 'email',
            'notes' => $validated['notes'] ?? null,
            'email' => $validated['email'],
            'is_active' => (bool) ($validated['is_active'] ?? true),
            'next_run_at' => $nextRunAt,
            'created_by' => $manager->id,
        ]);

        return redirect()
            ->route('admin.reports.scheduled')
            ->with('success', 'Scheduled report created successfully.');
    }

    protected function calculateInitialNextRun(array $data)
    {
        $base = Carbon::parse($data['start_date'] . ' ' . $data['run_time']);

        if ($data['frequency'] === 'daily') {
            return $base->greaterThan(now()) ? $base : $base->copy()->addDay();
        }

        if ($data['frequency'] === 'weekly') {
            $allowedDays = collect($data['days_of_week'] ?? [])
                ->map(fn ($day) => strtolower($day))
                ->values();

            $candidate = $base->copy();

            for ($i = 0; $i < 14; $i++) {
                $dayName = strtolower($candidate->format('l'));

                if ($allowedDays->contains($dayName) && $candidate->greaterThan(now())) {
                    return $candidate;
                }

                $candidate->addDay();
                $candidate->setTimeFromTimeString($data['run_time']);
            }

            return $base->copy()->addWeek();
        }

        if ($data['frequency'] === 'monthly') {
            $day = (int) ($data['day_of_month'] ?? $base->day);

            $candidate = $base->copy()->day(min($day, $base->copy()->endOfMonth()->day));

            if ($candidate->lessThanOrEqualTo(now())) {
                $candidate = $candidate->copy()->addMonthNoOverflow();
                $candidate->day(min($day, $candidate->copy()->endOfMonth()->day));
            }

            return $candidate;
        }

        if ($data['frequency'] === 'yearly') {
            $month = (int) ($data['month_of_year'] ?? $base->month);
            $day = (int) ($data['day_of_month'] ?? $base->day);

            $candidate = $base->copy()->month($month);
            $candidate->day(min($day, $candidate->copy()->endOfMonth()->day));

            if ($candidate->lessThanOrEqualTo(now())) {
                $candidate = $candidate->copy()->addYear();
                $candidate->month($month);
                $candidate->day(min($day, $candidate->copy()->endOfMonth()->day));
            }

            return $candidate;
        }

        return $base;
    }

    public function toggleScheduled(ScheduledReport $scheduledReport)
    {
        $manager = $this->currentManager();

        abort_unless($scheduledReport->created_by === $manager->id || $manager->role === 'Admin', 403);

        $scheduledReport->update([
            'is_active' => !$scheduledReport->is_active,
        ]);

        return back()->with('success', 'Scheduled report status updated successfully.');
    }

    public function deleteScheduled(ScheduledReport $scheduledReport)
    {
        $manager = $this->currentManager();

        abort_unless($scheduledReport->created_by === $manager->id || $manager->role === 'Admin', 403);

        $scheduledReport->delete();

        return back()->with('success', 'Scheduled report deleted successfully.');
    }
    public function runNow(ScheduledReport $scheduledReport, ReportBuilderService $reportBuilder)
{
    $manager = $this->currentManager();

    abort_unless(
        $scheduledReport->created_by === $manager->id || $manager->role === 'Admin',
        403
    );

    $template = $scheduledReport->template;

    if (! $template) {
        return back()->with('error', 'Template not found.');
    }

    $filters = array_merge(
        [
            'entity' => $template->entity,
            'period' => $template->period,
            'columns' => $template->columns_json ?? [],
        ],
        $template->filters_json ?? []
    );

    $report = $reportBuilder->build($filters);

    $fileName = 'manual_report_' . $scheduledReport->id . '_' . now()->format('Ymd_His') . '.pdf';
    $relativePath = 'reports/' . $fileName;
    $fullPath = storage_path('app/' . $relativePath);

    Pdf::view('admin.reports.pdf', [
            'report' => $report,
            'filters' => $filters,
        ])
        ->format('a4')
        ->landscape()
        ->save($fullPath);

    if (! empty($scheduledReport->email)) {
        \Mail::to($scheduledReport->email)->send(
            new \App\Mail\ScheduledReportReadyMail(
                $template->name,
                $scheduledReport->frequency,
                now()->format('Y-m-d h:i A'),
                $fullPath
            )
        );
    }

    \App\Models\ReportExport::create([
        'scheduled_report_id' => $scheduledReport->id,
        'report_template_id' => $template->id,
        'user_id' => $scheduledReport->created_by,
        'format' => 'pdf',
        'file_path' => $relativePath,
        'status' => 'completed',
        'generated_at' => now(),
    ]);

    return back()->with('success', 'Report sent successfully.');
}
public function history()
{
    $manager = $this->currentManager();

    $exports = ReportExport::with(['template', 'scheduledReport', 'user'])
        ->where('user_id', $manager->id)
        ->latest('generated_at')
        ->paginate(12);

    return view('admin.reports.history', compact('exports'));
}

public function downloadExport(ReportExport $reportExport)
{
    $manager = $this->currentManager();

    abort_unless(
        $reportExport->user_id === $manager->id || $manager->role === 'Admin',
        403
    );

    if (! $reportExport->file_path) {
        return back()->with('error', 'This export has no file attached.');
    }

    $fullPath = storage_path('app/' . $reportExport->file_path);

    if (! File::exists($fullPath)) {
        return back()->with('error', 'The export file could not be found.');
    }

    return response()->download($fullPath);
}

public function deleteExport(ReportExport $reportExport)
{
    $manager = $this->currentManager();

    abort_unless(
        $reportExport->user_id === $manager->id || $manager->role === 'Admin',
        403
    );

    if ($reportExport->file_path) {
        $fullPath = storage_path('app/' . $reportExport->file_path);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }

    $reportExport->delete();

    return back()->with('success', 'Export history item deleted successfully.');
}
}