require(['jquery'], function ($) {

    $(document).on('change', '.btn-file :file', function () {
        var input = $(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');

        if (numFiles) {
            filename = '';
            for (var i = 0; i < this.files.length; i++) {
                filename += this.files[i].name;
				if(i+1<this.files.length){
					filename += ", ";
				}
            }
            $('#filename').val(filename);
            $(this).closest('form').find("input[type='submit']").prop('disabled', false);
        }

    });
});
