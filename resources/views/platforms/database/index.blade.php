@extends('layouts.index')
@section('content')
<div class="box">
    <div class="box-header">
        <h3 class="box-title">
            {{ trans('platform.platform_database_list') }}
                <a class="btn btn-default btn-sm" href="{{ route('database.create') }}">{{ trans('platform.create_platform_database') }}</a>
        </h3>
    </div>
    <div class="box-body">
        <table id="gift_list" class="table table-bordered">
            <thead>
            <tr>
                <th style="width: 80px">#</th>
                <th style="width: 80px">{{ trans('platform.status') }}</th>
                <th style="width: 100px">{{ trans('platform.platform_database_name') }}</th>
                <th>{{ trans('platform.db_name') }}</th>
                <th>{{ trans('platform.operate') }}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection