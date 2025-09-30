<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(Request $request, string $locale): View
    {
        $query = Announcement::query()->orderByDesc('starts_at');

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }

        $announcements = $query->paginate(9)->withQueryString();

        return view('web.announcements.index', [
            'announcements' => $announcements,
            'activeStatus' => $status,
            'activeType' => $type,
        ]);
    }
}
