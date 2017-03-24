@extends('layouts.app')

@section('content')
            @if ($data)
            @if ($edit == TRUE)
            {!! Form::open(['url' => 'bookings/' . $booking->id . '/add']) !!}
            @endif

              <ul class="nav nav-tabs">
                @foreach($data as $category)
                    @if ($category->sub == 0)
                    <li {{ ($loop->first) ? 'class=active' : '' }} ><a href="#{{$category->name}}">{{ $category->name }}</a></li>
                    @endif
                @endforeach
            </ul>

            <div class="tab-content">
                @foreach($data as $category)

                @if ($category->sub == 0)
                {!! ($loop->first) ? '' : '</table></div>' !!}
                <div id="{{ $category->name }}" class="tab-pane fade {{ ($loop->first) ? 'in active' : '' }} ">
                <table class="table">
                <thead>
                    <tr>
                        <th style="border:0px;"></th>
                        <th style="border:0px;"></th>
                        <th style="border:0px;"></th>
                        <th style="border:0px;"></th>
                        <th style="border:0px;"></th>
                        @if ($edit == TRUE)
                        <th style="border:0px;"></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                @endif

                @if (!empty($category->all))
                    <td colspan="4" style="border: 0px;"><h2>{{ $category->name }}</h2></td>
                    </tbody>
                    <thead>
                    <tr>
                        <th></th>
                        <th>Item</th>
                        <th>2 Day Rate</th>
                        <th>Week Rate</th>
                        <th>Available</th>
                        @if ($edit == TRUE)
                        <th></th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($category->all as $item)
                    <tr>
                        <td>
                        @if (!empty($item->image))
                        {{ Html::image('images/catalog/thumb_' . $item->image) }}
                        @endif
                        </td>
                        <td><a href='{!! action('ItemController@show', ['items' => $item->id]) !!}'>{{ $item->description }}</a></td>
                        <td>£{{ number_format($item->dayPrice,2) }}</td>
                        <td>£{{ number_format($item->weekPrice,2) }}</td>
                        @if ($edit == TRUE)
                        <td>{{ $item->available }}/{{ $item->quantity }}</td>
                        @else
                        <td>{{ $item->quantity }}</td>
                        @endif
                        @if ($edit == TRUE)
                        <td>
                          <div class="numInput" id="spinner_{{ $item->id }}" max="{{ $item->available}}">
                            <button type="button" {{ $item->booked === 0 ? "disabled='true'" : "" }} onclick="sub({{ $item->id }})" class="btnLess btn btn-default">-</button>
                            <input class="form-control" {{ $item->available === 0 ? "disabled='true'" : "" }} name="{{ $item->id }}" type="text"  pattern="[0-9]+" title="Value must be an integer" value="{{ $item->booked }}"/>
                            <button type="button" {{ $item->booked === $item->available ? "disabled='true'" : "" }} onclick="plus({{ $item->id }})" class="btnMore btn btn-default">+</button>
                          </div>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    </tbody>
                @endif

                {!! ($loop->last) ? '</table></div>' : '' !!}
                @endforeach
            </div>

            @if ($edit == TRUE)
            {!! Form::submit('Save',
            array('class'=>'btn btn-primary'
            )) !!}
            {!! Form::close() !!}
            @endif
            @endif

@endsection

@section('scripts')
  <script>
    window.onload = function() {
      if(window.location.hash) {
        var hash = window.location.hash;
        $('.nav-tabs a[href="' + hash + '"]').tab('show');
      }
    };

    $('.nav-tabs a').click(function (e) {
    e.preventDefault();
    location.replace(e.target.hash);
    $(this).tab('show');
});

function plus(ref)
{
  var main = document.getElementById("spinner_" + ref);
	var max = parseInt(main.getAttribute("max"));
  var val = main.getElementsByTagName('input')[0];
  var cur = parseInt(val.value);
  var newVal = cur + 1;
  if (cur < max){
    val.value = newVal;
  }
  if (newVal == max){
    main.getElementsByClassName('btnMore')[0].disabled = true;
  }
  main.getElementsByClassName('btnLess')[0].disabled = false;
}

function sub(ref)
{
  var main = document.getElementById("spinner_" + ref);
	var max = parseInt(main.getAttribute("max"));
  var val = main.getElementsByTagName('input')[0];
  var cur = parseInt(val.value);
  var newVal = cur - 1;
  if (cur > 0){
    val.value = newVal;
  }
  if (newVal == 0){
    main.getElementsByClassName('btnLess')[0].disabled = true;
  }
  main.getElementsByClassName('btnMore')[0].disabled = false;
}

  </script>
@endsection
