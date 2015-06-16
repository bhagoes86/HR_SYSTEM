@section('area')
	@include('widgets.common.form_name', [
		'widget_template'	=> 'panel',
		'widget_options'	=> ['widget_title'		=> 'Tambah Organisasi :',
								'form_url'			=> route('hr.organisations.store', ['id' => $id]),
								'identifier'		=> 1,
								'search'			=> ['id' => $id],
								'sort'				=> [],
								'page'				=> 1,
								'per_page'			=> 1,
								]
	])	
@stop