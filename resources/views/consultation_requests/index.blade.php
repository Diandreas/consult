@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <header class="mb-4 text-center">
            <h1 class="display-4 text-primary">{{ __('Consultation Requests') }}</h1>
            <p class="lead text-muted">{{ __('Manage and view all consultation requests') }}</p>
        </header>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <form action="{{ route('consultation_requests.index') }}" method="GET" class="d-flex w-100 w-md-auto mb-3 mb-md-0">
                        <div class="input-group">
                            <input type="text" name="search" placeholder="{{ __('Search') }}" value="{{ request('search') }}" class="form-control" aria-label="{{ __('Search') }}">
                            <select name="search_type" class="form-select">
                                <option value="all" {{ request('search_type') == 'all' ? 'selected' : '' }}>{{ __('All') }}</option>
                                <option value="priority" {{ request('search_type') == 'priority' ? 'selected' : '' }}>{{ __('Priority') }}</option>
                                <option value="status" {{ request('search_type') == 'status' ? 'selected' : '' }}>{{ __('Status') }}</option>
                                <option value="name" {{ request('search_type') == 'name' ? 'selected' : '' }}>{{ __('Name') }}</option>
                                <option value="description" {{ request('search_type') == 'description' ? 'selected' : '' }}>{{ __('Description') }}</option>
                            </select>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                    <a href="{{ route('consultation_requests.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-lg"></i> {{ __('Add New Request') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($consultationRequests as $request)
                <div class="col">
                    <div class="card h-100 border-start-4 {{ $request->status == 'pending' ? 'border-warning' : ($request->status == 'comit' ? 'border-primary' : ($request->status == 'finished' ? 'border-success' : ($request->status == 'rejected' ? 'border-danger' : 'border-secondary'))) }}">
                        <div class="card-header text-white {{ $request->status == 'pending' ? 'bg-warning' : ($request->status == 'comit' ? 'bg-primary' : ($request->status == 'finished' ? 'bg-success' : ($request->status == 'rejected' ? 'bg-danger' : 'bg-secondary'))) }}">
                            <i class="bi {{ $request->status == 'pending' ? 'bi-hourglass-split' : ($request->status == 'comit' ? 'bi-check-circle' : ($request->status == 'finished' ? 'bi-check-circle-fill' : ($request->status == 'rejected' ? 'bi-x-circle' : 'bi-question-circle'))) }} me-2"></i>
                            <strong>{{ __(ucfirst($request->status)) }}</strong>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <p class="text-muted mb-2"><i class="bi bi-flag-fill text-primary"></i> {{ $request->priority->name }}</p>
                            <p class="card-text text-truncate">{!! $request->description !!}</p>
                        </div>
                        <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                            <a href="{{ route('consultation_requests.show', $request->id) }}" class="text-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if($request->created_at->diffInMinutes(now()) <= 30)
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('consultation_requests.edit', $request->id) }}" class="text-primary me-3">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('consultation_requests.destroy', $request->id) }}" method="POST" class="mb-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger p-0">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseover', function() {
                this.classList.add('shadow-lg');
            });
            card.addEventListener('mouseout', function() {
                this.classList.remove('shadow-lg');
            });
        });
    </script>
@endsection
