@extends('layouts.app')

@section('content')
    <div class="container-fluid page__heading-container">
        <div
            class="page__heading d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
            <div>
                <h1 class="m-lg-0">Final Quiz</h1>
                <div class="d-inline-flex align-items-center">
                    <i class="material-icons icon-16pt mr-1 text-muted">school</i> <a href="#" class="text-muted">Getting
                        Started with InVision</a>
                </div>
            </div>

            <a href="" class="btn btn-success ml-lg-3 mt-3 mt-lg-0">Back to Course <i
                    class="material-icons">arrow_forward</i></a>
        </div>
    </div>

    <div class="container-fluid page__container">

        <div class="alert alert-soft-blue d-flex align-items-center card-margin p-2" role="alert">
            <i class="material-icons mr-3">info</i>
            <div class="text-body">Your currently answered to <strong class="text-primary">5 correct</strong> questions.
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card" id="layout"></div>
            </div>
            <div class="col-md-4 ">
                @include('pages.quiz.sidebar')
            </div>
        </div>


    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready( async function() {
            let url = BASE_URL+'/get-data';
            let response = await get(url);
            if (response.status) {
                $('#layout').append(showLayouts(response))
            }
        })

        $(document).on('click', '.link', async function (e) {
            e.preventDefault()
            let id = $(this).data('id');
            let number = $(this).data('number');
            let url = BASE_URL+'/get-data-sidebar/'+id+'/'+number;
            let response = await get(url);
            if (response.status) {
                $('#layout').empty()
                $('#layout').append(showLayouts(response))
            }
        })

        $(document).on('click', '.skip', async function (e) {
            e.preventDefault()
            let id = $('#id_question').val();
            let number = $('#number').val();
            let url = BASE_URL+'/get-data/'+id+'/'+number;
            let response = await get(url);
            if (response.status) {
                $('#layout').empty()
                $('#layout').append(showLayouts(response))
            }
        })

        $(document).on('submit', '#form', async function( e ){
            e.preventDefault();
            let form_data = new FormData( this );
            let url = BASE_URL+'/submit';
            let response = await insert(url, form_data);
            if (response.status) {
                $('#layout').empty()
                $('#layout').append(showLayouts(response))
            }else{
                alertError(response.message)
            }
        })

        function showLayouts(data){
            let cols = ''
                     cols += ' <form action="#" method="POST" id="form">'
                     cols += '    @csrf'
                     cols += '    <input type="hidden" id="id_question" name="id_question" value="'+data.question.id+'">'
                     cols += '    <input type="hidden" id="number" name="number" value="'+data.number+'">'
                     cols += '    <div class="card-header">'
                     cols += '        <div class="media align-items-end">'
                     cols += '            <div class="media-left">'
                     cols += '                <h4 class="m-0 text-primary mr-2"><strong>#'+data.number+'</strong></h4>'
                     cols += '            </div>'
                     cols += '            <div class="media-body">'
                        if (data.question.questionimage) {
                            cols += '           <img class="rounded" src="'+BASE_URL+'/img/'+data.question.questionimage+'" style="height: 300px; width: 100%; object-fit: cover; object-position: center">'
                        }
                     cols += '                <h4 class="card-title m-0"> '+data.question.questionname+' </h4>'
                     cols += '            </div>'
                     cols += '        </div>'
                     cols += '    </div>'
                     cols += '    <div class="card-body">'
                     cols += '          <div class="form-group">'
                     cols += '              <div class="form-check">'
                     cols += '                  <input '+(data.answer ? data.answer.answer == 'opt1' ? 'checked' : '' : '') +' id="opt1" name="opt" value="opt1" type="radio" class="form-check-input">'
                     cols += '                  <label for="opt1" class="form-check-label">'+data.question.opt1+'</label>'
                     cols += '              </div>'
                     cols += '          </div>'
                     cols += '          <div class="form-group">'
                     cols += '              <div class="form-check">'
                     cols += '                  <input '+(data.answer ? data.answer.answer == 'opt2' ? 'checked' : '' : '') +' id="opt2" name="opt" value="opt2" type="radio" class="form-check-input">'
                     cols += '                  <label for="opt2" class="form-check-label">'+data.question.opt2+'</label>'
                     cols += '              </div>'
                     cols += '          </div>'
                     cols += '          <div class="form-group">'
                     cols += '              <div class="form-check">'
                     cols += '                  <input '+(data.answer ? data.answer.answer == 'opt3' ? 'checked' : '' : '') +' id="opt3" name="opt" value="opt3" type="radio" class="form-check-input">'
                     cols += '                  <label for="opt3" class="form-check-label">'+data.question.opt3+'</label>'
                     cols += '              </div>'
                     cols += '          </div>'
                     cols += '          <div class="form-group">'
                     cols += '              <div class="form-check">'
                     cols += '                  <input '+(data.answer ? data.answer.answer == 'opt4' ? 'checked' : '' : '') +' id="opt4" name="opt" value="opt4" type="radio" class="form-check-input">'
                     cols += '                  <label for="opt4" class="form-check-label">'+data.question.opt4+'</label>'
                     cols += '              </div>'
                     cols += '          </div>'
                     cols += '          <div class="form-group">'
                     cols += '              <div class="form-check">'
                     cols += '                  <input '+(data.answer ? data.answer.answer == 'opt5' ? 'checked' : '' : '') +' id="opt5" name="opt" value="opt5" type="radio" class="form-check-input">'
                     cols += '                  <label for="opt5" class="form-check-label">'+data.question.opt5+'</label>'
                     cols += '              </div>'
                     cols += '          </div>'
                     cols += '    </div>'
                     cols += '    <div class="card-footer">'
                     cols += '        <a href="#" class="skip btn btn-light">Skip</a>'
                    //  cols += '      <button type="button" class="btn btn-outline-warning float-right mark marker-'+data.number+'" data-number="'+data.number+'" data-id="'+data.question.id+'">Mark</button>'
                     cols += '        <button type="submit" class="btn btn-success mr-2 float-right">Submit <i'
                     cols += '                class="material-icons btn__icon--right">arrow_forward</i></button>'
                     cols += '    </div>'
                     cols += ' </form>'
                     //showCheckSidebar(data, data.number)
                return cols
        }

        // $(document).on('click', '.mark', async function(e) {
        //     e.preventDefault();
        //     let id = $(this).data('id')
        //     let number = $(this).data('number')
        //     let url = BASE_URL+'/mark/'+id;
        //     let response = await get(url);
            
        //     if (response.status) {
        //         $('.clear-'+number).addClass('bg-primary').removeClass('bg-white').removeClass('bg-warning').append('<i class="fas fa-star text-white" ></i>')
        //     }
        // })  

        // function showCheckSidebar(value, number) {
        //     if (value.answer) {
        //         $('.clear-'+number).addClass('bg-warning').removeClass('bg-white')
        //         $('.marker-'+number).hide()
        //     }
        // } 

        var seconds = 0, minutes = 90, t;
        function countDown() {
            if (sessionStorage.getItem("timeStoreSeconds")) {
                seconds = sessionStorage.getItem("timeStoreSeconds");
            }
            if (sessionStorage.getItem("timeStoreMinutes")) {
                minutes = sessionStorage.getItem("timeStoreMinutes");
            }
            seconds--;
            sessionStorage.setItem("timeStoreSeconds", seconds);
            if (seconds <= 0) {
                seconds = 60;
                sessionStorage.removeItem("timeStoreSeconds");
                minutes--;
                sessionStorage.setItem("timeStoreMinutes", minutes);
                if (minutes < 0) {
                    alertError('waktu habis!!!')
                    $('#form').submit();
                    sessionStorage.removeItem("timeStoreMinutes")
                    sessionStorage.removeItem("timeStoreSeconds")
                }
            }
            $('.timer').html((minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") + ":" + (seconds > 9 ? seconds : "0" + seconds));
            timer();
        }
        function timer() {
            t = setTimeout(countDown, 1000);
        }
        timer();
    </script>
@endpush