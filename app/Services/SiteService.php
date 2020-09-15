<?php

namespace App\Services;

use App\Model\Bank;
use App\Model\District;
use App\Model\Province;
use App\Model\Branch;
use App\Model\ProvinceTheBank;
use App\Model\DistrictTheBank;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use App\Model\ExchangeRate;
use App\Model\Atm;
use App\Model\News;
use Cache;

class SiteService
{
	protected $districtModel;

	protected $bankModel;

	protected $branchModel;

	protected $provinceTheBankModel;

	protected $districtTheBankModel;

	protected $atmModel;

	protected $exchangeRate;

	protected $newsModel;

	public function __construct(News $newsModel, ExchangeRate $exchangeRateModel, Atm $atmModel, Province $provinceModel, Bank $bankModel, District $districtModel, Branch $branchModel, ProvinceTheBank $provinceTheBankModel, DistrictTheBank $districtTheBankModel)
	{
		$this->provinceModel = $provinceModel;
		$this->bankModel = $bankModel;
		$this->districtModel = $districtModel;
		$this->branchModel = $branchModel;
		$this->provinceTheBankModel = $provinceTheBankModel;
		$this->districtTheBankModel = $districtTheBankModel;
		$this->atmModel = $atmModel;
		$this->exchangeRateModel = $exchangeRateModel;
		$this->newsModel = $newsModel;
	}

	public function home()
	{
		$exchangeRate = $this->exchangeRateModel->where('bank_id', 1)->latest('date')->first();
		$bankId = rand(1, 11);

		return [
			'exchangeRate' => $exchangeRate,
			'banks' => $this->bankModel->all(),
			'bank' => $this->bankModel->findOrfail($bankId),
			'provinces' => $this->provinceModel->all(),
			'districtHcm' => $this->districtModel->where('province_id', 2)->get(),
			'news' => $this->newsModel->latest()->take(6)->get(),
			'vietinbankBranchHn' => $this->provinceModel->where('id', 3)
														->with(['branch' => function($query) use ($bankId) {
															$query->where('bank_id', $bankId)->limit(18);
														}])
														->first(),
			'vietinbankBranchHcm' => $this->provinceModel->where('id', 2)
														 ->with(['branch' => function($query) use ($bankId) {
															$query->limit(18);
														 }])
														 ->first()
		];
	}

	public function news()
	{
		try {
			$news = $this->newsModel->latest()->paginate(10);
			$bank = $this->bankModel->all()->random(1);

			return [
				'news' => $news,
				'bank' => $bank[0],
			];
		} catch (\Throwable $th) {
			return NULL;
		}
	}

	public function newsDetail($newsId)
	{
		try {
			$news = $this->newsModel->findOrFail($newsId);
			$news->increment('view');
			$latestNews = $this->newsModel->where('id', '!=', $newsId)->latest()->take(6)->get();

			return [
				'news' => $news,
				'latestNews' => $latestNews
			];
		} catch (\Throwable $th) {
			return NULL;
		}
	}

	public function getExchange($inputs)
	{
		$exchangeRate = $this->exchangeRateModel
							 ->where('bank_id', $inputs['bankId'])
							 ->latest('date')
							 ->first();
							 
		return $exchangeRate;
	}

	public function exchangeRate($bankId)
	{
		try {
			$bank = $this->bankModel->findOrFail($bankId);
			$exchangeRate = $this->exchangeRateModel->where('bank_id', $bankId)
													->latest('date')
													->first();
			$latestNews = $this->newsModel->latest()->take(6)->get();
			$branchAll = $this->branchModel->where('bank_id', $bankId)
										   ->get();
			
			if (count($branchAll) >= 10) {
				$branchRandom = $branchAll->random(10);
			} else {
				$branchRandom = $branchAll;
			}
			
			return [
				'bank' => $bank,
				'exchangeRate' => $exchangeRate,
				'latestNews' => $latestNews,
				'branchRandom' => $branchRandom
			];
		} catch (\Throwable $th) {
			return NULL;
		}
	}

