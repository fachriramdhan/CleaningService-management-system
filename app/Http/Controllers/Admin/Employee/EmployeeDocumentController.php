<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Http\Controllers\Controller;
use App\Models\EmployeeDocument;
use App\Models\CsProfile;
use Illuminate\Http\Request;

class EmployeeDocumentController extends Controller
{
    /**
     * Display list of all employee documents
     */
    public function index(Request $request)
    {
        $query = EmployeeDocument::with('csProfile.user')->latest('uploaded_at');

        // Filter by verification status
        if ($request->filled('is_verified')) {
            $query->where('is_verified', $request->is_verified);
        }

        // Filter by document type
        if ($request->filled('document_type')) {
            $query->where('document_type', $request->document_type);
        }

        // Filter by CS
        if ($request->filled('cs_profile_id')) {
            $query->where('cs_profile_id', $request->cs_profile_id);
        }

        $documents = $query->paginate(20);
        $csProfiles = CsProfile::with('user')->get();

        // Statistics
        $stats = [
            'total' => EmployeeDocument::count(),
            'verified' => EmployeeDocument::where('is_verified', true)->count(),
            'unverified' => EmployeeDocument::where('is_verified', false)->count(),
        ];

        return view('admin.employee.documents.index', compact('documents', 'csProfiles', 'stats'));
    }

    /**
     * Show documents for specific CS
     */
    public function showByCs($csProfileId)
    {
        $csProfile = CsProfile::with('user')->findOrFail($csProfileId);
        $documents = $csProfile->documents()->latest('uploaded_at')->get();
        $missingDocuments = $csProfile->getMissingDocuments();

        return view('admin.employee.documents.by-cs', compact('csProfile', 'documents', 'missingDocuments'));
    }

    /**
     * Display the specified document
     */
    public function show($id)
    {
        $document = EmployeeDocument::with(['csProfile.user', 'verifier'])->findOrFail($id);

        return view('admin.employee.documents.show', compact('document'));
    }

    /**
     * Verify document
     */
    public function verify(Request $request, $id)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $document = EmployeeDocument::findOrFail($id);

        if ($document->is_verified) {
            return back()->withErrors(['status' => 'Dokumen sudah diverifikasi sebelumnya.']);
        }

        $document->verify(auth()->id(), $validated['notes'] ?? null);

        return back()->with('success', 'Dokumen berhasil diverifikasi.');
    }

    /**
     * Unverify document (if verification was wrong)
     */
    public function unverify(Request $request, $id)
    {
        $validated = $request->validate([
            'notes' => 'required|string|max:500',
        ]);

        $document = EmployeeDocument::findOrFail($id);

        if (!$document->is_verified) {
            return back()->withErrors(['status' => 'Dokumen belum diverifikasi.']);
        }

        $document->unverify($validated['notes']);

        return back()->with('success', 'Verifikasi dokumen dibatalkan.');
    }

    /**
     * Delete document (admin can force delete)
     */
    public function destroy($id)
    {
        $document = EmployeeDocument::findOrFail($id);
        $document->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }

    /**
     * Download document
     */
    public function download($id)
    {
        $document = EmployeeDocument::findOrFail($id);

        $filePath = storage_path('app/public/' . $document->file_path);

        if (!file_exists($filePath)) {
            return back()->withErrors(['file' => 'File tidak ditemukan.']);
        }

        return response()->download($filePath, $document->original_filename);
    }

    /**
     * Show document completion report
     */
    public function completionReport()
    {
        $csProfiles = CsProfile::with(['user', 'documents'])->get();

        $report = $csProfiles->map(function($csProfile) {
            return [
                'cs' => $csProfile,
                'completion_percentage' => $csProfile->getProfileCompletionPercentage(),
                'uploaded_documents' => $csProfile->documents->pluck('document_type')->toArray(),
                'missing_documents' => $csProfile->getMissingDocuments(),
                'verified_count' => $csProfile->verifiedDocuments()->count(),
                'total_count' => $csProfile->documents()->count(),
            ];
        });

        return view('admin.employee.documents.completion-report', compact('report'));
    }
}
