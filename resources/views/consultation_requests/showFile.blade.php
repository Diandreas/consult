@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="card-title mb-4">{{ $userFile->file_name }}</h1>
{{--                <div class="mb-3">--}}
{{--                    <a href="{{ route('user_files.download', $userFile->id) }}" class="btn btn-primary me-2">--}}
{{--                        <i class="bi bi-download"></i> Download File--}}
{{--                    </a>--}}

{{--                    <form action="{{ route('user_files.destroy', $userFile->id) }}" method="POST" class="d-inline">--}}
{{--                        @csrf--}}
{{--                        @method('DELETE')--}}
{{--                        <button type="submit" class="btn btn-danger">--}}
{{--                            <i class="bi bi-trash"></i> Delete--}}
{{--                        </button>--}}
{{--                    </form>--}}
{{--                </div>--}}

            </div>
        </div>
        <div id="pdf-container" class="border rounded" style="height: 600px; overflow: auto; display: none;">

            <iframe id="pdf-iframe" src="{{ route('user_files.preview', $userFile->id) }}" style="width: 100%; height: 100%; border: none;"></iframe>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filePath = '{{ $userFile->file_path }}';
            const fileExtension = filePath.split('.').pop().toLowerCase();

            if (fileExtension !== 'pdf') {
                document.getElementById('preview-unavailable').style.display = 'block';
                return;
            }

            const container = document.getElementById('pdf-container');
            const pdfControls = document.getElementById('pdf-controls');

            container.style.display = 'block';
            pdfControls.style.display = 'flex';
        });
    </script>
@endsection
