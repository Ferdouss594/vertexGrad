@extends('layouts.app')
@section('title',$investor->name)
@section('content')
<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
    <div class="d-flex justify-content-between">
        <h5>{{ $investor->name }}</h5>
        <div>
            <a href="{{ route('investors.edit',$investor) }}" class="btn btn-sm btn-warning">Edit</a>
            <form action="{{ route('investors.destroy',$investor) }}" method="POST" style="display:inline-block">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('Archive investor?')">Archive</button>
            </form>
        </div>
    </div>

    <ul class="nav nav-tabs mt-3" role="tablist">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#profileTab">Profile</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#notesTab">Notes</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#filesTab">Files</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#activityTab">Activity</a></li>
    </ul>

    <div class="tab-content pt-3">
        <div id="profileTab" class="tab-pane fade show active">
            <p><strong>Company:</strong> {{ $investor->company }}</p>
            <p><strong>Phone:</strong> {{ $investor->phone }}</p>
            <p><strong>Email:</strong> {{ $investor->email }}</p>
            <p><strong>Position:</strong> {{ $investor->position }}</p>
            <p><strong>Investment Type:</strong> {{ $investor->investment_type }}</p>
            <p><strong>Budget:</strong> {{ $investor->budget }}</p>
            <p><strong>Source:</strong> {{ $investor->source }}</p>
            <p><strong>Notes:</strong> {{ $investor->notes }}</p>
        </div>

      <div id="notesTab" class="tab-pane fade">
    <div id="notesList">
        @foreach($investor->notes as $note)
            <div class="border p-2 mb-2" id="note-{{ $note->id }}">
                <small>{{ $note->user?->name ?? 'System' }} • {{ $note->created_at->diffForHumans() }}</small>
                <p>{{ $note->note }}</p>
                @if(auth()->check())
                    <button class="btn btn-sm btn-outline-danger delete-note" data-id="{{ $note->id }}">Delete</button>
                @endif
            </div>
        @endforeach
    </div>

    <textarea id="noteText" class="form-control" rows="3"></textarea>
</div>


           
            <button id="addNoteBtn" data-id="{{ $investor->id }}" class="btn btn-primary mt-2">Add Note</button>
        </div>

        <div id="filesTab" class="tab-pane fade">
            <form id="uploadFileForm">
                @csrf
                <input type="file" id="fileInput">
                <button id="uploadBtn" data-id="{{ $investor->id }}" class="btn btn-sm btn-outline-primary">Upload</button>
            </form>
            <ul id="filesList" class="mt-2">
                @foreach($investor->files as $f)
                    <li id="file-{{ $f->id }}">
                        <a href="{{ asset('storage/'.$f->path) }}" target="_blank">{{ $f->filename }}</a>
                        <button class="btn btn-sm btn-outline-danger delete-file" data-id="{{ $f->id }}">Delete</button>
                    </li>
                @endforeach
            </ul>
        </div>

        <div id="activityTab" class="tab-pane fade">
            <ul>
                @foreach($investor->activities as $act)
                    <li>{{ $act->created_at->diffForHumans() }} — {{ $act->action }} — {{ json_encode($act->meta) }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('addNoteBtn').addEventListener('click', function(){
    var id = this.dataset.id;
    var text = document.getElementById('noteText').value.trim();
    if(!text) return alert('Enter note');
    fetch("{{ url('investors') }}/"+id+"/notes", {
        method:'POST',
        headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'},
        body: JSON.stringify({note:text})
    })
    .then(r=>r.json()).then(res=>{
        if(res.status=='success') location.reload();
        else alert('Error');
    });
});

document.querySelectorAll('.delete-note').forEach(btn=>{
    btn.addEventListener('click', function(){
        if(!confirm('Delete note?')) return;
        var id = this.dataset.id;
        fetch("{{ url('investors') }}/{{ $investor->id }}/notes/"+id, {
            method:'DELETE',
            headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}
        }).then(r=>r.json()).then(res=>{
            if(res.status=='success') document.getElementById('note-'+id).remove();
        });
    });
});

document.getElementById('uploadBtn').addEventListener('click', function(e){
    e.preventDefault();
    var id = this.dataset.id;
    var input = document.getElementById('fileInput');
    if(!input.files.length) return alert('Choose file');
    var fd = new FormData();
    fd.append('_token','{{ csrf_token() }}');
    fd.append('file', input.files[0]);
    fetch("{{ url('investors') }}/"+id+"/files", { method:'POST', body: fd })
    .then(r=>r.json()).then(res=>{
        if(res.status=='success') location.reload();
        else alert('Upload failed');
    });
});

document.querySelectorAll('.delete-file').forEach(btn=>{
    btn.addEventListener('click', function(){
        if(!confirm('Delete file?')) return;
        var id = this.dataset.id;
        fetch("{{ url('investors') }}/{{ $investor->id }}/files/"+id, {
            method:'DELETE',
            headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}
        }).then(r=>r.json()).then(res=>{
            if(res.status=='success') document.getElementById('file-'+id).remove();
        });
    });
});
</script>
@endpush
