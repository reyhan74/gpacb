<?php
namespace App\Http\Controllers;
use App\Models\CandidateWeeklyTopic;
use Illuminate\Http\Request;
class CandidateTopicAdminController extends Controller {
 public function index(){ return view('manage.candidate-topics.index',['topics'=>CandidateWeeklyTopic::query()->orderBy('week_number')->get()]); }
 public function store(Request $r){ $d=$r->validate(['week_number'=>'required|integer|min:1|max:52','activity_date'=>'required|date','title'=>'required|string|max:255','description'=>'nullable|string|max:2000']); CandidateWeeklyTopic::query()->updateOrCreate(['week_number'=>$d['week_number']],$d+['is_active'=>true]); return back()->with('success','Tanggal dan judul kegiatan berhasil disimpan.'); }
 public function destroy(CandidateWeeklyTopic $topic){$topic->delete();return back()->with('success','Kegiatan berhasil dihapus.');}
}
