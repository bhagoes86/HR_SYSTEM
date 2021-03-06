<?php namespace App\Models\Observers;

use Validator, Event;
use \App\Models\Chart;
use \App\Models\Menu;
use \App\Models\WorkAuthentication;
use App\Events\CreateRecordOnTable;

/* ----------------------------------------------------------------------
 * Event:
 * 	Created						
 * 	Saving						
 * 	Updated						
 * 	Deleting						
 * ---------------------------------------------------------------------- */

class ChartObserver 
{
	public function created($model)
	{
		if(isset($model['attributes']['branch_id']))
		{
			$attributes['record_log_id'] 		= $model->id;
			$attributes['record_log_type'] 		= get_class($model);
			$attributes['name'] 				= 'Menambah Struktur Organisasi pada cabang '.$model->branch->name;
			$attributes['notes'] 				= 'Menambah Struktur Organisasi pada cabang '.$model->branch->name.' pada '.date('d-m-Y');
			$attributes['action'] 				= 'delete';

			Event::fire(new CreateRecordOnTable($attributes));

			if(!isset($model['attributes']['path']) || ($model['attributes']['path']==$model['attributes']['id']))
			{
				$newparent 						= Chart::where('id',  $model['attributes']['id'])->update(['path' => $model['attributes']['id']]);
			}
			else
			{
				$newparent 						= Chart::where('path',  $model['attributes']['path'])->first();
				$new 							= Chart::where('id', $model['attributes']['id'])->update(['path' => $model['attributes']['path'].','.$model['attributes']['id'], 'chart_id' => $newparent['id']]);
			}
			return true;
		}
	}

	public function saving($model)
	{
		$validator 							= Validator::make($model['attributes'], $model['rules']);

		if ($validator->passes())
		{
			return true;
		}
		else
		{
			$model['errors'] 				= $validator->errors();

			return false;
		}
	}

	public function updating($model)
	{
		//
		if(isset($model['attributes']['branch_id']))
		{
			$attributes['record_log_id'] 		= $model->id;
			$attributes['record_log_type'] 		= get_class($model);
			$attributes['name'] 				= 'Mengubah Struktur Organisasi pada cabang '.$model->branch->name;
			$attributes['notes'] 				= 'Mengubah Struktur Organisasi pada cabang '.$model->branch->name.' pada '.date('d-m-Y');
			$attributes['old_attribute'] 		= json_encode($model->getOriginal());
			$attributes['new_attribute'] 		= json_encode($model->getAttributes());
			$attributes['action'] 				= 'save';

			Event::fire(new CreateRecordOnTable($attributes));

			if(isset($model->getDirty()['chart_id']))
			{
				$childs 						= Chart::where('path', 'like', $model->path.'%')->get();

				if($model->chart()->count())
				{
					$newpath 					= $model->chart->path.','.$model->id;
				}
				else
				{
					$newpath 					= $model->id;
				}

				foreach ($childs as $key => $value) 
				{
					$new 						= Chart::where('id', $value['id'])->update(['path' => (preg_replace('/'.$model->path.',/', $newpath.',', $value['path'], 1))]);
				}

				$updatechartpath 				= Chart::where('id',  $model['attributes']['id'])->update(['path' => $newpath]);
			}

			return true;
		}	
	}

	public function deleting($model)
	{
		//
		if(count(explode(',', $model['attributes']['path']))==1 && $model['attributes']['tag']!='admin')
		{
			$model['errors'] 				= ['Tidak dapat menghapus posisi/departemen tertinggi diperusahaan'];

			return false;
		}

		$deletes 							= Chart::where('path', 'like', $model['attributes']['path'].'%')->with(['menus'])->get();

		foreach ($deletes as $key => $value) 
		{
			if($value->works()->count()&& $model['attributes']['tag']!='admin')
			{
				$model['errors'] 			= ['Tidak dapat menghapus posisi/departemen dengan pekerja yang masih aktif bekerja'];

				return false;
			}
			
			foreach($value['menus'] as $key2 => $value2)
			{
				$auth 	 		= new WorkAuthentication;
				$delete 		= $auth->find($value2['pivot']['id']);

				if($delete && !$delete->delete())
				{
					$model['errors']	= $delete->getError();
						
					return false;
				}
			}
		}

		$deletes 							= Chart::where('path', 'like', $model['attributes']['path'].'%')->with(['menus'])->delete();

		return true;
	}

	public function deleted($model)
	{
		if(isset($model['attributes']['branch_id']))
		{
			$attributes['record_log_id'] 		= $model->id;
			$attributes['record_log_type'] 		= get_class($model);
			$attributes['name'] 				= 'Menghapus Struktur Organisasi pada cabang '.$model->branch->name;
			$attributes['notes'] 				= 'Menghapus Struktur Organisasi pada cabang '.$model->branch->name.' pada '.date('d-m-Y');
			$attributes['action'] 				= 'restore';

			Event::fire(new CreateRecordOnTable($attributes));
		}
	}
}
