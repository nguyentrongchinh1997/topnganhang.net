<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Branch;
use App\Model\Province;
use App\Model\ProvinceThebank;
use App\Model\District;
use App\Model\Bank;
use App\Model\InterestRate;
use App\Model\DistrictTheBank;
use View;
use App\Services\SiteService;
use App\Model\Atm;
use App\Model\ExchangeRate;

class CloneController extends Controller
{
    protected $style1 = '<style>
                            .exchange-rate table tr td:nth-child(3), .exchange-rate table tr td:nth-child(4) {
                                color: #007fff;
                            }
                            .exchange-rate table tr td:nth-child(5), .exchange-rate table tr td:nth-child(6) {
                                color: red;
                            }
                            .exchange-rate table tr td:nth-child(2) {
                                text-align: left;
                            }
                        </style>';
    protected $style2 = '<style>
                            .exchange-rate table tr td:nth-child(2), .exchange-rate table tr td:nth-child(3) {
                                color: #007fff;
                                text-align: right;
                            }
                            .exchange-rate table tr td:nth-child(4) {
                                color: red;
                                text-align: right;
                            }
                        </style>';
    protected $style3 = '<style>
                            .exchange-rate table tr td:nth-child(3), .exchange-rate table tr td:nth-child(4) {
                                color: #007fff;
                                text-align: right;
                            }
                            .exchange-rate table tr td:nth-child(5) {
                                color: red;
                                text-align: right;
                            }
                        </style>';
                        
    public function tyGia()
    {
        $this->vietinbank();
        $this->sacombank();
        $this->techcombank();
        $this->agribank();
        $this->bidv('https://tygia.vn/ty-gia/bidv/ngay-', 'bidv'); //lấy tygia.vn
        $this->vietcombank('https://tygia.vn/ty-gia/vietcombank/ngay-', 'vietcombank');
        $this->mbBank('https://tygia.vn/ty-gia/mbbank/ngay-', 'mbBank'); // lấy ở tygia.vn
        $this->acb('https://tygia.vn/ty-gia/acb/ngay-', 'acb'); // tygia.vn
        $this->maritimeBank('https://thebank.vn/cong-cu/tinh-ty-gia-ngoai-te/ty-gia-maritimebank.html', $bankId = 8);
    }

    public function acb($link, $name)
    {
        $date = date('d-m-Y');
        $link = $link . $date;
        $this->getExchangeTyGia($bankId = 3, $date, $link, $name);
    }

    public function bidv($link, $name)
    {
        $date = date('d-m-Y');
        $link = $link . $date;
        $this->getExchangeTyGia($bankId = 4, $date, $link, $name);
    }
    
    public function mbBank($link, $name)
    {
        $date = date('d-m-Y');
        $link = $link . $date;
        $this->getExchangeTyGia($bankId = 6, $date, $link, $name);
    }

    public function vietcombank($link, $name)
    {
        $date = date('d-m-Y');
        $link = $link . $date;
        $this->getExchangeTyGia($bankId = 1, $date, $link, $name);
    }

    public function getExchangeTyGia($bankId, $date, $link, $name)
    {
        try {
            $date = date('Y-m-d', strtotime($date));
            $html = file_get_html_custom($link);

            if (!empty($html->find('table.table.table-bordered.table-hover'))) {
                $date = date('Y-m-d', strtotime($date));
                $content = $html->find('table.table.table-bordered.table-hover', 0)->outertext;
                $this->insertExchangeRate($date, $bankId, $content . $this->style1);

                echo 'Thêm thành công ' . $name . '<hr>';
            }
        } catch (\Throwable $th) {
            echo $th->getMessage() . $name . '<hr>';
        }
    }

    public function maritimeBank($link, $bankId)
    {
        $this->getExchangeTheBank($link, $bankId, date('Y-m-d'), $name ='Maritime Bank');
    }

    // public function vietcombank($link, $bankId = 1)
    // {
    //     $this->getExchangeTheBank($link, $bankId, date('Y-m-d'), $name ='vietcombank');
    // }

    // public function acb($link, $bankId = 3)
    // {
    //     $this->getExchangeTheBank($link, $bankId, date('Y-m-d'), $name ='acb');
    // }

