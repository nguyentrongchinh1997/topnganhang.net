function branchSearch() {
    bank = $('#bank').val();
    province = $('#province').val();
    district = $('#district').val();

    if (bank == -1) {
        alert('Bạn muốn tìm chi nhánh của ngân hàng nào?');

        return false;
    } else if (province == -1) {
        alert('Bạn muốn tìm chi nhánh cho tỉnh / thành phố nào?');

        return false;
    } else if (district == -1) {
        alert('Bạn muốn tìm chi nhánh cho quận / huyện nào?');

        return false;
    }

    return true;
}