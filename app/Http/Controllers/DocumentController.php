<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Documents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function store(Request $request)
    {
        Gate::authorize('manage-documents'); 

        $validated = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'document_name' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $path = $request->file('file')->store('documents', 'public');

        $document = Documents::create([
            'client_id' => $validated['client_id'],
            'document_name' => $validated['document_name'],
            'file_path' => $path,
            'verified' => false,
        ]);

        ActivityLog::record(
            'Document Uploaded',
            "Uploaded document '{$document->document_name}' for client ID {$document->client_id}"
        );


        return back()->with('success', 'Document uploaded successfully.')
                    ->with('reopen_processing_id', $request->input('reopen_id'))
                    ->with('reopen_client_id', $validated['client_id']);
    }

    public function verify(Documents $document)
    {
        Gate::authorize('manage-documents');

        $document->update(['verified' => true]);

        ActivityLog::record(
            'Document Verified',
            "Verified document '{$document->document_name}' for client ID {$document->client_id}"
        );

        return back()->with('success', 'Document marked as verified.')
                    ->with('reopen_processing_id', request()->input('reopen_id'))
                    ->with('reopen_client_id', $document->client_id);
    }
}