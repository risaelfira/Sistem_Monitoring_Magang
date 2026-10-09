<?php

namespace App\Http\Controllers;

use App\Models\FinalProjectTask;
use App\Models\FinalProjectTaskStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinalProjectTaskController extends Controller
{
    private const STATUSES = [
        'Belum',
        'On Progress',
        'Done',
    ];

    public function index()
    {
        $tasks = FinalProjectTask::where('user_id', Auth::id())
            ->with(['statusHistories'])
            ->orderByRaw("CASE status
                WHEN 'On Progress' THEN 1
                WHEN 'Belum' THEN 2
                WHEN 'Done' THEN 3
                ELSE 4 END")
            ->orderBy('deadline')
            ->orderByDesc('created_at')
            ->get();

        $counts = [
            'all' => $tasks->count(),
            'belum' => $tasks->where('status', 'Belum')->count(),
            'on_progress' => $tasks->where('status', 'On Progress')->count(),
            'done' => $tasks->where('status', 'Done')->count(),
        ];

        return view('final-project.index', compact('tasks', 'counts'));
    }

    public function create()
    {
        return view('final-project.form', [
            'task' => null,
            'statuses' => self::STATUSES,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'status' => 'required|in:Belum,On Progress,Done',
        ]);

        $data['user_id'] = Auth::id();

        FinalProjectTask::create($data);

        return redirect()
            ->route('final-project.index')
            ->with('success', 'Kegiatan proyek akhir berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $task = FinalProjectTask::where('user_id', Auth::id())
            ->findOrFail($id);

        return view('final-project.form', [
            'task' => $task,
            'statuses' => self::STATUSES,
        ]);
    }

    public function update(Request $request, $id)
    {
        $task = FinalProjectTask::where('user_id', Auth::id())
            ->findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
        ]);

        $task->update($data);

        return redirect()
            ->route('final-project.index')
            ->with('success', 'Kegiatan proyek akhir berhasil diperbarui.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Belum,On Progress,Done',
        ]);

        $task = FinalProjectTask::where('user_id', Auth::id())
            ->findOrFail($id);

        $oldStatus = $task->status;
        $newStatus = $request->status;

        if ($oldStatus !== $newStatus) {
            $task->update(['status' => $newStatus]);

            FinalProjectTaskStatusHistory::create([
                'final_project_task_id' => $task->id,
                'user_id' => Auth::id(),
                'from_status' => $oldStatus,
                'to_status' => $newStatus,
                'changed_at' => now(),
            ]);
        }

        return redirect()
            ->route('final-project.index')
            ->with(
                'success',
                $oldStatus === $newStatus
                    ? 'Status tidak berubah.'
                    : 'Status kegiatan berhasil diubah menjadi ' . $newStatus . '.'
            );
    }

    public function destroy($id)
    {
        $task = FinalProjectTask::where('user_id', Auth::id())
            ->findOrFail($id);

        $task->delete();

        return redirect()
            ->route('final-project.index')
            ->with('success', 'Kegiatan proyek akhir berhasil dihapus.');
    }
}
