<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function index(Request $request, string $locale): View
    {
        $types = [
            'program' => trans('web.program_types.program'),
            'service' => trans('web.program_types.service'),
            'policy' => trans('web.program_types.policy'),
            'highlight' => trans('web.program_types.highlight'),
        ];

        $query = Program::query()->active()->orderBy('sort');

        $filterType = $request->string('type')->toString();
        if ($filterType && array_key_exists($filterType, $types)) {
            $query->where('type', $filterType);
        }

        $programs = $query->paginate(9)->withQueryString();

        return view('web.programs.index', [
            'programs' => $programs,
            'types' => $types,
            'activeType' => $filterType,
        ]);
    }

    public function show(string $locale, Program $program): View
    {
        abort_unless($program->is_active, 404);

        $related = Program::query()
            ->active()
            ->where('id', '!=', $program->id)
            ->where('type', $program->type)
            ->orderBy('sort')
            ->take(3)
            ->get();

        return view('web.programs.show', [
            'program' => $program,
            'relatedPrograms' => $related,
        ]);
    }
}
