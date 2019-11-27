@extends('layouts.template')

@section('title', 'Shop Alternative Version')

@section('main')
    <h1>Shop - Alternative listing</h1>
    <ul>
        @foreach($genres as $genre)
            <li> <h2>{{$genre->name}}</h2> </li>

            <ul>
                @foreach($genre->orderedRecords as $record)
                    <li><a class="link1" data-id="{{ $record->id }}" href="#!">{{$record->artist}} - {{ $record->title }}</a> | price: € {{ number_format($record->price,2) }} | stock: {{ $record->stock }}</li>
                @endforeach
            </ul>
        @endforeach
    </ul>
@endsection

@section('script_after')
    <script>
        $(function () {
            // Get record id and redirect to the detail page
            $('.link1').click(function () {
                record_id = $(this).data('id');
                $(location).attr('href', `/shop/${record_id}`); //OR $(location).attr('href', '/shop/' + record_id);
            })
        });
    </script>
@endsection
