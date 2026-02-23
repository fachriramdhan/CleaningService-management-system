<?php

namespace App\Http\Controllers\CS\Profile;

use App\Http\Controllers\Controller;
use App\Models\CsProfile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display CS profile
     */
    public function index()
    {
        $csProfile = auth()->user()->csProfile->load(['user', 'area', 'documents']);

        // Calculate profile completion
        $completionPercentage = $csProfile->getProfileCompletionPercentage();
        $missingDocuments = $csProfile->getMissingDocuments();

        return view('cs.profile.index', compact('csProfile', 'completionPercentage', 'missingDocuments'));
    }

    /**
     * Show the form for editing profile
     */
    public function edit()
    {
        $csProfile = auth()->user()->csProfile->load('user');

        return view('cs.profile.edit', compact('csProfile'));
    }

    /**
     * Update profile information
     */
    public function update(Request $request)
    {
        $csProfile = auth()->user()->csProfile;

        $validated = $request->validate([
            // Personal Information
            'alamat_lengkap' => 'nullable|string|max:500',
            'no_hp' => 'nullable|string|max:20',
            'no_wa' => 'nullable|string|max:20',
            'nik' => 'nullable|string|max:20|unique:cs_profiles,nik,' . $csProfile->id,
            'no_kk' => 'nullable|string|max:20',
            'tanggal_lahir' => 'nullable|date|before:today',
            'tempat_lahir' => 'nullable|string|max:100',
            'jenis_kelamin' => 'nullable|in:L,P',
            'status_pernikahan' => 'nullable|in:belum_menikah,menikah,cerai',

            // Emergency Contact
            'emergency_contact_name' => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_relation' => 'nullable|string|max:50',

            // Bank Information
            'bank_name' => 'nullable|string|max:100',
            'bank_account_number' => 'nullable|string|max:50',
            'bank_account_name' => 'nullable|string|max:100',

            // Profile Photo (optional)
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle photo upload
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($csProfile->foto && $csProfile->foto !== 'default-avatar.png') {
                \Storage::disk('public')->delete($csProfile->foto);
            }

            $validated['foto'] = $request->file('foto')->store('cs-photos', 'public');
        }

        $csProfile->update($validated);

        return redirect()->route('cs.profile.index')
            ->with('success', 'Profile berhasil diupdate.');
    }

    /**
     * Update user account information (name, email, password)
     */
    public function updateAccount(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'required_with:new_password|current_password',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update name and email
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Update password if provided
        if ($request->filled('new_password')) {
            $user->password = bcrypt($validated['new_password']);
        }

        $user->save();

        return back()->with('success', 'Informasi akun berhasil diupdate.');
    }

    /**
     * Show profile completion guide
     */
    public function completionGuide()
    {
        $csProfile = auth()->user()->csProfile;

        $completionPercentage = $csProfile->getProfileCompletionPercentage();
        $missingDocuments = $csProfile->getMissingDocuments();

        // Check which fields are missing
        $requiredFields = [
            'alamat_lengkap' => 'Alamat Lengkap',
            'no_hp' => 'No. HP',
            'emergency_contact_name' => 'Nama Kontak Darurat',
            'emergency_contact_phone' => 'No. HP Kontak Darurat',
            'nik' => 'NIK (KTP)',
            'tanggal_lahir' => 'Tanggal Lahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'bank_name' => 'Nama Bank',
            'bank_account_number' => 'No. Rekening',
        ];

        $missingFields = [];
        foreach ($requiredFields as $field => $label) {
            if (empty($csProfile->$field)) {
                $missingFields[] = $label;
            }
        }

        return view('cs.profile.completion-guide', compact(
            'csProfile',
            'completionPercentage',
            'missingFields',
            'missingDocuments'
        ));
    }
}
