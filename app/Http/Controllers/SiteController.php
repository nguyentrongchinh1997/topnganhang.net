<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Branch;
use App\Model\Province;
use App\Model\ProvinceThebank;
use App\Model\District;
use App\Model\Bank;
use App\Model\News;
use App\Model\InterestRate;
use App\Model\DistrictTheBank;
use View;
use App\Services\SiteService;
use App\Model\Atm;
use Response;
use Cache;

class SiteController extends Controller
{
    public function __construct(SiteService $siteService)
    {
        $this->siteService = $siteService;
        $cache = Cache::remember('fixed', 60, function() {
            return [
                    'bank' => Bank::all(),
                    'province' => Province::all(),
                    'latestNews' => News::latest()->take(6)->get(),
                    'swift_code' => News::where('id', 6)->first(),
            ];
        });
        View::share('viewShare', 
            $cache
        );
    }

    public function home()
    {
        return view('pages.home', $this->siteService->home());
    }

    public function news()
    {
        return view('pages.news.news_list', $this->siteService->news());
    }

    public function bankIntro($bankName, $bankId)
    {
        $result = $this->siteService->bankIntro($bankId);

        if (!empty($result)) {
            return view('pages.banks.bank_intro', $result);
        } else {
            return redirect()->route('index');
        }
    }

    public function bankBranchDetail($bankName, $province, $branch, $branchId)
    {
        $result = $this->siteService->bankBranchDetail($branchId);

        if (!empty($result)) {
            return view('pages.banks.bank_branch_detail', $result);
        } else {
            return redirect()->route('index');
        }
    }

    public function newsDetail($slug, $newsId)
    {
        $result = $this->siteService->newsDetail($newsId);

        if (!empty($result)) {
            return view('pages.news.news_detail', $result);
        } else {
            return redirect()->route('index');
        }
    }

    public function getExchange(Request $request)
    {
        $result = $this->siteService->getExchange($request->all());

        return response()->json([
                                    'table' => $result->content,
                                    'date' => date('d/m/Y', strtotime($result->date)),
                                    'bank_name' => $result->bank->name_en
                                ]);
    }

    public function interestRate($bankName, $bankId)
    {
        $latestNews = News::latest()->take(6)->get();
        $branchAll = Branch::where('bank_id', $bankId)->get();
        $branchRandom = $branchAll->random(10);
        $bank = Bank::findOrFail($bankId);

        return view('pages.interests.interest_rate', [
                                                'interestRate' => InterestRate::where('bank_id', $bankId)->first(),
                                                'latestNews' => $latestNews,
                                                'branchRandom' => $branchRandom,
                                                'bank' => $bank
                                            ]);
    }

    public function exchangeRateDate($bank, $bankId, $date)
    {
        $result = $this->siteService->exchangeRateDate($bank, $bankId, $date);

        if (!empty($result)) {
            return view('pages.exchanges.exchange_rate_date', $result);
        } else {
            return back();
        }
    }

    public function exchangeRateSearch(Request $request, $bankId)
    {
        $bank = Bank::find($bankId);
        $date = $request->date;
        
        return redirect()->route('exchange-rate-date', ['bank' => str_slug($bank->name_en), 'id' => $bankId, 'date' => $date]);
    }

    public function exchangeRate($bank, $bankId)
    {
        $result = $this->siteService->exchangeRate($bankId);

        if (!empty($result)) {
            return view('pages.exchanges.exchange_rate', $result);
        } else {
            return redirect()->route('index');
        }
    }

    public function bank($slug)
    {
        $result = $this->siteService->bank($slug);

        if (!empty($result)) {
            return view('pages.banks.bank', $this->siteService->bank($slug));
        } else {
            return redirect()->route('index');
        }
    }

    public function getDistrict(Request $request)
    {
        $district = District::where('province_id', $request->province_id)->get();

        return view('pages.district', ['district' => $district]);
    }

    public function getDistrictTheBank(Request $request)
    {
        $district = District::where('province_id', $request->province_id)->get();

        return view('pages.banks.district_the_bank', ['district' => $district, 'district_id' => $request->district_id]);        
    }

    public function search(Request $request)
    {
        $inputs = $request->all();
        $bank = Bank::findOrFail($inputs['bank']);
        $province = Province::findOrFail($inputs['province']);
        $district = District::findOrFail($inputs['district']);

        return redirect()->route('district-bank', ['bank_name' => $bank->slug, 'province' => $province->slug, 'district' => $district->slug]);
    }

    public function provinceBank($bankName, $province)
    {
        $result = $this->siteService->provinceBank($bankName, $province);

        if (!empty($result)) {
            return view('pages.banks.province_bank', $result);
        } else {
            return redirect()->route('index');
        }
    }

    public function districtBank($bankName, $province, $district)
    {
        $result = $this->siteService->district($bankName, $province, $district);

        if (!empty($result)) {
            return view('pages.banks.district_bank', $result);
        } else {
            return redirect()->route('index');
        }
    }

    public function atmDetail($bankName, $address, $id)
    {
        $result = $this->siteService->atmDetail($id);

        if (!empty($result)) {
            return view('pages.atms.atm_detail', $result);
        } else {
            return redirect()->route('index');
        }
    }

    public function atmSearch(Request $request)
    {
        $inputs = $request->all();
        $bank = Bank::findOrFail($inputs['bank']);

        if ($inputs['bank'] != '' && $inputs['province'] == '' && $inputs['district'] == '') {
            return redirect()->route('bank-atm', ['bank' => str_slug($bank->name_en), 'id' => $bank->id]);
        } else if ($inputs['bank'] != '' && $inputs['province'] != '' && $inputs['district'] == '') {
            $province = Province::findOrFail($inputs['province']);
            
            return redirect()->route('province-atm', ['bank' => str_slug($bank->name_en), 'province' => $province->slug, 'bank_id' => $bank->id, 'province_id' => $province->id]);
        } else if ($inputs['bank'] != '' && $inputs['province'] != '' && $inputs['district'] != '') {
            $province = Province::findOrFail($inputs['province']);
            $district = District::findOrFail($inputs['district']);

            return redirect()->route('district-atm', ['bank' => str_slug($bank->name_en), 'district' => $district->slug, 'province' => $province->slug, 'bank_id' => $bank->id, 'province_id' => $province->id, 'district_id' => $district->id]);
        }
    }

    public function districtAtm($bank, $district, $province, $bankId, $provinceId, $districtId)
    {
        $result = $this->siteService->districtAtm($bank, $district, $province, $bankId, $provinceId, $districtId);

        if (!empty($result)) {
            return view('pages.atms.atm_district', $result);
        } else {
            return redirect()->route('index');
        }
    }

    public function bankAtm($bankName, $bankId)
    {
        $result = $this->siteService->bankAtm($bankId);

        if (!empty($result)) {
            return view('pages.atms.atm_bank', $result);
        } else {
            return redirect()->route('index');
        }
    }

    public function provinceAtm($bank, $province, $bankId, $provinceId)
    {
        $result = $this->siteService->provinceAtm($bank, $province, $bankId, $provinceId);

        if (!empty($result)) {
            return view('pages.atms.atm_province', $result);
        } else {
            return redirect()->route('index');
        }
    }

    public function atmList(Request $request)
    {        
        $result = $this->siteService->atmList($request);

        if (!empty($result)) {
            return view('pages.atms.atm', $result);
        } else {
            return redirect()->route('index');
        }
        
    }

    public function atmProvince($province)
    {
        $result = $this->siteService->atmProvince($province);

        if (!empty($result)) {
            return view('pages.atms.atm_province');
        } else {
            return redirect()->route('index');
        }
    }
}
