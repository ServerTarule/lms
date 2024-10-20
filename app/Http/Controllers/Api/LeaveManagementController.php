<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Leaves;
use Carbon\Carbon;
class LeaveManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLeave(Request $request)
    {
        // Validate the request to ensure employee_id is present
        // $request->validate([
        //     'employee_id' => 'required|integer|exists:employees,id', // Adjust based on your employees table
        // ]);

        $today = Carbon::today()->format('Y-m-d');
        // Fetch leaves for the given employee_id from today onwards
        $leaves = Leaves::where('employee_id', $request->employee_id)
            ->where('start_time', '>=', $today)
            ->get();

           // $sql = $leaves->toSql();


        if ($leaves->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No leave records found for the specified employee.'
            ], 200);
        }

        return response()->json([
            'success' => true,
            'data' => $leaves,
            'message' => 'Leave records fetched successfully.'
        ], 200);

       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $dateOnly = Carbon::parse($request->start_time)->format('Y-m-d');

        $existingLeave = Leaves::whereDate('start_time', $dateOnly)
            ->where('employee_id', $request->employee_id)
            ->first();

        if ($existingLeave) {
            return response()->json([
                'success' => false,
                'message' => 'Leave record for this date already exists.'
            ], 200);
        }

        $user = Leaves::create([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'type' => $request->type,
            'comment' => $request->comment,
            'employee_id' => $request->employee_id,
        ]);

        if ($user) {
            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => 'Leave record created successfully.'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create leave record.'
            ], 200);
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
