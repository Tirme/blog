<form method="post" action="{{ $form->action }}">
    {!! $form->photo_upload->getFormHtml() !!}
    <button type="submit" class="btn btn-primary">Save</button>
    <input type="hidden" name="album_id" value="{{ $form->album_id }}" />
    <input type="hidden" name="_hash" value="{{ $form->hash }}" />
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="redirect[success]" value="{{ $form->redirect['success'] }}" />
</form>
