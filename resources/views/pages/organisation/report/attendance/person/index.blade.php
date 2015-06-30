@section('nav_topbar')
	@include('widgets.common.nav_topbar', 
	['breadcrumb' 	=> 	[	
							['name' => $data['name'], 'route' => route('hr.organisations.show', [$data['id'], 'org_id' => $data['id']]) ], 
							['name' => 'Laporan Aktivitas', 'route' => route('hr.report.attendances.index', ['org_id' => $data['id'], 'start' => $start, 'end' => $end]) ],
							['name' => $person['name'], 'route' => route('hr.attendance.persons.index', ['org_id' => $data['id'], 'person_id' => $person['id'], 'start' => $start, 'end' => $end]) ],
						]
	])
@stop

@section('nav_sidebar')
	@include('widgets.common.nav_sidebar', [
		'widget_template'		=> 'plain_no_title',
		'widget_title'			=> 'Structure',		
		'widget_title_class'	=> 'text-uppercase ml-10 mt-20',
		'widget_body_class'		=> '',
		'widget_options'	=> [
									'sidebar'				=>
									[
										'search'			=> [],
										'sort'				=> ['name' => 'asc'],
										'page'				=> 1,
										'per_page'			=> 100,
										'pengaturan'		=> 'yes',
										'active_attendance_report'	=> 'yes'
									]
								]
	])
@overwrite

@section('content_filter')
@overwrite

@section('content_body')	
	@include('widgets.organisation.report.attendance.person.table', [
		'widget_template'		=> 'panel',
		'widget_title'			=> 'Laporan Aktivitas "'.$person['name'].'"<br/> Tanggal '.date('d-m-Y',strtotime($start)).' - '.date('d-m-Y',strtotime($end)).''.((Input::has('page') && (int)Input::get('page') > 1) ? '<small class="font-16"> Halaman '.Input::get('page').'</small>' : null),
		'widget_title_class'	=> 'text-uppercase ml-10 mt-20',
		'widget_body_class'		=> '',
		'widget_options'		=> 	[
										'personlist'			=>
										[
											'organisation_id'	=> $data['id'],
											'search'			=> ['id' => $person['id'], 'processlogsondate' => ['on' => [$start, $end]]],
											'sort'				=> ['persons.name' => 'asc'],
											'page'				=> 1,
											'per_page'			=> 1,
											'route_create'		=> route('hr.calendars.create', ['org_id' => $data['id']])
										]
									]
	])

	@include('widgets.organisation.idle.table', [
		'widget_template'		=> 'panel',
		'widget_title'			=> '<h4>Catatan Perubahan Waktu Idle</h4>',
		'widget_title_class'	=> 'text-uppercase ml-10 mt-20',
		'widget_body_class'		=> '',
		'widget_options'		=> 	[
										'idlelist'			=>
										[
											'organisation_id'	=> $data['id'],
											'search'			=> ['ondate' => [$start, $end], 'withattributes' => ['createdby']],
											'sort'				=> ['start' => 'asc'],
											'page'				=> 1,
											'per_page'			=> 100,
											'route_create'		=> route('hr.idles.create', ['org_id' => $data['id']])
										]
									]
	])
@overwrite

@section('content_footer')
@overwrite