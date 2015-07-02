@extends('widget_templates.'.($widget_template ? $widget_template : 'plain'))

@if (!$widget_error_count)
	@section('widget_title')
	<h1> {!! $widget_title or 'Laporan Kehadiran' !!} </h1>
	<small>Total data {{ $PersonComposer['widget_data']['personlist']['person-pagination']->total() }}</small>
	<?php
		$PersonComposer['widget_data']['personlist']['person-pagination']->setPath('hr.report.attendances.index');
	 ?>

	 @if(isset($PersonComposer['widget_data']['personlist']['active_filter']) && !is_null($PersonComposer['widget_data']['personlist']['active_filter']))
		<div class="clearfix">&nbsp;</div>
		@foreach($PersonComposer['widget_data']['personlist']['active_filter'] as $key => $value)
			<span class="active-filter">{{$value}}</span>
		@endforeach
	@endif
	
	<div class="btn-group pull-right">
		<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fa fa-file"></i> Export to <span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
			<li><a href="{{route('hr.report.attendances.index', array_merge(Input::all(), ['print' => 'yes', 'mode' => 'csv']))}}">CSV</a></li>
			<li><a href="{{route('hr.report.attendances.index', array_merge(Input::all(), ['print' => 'yes', 'mode' => 'xls']))}}">XLS</a></li>
		</ul>
	</div>

	@overwrite

	@section('widget_body')
			@if(isset($PersonComposer['widget_data']['personlist']['person']))
				<table class="table">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Jabatan</th>
							<th>Total Aktif</th>
							<th>Total Idle I</th>
							<th>Total Idle II</th>
							<th>Total Idle III</th>
							<!-- <th>Total Absence</th>
							<th>Possible Total Effective</th> -->
							<th>Time Loss Rate</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					@foreach($PersonComposer['widget_data']['personlist']['person'] as $key => $value)
						<tbody>
							<tr>
								<td>
									{{$key+1}}
								</td>
								<td>
									{{$value['name']}}
								</td>
								<td>
									{{$value['position']}} {{$value['department']}} {{$value['branch']}}
								</td>
								<td>
									{{floor($value['total_active']/3600)}} Jam<br/>
									{{floor(($value['total_active']%3600)/60)}} Menit</br/> 
									{{floor(($value['total_active']%3600)%60)}} Detik
								</td>
								<td>
									{{floor($value['total_idle_1']/3600)}} Jam<br/>
									{{floor(($value['total_idle_1']%3600)/60)}} Menit</br/> 
									{{floor(($value['total_idle_1']%3600)%60)}} Detik
								</td>
								<td>
									{{floor($value['total_idle_2']/3600)}} Jam<br/>
									{{floor(($value['total_idle_2']%3600)/60)}} Menit</br/> 
									{{floor(($value['total_idle_2']%3600)%60)}} Detik
								</td>
								<td>
									{{floor($value['total_idle_3']/3600)}} Jam<br/>
									{{floor(($value['total_idle_3']%3600)/60)}} Menit</br/> 
									{{floor(($value['total_idle_3']%3600)%60)}} Detik
								</td>
								<!-- <td>
									{{gmdate('H:i:s', $value['total_absence'])}}
								</td>
								<td>
									{{gmdate('H:i:s', $value['possible_total_effective'])}}
								</td> -->
								<td>
									<?php $tlr = ($value['total_absence']!=0 ? $value['total_absence'] : 1) / ($value['possible_total_effective']!=0 ? $value['possible_total_effective'] : 1);?>
									{{round(abs($tlr) * 100, 2)}} %
								</td>
								<td class="text-right">
									<a href="{{route('hr.attendance.persons.index', ['person_id' => $value['id'], 'org_id' => $data['id'], 'start' => $start, 'end' => $end])}}" class="btn btn-default"><i class="fa fa-eye"></i></a>
								</td>
							</tr>
						</tbody>
					@endforeach
				</table>

				<div class="row">
					<div class="col-sm-12 text-center">
						<p>Menampilkan {!! $PersonComposer['widget_data']['personlist']['person-display']['from']!!} - {!! count($PersonComposer['widget_data']['personlist']['person']) !!}</p>
						{!! $PersonComposer['widget_data']['personlist']['person-pagination']->appends(Input::all())->render()!!}
					</div>
				</div>

				<div class="clearfix">&nbsp;</div>
			@endif
	@overwrite	
@else
	@section('widget_title')
	@overwrite

	@section('widget_body')
	@overwrite
@endif