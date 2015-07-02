@extends('widget_templates.'.($widget_template ? $widget_template : 'plain'))
@if (!$widget_error_count)
	@section('widget_title')
		<h1> {{ is_null($id) ? 'Tambah Karir ' : 'Ubah Karir '}} "{{$person['name']}}" </h1> 
	@overwrite

	@section('widget_body')
		<div class="clearfix">&nbsp;</div>
		{!! Form::open(['url' => $WorkComposer['widget_data']['worklist']['form_url'], 'class' => 'form no_enter']) !!}	
			<div class="form-group">
				<label class="control-label">Posisi</label>
				@include('widgets.organisation.branch.chart.select', [
					'widget_options'		=> 	[
													'chartlist'			=>
													[
														'organisation_id'	=> $data['id'],
														'search'			=> ['withattributes' => ['branch'], 'child' => (Session::get('user.menuid')==4 ? Session::get('user.chartpath') : '' )],
														'sort'				=> ['name' => 'asc'],
														'page'				=> 1,
														'per_page'			=> 100,
														'chart_id'			=> $WorkComposer['widget_data']['worklist']['work']['chart_id'],
														'tabindex'			=> 1,
													]
												]
				])
			</div>
			<div class="form-group">
				<label class="control-label">Calendar</label>
				@include('widgets.organisation.calendar.select', [
					'widget_options'		=> 	[
													'calendarlist'			=>
													[
														'organisation_id'	=> $data['id'],
														'search'			=> [],
														'sort'				=> ['name' => 'asc'],
														'page'				=> 1,
														'per_page'			=> 100,
														'calendar_id'		=> $WorkComposer['widget_data']['worklist']['work']['calendar_id'],
														'tabindex'			=> 2,
													]
												]
				])
			</div>
			<div class="form-group">
				<label class="control-label">Status</label>
				{!!Form::select('status', ['contract' => 'Kontrak', 'internship' => 'Magang', 'trial' => 'Probation', 'permanent' => 'Tetap', 'others' => 'Lainnya'], $WorkComposer['widget_data']['worklist']['work']['status'], ['class' => 'form-control select2', 'tabindex' => 3]) !!}
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Start</label>
						{!!Form::input('text', 'start', $WorkComposer['widget_data']['worklist']['work']['start'], ['class' => 'form-control date-mask', 'tabindex' => 4])!!}
					</div>	
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">End</label>
						{!!Form::input('text', 'end', $WorkComposer['widget_data']['worklist']['work']['end'], ['class' => 'form-control date-mask', 'tabindex' => 5])!!}
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label">Alasan Berhenti</label>
				{!!Form::textarea('reason_end_job', $WorkComposer['widget_data']['worklist']['work']['reason_end_job'], ['class' => 'form-control', 'tabindex' => 6])!!}
			</div>
			<div class="form-group text-right">
				<a href="{{ $WorkComposer['widget_data']['worklist']['route_back'] }}" class="btn btn-default mr-5">Batal</a>
				<input type="submit" class="btn btn-primary" value="Simpan">
			</div>
		{!! Form::close() !!}
	@overwrite	
@else
	@section('widget_title')
	@overwrite

	@section('widget_body')
	@overwrite
@endif