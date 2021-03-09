<div class="list-group">
    <div class="ml-3 row align-items-center">
        <h3 class="d-inline">Sisa waktu : </h3>
        <h1 class="d-inline timer"> 00:00:00</h1>
    </div>
    @foreach ($questions as $question)
        <a href="#" class="list-group-item link" data-number="{{ $loop->iteration }}" data-id="{{ $question->id }}">
            <span class="media align-items-center">
                <span class="media-left mr-2">
                    <span class="btn btn-light btn-sm">#{{ $loop->iteration }}</span>
                </span>
                <span class="media-body"> {{ $question->questionname }} </span>
            </span>
        </a>
    @endforeach

</div>