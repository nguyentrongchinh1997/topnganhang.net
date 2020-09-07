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

		return [
			'exchangeRate' => $exchangeRate,
			'banks' => $this->bankModel->all(),
			'provinces' => $this->provinceModel->all(),
			'districtHcm' => $this->districtModel->where('province_id', 2)->get(),
			'news' => $this->newsModel->latest()->take(6)->get(),
		];
	}

	public function news()
	{
		try {
			$news = $this->newsModel->latest()->paginate(10);

			return [
				'news' => $news
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
			
			return [
				'bank' => $bank,
				'exchangeRate' => $exchangeRate,
				'latestNews' => $latestNews
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

			return [
				'bank' => $bank,
				'exchangeRate' => $exchangeRate,
				'date' => $date,
				'latestNews' => $latestNews,
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
			$otherBranch = $this->branchModel->where('id', '!=', $branchId)
											 ->where('bank_id', $branch->bank_id)
											 ->get()
											 ->random(15);
			
			return [
				'branch' => $branch,
				'otherBranch' => $otherBranch
			];
		} catch (\Throwable $th) {
			return NULL;
		}
	}

	public function bankIntro($bankId)
	{
		try {
			return [
				'bank' => $this->bankModel->findOrFail($bankId),
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

			return [
				'province' => $province,
				'bank' => $bank,
				'branchs' => $data
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

			return [
				'bank' => $bank,
				'district' => $district,
				'branchs' => $branchs,
				'province' => $district->province
			];
		} catch (\Exception $e) {
			return NULL;
		}
	}

	public function atmDetail($id)
	{
		try {
			$atm = $this->atmModel->findOrFail($id);

			return [
				'atm' => $atm
			];
		} catch (\Throwable $th) {
			return NULL;
		}
	}

	public function provinceAtm($bank, $province, $bankId, $provinceId)
	{
		try {
			$districts = $this->districtTheBankModel->where('province_the_bank_id', $provinceId)
													->whereHas('atm', function($query) use ($bankId){
														$query->where('bank_id', $bankId);
													})
													->get();
			$atms = $this->atmModel->where('province_the_bank_id', $provinceId)
								   ->paginate(30);

			return [
				'bank' => $this->bankModel->findOrFail($bankId),
				'districts' => $districts,
				'province' => $this->provinceTheBankModel->findOrFail($provinceId),
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
								   ->where('province_the_bank_id', $provinceId)
								   ->where('district_the_bank_id', $districtId)
								   ->paginate(20);
			$news = $this->newsModel->latest()->take(6)->get();

			return [
				'bank' => $this->bankModel->findOrFail($bankId),
				'atms' => $atms,
				'district' => $this->districtTheBankModel->findOrFail($districtId),
				'province' => $this->provinceTheBankModel->findOrFail($provinceId),
				'news' => $news
			];
		} catch (\Throwable $th) {
			return NULL;
		}
	}

	public function bankAtm($bankId)
	{
		try {
			$provinces = $this->provinceTheBankModel->whereHas('atm', function($query) use ($bankId){
														$query->where('bank_id', $bankId);
													})
													->get();
			$bank = $this->bankModel->findOrFail($bankId);

			return [
				'provinces' => $provinces,
				'bank' => $bank
			];
		} catch (\Throwable $th) {
			//dd($th->getMessage());
			return NULL;
		}
	}

	public function atmList($request)
	{
		$banks = $this->bankModel->all();
		$provinceThebank = $this->provinceTheBankModel->all();
		$districtTheBank = $this->districtTheBankModel->all();
		
		return [
			'banks' => $banks,
			'provinceThebank' => $provinceThebank,
			'districtTheBank' => $districtTheBank,
		];
	}

	public function atmProvince($province)
	{
		try {
			$province = $this->provinceTheBankModel->where('slug', $province)->first();
			$atmProvince = $this->atmModel->where('province_the_bank_id', $province->id)->paginate(30);

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
