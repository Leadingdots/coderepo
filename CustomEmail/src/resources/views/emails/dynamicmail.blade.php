@php
foreach($tokens as $key => $token){
    $template = str_replace('#'.$key.'#',$token,$template);
}
@endphp
{!!$template!!}