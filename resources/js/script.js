
// if ($('.custom-file-container').attr("data-upload-id")) {
//     const upload = new FileUploadWithPreview.default('customFileInput');
// }

function deleteData(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.value) {
            document.getElementById('delete-form-'+id).submit();
        }
    })
}
$(function () {
    $("#datatable").DataTable();
    $('.dropify').dropify();
    $('.select').each(function () {
        $(this).select2();
    });
});
