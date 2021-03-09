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
            <div class="text-body">Course Dashboard</div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <form action="" method="POST" id="form">
                    @csrf
                    <div class="row" id="layout"></div>
                    <div>
                        <button id="prev" class="btn btn-light">Prev Page</button>
                        <button type="submit" class="btn btn-success float-right">Next Page <i
                                    class="material-icons btn__icon--right">arrow_forward</i></button>
                    </div>
                </form>              
            </div>
            <div class="col-md-4 ">
                @include('pages.quiz_10_row.sidebar')
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        let number;
        $(document).ready( async function() {
            let url = BASE_URL+'/10/get-data';
            let response = await get(url);
            if (response.status) {
                if (response.isPrev) {
                    $('#prev').prop("disabled", true)
                }else{
                    $('#prev').prop("disabled", false)
                }
                $('#layout').append(showLayouts(response))
            }
        });
        $(document).on('change', '.radio', function() {
            let isCheck = $(this).is(':checked')
            let number = $(this).data('number')
            if (isCheck) {
                $('.clear-'+number)
                .addClass('bg-warning').removeClass('bg-white')
            }else{
                $('.clear-'+number).addClass('bg-white').removeClass('bg-warning')
            }
        })

        $(document).on('click', '.nav-question', async function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let number = $(this).data('number')
            let url = BASE_URL+'/10/get-data-sidebar/'+id+'/'+number;
            let response = await get(url);
            if (response.status) {
                $('#layout').empty()
                $('#layout').append(showLayouts(response))
            }
        })

        $(document).on('click', '#prev', async function(e) {
            e.preventDefault();
            let url = BASE_URL+'/10/get-data/'+null+'/'+number+'/'+'ada';
            let response = await get(url);
            
            if (response.status) {
                $('#layout').empty()
                if (response.isPrev) {
                    $('#prev').prop("disabled", true)
                }else{
                    $('#prev').prop("disabled", false)
                }
                $('#layout').append(showLayouts(response))
            }
        })

        $(document).on('click', '.mark', async function(e) {
            e.preventDefault();
            let id = $(this).data('id')
            let number = $(this).data('number')
            let url = BASE_URL+'/10/mark/'+id;
            let response = await get(url);
            
            if (response.status) {
                $('.clear-'+number).addClass('bg-primary').removeClass('bg-white').removeClass('bg-warning').append('<i class="fas fa-star text-white" ></i>')
            }
        })  

        $(document).on('submit', '#form', async function( e ){
            e.preventDefault();
            let form_data = new FormData( this );
            let url = BASE_URL+'/10/submit';
            let response = await insert(url, form_data);
            console.log(response);
            if (response.status) {
                $('#prev').prop("disabled", false)
                $('#layout').empty()
                $('#layout').append(showLayouts(response))
            }else{
                alertError(response.message)
            }
        })

        function showLayouts(data){
            number = data.number
            let cols = ''
            $.each(data.questions, function(index, value) {
                cols += '<div class="col-md-3">'
                cols += '    <div class="card">'
                cols += '        <div class="card-body">'
                cols += '            <h6 class="text-center">Question</h6> <br/>'
                cols += '            <h2 class="text-center">'+number+'</h2>'
                cols += '        </div>'
                cols += '    </div>'
                cols += '</div>'
                cols += '<div class="col-md-9">'
                cols += '    <div class="card">'
                cols += '        <input type="hidden" name="id_question" value="'+value.id+'">'
                cols += '        <input type="hidden" name="number" value="'+number+'">'
                cols += '        <div class="card-header">'
                cols += '            <div class="media align-items-end">'
                cols += '                <div class="media-body">'
                    if (value.questionimage) {
                            cols += '           <img class="rounded" src="'+BASE_URL+'/img/'+value.questionimage+'" style="height: 300px; width: 100%; object-fit: cover; object-position: center">'
                    }
                cols += '                    <h4 class="card-title m-0"> '+value.questionname+' </h4>'
                cols += '                </div>'
                cols += '            </div>'
                cols += '        </div>'
                cols += '    <div class="card-body">'
                cols += '          <div class="form-group">'
                cols += '              <div class="form-check">'
                cols += '                  <input '+(value.answer == 'opt1' ? 'checked' : '') +' id="opt1-'+index+'" name="opt['+index+']" value="opt1" type="radio" data-number="'+number+'" class="form-check-input radio">'
                cols += '                  <label for="opt1-'+index+'" class="form-check-label">'+value.opt1+'</label>'
                cols += '              </div>'
                cols += '          </div>'
                cols += '          <div class="form-group">'
                cols += '              <div class="form-check">'
                cols += '                  <input '+(value.answer == 'opt2' ? 'checked' : '') +' id="opt2-'+index+'" name="opt['+index+']" value="opt2" type="radio" data-number="'+number+'" class="form-check-input radio">'
                cols += '                  <label for="opt2-'+index+'" class="form-check-label">'+value.opt2+'</label>'
                cols += '              </div>'
                cols += '          </div>'
                cols += '          <div class="form-group">'
                cols += '              <div class="form-check">'
                cols += '                  <input '+(value.answer == 'opt3' ? 'checked' : '') +' id="opt3-'+index+'" name="opt['+index+']" value="opt3" type="radio" data-number="'+number+'" class="form-check-input radio">'
                cols += '                  <label for="opt3-'+index+'" class="form-check-label">'+value.opt3+'</label>'
                cols += '              </div>'
                cols += '          </div>'
                cols += '          <div class="form-group">'
                cols += '              <div class="form-check">'
                cols += '                  <input '+(value.answer == 'opt4' ? 'checked' : '') +' id="opt4-'+index+'" name="opt['+index+']" value="opt4" type="radio" data-number="'+number+'" class="form-check-input radio">'
                cols += '                  <label for="opt4-'+index+'" class="form-check-label">'+value.opt4+'</label>'
                cols += '              </div>'
                cols += '          </div>'
                cols += '          <div class="form-group">'
                cols += '              <div class="form-check">'
                cols += '                  <input '+(value.answer == 'opt5' ? 'checked' : '') +' id="opt5-'+index+'" name="opt['+index+']" value="opt5" type="radio" data-number="'+number+'" class="form-check-input radio">'
                cols += '                  <label for="opt5-'+index+'" class="form-check-label">'+value.opt5+'</label>'
                cols += '              </div>'
                cols += '          </div>'
                cols += '       </div>'
                cols += '       <div class="card-footer">'
                cols += '      <button type="button" class="btn btn-sm btn-outline-warning float-right mark marker-'+number+'" data-number="'+number+'" data-id="'+value.id+'">Mark</button>'   
                cols += '       </div>'
                cols += '    </div>'
                cols += '</div>'
                showCheckSidebar(value, number)
                number++
            })
            return cols
        }

        function showCheckSidebar(value, number) {
            if (value.answer) {
                $('.clear-'+number).addClass('bg-warning').removeClass('bg-white')
                $('.marker-'+number).hide()
            }
            if (value.remark) {
                $('.clear-'+number).addClass('bg-primary').removeClass('bg-white').removeClass('bg-warning').append('<i class="fas fa-star text-white" ></i>')
            }
        } 

        var seconds = 60, minutes = 90, t;
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


