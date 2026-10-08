<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Member;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicSiteController extends Controller
{
    public function home()
    {
        $settings = SiteSetting::current();
        $articles = Content::where('approval_status', 'approved')->latest()->take(3)->get();
        $totalAnggota = Member::where('tipe_anggota', 'anggota')->count();
        $totalAngkatan = Member::whereNotNull('angkatan')->distinct('angkatan')->count('angkatan');

        return view('public.home', compact('settings', 'articles', 'totalAnggota', 'totalAngkatan'));
    }

    public function checkNia(Request $request)
    {
        $search = trim((string) $request->input('q', ''));
        $result = null;

        if ($search) {
            $result = Member::query()
                ->where('nia', $search)
                ->orWhere('nis', $search)
                ->orWhere('nama', 'like', "%{$search}%")
                ->first();
        }

        return view('public.check-nia', compact('search', 'result'));
    }

    public function articles(Request $request)
    {
        $search = trim((string) $request->input('q', ''));
        $type = (string) $request->input('type', '');

        $query = Content::query()->where('approval_status', 'approved');

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%");
            });
        }

        if (in_array($type, ['berita', 'materi'], true)) {
            $query->where('type', $type);
        }

        $articles = $query->latest()->paginate(9)->withQueryString();

        return view('public.articles', compact('articles', 'search', 'type'));
    }

    public function showArticle(string $slug)
    {
        $article = Content::query()
            ->where('approval_status', 'approved')
            ->get()
            ->first(fn (Content $content) => Str::slug($content->title) === $slug);

        abort_if($article === null, 404);

        return view('public.article-detail', compact('article'));
    }
}