	public function exchangeRateDate($bank, $bankId, $date)
	{
		try {
			$bank = Bank::findOrFail($bankId);
			$exchangeRate = $this->exchangeRateModel->where('bank_id', $bankId)
													->where('date', $date)
													->first();
			$latestNews = $this->newsModel->latest()->take(6)->get();
			$branchAll = $this->branchModel->where('bank_id', $bankId)
										   ->get();
			
			if (count($branchAll) >= 10) {
				$branchRandom = $branchAll->random(10);
			} else {
				$branchRandom =$branchAll;
			}

			return [
				'bank' => $bank,
				'exchangeRate' => $exchangeRate,
				'date' => $date,
				'latestNews' => $latestNews,
				'branchRandom' => $branchRandom
			];
		} catch (\Throwable $th) {
			return NULL;
		}
	}

	public function bank($slug)
	{
		try {
			$bank = $this->getBank($slug);
			$provinces = $this->provinceModel
							  ->whereHas('branch', function($query) use ($bank) {
							  		$query->where('bank_id', $bank->id);
							  })
							  ->with(['branch' => function($query) use ($bank){
							  		$query->where('bank_id', $bank->id);
							  }])
							  ->get();
			return [
				'bank' => $bank,
				'provinces' => $provinces
			];
		} catch (\Exception $e) {
			return NULL;
		}
	}

	public function bankBranchDetail($branchId)
	{
		try {
			$branch = $this->branchModel->findOrFail($branchId);

			$cache = Cache::remember('branch_detail', 60, function() use ($branchId, $branch) {
				$districtSameBranchs = $this->branchModel->where('id', '!=', $branchId)
											 		 ->where('bank_id', $branch->bank_id)
											 		 ->where('district_id', $branch->district_id)
													 ->get();

				if (count($districtSameBranchs) >= 10) {
					$districtSameBranchs = $districtSameBranchs->random(10);
				}
				$otherBranchs = $this->branchModel->where('id', '!=', $branchId)
												->where('bank_id', $branch->bank_id)
												->get();
				if (count($otherBranchs) >= 10) {
					$otherBranchs = $otherBranchs->random(10);
				}
				

				return [
						'districtSameBranchs' => $districtSameBranchs,
						'otherBranchs' => $otherBranchs,
				];
			});
			$bankName = $branch->bank->name_en;
			$district = $branch->district->name;
			$province = $branch->district->province->name;
			$branchName = $branch->name;
			$string = "Chi nhánh ngân hàng <b>$bankName</b>, chi nhánh $district ngân hàng <b>$bankName</b>, chi nhánh ngân hàng <b>$bankName</b> tại $district, $branchName ngân hàng <b>$bankName</b>, địa chỉ chi nhánh ngân hàng <b>$bankName</b> tại $district $province";

			return [
				'branch' => $branch,
				'bank' => $branch->bank,
				'districtSameBranchs' => $cache['districtSameBranchs'],
				'otherBranchs' => $cache['otherBranchs'],
				'string' => $string,
			];
		} catch (\Throwable $th) {
			return NULL;
		}
	}

	public function bankIntro($bankId)
	{
		try {
			$bank = $this->bankModel->findOrFail($bankId);
			$branchAll = $this->branchModel->where('bank_id', $bankId)
									  ->get();
			
			if (count($branchAll) >= 10) {
				$branchRandom = $branchAll->random(10);
			} else {
				$branchRandom = $branchAll;
			}
			
			return [
				'bank' => $bank,
				'branchRandom' => $branchRandom,
			];
		} catch (\Throwable $th) {
			return NULL;
		}
	}

	public function provinceBank($bankName, $provinceSlug)
	{
		try {
			$bank = $this->getBank($bankName);
			$province = $this->provinceModel->where('slug', $provinceSlug)->first();
			$branchs = $province->branch->where('bank_id', $bank->id);
			$data = $this->paginate($branchs);
			$data->withPath(url()->current());
			$bankName = $bank->name_en;
			$provinceName = $province->name;
			$string = "Chi nhánh ngân hàng <b>$bankName</b>, chi nhánh ngân hàng <b>$bankName</b> tại $provinceName, địa chỉ chi nhánh ngân hàng <b>$bankName</b> tại $provinceName, danh sách chi nhánh ngân hàng $bankName tại $provinceName, tìm kiếm chi nhánh ngân hàng $bankName ở $provinceName, $bankName $provinceName";
			
			return [
				'province' => $province,
				'bank' => $bank,
				'branchs' => $data,
				'string' => $string
			];
		} catch (\Exception $e) {
			return NULL;
		}
	}

