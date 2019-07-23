@extends('layouts.index')
@section('content')
<div class="box">
    <div class="box-header">
        <h3 class="box-title">
            {{ trans('platform.platform_database_list') }}
                <a class="btn btn-default btn-sm" href="{{ route('database.create') }}">{{ trans('platform.create_database') }}</a>
        </h3>
    </div>
    <div class="box-body">
        <table id="gift_list" class="table table-bordered">
            <thead>
            <tr>
                <th width="20">#</th>
                <th width="50">{{ trans('platform.status') }}</th>
                <th>{{ trans('platform.name') }}</th>
                <th>{{ trans('platform.db_name') }}</th>
                <th>{{ trans('platform.redis_code') }}</th>
                <th>{{ trans('platform.operate') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($platformDatabase as $database)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <span class="btn btn-{{ $database->status == 'enable' ? 'success' : 'danger' }} btn-xs">{{ trans('platform.status_types.' . $database->status) }}</span>
                    </td>
                    <td>{{ $database->name }}</td>
                    <td>{{ $database->database }}</td>
                    <td>{{ $database->redis_code }}</td>
                    <td>
                        <a href="{{ route('database.edit', $database->id) }}" class="btn btn-primary btn-xs">{{ trans('platform.edit') }}</a>
                        <button class="btn btn-danger btn-xs show-del-dialog"
                                data-url="{{ route('database.destroy', $database->id) }}"
                                data-name="{{ $database->name }}"

                        >{{ trans('platform.delete') }}</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
    @include('includes.alert.delete')
@endsection

@section('script')
    <script src="{{ elixir('js/alert.js') }}"></script>
@endsection