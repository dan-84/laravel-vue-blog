<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Contracts\TagRepository;
use App\Repositories\Contracts\PostRepository;
use Mcamara\LaravelLocalization\LaravelLocalization;

class AjaxController extends Controller
{
    /**
     * @var PostRepository
     */
    protected $posts;

    /**
     * @var TagRepository
     */
    protected $tags;

    /**
     * @var LaravelLocalization
     */
    protected $localization;

    /**
     * AjaxController constructor.
     */
    public function __construct(PostRepository $posts, TagRepository $tags, LaravelLocalization $localization)
    {
        $this->posts = $posts;
        $this->tags = $tags;
        $this->localization = $localization;
    }

    /**
     * Global index search.
     *
     * @return mixed
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        return empty($query) ? [] : $this->posts->search($query)->take(50)->get();
    }

    /**
     * Search internal transatables routes.
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function routesSearch(Request $request)
    {
        $items = [];

        $routes = __('routes');

        foreach ($routes as $name => $uri) {
            $items[$name] = $uri;
        }

        return [
            'items' => $items,
        ];
    }

    /**
     * Search tags.
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function tagsSearch(Request $request)
    {
        $query = $request->get('q');

        $locale = app()->getLocale();

        return [
            'items' => $this->tags->query()
                ->where("name->{$locale}", 'like', "%$query%")
                ->pluck('name'),
        ];
    }

    /**
     * @return array
     */
    public function imageUpload(Request $request)
    {
        $uploadedImage = $request->file('upload');

        // Resize image below 600px width if needed
        $image = Image::make($uploadedImage->openFile())->widen(600, function ($constraint) {
            $constraint->upsize();
        });

        $imagePath = "/tmp/{$uploadedImage->getClientOriginalName()}";
        Storage::disk('public')->put($imagePath, $image->stream());

        return [
            'uploaded' => true,
            'url'      => "/storage{$imagePath}",
            'width'    => $image->width(),
            'height'   => $image->height(),
        ];
    }
}
