
@foreach ($main as $mains)
<li><a href="/master/main/{{$mains->id}}">{{$mains->name}}</a></li>
@endforeach
    @foreach ($masters as $master)
    <li><a href="/dynamic/{{$master->id}}">{{$master->name}}</a></li>
    @endforeach

