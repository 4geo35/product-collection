<?php

namespace GIS\ProductCollection\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use GIS\ProductCollection\Interfaces\ProductCollectionModelInterface;
use GIS\ProductCollection\Models\ProductCollection;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ProductCollectionController extends Controller
{
    public function index(): View
    {
        $modelClass = config("product-collection.customProductCollectionModel") ?? ProductCollection::class;
        Gate::authorize("viewAny", $modelClass);
        return view("pct::admin.product-collections.index");
    }

    public function show(ProductCollectionModelInterface $collection): View
    {
        Gate::authorize("viewAny", $collection);
        return view("pct::admin.product-collections.show", compact("collection"));
    }
}
