<?php

use Illuminate\Database\Seeder;
use App\Model\Bank;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
        	array(
        		'name_vi' => 'Ngoại Thương',
        		'name_en' => 'Vietcombank',
        		'slug' => 'ngoai-thuong',
        		'image' => 'vietcombank.jpg'
        	),
        	array(
        		'name_vi' => 'Công Thương',
        		'name_en' => 'Vietinbank',
        		'slug' => 'cong-thuong',
        		'image' => 'vietinbank.jpg'
        	),
        	array(
        		'name_vi' => 'Á Châu',
        		'name_en' => 'ACB',
        		'slug' => 'a-chau',
        		'image' => 'acb.jpg'
        	),
        	array(
        		'name_vi' => 'Đầu tư và phát triển Việt Nam',
        		'name_en' => 'BIDV',
        		'slug' => 'dau-tu-va-phat-trien-viet-nam',
        		'image' => 'vietcombank.jpg'
        	),
        	array(
        		'name_vi' => 'Nông nghiệp và Phát triển Nông thôn Việt Nam',
        		'name_en' => 'Agribank',
        		'slug' => 'nong-nghiep',
        		'image' => 'agribank.jpg'
        	),
        	array(
        		'name_vi' => 'Thương mại cổ phần Quân đội',
        		'name_en' => 'MB',
        		'slug' => 'quan-doi',
        		'image' => 'mb.jpg'
        	),
        	array(
        		'name_vi' => 'Đông Nam Á',
        		'name_en' => 'SeABank',
        		'slug' => 'dong-nam-a',
        		'image' => 'seabank.jpg'
        	),
        	array(
        		'name_vi' => 'Hàng Hải Việt Nam',
        		'name_en' => 'Maritime Bank',
        		'slug' => 'hang-hai-viet-nam',
        		'image' => 'msb.jpg'
        	),
        	array(
        		'name_vi' => 'Kỹ thương Việt Nam',
        		'name_en' => 'Techcombank',
        		'slug' => 'ky-thuong-viet-nam',
        		'image' => 'techcombank.jpg'
        	),
        	array(
        		'name_vi' => 'Việt Nam Thịnh Vượng',
        		'name_en' => 'VPBank',
        		'slug' => 'viet-nam-thinh-vuong',
        		'image' => 'vpbank.jpg'
        	),
        	array(
        		'name_vi' => 'Sài Gòn Thường Tín',
        		'name_en' => 'Sacombank',
        		'slug' => 'sai-gon-thuong-tin',
        		'image' => 'sacombank.jpg'
        	),
        );

        Bank::insert($data);
    }
}
