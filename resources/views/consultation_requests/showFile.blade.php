@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="card-title mb-4">{{ $userFile->file_name }}</h1>
                <div class="mb-3">
                    <a href="{{ route('user_files.download', $userFile->id) }}" class="btn btn-primary me-2">
                        <i class="bi bi-download"></i> Download File
                    </a>

                    <form action="{{ route('user_files.destroy', $userFile->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </div>

                <div id="pdf-controls" class="mb-3 d-flex align-items-center" style="display: none;">
                    <button id="prev-page" class="btn btn-outline-primary me-2">
                        <i class="bi bi-chevron-left"></i> Previous
                    </button>
                    <div class="input-group" style="width: auto;">
                        <span class="input-group-text">Page</span>
                        <input type="number" id="page-number" class="form-control" min="1" style="width: 70px;">
                        <span class="input-group-text">of <span id="total-pages"></span></span>
                    </div>
                    <button id="next-page" class="btn btn-outline-primary ms-2">
                        Next <i class="bi bi-chevron-right"></i>
                    </button>
                </div>

                <div id="pdf-container" class="border rounded" style="height: 600px; overflow: auto; display: none;"></div>
                <div id="preview-unavailable" class="alert alert-warning" role="alert" style="display: none;">
                    Preview not available
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filePath = '{{ $userFile->file_path }}';
            const fileExtension = filePath.split('.').pop().toLowerCase();

            if (fileExtension !== 'pdf') {
                document.getElementById('preview-unavailable').style.display = 'block';
                return;
            }

            const url = '{{ asset('storage/' . $userFile->file_path) }}';
            const container = document.getElementById('pdf-container');
            const prevPageButton = document.getElementById('prev-page');
            const nextPageButton = document.getElementById('next-page');
            const pageNumberInput = document.getElementById('page-number');
            const totalPagesSpan = document.getElementById('total-pages');
            const pdfControls = document.getElementById('pdf-controls');

            container.style.display = 'block';
            pdfControls.style.display = 'flex';

            let pdfDoc = null;
            let pageNum = 1;
            let pageRendering = false;
            let pageNumPending = null;
            let scale = 1.5;
            let canvas = document.createElement('canvas');
            let ctx = canvas.getContext('2d');

            container.appendChild(canvas);

            pdfjsLib.getDocument(url).promise.then(function(pdf) {
                pdfDoc = pdf;
                totalPagesSpan.textContent = pdf.numPages;
                renderPage(pageNum);
            });

            function renderPage(num) {
                pageRendering = true;
                pdfDoc.getPage(num).then(function(page) {
                    const viewport = page.getViewport({ scale: scale });
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    const renderContext = {
                        canvasContext: ctx,
                        viewport: viewport
                    };
                    page.render(renderContext).promise.then(function() {
                        pageRendering = false;
                        if (pageNumPending !== null) {
                            renderPage(pageNumPending);
                            pageNumPending = null;
                        }
                    });
                });

                pageNumberInput.value = num;
            }

            function queueRenderPage(num) {
                if (pageRendering) {
                    pageNumPending = num;
                } else {
                    renderPage(num);
                }
            }

            prevPageButton.addEventListener('click', function() {
                if (pageNum <= 1) return;
                pageNum--;
                queueRenderPage(pageNum);
            });

            nextPageButton.addEventListener('click', function() {
                if (pageNum >= pdfDoc.numPages) return;
                pageNum++;
                queueRenderPage(pageNum);
            });

            pageNumberInput.addEventListener('change', function() {
                const n = parseInt(this.value);
                if (n > 0 && n <= pdfDoc.numPages) {
                    pageNum = n;
                    queueRenderPage(pageNum);
                }
            });
        });
    </script>
@endsection
