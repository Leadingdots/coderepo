@extends('customemail::layouts.app')
@push('meta')
    <title>Templates | {{ config('app.name') }}</title>
    <meta content="Templates" name="description" />
    <meta content="{{ config('app.name') }}" name="author" />
@endpush
@section('content')
    <a type="button" href="{{route('ldots.template.create')}}" class="btn btn-primary mb-2 float-right">Add New</a>
    <table class="table table-bordered table-hover" id="record-list" data-url="{{route('ldots.template.list')}}">
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Name</th>
                <th>Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right"></td>
            </tr>
        </tfoot>
    </table>

@stop

@push('appendJs')
    <script>
        var searchUrl = "{{route('ldots.template.list')}}"
        var listUrl = "{{route('ldots.template.index')}}"
        var deleteUrl = "{{route('ldots.template.delete')}}"
        var changeUrl = "{{route('ldots.template.status')}}"
        var total_pages = 1;
        var page = 1;
        var tblObj = $("#record-list");
    </script>
    <script src="{{asset('public/leadingdots/customemail/js/list-records.js') }}" type="text/javascript" charset="utf-8"></script>
@endpush