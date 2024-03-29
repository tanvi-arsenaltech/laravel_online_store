@section('js')
<script>
    $('#name').on('change keyup', function() {
        element = $(this);
        var title = element.val();
        console.log(element.val());
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{ route('getSlug') }}',
            type: 'get',
            data: {
                title
            },
            dataType: 'json',
            success: function(response) {
                $("button[type=submit]").prop('disabled', false);
                if (response["status"] == true) {
                    $('#slug').val(response['slug']);
                }
            }
        });
    });
</script>
@endsection