<?php

namespace App\Http\Controllers\Mda;

use App\Http\Controllers\Controller;
use App\Models\Evidence;
use App\Models\FileType;
use App\Models\Progress;
use App\Models\Target;
use App\Repositories\MdaRepository;
use Exception;
use Illuminate\Http\Request;

class ProgressController extends Controller
{

    protected $mdaRepository;

    public function __construct(MdaRepository $mdaRepository)
    {
        $this->mdaRepository = $mdaRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        return inertia('Mda/Progress/CreatePage', [
            'targetId' => $id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        //dd($request->all());
        $request->validate([
            'progress_percent' => ['required', 'integer'],
            'description' => ['required', 'string'],
            'evidence' => ['required','array'],
            'evidence.*' => ['file', 'max:2048', 'mimes:zip,jpg,jpeg,png,pdf,docx,xls,xlsx,csv,mp3,mp4'],
        ]);

        try{
            $mda_data = $this->mdaRepository->getCurrentUserMdaAndDepartment();

            $target = Target::findOrFail($id);

            $pending_progress = Progress::where('progressable_type', 'App\Models\Target')
                ->where('progressable_id', $id)
                ->where('is_approved', false)
                ->first();

            if ($pending_progress) {
                return back()->withErrors(['error' => 'There is already unapproved progress for this target. Please wait for approval before submitting new progress.']);
            }

            $last_progress = Progress::where('progressable_type', Target::class)
                ->where('progressable_id', $target->id)
                ->orderBy('created_at', 'desc')
                ->first();

            if (!is_null($last_progress) && $last_progress->progress_percent >= $request->progress_percent) {
                return back()->withErrors(['error' => 'Progress percentage must be greater than the last recorded progress percentage (' . $last_progress->progress_percent . '%).']);
            }


            $progress = Progress::create([
                'progressable_type' => 'App\Models\Target',
                'progressable_id' => $target->id,
                'mda_id' => $mda_data['mda']->id,
                'progress_percent' => $request->progress_percent,
                'progress_description' => $request->description,
                'is_approved' => false,
            ]);


            foreach ($request->file('evidence') as $file) {
                $extension = $file->guessExtension();
                $uniqueName = uniqid() . '_' . $file->getClientOriginalName();
                $file->storeAs('uploads', $uniqueName);

                Evidence::create([
                    'evidenceable_type' => 'App\Models\Progress',
                    'evidenceable_id' => $progress->id,
                    'file_path' => $uniqueName,
                    'file_type' => $extension,
                    'description' => $request->description,
                ]);
            }

            return back()->with('success', 'Progress uploaded successfully');

        }catch(Exception $e)
        {
            dd($e);
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
