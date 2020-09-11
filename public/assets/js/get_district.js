$(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#province').change(function(){
        province_id = $(this).val();
        $.ajax({
               type:'POST',
               url:'district',
               data:{province_id:province_id},
               success:function(data){
                $('#district').html(data);
               }

        });
    })
});