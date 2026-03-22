<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectInvestment;
use Illuminate\Http\Request;
use App\Notifications\FundingRequestApprovedNotification;
use App\Notifications\FundingRequestRejectedNotification;

class InvestmentRequestController extends Controller
{
    public function index(Request $request)
    {
        $allowedStatuses = ['interested', 'requested', 'approved', 'rejected'];

        $query = ProjectInvestment::query()
            ->with([
                'investor.investor',
                'project',
            ]);

        if ($request->filled('status') && in_array($request->status, $allowedStatuses)) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->whereHas('investor', function ($investorQ) use ($search) {
                    $investorQ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%");
                })->orWhereHas('project', function ($projectQ) use ($search) {
                    $projectQ->where('name', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%");
                })->orWhere('message', 'like', "%{$search}%");
            });
        }

        $sortBy = $request->get('sort_by', 'latest');
        if ($sortBy === 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $perPage = (int) $request->get('per_page', 10);
        if (! in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $investmentRequests = $query->paginate($perPage)->withQueryString();

        $stats = [
            'total'      => ProjectInvestment::count(),
            'interested' => ProjectInvestment::where('status', 'interested')->count(),
            'requested'  => ProjectInvestment::where('status', 'requested')->count(),
            'approved'   => ProjectInvestment::where('status', 'approved')->count(),
            'rejected'   => ProjectInvestment::where('status', 'rejected')->count(),
            'amount'     => ProjectInvestment::where('status', 'approved')->sum('amount'),
        ];

        return view('admin.investment-requests.index', compact('investmentRequests', 'stats'));
    }

    public function updateStatus(Request $request, ProjectInvestment $investmentRequest)
    {
        $data = $request->validate([
            'status' => 'required|in:interested,requested,approved,rejected',
        ]);

        $oldStatus = $investmentRequest->status;
        $newStatus = $data['status'];

        if ($oldStatus === $newStatus) {
            return back()->with('success', 'Request status is already up to date.');
        }

        $investmentRequest->update([
            'status' => $newStatus,
        ]);

        $investmentRequest->load(['investor', 'project']);

        if ($newStatus === 'approved' && $investmentRequest->investor && $investmentRequest->project) {
            $investmentRequest->investor->notify(
                new FundingRequestApprovedNotification($investmentRequest->project)
            );
        }

        if ($newStatus === 'rejected' && $investmentRequest->investor && $investmentRequest->project) {
            $investmentRequest->investor->notify(
                new FundingRequestRejectedNotification($investmentRequest->project)
            );
        }

        return back()->with('success', 'Investment request status updated successfully.');
    }
}