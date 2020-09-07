$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function check()
{
    bank = $('#bank').val();

    if (bank == '') {
        alert('Bạn muốn tìm ATM của ngân hàng nào?');

        return false;
    }
    return true;
}
province_id = $('#province').val();
district_id = "{{$inputs['district']}}";
$.ajax({
    type:'POST',
    url:'{{route("district-the-bank")}}',
    data:{province_id:province_id,district_id:district_id},
    success:function(data){
        $('#district').html(data);
    }

});
$(function(){
    $('#province').change(function(){
        province_id = $(this).val();
        district_id = '';
        $.ajax({
               type:'POST',
               url:'{{route("district-the-bank")}}',
               data:{province_id:province_id,district_id:district_id},
               success:function(data){
                $('#district').html(data);
               }

        });
    })
});