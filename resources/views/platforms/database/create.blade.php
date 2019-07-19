@extends('layouts.index')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <h3>{{ trans('platform.create_database') }}</h3>
                <ul class="pager">
                    <li class="previous">
                        <a href="{{ route('database.index') }}">{{ trans('platform.return') }}</a>
                    </li>
                </ul>
                <div class="box box-info">
                    <form class="form-horizontal" method="post" action="{{ route('database.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="enable" class="col-sm-4 control-label"><span class="text-red">＊</span>{{ trans('platform.name') }}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="name">
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('db_name') ? ' has-error' : '' }}">
                                <label class="col-sm-4 control-label"><span class="text-red">＊</span>{{ trans('platform.db_name') }}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="db_name">
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                <label for="fee" class="col-sm-4 control-label margin-top-20"><span class="text-red">＊</span>{{ trans('platform.status') }}</label>
                                <div class="col-sm-8">
                                    <label for="">{{ trans('platform.status_types.enable') }}</label>
                                    <input type="radio" name="status" value="enable" checked>

                                    <label for="">{{ trans('platform.status_types.disable') }}</label>
                                    <input type="radio" name="status" value="disable">
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('note') ? ' has-error' : '' }}">
                                <label for="fee" class="col-sm-4 control-label margin-top-20">{{ trans('platform.note') }}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="note">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">
                                <span class="fa fa-check"></span>{{ trans('platform.create') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection