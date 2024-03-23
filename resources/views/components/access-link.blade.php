@can($access)
<a class="{{$class??'collapse-item'}}" href="{{$href}}" @if(isset($attributes) && !empty($attributes)) @foreach($attributes as $attribute => $value) {{$attribute}}='{{$value}}' @endforeach @endif>{!! $title !!}</a>
@endcan
