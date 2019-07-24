@extends('layouts.index')
@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">
                {{ trans('platform.platform_setting') }}
            </h3>
        </div>
        <div class="box-body">
            <form id="kick" method="post" class="form-inline"  action="{{ Route('platform.kickMemberAll') }}">
                {{ csrf_field() }}
                <div class="col-sm-3">
                    <button type="button" class="btn btn-primary btn-sm" id="kick-member-all"
                            data-title="{{ trans('platform.alert.kick_member_all_title') }}">{{ trans('platform.kick_member_all') }}</button>
                </div>
            </form>
            <form id="maintain" method="post" class="form-inline" action="{{ Route('platform.toggleMaintain') }}">
                {{ csrf_field() }}
                <div class="col-sm-3">
                    <button type="button" class="btn btn-success btn-sm" id="enable-maintain"
                            data-title="{{ trans('platform.alert.enable_maintain_title') }}">{{ trans('platform.toggle_maintain.0') }}</button>
                    <button type="button" class="btn btn-warning btn-sm" id="disable-maintain"
                            data-title="{{ trans('platform.alert.disable_maintain_title') }}">{{ trans('platform.toggle_maintain.1') }}</button>
                    <input type="hidden" id="maintain-status" name="status">
                </div>
            </form>
            <form id="api-key" method="post" class="form-inline"  action="{{ Route('platform.toggleApiKey') }}">
                {{ csrf_field() }}
                <div class="col-sm-3">
                    <button type="button" class="btn btn-success btn-sm" id="enable-api-key"
                            data-title="{{ trans('platform.alert.enable_api_key_title') }}">{{ trans('platform.toggle_api_key.enable') }}</button>
                    <button type="button" class="btn btn-warning btn-sm" id="disable-api-key"
                            data-title="{{ trans('platform.alert.disable_api_key_title') }}">{{ trans('platform.toggle_api_key.disable') }}</button>
                    <input type="hidden" id="api-key-status" name="status">
                </div>
            </form>
        </div>
    </div>
    @include('includes.alert.delete')
@endsection

@section('script')
    <script src="{{ elixir('js/platforms/setting.js') }}"></script>
@endsection