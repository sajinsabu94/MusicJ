<?php 

class SecureSqlConfig
{
	static function set_sql_config($type=NULL)
	{
		if(strtoupper($type) == "LOCALHOST")
		{
			return array(
				'host' => 'localhost:3306',
				'user' => 'root',
				'pass' => '',
				'db' => 'musicj'
			);
		}
		else{
			return array(
				'host' => 'localhost:3306',
				'user' => 'root',
				'pass' => '',
				'db' => 'musicj'
			);
		}
	}
}

class SecureSqlMusic
{
	private static $config;
	static function get_sql_config()
	{
		self::$config = SecureSqlConfig::set_sql_config();
	}
	static function query($sql, $has_ret = FALSE, $types = NULL)
	{
		self::get_sql_config();
		$cn = new mysqli(
			self::$config['host'],
			self::$config['user'],
			self::$config['pass'],
			self::$config['db']
		);
		
		$result = null;

		if($cn->errno <>0)
		{
			trigger_error('Database error occured #'. $cn->errno . ' : '. $cn->error . E_USER_ERROR);
		}

		$ret = NULL;
		$st = $cn->prepare($sql);

		if(is_null($types))
		{
			if(!$has_ret)
			{
				$st->execute();
				$st->close();
				$cn->close();

				$ret = "Query Executed";
			}
			else
			{
				$st->execute();
				$bool = false;
				$p = array();
				$code = '$st->bind_result(';
				for($i = 0 ; $i<$st->field_count; $i++)
				{
					if(!$bool)
					{
						$bool = true;
						$code .= '$p['. $i .']';
					}
					else
					{
						$code .= ',$p['. $i .']';
					}
				}
				$code .=');';
				eval($code);
				$result = array();
				$row = 0;
				while($st->fetch())
				{
					for($i=0 ; $i< count($p) ; $i++)
					{
						$result[$row][$i] = $p[$i];
					}
					$row++;
				}
				$st->close();
				$cn->close();
			}
		}
		else
		{
			if(!$has_ret)
			{
				$arg = func_get_args();
				$code = '$st->bind_param($types';
				for($i = 3; $i < count($arg) ; $i++)
				{
					$code .= ',$arg['. $i .']';
				}
				$code .= ');';
				eval($code);

				$st->execute();
				$st->close();
				$cn->close();

				$ret = "Query Executed";
			}
			else
			{
				$arg = func_get_args();
				$code = '$st->bind_param($types';
				for($i=3 ; $i< count($arg) ; $i++)
				{
					$code .= ',$arg['. $i .']';
				}
				$code .= ');';
				eval($code);

				$st->execute();
				$bool = false;
				$p = array();

				$code_result = '$st->bind_result(';
				for($i = 0 ; $i<$st->field_count; $i++)
				{
					if(!$bool)
					{
						$bool = true;
						$code_result .= '$p['. $i .']';
					}
					else
					{
						$code_result .= ',$p['. $i .']';
					}
				}
				$code_result .=');';
				eval($code_result);
				$result = array();
				$row = 0;
				while($st->fetch())
				{
					for($i=0 ; $i< count($p) ; $i++)
					{
						$result[$row][$i] = $p[$i];
					}
					$row++;
				}
				$st->close();
				$cn->close();				
			}
		}
		return $result;
	}
}
?>
