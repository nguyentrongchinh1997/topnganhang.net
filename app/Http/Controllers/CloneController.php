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
    protected $style4 = '<style>
                            .exchange-rate table tr td:nth-child(2) {
                                text-align: right;
                                color: #007fff;
                            }
                            .exchange-rate table tr td:nth-child(3) {
                                text-align: right;
                                color: red;
                            }
                        </style>';
                        
    public function tyGia()
    {
        $this->vietinbank();
        $this->sacombank();
        $this->techcombank();
        $this->agribank();
        $this->mbbank('https://thebank.vn/cong-cu/tinh-ty-gia-ngoai-te/ty-gia-mbbank.html', $bankId = 6);
        $this->getExchangePageNganHang('https://bidv.ngan-hang.com/', 4); // bidv
        $this->getExchangePageNganHang('https://acb.ngan-hang.com/', 3); // acb
        $this->getExchangePageNganHang('https://maritime.ngan-hang.com/', 8); //maritime
        $this->getExchangePageNganHang('https://vpbank.ngan-hang.com/', 10); //vpbank
        $this->getExchangePageNganHang('https://seabank.ngan-hang.com/', 7); //seabank
        $this->getExchangePageNganHang('https://vietcombank.ngan-hang.com/', 1); //vietcombank
        //$this->bidv('https://tygia.vn/ty-gia/bidv/ngay-', 'bidv'); //lấy tygia.vn
        //$this->mbBank('https://tygia.vn/ty-gia/mbbank/ngay-', 'mbBank'); // lấy ở tygia.vn
        //$this->acb('https://tygia.vn/ty-gia/acb/ngay-', 'acb'); // tygia.vn
        //$this->vietcombank('https://tygia.vn/ty-gia/vietcombank/ngay-', 'vietcombank');
        
    }

    public function acb($link, $name)
    {
        $date = date('d-m-Y');
        $link = $link . $date;
        $this->getExchangeTyGia($bankId = 3, $date, $link, $name);
    }

    public function bidv($link)
    {
        /**
         * Lấy tỷ giá tại trang tygia.vn
         */
        // $date = date('d-m-Y');
        // $link = $link . $date;
        // $this->getExchangeTyGia($bankId = 4, $date, $link, $name);        
    }

    public function getExchangePageNganHang($link, $bankId)
    {
        try {
            $html = file_get_html_custom($link);
            
            if (!empty($html->find('table.tb-bordered', 0))) {
                $content = $html->find('table.tb-bordered', 0)->outertext;

                foreach ($html->find('table.tb-bordered a') as $a) {
                    $href = $a->href;
                    $content = str_replace($href, '', $content);
                }
            } else if (!empty($html->find('table.table-bordered', 0))) {
                $content = $html->find('table.table-bordered', 0)->outertext;

                foreach ($html->find('table.table-bordered a') as $a) {
                    $href = $a->href;
                    $content = str_replace($href, '', $content);
                }
            }
            $date = date('Y-m-d');

            ExchangeRate::updateOrCreate(
                [
                    'date' => $date,
                    'bank_id' => $bankId
                ],
                [
                    'content' => $content . $this->style4
                ]
            );

            echo 'Thêm thành công ' . $link . '<hr>';
        } catch (\Throwable $th) {
            echo $th->getMessage() . ':' . $link . '<hr>';
        }
        
    }
    
    // public function mbBank($link, $name)
    // {
    //     $date = date('d-m-Y');
    //     $link = $link . $date;
    //     $this->getExchangeTyGia($bankId = 6, $date, $link, $name);
    // }

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

    public function mbbank($link, $bankId)
    {
        $this->getExchangeTheBank($link, $bankId, date('Y-m-d'), $name ='MBBank');
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

    public function getBranch()
    {
    	try {
            $random = rand(1, 11);
            $array = config('config.link')[$random];
            $domain = $array['domain'];
            $bankId = $array['bank_id'];
    		$html = file_get_html_custom($domain);
            
            if (!empty($html->find('ul.s1_l'))) {
                $provinces = $html->find('ul.s1_l li');
            } else if (!empty($html->find('ul.list-cities'))) {
                $provinces = $html->find('ul.list-cities li');
            }

    		foreach ($provinces as $tinh) {
                $province = trim($tinh->find('a', 0)->plaintext);
                
                if (in_array($bankId, [6, 7, 8])) {
                    $link = $domain . $tinh->find('a', 0)->href;
                } else {
                    $link = $tinh->find('a', 0)->href;
                }
                
                $provinceCheck = Province::where('slug', str_slug($province))->first();

                if (!empty($provinceCheck)) {
                    $this->district($link, $provinceCheck, $domain, $bankId);
                } else {
                    $provinceResult = Province::create([
                        'slug' => str_slug($province),
                        'name' => $province
                    ]);

                    $this->district($link, $provinceResult, $domain, $bankId);
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
            $rand = rand(1, 11);
            $array = config('config.link')[$rand];
            $domain = $array['domain'] . 'atm';
            $bankId = $array['bank_id'];
            $html = file_get_html_custom($domain);
            
            if ($bankId != 8) {
                if (in_array($bankId, [6, 7])) {
                    $provinces = $html->find('ul.list-cities li');
                } else {
                    $provinces = $html->find('ul.s1_l li');
                }
            }

    		//foreach ($html->find('ul.list-cities li') as $tinh) { Dành cho seabnk và mbbank
            foreach ($provinces as $tinh) {
                /**
                 * Dành cho mbbank và seabank
                 * $province = trim($tinh->find('a', 0)->plaintext);
                 * $province = trim(explode('(', $province)[0]);
                 * $link = $domain . $tinh->find('a', 0)->href;
                 */

                if ($bankId != 8) {
                    if (in_array($bankId, [6, 7])) {
                        $province = trim($tinh->find('a', 0)->plaintext);
                        $province = trim(explode('(', $province)[0]);
                        $link = $array['domain'] . $tinh->find('a', 0)->href;
                    } else {
                        $province = trim($tinh->find('a', 0)->plaintext);
                        $span = $tinh->find('span', 0)->plaintext;
                        $province = trim(\str_replace($span, '', $province));
                        $link = $tinh->find('a', 0)->href;
                    }
                }
                
                $provinceCheck = Province::where('slug', str_slug($province))->first();

                if (!empty($provinceCheck)) {
                    $this->districtAtm($link, $provinceCheck->id, $domain, $bankId, $array);
                } else {
                    $provinceResult = Province::create([
                        'slug' => str_slug($province),
                        'name' => $province
                    ]);

                    $this->districtAtm($link, $provinceResult->id, $domain, $bankId, $array);
                }
    		}
        } catch (\Throwable $th) {
            echo "Lỗi: " . $th->getMessage() . '<br>';
            echo 'Dong: ' . $th->getLine() . '<br>';
            echo 'link: ' . $domain . '<hr>';
        }
    }

    public function districtAtm($link, $provinceId, $domain, $bankId, $array)
    {
        $html = file_get_html_custom($link);

        if ($bankId != 8) {
            if (in_array($bankId, [6, 7])) {
                $districts = $html->find('.content table.table tr');
            } else {
                $districts = $html->find('ul.s1_l li');
            }
        }

    	foreach ($districts as $district) {
            if ($bankId != 8) {
                if (in_array($bankId, [6, 7])) {
                    $name = trim($district->plaintext);
                    $rigth = $district->find('.cright', 0)->plaintext;
                    $name = str_replace($rigth, '', $name);
                    $link = $array['domain'] . $district->find('a', 0)->href;
                } else {
                    $name = trim($district->find('a', 0)->plaintext);
                    $span = $district->find('span', 0)->plaintext;
                    $name = trim(\str_replace($span, '', $name));
                    $link = $district->find('a', 0)->href;
                }
            }
            
            $checkDistrict = District::where('slug', str_slug($name))
                                      ->where('province_id', $provinceId)
                                      ->first();

            if (!empty($checkDistrict)) {
                $this->atmAdd($link, $checkDistrict->id, $domain, $provinceId, $bankId, $array);
            } else {
                $districtResult = District::create(
                    [
                        'slug' => str_slug($name),
                        'province_id' => $provinceId,
                        'name' => $name,
                    ]
                );
                $this->atmAdd($link, $districtResult->id, $domain, $provinceId, $bankId, $array);
            }
		}
    }

    public function district($link, $province, $domain, $bankId)
    {
        $html = file_get_html_custom($link);
        
        if (!empty($html->find('ul.list-cities li'))) {
            $districts = $html->find('ul.list-cities li');
            $type = 1;
        } else if (!empty($html->find('ul.s1_l li'))) {
            $districts = $html->find('ul.s1_l li');
            $type = 2;
        }

    	foreach ($districts as $district) {
            if ($type == 1) {
                $name = trim($district->find('a', 0)->plaintext);
                $link = $domain . $district->find('a', 0)->href;
            } else if ($type == 2) {
                $name = trim($district->find('a', 0)->plaintext);
                $span = $district->find('a span', 0)->plaintext;
                $name = str_replace($span, '', $name);
                $link = $district->find('a', 0)->href;
            }
			
            $checkDistrict = District::where('slug', str_slug($name))
                                      ->where('province_id', $province->id)
                                      ->first();
            
            if (!empty($checkDistrict)) {
                $this->branch($link, $checkDistrict, $domain, $bankId);
            } else {
                $districtResult = District::create(
                    [
                        'slug' => str_slug($name),
                        'province_id' => $province->id,
                        'name' => $name,
                    ]
                );
                $this->branch($link, $districtResult, $domain, $bankId);
            }
		}
    }

    public function branch($link, $district, $domain, $bankId)
    {
        $other_info = NULL;
        $html = file_get_html_custom($link);
        
        if (!empty($html->find('.page-content ul li.list-group-item'))) {
            $ul = $html->find('.page-content ul li.list-group-item');
            $type = 1;
        } else if (!empty($html->find('ul.s2_l li'))) {
            $type = 2;
            $ul = $html->find('ul.s2_l li');
        }
        
        foreach ($ul as $li) {
            $name = $li->find('h3', 0)->plaintext;
            $address = $li->find('p', 0)->plaintext;

            if ($type == 2) {
                $url = $li->find('a', 0)->href;
            } else if ($type == 1) {
                $url = $domain . $li->find('a', 0)->href;
            }
            
            $other_info = $this->getOtherInfo($url);

            Branch::updateOrCreate(
                [
                    'district_id' => $district->id,
                    'name' => $name,
                    'bank_id' => $bankId,
                ],
                [
                    'address' => $address,
                    'other_info' => $other_info
                ]
            );
            
            echo "Thêm thành công: $link<hr>";
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

    public function atmAdd($link, $districtId, $domain, $provinceId, $bankId, $array)
    {
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
        if ($bankId != 8) {
            if (in_array($bankId, [6, 7])) {
                $element = $html->find('.content ul li.list-group-item');
            } else {
                $element = $html->find('ul.s2_l li');
            }
        }
        foreach ($element as $li) {
            if ($bankId != 8) {
                if (in_array($bankId, [6, 7])) {
                    $name = $li->find('a', 0)->plaintext;
                    $address = trim($li->find('p', 0)->plaintext);
                    $url = $array['domain'] . $li->find('a', 0)->href;
                    $html = file_get_html_custom($url);
                    $other_info = '';

                    foreach ($html->find('.content p') as $info) {
                        $other_info = $other_info . $info->outertext;
                    }
                } else {
                    $address = $li->find('p', 0)->plaintext;
                    $name = $li->find('h3', 0)->plaintext;
                    $url = $li->find('a', 0)->href;
                    $other_info = $this->getOtherInfo($url);
                }
            }

            Atm::updateOrCreate(
                [
                    'bank_id' => $bankId,
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
