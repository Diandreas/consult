@extends('layouts.app')
<style>
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease;
    }
    .priority-badge {
        position: absolute;
        top: 10px;
        right: 10px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.card-hover');
        cards.forEach(card => {
            card.addEventListener('mouseover', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 0.5rem 1rem rgba(0, 0, 0, 0.15)';
            });
            card.addEventListener('mouseout', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '';
            });
        });
    });
</script>
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

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($consultationRequests as $request)
                <div class="col">
                    <div class="card h-100 shadow-sm card-hover">
                        <div class="card-header bg-{{ $request->status == 'pending' ? 'warning' : ($request->status == 'comit' ? 'primary' : ($request->status == 'finished' ? 'success' : ($request->status == 'rejected' ? 'danger' : 'secondary'))) }} text-white">
                            <i class="bi bi-circle-fill me-2"></i>{{ __(ucfirst($request->status)) }}
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $request->name }}</h5>
                            <p class="card-text">{!! $request->description !!}</p>
                            <span class=" text-white badge bg-{{ $request->priority->name == 'low' ? 'info' : ($request->priority->name == 'medium' ? 'warning' : 'primary') }} priority-badge">
                            {{ $request->priority->name }}
                        </span>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 text-end">
                            <a href="{{ route('consultation_requests.show', $request->id) }}" class="btn btn-outline-primary btn-sm me-2">
                                <i class="bi bi-eye"></i> {{ __('View') }}
                            </a>
                            @if($request->created_at->diffInMinutes(now()) <= 30)
                                <a href="{{ route('consultation_requests.edit', $request->id) }}" class="btn btn-outline-secondary btn-sm me-2">
                                    <i class="bi bi-pencil"></i> {{ __('Edit') }}
                                </a>
                                <form action="{{ route('consultation_requests.destroy', $request->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('{{ __('Are you sure you want to delete this request?') }}')">
                                        <i class="bi bi-trash"></i> {{ __('Delete') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection


