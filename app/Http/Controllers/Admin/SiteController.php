<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use App\Model\News;
use App\Model\Bank;
use App\Model\InterestRate;

class SiteController extends Controller
{
    public function home()
    {
        $news = News::latest()->paginate(20);

        return view('admin.pages.news_list', ['news' => $news]);
    }

    public function bankList()
    {
        return view('admin.pages.bank_list', ['banks' => Bank::all()]);
    }

    public function bankEditForm($bankId)
    {
        return view('admin.pages.bank_edit', ['bank' => Bank::findOrFail($bankId)]);
    }

    public function bankEdit(Request $request, $bankId)
    {
        Bank::updateOrCreate(
            [
                'id' => $bankId
            ],
            $request->all()
        );

        InterestRate::updateOrCreate(
            [
                'bank_id' => $bankId
            ],
            [
                'content' => $request->interest
            ]
        );

        return back()->with('success', 'Sửa thành công');
    }

    public function interestRateForm($bankId)
    {
        return view('admin.pages.interest_rate', ['']);
    }

    public function newsEditForm($newsId)
    {
        $news = News::findOrFail($newsId);

        return view('admin.pages.news_edit', ['news' => $news]);
    }

    public function newsEdit(Request $request, $newsId)
    {
        $inputs = $request->all();
        $news = News::findOrFail($newsId);

        if (empty($inputs['img'])) {
            $nameFile = $inputs['old_img'];
        } else {
            $nameFile = $this->uploadImage($inputs['img'], $inputs['title']);

            if (file_exists(public_path('upload/og_images/' . $news->image))) {
                unlink(public_path('upload/og_images/' . $news->image));
            }
            
            if (file_exists(public_path('upload/thumbnails/' . $news->image))) {
                unlink(public_path('upload/thumbnails/' . $news->image));
            }
        }
        News::updateOrCreate(
            [
                'id' => $newsId
            ],
            [
                'title' => $inputs['title'],
                'image' => $nameFile,
                'description' => $inputs['description'],
                'tags' => $inputs['tags'],
                'author' => $inputs['author'],
                'content' => $inputs['content']
            ]
        );

        return redirect()->route('admin.home')->with('success', 'Sửa thành công');
    }

    public function newsAddForm()
    {
        return view('admin.pages.news_add');
    }

    public function newsAdd(Request $request)
    {
        $inputs = $request->all();
        $nameFile = $this->uploadImage($request->img, $request->title);
        $inputs += ['slug' => str_slug($request->title), 'image' => $nameFile];
        News::create($inputs);

        return redirect()->route('admin.home')->with('success', 'Thêm thành công');
    }

    public function uploadImage($image, $title)
	{
		$format = $image->getClientOriginalExtension();
		$nameFile = str_slug($title) . '-' . rand() . '.' . $format;
		$data = getimagesize($image->getRealPath());
        $width = $data[0];
        $height = $data[1];
        $widthThumbnailResize = 255;
        $widthOgImageResize = 730;
        $heightThumbnailResize = ($height * $widthThumbnailResize) / $width;
        $heightOgImageResize = ($height * $widthOgImageResize) / $width;
    /*resize thumbnail*/
	    $thumbnail_resize = Image::make($image->getRealPath());              
	    $thumbnail_resize->resize($widthThumbnailResize, $heightThumbnailResize);
	    $thumbnail_resize->save(public_path('upload/thumbnails/' . $nameFile));
	/*resize og:image*/
	    $og_image_resize = Image::make($image->getRealPath());              
	    $og_image_resize->resize($widthOgImageResize, $heightOgImageResize);
	    $og_image_resize->save(public_path('upload/og_images/' . $nameFile));

	    return $nameFile;
	}
}
