<?php

namespace App\Http\Controllers\Dashboard\Professional;

use App\Http\Controllers\Controller;
use App\Http\Requests\CalendarAnnonceRequest as RequestsCalendarAnnonceRequest;
use App\Interfaces\Professional\CalendarProfessionalInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Request\CalendarAnnonceRequest;


class CalendarDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $calendar;


    public function __construct(CalendarProfessionalInterface $calendar)
    {
        $this->calendar = $calendar;
    }

    public function index()
    {
      return $this->calendar->index();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestsCalendarAnnonceRequest $request)
    {

        return $this->calendar->store($request);

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
        return $this->calendar->destroy($id);
    }

    public function get_events()
    {
        return $this->calendar->get_events();
    }

   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request)
    {
        return $this->calendar->post($request);
    }

    public function update_annonce(Request $request)
    {
        return $this->calendar->update_annonce($request);
    }
    public function update_planning(Request $request)
    {
        return $this->calendar->update_planning($request);
    }
}
