<?php

namespace App\Http\Controllers;

use App\Models\JobDesk;
use App\Models\JobList;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobListController extends Controller
{
    public function index($uuid, $jobDeskId){
        if (!$order = Order::where(['uuid' => $uuid])->first()) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }

        $jobDesk = JobDesk::where(['order_id' => $order->id, 'id' => $jobDeskId])->orderBy('updated_at', 'DESC')->first();

        $jobListFinished = $jobDesk->jobList()->where('finished', true);
        $jobDesk['finished'] = $jobListFinished->count();
        $jobDesk['total'] = $jobDesk->jobList->count();

        // dd($jobDesk);

        return view('order.jobdesk.index', [
            'title' => 'Task List',
            'page' => 'order',
            'order' => $order,
            'jobDesk' => $jobDesk,
            'jobLists' => $jobDesk->jobList,
            'subpage1' => 'report',
        ]);
    }

    public function create($uuid, $jobDeskId){
        if (!$order = Order::where(['uuid' => $uuid])->first()) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }

        $jobDesk = JobDesk::where(['order_id' => $order->id, 'id' => $jobDeskId])->orderBy('updated_at', 'DESC')->first();

        return view('order.jobdesk.joblist-create', [
            'title' => 'Tambah Task List',
            'page' => 'order',
            'order' => $order,
            'jobDesk' => $jobDesk,
            'subpage1' => 'report',
        ]);
    }

    public function store($uuid, $jobDeskId, Request $request){
        $request->validate([
            'name' => 'required|min:3',
        ]);

        JobList::create([
            'name' => $request->name,
            'job_desk_id' => $jobDeskId,
        ]);

        return redirect("/order/$uuid/job-desk/$jobDeskId")->with([
            'success' => 'Data berhasil ditambahkan',
        ]);;
    }

    public function edit($uuid, $jobDeskId, $jobListId){
        if (!$order = Order::where(['uuid' => $uuid])->first()) {
            return redirect('/order/list')->withErrors([
                'message' => 'Order not found',
            ]);
        }
        
        if(!$jobDesk = JobDesk::where(['order_id' => $order->id, 'id' => $jobDeskId])->orderBy('updated_at', 'DESC')->first()){
            return redirect('/order/list')->withErrors([
                'message' => 'JobDesk not found',
            ]);
        }

        if(!$jobList = JobList::find($jobListId)){
            return redirect('/order/list')->withErrors([
                'message' => 'JobDesk not found',
            ]);
        }

        return view('order.jobdesk.joblist-edit', [
            'title' => "Edit {$jobList->name}",
            'page' => 'order',
            'order' => $order,
            'jobDesk' => $jobDesk,
            'jobList' => $jobList,
            'subpage1' => 'report',
        ]);
    }

    public function updateName($uuid, $jobDeskId, $jobListId, Request $request){
        $request->validate([
            'name' => 'required|min:3',
        ]);

        $jobList = JobList::find($jobListId);
        if (!$jobList) {
            return redirect('/order/list')->withErrors([
                'data' => 'data tidak ditemukan',
            ]);
        }

        $jobList->update([
            'name' => $request->name,
        ]);

        return redirect("/order/$uuid/job-desk/$jobDeskId")->with([
            'success' => 'Data has been updated',
        ]);
    }

    public function updateStatus($id, Request $request){
        if(!$jobList = JobList::find($id)){
            return response()->json([
                'message' => 'Job list not found',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'finished' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'data invalid',
                'data' => $request->all(),
            ], 400);
        }

        $jobList->update([
            'finished' => $request->finished,
        ]);

        return response()->json([
            'message' => 'data has been updated',
            'data' => $request->all(),
        ]);
    }

    public function delete($id){
        $document = JobList::find($id);
        if (!$document) {
            return response()->json([
                'message' => 'data not found',
            ], 404);
        }

        $document->delete();
        return response()->json([
            'message' => 'data has been deleted',
        ]);
    }
}
