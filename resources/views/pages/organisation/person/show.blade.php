@section('nav_topbar')
	@include('widgets.common.nav_topbar', 
	['breadcrumb' => [
						['name' => $data['name'], 'route' => route('hr.organisations.show', [$data['id'], 'org_id' => $data['id']]) ], 
						['name' => 'Data Karyawan', 'route' => route('hr.persons.index', ['org_id' => $data['id']]) ],
						['name' => $person['name'], 'route' => route('hr.persons.index', ['org_id' => $data['id'] ])], 
					]
	])
@stop

@section('nav_sidebar')
	@include('widgets.common.nav_sidebar', [
		'widget_template'		=> 'plain_no_title',
		'widget_title'			=> 'Structure',		
		'widget_title_class'	=> 'text-uppercase ml-10 mt-20',
		'widget_body_class'		=> '',
		'widget_options'		=> 	[
										'sidebar'				=> 
										[
											'search'			=> [],
											'sort'				=> [],
											'page'				=> 1,
											'per_page'			=> 100
										]
									]
	])
@overwrite

@section('content_body')
	<div class="row">
		<div class="col-sm-6">
			@include('widgets.organisation.workleave.stat.left_quota', [
				'widget_template'		=> 'plain',
				'widget_title'			=> 'Sisa Cuti "'.$person['name'].'"',
				'widget_title_class'	=> 'text-uppercase ml-10 mt-20',
				'widget_body_class'		=> '',
				'widget_options'		=> 	[
												'personlist'			=>
												[
													'organisation_id'	=> $data['id'],
													'search'			=> ['id' => $person['id'], 'globalwage' => array_merge(['organisationid' => $data['id'], 'on' => date('Y-m-d')], (isset($filtered['search']) ? $filtered['search'] : []))],
													'sort'				=> (isset($filtered['sort']) ? $filtered['sort'] : ['persons.name' => 'asc']),
													'page'				=> 1,
													'active_filter'		=> (isset($filtered['active']) ? $filtered['active'] : null),
													'per_page'			=> 1,
												]
											]
			])
		</div>
		<div class="col-sm-6">
			@include('widgets.organisation.person.stat.average_loss_rate', [
				'widget_template'		=> 'plain',
				'widget_title'			=> 'Average Loss Rate "'.$person['name'].'"',
				'widget_options'		=> 	[
												'lossratelist'		=>
												[
													'organisation_id'	=> $data['id'],
													'search'			=> ['id' => $person['id'], 'globalattendance' => ['organisationid' => $data['id'], 'on' => date('Y-m-d')]],
													'sort'				=> [],
													'page'				=> 1,
													'per_page'			=> 100,
												]
											]
			])
	</div>
	<div class="row">
		<div class="col-sm-12">
			@include('widgets.organisation.person.work.table', [
				'widget_template'		=> 'panel',
				'widget_title'			=> '<h4>Pekerjaan Saat Ini "'.$person['name'].'"'.((Input::has('page') && (int)Input::get('page') > 1) ? '<small class="font-16"> Halaman '.Input::get('page').'</small></h4>' : null),
				'widget_title_class'	=> 'text-uppercase ml-10 mt-20',
				'widget_body_class'		=> '',
				'widget_options'		=> 	[
												'worklist'			=>
												[
													'organisation_id'	=> $data['id'],
													'search'			=> ['personid' => $person['id'], 'withattributes' => ['chart', 'chart.branch', 'chart.branch.organisation'], 'active' => true],
													'sort'				=> ['end' => 'asc'],
													'page'				=> (Input::has('page') ? Input::get('page') : 1),
													'per_page'			=> 100,
													'route_create'		=> route('hr.person.works.create', ['org_id' => $data['id'], 'person_id' => $person['id']]),
												]
											]
			])
		</div>
	</div>

	{!! Form::open(array('route' => array('hr.person.works.delete', 0),'method' => 'DELETE')) !!}
		@include('widgets.modal.delete', [
			'widget_template'		=> 'plain_no_title'
		])
	{!! Form::close() !!}
@overwrite

@section('content_filter')
@overwrite

@section('content_footer')
@overwrite