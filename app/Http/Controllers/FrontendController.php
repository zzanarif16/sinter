<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Contact;
use App\Models\Inspiration;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\View\View;

class FrontendController extends Controller
{
    public function index(): View
    {
        $hasProducts = Schema::hasTable('products');
        $hasInspirations = Schema::hasTable('inspirations');
        $hasAbouts = Schema::hasTable('abouts');
        $hasContacts = Schema::hasTable('contacts');

        $featuredFamilies = collect(Product::FAMILY_OPTIONS)
            ->keys()
            ->map(fn(string $family): array => [
                'key' => $family,
                'label' => ucfirst(strtolower($family)),
                'slug' => Str::slug($family),
            ]);

        return view('frontend.home', [
            'featuredFamilies' => $featuredFamilies,
            'featuredInspirations' => $hasInspirations ? Inspiration::query()
                ->where('is_featured', true)
                ->latest()
                ->take(3)
                ->get() : collect(),
            'about' => $hasAbouts ? About::query()->latest()->first() : null,
            'contact' => $hasContacts ? Contact::query()->latest()->first() : null,
        ]);
    }

    public function products(): View
    {
        $products = Schema::hasTable('products')
            ? Product::query()->orderBy('family')->orderBy('sort_order')->get()
            : new Collection();

        $familyLinks = collect(Product::FAMILY_OPTIONS)
            ->keys()
            ->map(fn(string $family): array => [
                'key' => $family,
                'label' => ucfirst(strtolower($family)),
                'slug' => Str::slug($family),
            ]);

        return view('frontend.products', [
            'productsByFamily' => $products->groupBy('family'),
            'sections' => Product::SECTION_OPTIONS,
            'selectedFamily' => null,
            'familyLinks' => $familyLinks,
        ]);
    }

    public function productsByFamily(string $family): View
    {
        $selectedFamily = collect(Product::FAMILY_OPTIONS)
            ->keys()
            ->first(fn(string $item): bool => Str::slug($item) === Str::lower($family));

        abort_if(blank($selectedFamily), 404);

        $products = Schema::hasTable('products')
            ? Product::query()
            ->where('family', $selectedFamily)
            ->orderBy('sort_order')
            ->latest('id')
            ->get()
            : new Collection();

        $familyLinks = collect(Product::FAMILY_OPTIONS)
            ->keys()
            ->map(fn(string $item): array => [
                'key' => $item,
                'label' => ucfirst(strtolower($item)),
                'slug' => Str::slug($item),
            ]);

        return view('frontend.products', [
            'productsByFamily' => collect([$selectedFamily => $products]),
            'sections' => Product::SECTION_OPTIONS,
            'selectedFamily' => $selectedFamily,
            'familyLinks' => $familyLinks,
        ]);
    }

    public function inspirations(): View
    {
        return view('frontend.inspirations', [
            'inspirations' => Schema::hasTable('inspirations') ? Inspiration::query()
                ->latest()
                ->get() : collect(),
        ]);
    }

    public function productDetail(string $slug): View
    {
        abort_unless(Schema::hasTable('products'), 404);

        $product = Product::query()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedProducts = Product::query()
            ->where('family', $product->family)
            ->whereKeyNot($product->id)
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        return view('frontend.product-detail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'sections' => Product::SECTION_OPTIONS,
        ]);
    }

    public function inspirationDetail(string $slug): View
    {
        abort_unless(Schema::hasTable('inspirations'), 404);

        $inspiration = Inspiration::query()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedInspirations = Inspiration::query()
            ->whereKeyNot($inspiration->id)
            ->latest()
            ->take(4)
            ->get();

        return view('frontend.inspiration-detail', [
            'inspiration' => $inspiration,
            'relatedInspirations' => $relatedInspirations,
        ]);
    }

    public function about(): View
    {
        return view('frontend.about', [
            'about' => Schema::hasTable('abouts') ? About::query()->latest()->first() : null,
        ]);
    }
}
