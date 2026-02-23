<?php

namespace App\Http\Controllers\CS\Profile;

use App\Http\Controllers\Controller;
use App\Models\EmployeeDocument;
use Illuminate\Http\Request;

class DocumentUploadController extends Controller
{
    /**
     * Display uploaded documents
     */
    public function index()
    {
        $csProfile = auth()->user()->csProfile;
        $documents = $csProfile->documents()->latest()->get();

        // Required document types
        $requiredDocuments = ['ktp', 'kk', 'ijazah', 'rekening'];
        $missingDocuments = $csProfile->getMissingDocuments();

        return view('cs.profile.documents', compact('documents', 'requiredDocuments', 'missingDocuments'));
    }

    /**
     * Show upload form
     */
    public function create()
    {
        $csProfile = auth()->user()->csProfile;
        $missingDocuments = $csProfile->getMissingDocuments();

        return view('cs.profile.document-upload', compact('missingDocuments'));
    }

    /**
     * Store uploaded document
     */
    public function store(Request $request)
    {
        $csProfile = auth()->user()->csProfile;

        $validated = $request->validate([
            'document_type' => 'required|in:ktp,kk,ijazah,rekening',
            'document_number' => 'nullable|string|max:50',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // Max 5MB
        ]);

        // Check if document already exists
        $existing = EmployeeDocument::where('cs_profile_id', $csProfile->id)
            ->where('document_type', $validated['document_type'])
            ->first();

        if ($existing) {
            return back()->withErrors([
                'document_type' => 'Dokumen ' . $this->getDocumentLabel($validated['document_type']) . ' sudah pernah diupload. Silakan hapus yang lama terlebih dahulu.'
            ]);
        }

        // Store file
        $file = $request->file('file');
        $fileName = time() . '_' . $validated['document_type'] . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('employee-documents/' . $validated['document_type'], $fileName, 'public');

        // Create document record
        EmployeeDocument::create([
            'cs_profile_id' => $csProfile->id,
            'document_type' => $validated['document_type'],
            'document_number' => $validated['document_number'],
            'file_path' => $filePath,
            'original_filename' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'uploaded_at' => now(),
        ]);

        return redirect()->route('cs.profile.documents')
            ->with('success', 'Dokumen ' . $this->getDocumentLabel($validated['document_type']) . ' berhasil diupload.');
    }

    /**
     * Display the specified document
     */
    public function show($id)
    {
        $csProfile = auth()->user()->csProfile;

        $document = EmployeeDocument::where('cs_profile_id', $csProfile->id)
            ->findOrFail($id);

        return view('cs.profile.document-view', compact('document'));
    }

    /**
     * Delete document
     */
    public function destroy($id)
    {
        $csProfile = auth()->user()->csProfile;

        $document = EmployeeDocument::where('cs_profile_id', $csProfile->id)
            ->findOrFail($id);

        // Check if verified
        if ($document->is_verified) {
            return back()->withErrors([
                'document' => 'Dokumen yang sudah diverifikasi tidak bisa dihapus. Hubungi Admin jika perlu mengubah.'
            ]);
        }

        $document->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }

    /**
     * Download document
     */
    public function download($id)
    {
        $csProfile = auth()->user()->csProfile;

        $document = EmployeeDocument::where('cs_profile_id', $csProfile->id)
            ->findOrFail($id);

        $filePath = storage_path('app/public/' . $document->file_path);

        if (!file_exists($filePath)) {
            return back()->withErrors(['file' => 'File tidak ditemukan.']);
        }

        return response()->download($filePath, $document->original_filename);
    }

    /**
     * Helper: Get document label
     */
    private function getDocumentLabel($type)
    {
        return match($type) {
            'ktp' => 'KTP',
            'kk' => 'Kartu Keluarga',
            'ijazah' => 'Ijazah',
            'rekening' => 'Buku Rekening',
            default => $type,
        };
    }
}
