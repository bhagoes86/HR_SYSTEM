@extends('widget_templates.'.($widget_template ? $widget_template : 'plain'))

@if (!$widget_error_count)
	@section('widget_title')
		<h1> {!! $widget_title  or 'Data Karyawan' !!} </h1>
		<small>Total data {{$PersonComposer['widget_data']['personlist']['person-pagination']->total()}}</small>

		@if(isset($PersonComposer['widget_data']['personlist']['active_filter']) && !is_null($PersonComposer['widget_data']['personlist']['active_filter']))
			<div class="clearfix">&nbsp;</div>
			@foreach($PersonComposer['widget_data']['personlist']['active_filter'] as $key => $value)
				<span class="active-filter">{{$value}}</span>
			@endforeach
		@endif
	@overwrite

	@section('widget_body')
		<a href="{{ $PersonComposer['widget_data']['personlist']['route_create'] }}" class="btn btn-primary">Tambah Data</a>
		@if(isset($PersonComposer['widget_data']['personlist']['person']))
			<div class="clearfix">&nbsp;</div>
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr class="row">
							<th class="">No</th>
							<th class=""></th>
							<th class="">Nama</th>
							<th class="">Posisi</th>
							<th class="">Email</th>
							<th class="">&nbsp;</th>
						</tr>
					</thead>
					<?php $i = $PersonComposer['widget_data']['personlist']['person-display']['from'];?>
					@foreach($PersonComposer['widget_data']['personlist']['person'] as $key => $value)
						<tbody>
							<tr class="row">
								<td class="">
									{{$i}}
								</td>
								<td class="">
									{!! HTML::image($value['avatar'], '', array( 'width' => 64, 'height' => 64, 'class' => 'img-rounded' )) !!} 
								</td>
								<td class="">
									{{$value['name']}}
								</td>
								<td class="">
									@if(isset($value['works'][0]))
										{{$value['works'][0]['name']}} {{$value['works'][0]['tag']}} {{$value['works'][0]['branch']['name']}}
									@endif
								</td>
								<td class="">
									@if(isset($value['contacts'][0]))
										{{$value['contacts'][0]['value']}}
									@endif
								</td>
								<td class="text-right">
									<div class="btn-group">
										<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pengaturan <span class="caret"></span></button>
										<ul class="dropdown-menu dropdown-menu-right">
											<li>
												<a href="javascript:;" data-toggle="modal" data-target="#delete" data-delete-action="{{ route('hr.persons.delete', [$value['id'], 'org_id' => $data['id']]) }}" title="hapus"><i class="fa fa-trash fa-fw"></i> Hapus</a>
											</li>
											<li>
												<a href="{{route('hr.persons.edit', [$value['id'], 'org_id' => $data['id']])}}" title="ubah"><i class="fa fa-pencil fa-fw"></i> Ubah</a>
											</li>
											<li>
												<a href="{{route('hr.persons.show', [$value['id'], 'org_id' => $data['id']])}}"  title="lihat"><i class="fa fa-eye fa-fw"></i> Detail</a>
											</li>
											<li>
												<a href="{{route('hr.person.works.index', ['person_id' => $value['id'], 'org_id' => $data['id']])}}" title="karir"><i class="fa fa-building fa-fw"></i> Pekerjaan</a>
											</li>
											<li>
												<a href="{{route('hr.person.schedules.index', ['person_id' => $value['id'], 'org_id' => $data['id']])}}" title="jadwal"><i class="fa fa-calendar fa-fw"></i> Jadwal</a>
											</li>
											<li>
												<a href="{{route('hr.person.workleaves.index', ['person_id' => $value['id'], 'org_id' => $data['id']])}}" title="jatah cuti"><i class="fa fa-bed fa-fw"></i> Jatah Cuti</a>
											</li>
											<li>
												<a href="{{route('hr.person.contacts.index', ['person_id' => $value['id'], 'org_id' => $data['id']])}}" title="kontak"><i class="fa fa-phone fa-fw"></i> Kontak</a>
											</li>
											<li>
												<a href="{{route('hr.person.documents.index', ['person_id' => $value['id'], 'org_id' => $data['id']])}}" title="dokumen"><i class="fa fa-file fa-fw"></i> Dokumen</a>
											</li>
											<li>
												<a href="{{route('hr.person.relatives.index', ['person_id' => $value['id'], 'org_id' => $data['id']])}}" title="kerabat"><i class="fa fa-child fa-fw"></i> Kerabat</a>
											</li>
										</ul>
									</div>
								</td>
							</tr>
						</tbody>
						<?php $i++;?>
					@endforeach
				</table>
			</div>

			<div class="row">
				<div class="col-sm-12 text-center">
					<p>Menampilkan {!!$PersonComposer['widget_data']['personlist']['person-display']['from']!!} - {!!$PersonComposer['widget_data']['personlist']['person-display']['to']!!}</p>
					{!!$PersonComposer['widget_data']['personlist']['person-pagination']->appends(Input::all())->render()!!}
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