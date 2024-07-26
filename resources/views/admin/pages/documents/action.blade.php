<div class="d-flex">
    <a href="{{ route('documents.preview', basename($row->file_path)) }}" class="btn btn-info btn-sm me-2" target="_blank">
        <i class="bi bi-eye"></i>
    </a>
    <a href="{{ route('documents.download', basename($row->file_path)) }}" class="btn btn-success btn-sm me-2">
        <i class="bi bi-download"></i>
    </a>
    @if (auth()->user()->id === $row->uploaded_by)
        <a href="{{ $editUrl }}" class="btn btn-warning btn-sm me-2">
            <i class="bi bi-pencil"></i>
        </a>
        <form action="{{ $deleteUrl }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    @endif
</div>
