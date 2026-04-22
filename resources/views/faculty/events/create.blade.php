@extends('layouts.app')
@section('title','Create Event')
@section('page-title','Create Event')
@section('page-subtitle','Add a new college event for certificate issuance')

@section('content')
<div class="max-w-2xl">
<form method="POST" action="{{ route('events.store') }}">
@csrf
<div class="space-y-5">
    <div class="card p-6">
        <div class="grid md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Event Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. National Tech Symposium 2024"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Event Type <span class="text-red-500">*</span></label>
                <select name="event_type" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select type…</option>
                    @foreach(['Workshop','Seminar','Competition','Hackathon','Symposium','Cultural','Sports','Webinar','Conference','Training','Other'] as $type)
                    <option {{ old('event_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Department</label>
                <input type="text" name="department" value="{{ old('department', auth()->user()->department) }}" placeholder="e.g. Computer Science"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Start Date <span class="text-red-500">*</span></label>
                <input type="date" name="event_date" value="{{ old('event_date') }}" required
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">End Date</label>
                <input type="date" name="event_end_date" value="{{ old('event_end_date') }}"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Venue</label>
                <input type="text" name="venue" value="{{ old('venue') }}" placeholder="e.g. Main Auditorium, Block A"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                <textarea name="description" rows="3" placeholder="Brief description of the event…"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('description') }}</textarea>
            </div>
        </div>
    </div>
    <div class="flex gap-3">
        <button type="submit" class="btn-primary">Create Event</button>
        <a href="{{ route('events.index') }}" class="px-5 py-2 border border-gray-200 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Cancel</a>
    </div>
</div>
</form>
</div>
@endsection
