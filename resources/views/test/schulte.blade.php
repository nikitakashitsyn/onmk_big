@push('javascript')
    var current_element = 1;

    $('.schulte-cell').click(function() {

        var error_element = $('.schulte-errors');

        if($(this).data('value') != current_element)
        {
            error_element.text(parseInt(error_element.text()) + 1) ;
        }else{
            $(this).find('div').css('background-color','#C9F2B8');
            current_element++;
        }

        console.log($(this).data('value'),current_element);


    })
@endpush


@php
    $k = 0;
@endphp
<div class="row">
    <div class="col-md-6">
        <table class="table table-bordered">
            @for($i = 0 ; $i <=5;$i++)
                <tr>
                    @for($j = 0 ; $j <=5;$j++)
                        <td style="padding:0px;">
                            @php
                                $k++
                            @endphp
                            <a href="#" class="schulte-cell" data-value="{{$model->data['schulte'][$k] ?? null}}">
                                <div class="text-center" style="padding:0px;color:black;font-size: 30px;font-weight: bold">
                                    {{$model->data['schulte'][$k] ?? null}}
                                </div>
                            </a>
                        </td>
                    @endfor
                </tr>
            @endfor
        </table>
    </div>
</div>

<h1>Ошибок <span class="schulte-errors">0</span></h1>
