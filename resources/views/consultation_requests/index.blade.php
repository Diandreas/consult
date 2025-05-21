@extends('layouts.app')
<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    .status-badge {
        display: inline-block;
        padding: 0.25em 0.6em;
        font-size: 75%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
    }
    .status-pending { background-color: #ffc107; color: #212529; }
    .status-comit { background-color: #007bff; color: white; }
    .status-finished { background-color: #28a745; color: white; }
    .status-rejected { background-color: #dc3545; color: white; }
    .priority-low { background-color: #17a2b8; color: white; }
    .priority-medium { background-color: #ffc107; color: #212529; }
    .priority-high { background-color: #007bff; color: white; }
    .document-linked { color: #28a745; }
</style>

@section('content')
    <div class="container py-5">
        <header class="text-center mb-5">
            <h1 class="display-4 fw-bold text-primary">{{ __('Consultation Requests') }}</h1>
            <p class="lead text-muted">{{ __('Manage and view all consultation requests efficiently') }}</p>
        </header>

        <div class="row g-4 mb-4">
            <div class="col-md-8">
                <form action="{{ route('consultation_requests.index') }}" method="GET" class="d-flex">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="{{ __('Search requests...') }}" value="{{ request('search') }}">
                        <select name="search_type" class="form-select" style="max-width: 200px;">
                            <option value="all" {{ request('search_type') == 'all' ? 'selected' : '' }}>{{ __('All') }}</option>
                            <option value="priority" {{ request('search_type') == 'priority' ? 'selected' : '' }}>{{ __('Priority') }}</option>
                            <option value="status" {{ request('search_type') == 'status' ? 'selected' : '' }}>{{ __('Status') }}</option>
                            <option value="name" {{ request('search_type') == 'name' ? 'selected' : '' }}>{{ __('Name') }}</option>
                            <option value="description" {{ request('search_type') == 'description' ? 'selected' : '' }}>{{ __('Description') }}</option>
                        </select>
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i> {{ __('Search') }}
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('consultation_requests.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-lg"></i> {{ __('New Request') }}
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Date de début') }}</th>
                                <th>{{ __('Date de fin') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Priority') }}</th>
                                <th>{{ __('Document') }}</th>
                                <th class="text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($consultationRequests as $request)
                                <tr>
                                    <td>{{ $request->id }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $request->status }}">
                                            {{ __(ucfirst($request->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $request->date_start }}</td>
                                    <td>{{ $request->date_end }}</td>
                                    <td>
                                        <div style="max-height: 50px; overflow: hidden; text-overflow: ellipsis;">
                                            {!! Str::limit(strip_tags($request->description), 100) !!}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge priority-{{ $request->priority->name }}">
                                            {{ $request->priority->name }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($request->document_id)
                                            <i class="bi bi-file-earmark-text document-linked"></i>
                                            <span class="small">{{ Str::limit($request->document->title ?? 'Document', 20) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('consultation_requests.show', $request->id) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @if($request->created_at->diffInMinutes(now()) <= 30)
                                                <a href="{{ route('consultation_requests.edit', $request->id) }}" class="btn btn-outline-secondary btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('consultation_requests.destroy', $request->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('{{ __('Are you sure you want to delete this request?') }}')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">{{ __('No consultation requests found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $consultationRequests->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection


