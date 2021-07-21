<?php

namespace App\Helpers;
use Request;
use App\Log as LogModel;

/**
* 
*/
class Log
{
	public static function addToLog($subject,$user_name,$user_id)
	{
		$log = [];
		$log['subject'] = $subject;
		$log['user_name'] = $user_name;
		$log['user_id'] = $user_id;
		LogModel::create($log);
	}

	public static function logLists()
	{
		return LogModel::latest()->get();
	}

	public static function logDelete()
	{
		LogModel::truncate();
	}
}