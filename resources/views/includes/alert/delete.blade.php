<div class="modal fade modal-danger" id="delete" tabindex="-1" role="dialog" aria-labelledby="delete">
    <div class="modal-dialog" role="document">
        <form id="delete-form" method="post" action="">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <input type="hidden" name="status">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">
                        {{ trans('dialog.delete_title') }}
                    </h4>
                </div>
                <div class="modal-body">
                    <p id="name"></p>
                    <p>{{ trans('dialog.delete_content') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">
                        {{ trans('dialog.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-outline">
                        {{ trans('dialog.submit') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>