    // public function bidv($link, $bankId = 4)
    // {
    //     $this->getExchangeTheBank($link, $bankId, date('Y-m-d'), $name ='bidv');
    // }

    public function getExchangeTheBank($link, $bankId, $date, $name)
    {
        try {
            $html = file_get_html_custom($link);

            if (!empty($html->find('table.table-exchange'))) {
                $content = $html->find('table.table-exchange', 0)->outertext;
                $this->insertExchangeRate(date('Y-m-d'), $bankId, $content . $this->style3);
            }
            
            echo 'Thêm thành công ' . $name . '<hr>';
        } catch (\Throwable $th) {
            echo $th->getMessage() . $name . '<hr>';
        }
    }

    public function vietinbank()
    {
        try {
            $date = date('d/m/Y');
            $link = 'https://www.vietinbank.vn/web/home/vn/ty-gia/?theDate=' . $date;
            // $date = explode('theDate=', $link)[1];
            $date = str_replace('/', '-', $date);
            $date = date('Y-m-d', strtotime($date));
            $html = file_get_html_custom($link);
            $bankId = 2;

            if (!empty($html->find('table#hor-ex-b'))) {
                $content = $html->find('table#hor-ex-b', 0)->outertext . '</table>';
                $this->insertExchangeRate($date, $bankId, $content);
    
                echo 'Thêm thành công vietinbank<hr>';
            } else {
                echo 'Không có dữ liệu<hr>';
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        
    }

    public function agribank()
    {
        try {
            $date = date('d-m-Y');
            $link = 'https://www.agribank.com.vn/wcm/connect/ttkhac/ty-gia/2020/' . $date . '?source=library&srv=cmpnt&cmpntid=b42b798a-7057-49c3-b0fd-3766e30729cf';
            // $date = explode('ty-gia/', $link)[1];
            // $date = explode('?source', $date)[0];
            // $date = explode('/', $date)[1];
            $date = date('Y-m-d', strtotime($date));
            $html = file_get_html_custom($link);
            $bankId = 5;
            
            if (!empty($html->find('table'))) {
                $content = $html->find('table', 0)->outertext;
                $this->insertExchangeRate($date, $bankId, $content . $this->style2);

                echo 'Thêm thành công agribank<hr>';
            } else {
                echo 'Chưa có dữ liệu agribank<hr>';
            }
        } catch (\Throwable $th) {
            echo $th->getMessage() . '<hr>';
        }
    }

    public function sacombank()
    {
        try {
            $link = 'https://www.sacombank.com.vn/company/Pages/ty-gia.aspx';
            $date = date('Y-m-d');
            $html = file_get_html_custom($link);
            $bankId = 11;

            if (!empty($html->find('.table.table'))) {
                $content = '';
                foreach ($html->find('table.table') as $key => $data) {
                    if ($key < 2) {
                        $content = $content . $data->outertext;
                    }
                }
                $this->insertExchangeRate($date, $bankId, $content);
                
                echo 'Thêm thành công Sacombank<hr>';
            }
        } catch (\Throwable $th) {
            echo $th->getMessage() . '<hr>';
        }
    }

    public function techcombank()
    {
        try {
            $date = date('d/m/Y');
            $link = 'https://www.techcombank.com.vn/customfield/findexchange?catId=234&date=' . $date;
            $html = file_get_html_custom($link);
            // $date = explode('&date=', $link)[1];
            $date = str_replace('/', '-', $date);
            $date = date('Y-m-d', strtotime($date));

            if (!empty($html->find('.table-responsive table'))) {
                $content = $html->find('.table-responsive table', 0)->outertext;
                $bankId = 9;
                $this->insertExchangeRate($date, $bankId, $content);

                echo 'Thêm thành công techcombank<hr>';
            } else {
                echo 'Chưa có dữ liệu techcombank<hr>';
            }
        } catch (\Throwable $th) {
            echo $th->getMessage() . '<hr>';
        }
    }

    public function insertExchangeRate($date, $bankId, $content)
    {
        return ExchangeRate::updateOrCreate(
            [
                'date' => $date,
                'bank_id' => $bankId
            ],
            [
                'content' => $content
            ]
        );        
    }

    public function getBank()
    {
    	try {
            $domain = 'https://mbbank.ngan-hang.com/';
    		$html = file_get_html_custom($domain);

    		foreach ($html->find('ul.list-cities li') as $tinh) {
    			$province = trim($tinh->find('a', 0)->plaintext);
                $link = $domain . $tinh->find('a', 0)->href;
                $provinceCheck = Province::where('slug', str_slug($province))->first();

                if (!empty($provinceCheck)) {
                    $this->district($link, $provinceCheck, $domain);
                } else {
                    $provinceResult = Province::create([
                        'slug' => str_slug($province),
                        'name' => $province
                    ]);

                    $this->district($link, $provinceResult, $domain);
                }
    		}
    	} catch (\Exception $e) {
            echo "Lỗi: " . $e->getMessage() . '<br>';
            echo 'link: ' . $link . '<hr>';
    	}
    }

    /**
     * Ngân hàng không có trong ngan-hang.com: maritime bank
     * Ngân hàng khác cấu trúc html với các ngân hàng còn lại: mbbank, seabank
     * @return void
     */
    public function getAtm()
    {
        try {
            $domain = 'https://mbbank.ngan-hang.com/atm';
            //$domain = 'https://mbbank.ngan-hang.com';
    		$html = file_get_html_custom($domain1);

    		//foreach ($html->find('ul.list-cities li') as $tinh) { Dành cho seabnk và mbbank
            foreach ($html->find('ul.s1_l li') as $tinh) {
                /**
                 * Dành cho mbbank và seabank
                 * $province = trim($tinh->find('a', 0)->plaintext);
                 * $province = trim(explode('(', $province)[0]);
                 * $link = $domain . $tinh->find('a', 0)->href;
                 */
                $province = trim($tinh->find('a', 0)->plaintext);
                $span = $tinh->find('span', 0)->plaintext;
                $province = trim(\str_replace($span, '', $province));
                $link = $tinh->find('a', 0)->href;
                $provinceCheck = Province::where('slug', str_slug($province))->first();

                if (!empty($provinceCheck)) {
                    $this->districtAtm($link, $provinceCheck->id, $domain);
                } else {
                    $provinceResult = Province::create([
                        'slug' => str_slug($province),
                        'name' => $province
                    ]);

                    $this->districtAtm($link, $provinceResult->id, $domain);
                }
    		}
        } catch (\Throwable $th) {
            echo "Lỗi: " . $th->getMessage() . '<br>';
            echo 'Dong: ' . $th->getLine() . '<br>';
            echo 'link: ' . $link . '<hr>';
        }
    }

    public function districtAtm($link, $provinceId, $domain)
    {
        $html = file_get_html_custom($link);

    	foreach ($html->find('ul.s1_l li') as $district) {
        //foreach ($html->find('.content table.table tr') as $district) { //dành cho seabank
            /**
             * Dành cho ngân hàng seabank
             * $name = trim($district->plaintext);
             * $rigth = $district->find('.cright', 0)->plaintext;
             * $name = str_replace($rigth, '', $name);
             * $link = $domain . $district->find('a', 0)->href;
             */
            

            /**
             * Dành cho các ngân hàng còn lại
             * $name = trim($district->find('a', 0)->plaintext);
             * $span = $district->find('span', 0)->plaintext;
             * $name = trim(\str_replace($span, '', $name));
             */
            $name = trim($district->find('a', 0)->plaintext);
            $span = $district->find('span', 0)->plaintext;
            $name = trim(\str_replace($span, '', $name));
            $link = $district->find('a', 0)->href;
            $checkDistrict = District::where('slug', str_slug($name))
                                      ->where('province_id', $provinceId)
                                      ->first();

            if (!empty($checkDistrict)) {
                $this->atmAdd($link, $checkDistrict->id, $domain, $provinceId);
            } else {
                $districtResult = District::create(
                    [
                        'slug' => str_slug($name),
                        'province_id' => $provinceId,
                        'name' => $name,
                    ]
                );
                $this->atmAdd($link, $districtResult->id, $domain, $provinceId);
            }
		}
    }

    public function district($link, $province, $domain)
    {
    	$html = file_get_html_custom($link);

    	foreach ($html->find('ul.list-cities li') as $district) {
			$name = trim($district->find('a', 0)->plaintext);
            $link = 'https://mbbank.ngan-hang.com' . $district->find('a', 0)->href;
            $checkDistrict = District::where('slug', str_slug($name))
                                      ->where('province_id', $province->id)
                                      ->first();
            
            if (!empty($checkDistrict)) {
                $this->branch($link, $checkDistrict, $domain);
            } else {
                $districtResult = District::create(
                    [
                        'slug' => str_slug($name),
                        'province_id' => $province->id,
                        'name' => $name,
                    ]
                );
                $this->branch($link, $districtResult, $domain);
            }
		}
    }

    public function branch($link, $district, $domain)
    {
        $bank_id = 6;
        $other_info = NULL;
    	$html = file_get_html_custom($link);

    	if (!empty($html->find('.page-content ul', 0))) {
    		$ul = $html->find('.page-content ul li[class="list-group-item"]');

			foreach ($ul as $li) {
				$name = $li->find('h3', 0)->plaintext;
                $address = $li->find('p', 0)->plaintext;
                $url = $domain . $li->find('a', 0)->href;
                $other_info = $this->getOtherInfo($url);

				Branch::updateOrCreate(
					[
						'district_id' => $district->id,
						'name' => $name,
						'bank_id' => $bank_id,
						
						
					],
					[
                        'address' => $address,
                        'other_info' => $other_info
					]
                );
                
                echo "Thêm thành công: $link<hr>";
			}
    	}
    }

    public function msm()
    {
        try {
            $atmTheBank = \DB::table('atms_old')->where('bank_id', 8)->get();

            foreach ($atmTheBank as $atm) {
                $districtTheBankSlug = \DB::table('district_thebank')->where('id', $atm->district_the_bank_id)->first();
                $district = District::where('slug', trim($districtTheBankSlug->slug))->first();
                $provinceId = $district->province_id;

                Atm::updateOrCreate(
                    [
                        'bank_id' => 8,
                        'district_id' => $district->id,
                        'province_id' => $provinceId,
                        'slug' => str_slug($atm->address),
                    ],
                    [
                        'address' => $atm->address
                    ]
                );
            }
        } catch (\Throwable $th) {
            echo $th->getMessage() . '<hr>';
        }
    }

    public function atmAdd($link, $districtId, $domain, $provinceId)
    {
        $bank_id = 6;
        $other_info = NULL;
    	$html = file_get_html_custom($link);

        /**
         * Dành cho seabank và mbbank
         * if (!empty($html->find('ul.s2_l'))) {
		    *foreach ($html->find('ul.s2_l li') as $li) {
         * if (!empty($html->find('.content ul li.list-group-item'))) {
	     * foreach ($html->find('.content ul li.list-group-item') as $li) {
         */

        /**
         * Dành cho ngân hàng còn lại
         */
    	if (!empty($html->find('ul.s2_l'))) {
		    foreach ($html->find('ul.s2_l li') as $li) {
                /**
                 * Dành cho seabank
                 */
                    // $name = $li->find('a', 0)->plaintext;
                    // $address = trim($li->find('p', 0)->plaintext);
                    // $url = $domain . $li->find('a', 0)->href;
                    // $html = file_get_html_custom($url);
                    // $other_info = '';

                    // foreach ($html->find('.content p') as $info) {
                    //     $other_info = $other_info . $info->outertext;
                    // }

                /**
                 * Dành cho ngân hàng còn lại
                 * $address = $li->find('p', 0)->plaintext;
                 * $name = $li->find('h3', 0)->plaintext;
                 * $url = $li->find('a', 0)->href;
                 * $other_info = $this->getOtherInfo($url);
                 */
                $address = $li->find('p', 0)->plaintext;
                $name = $li->find('h3', 0)->plaintext;
                $url = $li->find('a', 0)->href;
                $other_info = $this->getOtherInfo($url);

				Atm::updateOrCreate(
					[
                        'bank_id' => $bank_id,
                        'district_id' => $districtId,
                        'province_id' => $provinceId,
                        'slug' => str_slug($name),
					],
					[
                        'name' => $name,
                        'address' => $address,
                        'other_info' => $other_info
					]
                );
                
                echo "Thêm thành công: $link<hr>";
            }
            
    	}
    }

    public function getQuanHuyen($link)
    {
        //return $link;
        $data = array();
        $html = file_get_html_custom($link);
        $s = '';

        if (!empty($html->find('.rows_district'))) {
            foreach ($html->find('.rows_district .sl_chosen option') as $key => $option) {
                if ($key > 0) {
                    $id = $option->attr['value'];
                    $slug = str_slug($option->plaintext);
                    // $s = $s . "'" . $id . "'=>'" . $slug . "',";
                    $s = $s . $id . "=>" . "[" . "'name' => " . "'$option->plaintext'," . "'slug' => " . "'$slug'" . "],";
                }
            }

            return '[' . $s . ']';
        }
    }

    public function theBank()
    {
        $link = 'https://thebank.vn/cong-cu/tim-atm/vietinbank-40.html';
        $html = file_get_html_custom($link);
        $data['atm'] = array();

        if (!empty($html->find('.rows_province'))) {
            foreach ($html->find('.rows_province .sl_chosen option') as $key => $option) {
                if ($key > 0) {
                    $id = $option->attr['value'];
                    $slug = str_slug($option->plaintext);
                    $data['atm'][$id] = array(
                        'name' => "'" . $option->plaintext . "'",
                        'slug' => "'" . $slug . "'",
                        'quan_huyen' => $this->getQuanHuyen("https://thebank.vn/cong-cu/tim-atm/vietinbank-$slug-40-$id.html")
                    );
                }

            }
        }

        foreach ($data['atm'] as $key => $atm) {
            echo $key . " => " . "[". "'slug' =>" . $atm['slug'] . ",'name' => " . $atm['name'] . ",'quan_huyen' => " . $atm['quan_huyen'] . "]," . '<br>';
        }
        dd($data['atm']);
    }

    public function atm()
    {
        try {
            $data = config('config.atm');
            $banks = config('config.bank');

            foreach ($banks as $bankId => $bankItem) {
                foreach ($data as $provinceId => $provinceItem) {
                    foreach ($provinceItem['quan_huyen'] as $districtId => $district) {
                        $link = 'https://thebank.vn/cong-cu/tim-atm/' . $bankItem['the_bank'] . '-' . $district['slug'] . '-' . $provinceItem['slug'] . '-' . $bankItem['the_bank_id'] . '-' . $provinceId . '-' . $districtId . '.html';
                        $this->insertAtm($link, $bankId, $provinceId, $districtId);
                    }
                }
            }            
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function insertAtm($link, $bankId, $provinceId, $districtId)
    {
        try {
            $html = file_get_html_custom($link);

            if (!empty($html->find('.list_atm table'))) {
                foreach ($html->find('.list_atm table tr') as $stt => $tr) {
                    if ($stt > 1) {
                        $address = $tr->find('td', 2)->plaintext;

                        Atm::updateOrCreate(
                            [
                                'bank_id' => $bankId,
                                'address' => $address
                            ],
                            [
                                'province_id' => $provinceId,
                                'district_id' => $districtId,
                            ]
                        );
                    }
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage() . '<hr>';
        }
    }

    public function updateDb()
    {
        $branchs = Branch::where('bank_id', 11)->get();
        $other_info = $fax = $other = $branch_name = NULL;
        
        foreach ($branchs as $branchItem) {
            try {
                $name = str_slug($branchItem->name);
                $province = $branchItem->district->province->slug;
                $link = 'https://sacombank.ngan-hang.com/chi-nhanh/' . $province . '/' . $name;                
                $data = [
                    'other_info' => $this->getOtherInfo($link)
                ];
                Branch::where('id', $branchItem->id)->update($data);

                echo 'Update thành công id = ' . $branchItem->id . '<hr>';
            } catch (\Throwable $th) {
                echo 'Lỗi: ' . $th->getMessage() . '<br>';
                echo 'Link ' . $link . '<hr>';
            }
        }
    }

    public function getOtherInfo($link)
    {
        $html = file_get_html_custom($link);
        $string = '';

        if (!empty($html->find('ul.art_l li'))) {
            foreach ($html->find('ul.art_l li') as $li) {
                $string = $string . '<p>' . $li->plaintext . '</p> ';
            }
        } else if (!empty($html->find('ul.list-info li'))) {
            foreach ($html->find('ul.list-info li') as $li) {
                $string = $string . '<p>' . $li->plaintext . '</p> ';
            }
        }

        return $string;
    }
}
