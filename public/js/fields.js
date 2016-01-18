var tabs = VueStrap.tabset;
var tab = VueStrap.tab;

(function($) {
    $(document).ready(function() {
        $.datepicker.formatDate('yy-mm-dd');
        $('[type="date"]').datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $('[type="file"]').change(function(event) {
            var files = event.target.files;
            var model_name = $(this).attr('model_name');
            var data = new FormData();
            var hash = $('[name="_hash"]').val();
            var csrf_token = $('[name="_token"]').val();
            $.each(files, function(key, value) {
                data.append('photo[' + key + ']', value);
            });
            data.append('_token', csrf_token);
            data.append('_hash', hash);
            $.ajax({
                url: '/admin/upload/photo',
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false
            }).success(function(result) {
                var photos = result.photos || [];
                var preview = $('.photos-form');
                $.each(photos, function(key, photo) {
                    var index = $('li', preview).size() + 1;
                    preview.append(
                        '<li>' +
                        '<img src="data:image/' + photo.mine_type + ';base64,' + photo.base64 + '" />' +
                        '<input type="hidden" name="photos[' + index + '][id]" value="' + photo.id + '" />' +
                        '<textarea name="photos[' + index + '][summary]"> </textarea>' +
                        '</li>'
                    );
                });
            }).error(function(result) {

            });
        });
    });
})(jQuery);