	public function district($bankName, $province, $district)
	{
		try {
			$bank = $this->getBank($bankName);
			$district = $this->districtModel->where('slug', $district)->first();
			$branchs = $this->branchModel->where('bank_id', $bank->id)
										 ->where('district_id', $district->id)
										 ->paginate(30);
			$bankName = $bank->name_en;
			$districtName = $district->name;
			$province = $district->province->name;
			$string = "Chi nhánh ngân hàng <b>$bankName</b>, chi nhánh $districtName ngân hàng <b>$bankName</b>, chi nhánh ngân hàng <b>$bankName</b> tại $districtName, địa chỉ chi nhánh ngân hàng <b>$bankName</b> tại $districtName $province, chi nhánh ngân hàng $bankName tại $province";

			return [
				'bank' => $bank,
				'district' => $district,
				'branchs' => $branchs,
				'province' => $district->province,
				'string' => $string,
			];
		} catch (\Exception $e) {
			return NULL;
		}
	}

	public function atmDetail($id)
	{
		try {
			$atm = $this->atmModel->findOrFail($id);
			$otherAtm = $this->atmModel->where('id', '!=', $id)
									   ->where('province_id', $atm->province_id)
									   ->get();
			
			if (count($otherAtm) >= 20) {
				$otherAtm = $otherAtm->random(20);
			}

			return [
				'atm' => $atm,
				'otherAtm' => $otherAtm
			];
		} catch (\Throwable $th) {
			return NULL;
		}
	}

	public function provinceAtm($bank, $province, $bankId, $provinceId)
	{
		try {
			
			$districts = $this->districtModel->where('province_id', $provinceId)
											->whereHas('atm', function($query) use ($bankId){
												$query->where('bank_id', $bankId);
											})
											->get();
			$atms = $this->atmModel->where('province_id', $provinceId)
								   ->where('bank_id', $bankId)
								   ->paginate(30);

			return [
				'bank' => $this->bankModel->findOrFail($bankId),
				'districts' => $districts,
				'province' => $this->provinceModel->findOrFail($provinceId),
				'atms' => $atms
			];
		} catch (\Throwable $th) {
			return NULL;
		}
	}

	public function districtAtm($bank, $district, $province, $bankId, $provinceId, $districtId)
	{
		try {
			$atms = $this->atmModel->where('bank_id', $bankId)
								   ->where('province_id', $provinceId)
								   ->where('district_id', $districtId)
								   ->paginate(20);
			$news = $this->newsModel->latest()->take(6)->get();

			return [
				'bank' => $this->bankModel->findOrFail($bankId),
				'atms' => $atms,
				'district' => $this->districtModel->findOrFail($districtId),
				'province' => $this->provinceModel->findOrFail($provinceId),
				'news' => $news
			];
		} catch (\Throwable $th) {
			return NULL;
		}
	}

	public function bankAtm($bankId)
	{
		try {
			$provinces = $this->provinceModel->whereHas('atm', function($query) use ($bankId){
												$query->where('bank_id', $bankId);
											 })
											 ->get();
			$atms = $this->atmModel->where('bank_id', $bankId)->get();
			
			if (count($atms) >= 20) {
				$atms = $atms->random(20);
			}
			$bank = $this->bankModel->findOrFail($bankId);

			return [
				'provinces' => $provinces,
				'bank' => $bank,
				'atms' => $atms
			];
		} catch (\Throwable $th) {
			return NULL;
		}
	}

	public function atmList($request)
	{
		$banks = $this->bankModel->all();
		$provinceThebank = $this->provinceModel->all();
		$districtTheBank = $this->districtModel->all();
		$bank_id = rand(1, 3);
		$atms = $this->atmModel->where('bank_id', $bank_id)
							   ->get();

		if (count($atms) >= 30) {
			$atms = $atms->random(30);
		}
		
		return [
			'banks' => $banks,
			'provinceThebank' => $provinceThebank,
			'districtTheBank' => $districtTheBank,
			'atms' => $atms
		];
	}

	public function atmProvince($province)
	{
		try {
			$province = $this->provinceModel->where('slug', $province)->first();
			$atmProvince = $this->atmModel->where('province_id', $province->id)->paginate(30);

			return [
				'province' => $province,
				'atmProvince' => $atmProvince,
			];
		} catch (\Exception $e) {
			return NULL;
		}
		
	}

	public function paginate($items, $perPage = 30, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

	public function getBank($slug)
	{
		return $this->bankModel->where('slug', $slug)->first();
	}
}
