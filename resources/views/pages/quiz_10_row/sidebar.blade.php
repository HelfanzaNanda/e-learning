<div class="card row align-items-center">
    <h3 class="d-inline">Sisa waktu : </h3>
    <h1 class="d-inline timer"> 00:00:00</h1>
</div>
<div class="card">
    <div class="card-header row justify-content-around">
        <div><h6>Quiz Navigation</h6></div>
    </div>
    <div class="card-body">
        <div class="row px-1">
            @foreach ($questions as $question)
            <a href="#" data-number="{{ $loop->iteration }}" data-id="{{ $question->id }}" class="nav-question navigation-{{ $loop->iteration }} mr-1 mb-1" >
                <div class="bg-success text-white text-center" style="width: 30px; height: 20px;">{{ $loop->iteration }}</div>
                <div class="clear-{{ $loop->iteration }} bg-white" style="text-align: center; width: 30px; height: 20px;"></div>
            </a>
            @endforeach
        </div>
        
      
    </div>
</div>
