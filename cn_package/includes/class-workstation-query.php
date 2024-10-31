<?php

/**
 * Register all Query for the plugin
 *
 * @link       http://coderninja.in
 * @since      1.0.0
 *
 * @package    Cn_Query
 * @subpackage Cn_Query/includes
 */

/**
 * 
 *
 *
 * @since      1.0.0
 * @package    Cn_Query
 * @subpackage Cn_Query/includes
 * @author     Realty Workstation <info@realtyworkstation.com>
 */
class Cn_Query {

	// public function __construct() {
	// }

	public function iFetch($SQL)
	{
		global $wpdb;
		$SQL = $wpdb->prepare($SQL);
		$record = array_shift($wpdb->get_results($SQL));
		$record=json_decode(json_encode($record),true);
		return $record;
	}

	public function iWhileFetch($sql){
		global $wpdb;
		$sql = $wpdb->prepare($sql);
		$record = $wpdb->get_results($sql);
		$record=json_decode(json_encode($record),true);
		return $record;
	}

	public function iUpdateArray($table, $postData = array(),$conditions = array(),$html_spl='No')
	{
		global $wpdb;
		foreach($postData as $k=>$value)
		{				
			$postDataKey = esc_sql ($k);
			$postDataValue = esc_sql ($value);
			$postDataArrayValue = esc_sql($postData[$postDataKey]);
			if($html_spl=='Yes')
			{
				$postDataValue = htmlspecialchars($postDataValue);
			}
			if($postDataValue==NULL)
				$values .= "`$postDataKey` = NULL, ";
			else
				$values .= "`$postDataKey` = '$postDataArrayValue', ";
		}
		$values = substr($values, 0, strlen($values) - 2);
		foreach($conditions as $k => $v)
		{
			$conditionKey = esc_sql($k);
			$conditionValue = esc_sql($v);
			$v = htmlspecialchars($conditionValue);			
			$conds .= "$conditionKey = '$conditionValue'";
		}			
		$update = "UPDATE `$table` SET $values WHERE $conds";
		// $update = $wpdb->prepare($update);
		$rs=$wpdb->query($update);
		if($wpdb->last_error){
			$error=$wpdb->last_error;
			$last_query=$wpdb->last_query;
			$success='warning';
			$msg='Something was wrong';
		}
		else{
			$success='success';
			$msg='updated successfully';
		}
		$response=array('success'=> $success,'msg'=>$msg,'error'=> $error,'last_query' =>$last_query);
		return json_encode($response);
	}

	public function iQuery($SQL,&$rs)
	{
		if($this->iMainQuery($SQL,$rs))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function iMainQuery($SQL,&$rs)
	{
		global $wpdb;
		$SQL = $wpdb->prepare($SQL);
		$rs=$wpdb->query($SQL);
		if($wpdb->last_error){
			$error=$wpdb->last_error;
			$last_query=$wpdb->last_query;
			$success='warning';
		}
		else{
			$success='success';
		}
		$response=array('success'=> $success,'error'=> $error,'last_query' =>$last_query);
		return $response;

	}

	public function iInsert($table, $postData = array(),$html_spl='No')
	{
		global $wpdb;
		$sql = "DESC $table";
		$getFields = array();
		$sql = $wpdb->prepare($sql);
		$fieldArr = $wpdb->get_results($sql);
		foreach($fieldArr as $field)
		{
			$field=json_decode(json_encode($field),true);
			$getFields[sizeof($getFields)] = $field['Field'];
		}
		$fields = "";
		$values = "";
		if (sizeof($getFields) > 0)
		{				
			foreach($getFields as $k)
			{
				$kValue = esc_sql( $k );
				$postDataValue = esc_sql( $postData[$kValue] );
				if (isset($postDataValue))
				{
					if($html_spl=='No')
					{
						$postDataValue = $postDataValue;
					}
					else
					{
						$postDataValue = htmlspecialchars($postDataValue);
					}
					
					$fields .= "`$kValue`, ";
					$values .= "'$postDataValue', ";
				}
			}			
			$fields = substr($fields, 0, strlen($fields) - 2);
			$values = substr($values, 0, strlen($values) - 2);
			$insert = "INSERT INTO $table ($fields) VALUES ($values)";
			// $insert = $wpdb->prepare($insert);
			$rs=$wpdb->query($insert);
			if($wpdb->last_error){
				$error=$wpdb->last_error;
				$last_query=$wpdb->last_query;
				$success='warning';
				$msg='Something was wrong';
			}
			else{
				$success='success';
				$msg='Added successfully';
				$insert_id=$wpdb->insert_id;
			}
		}
		else
		{
			$msg='Something was wrong';
			$success='warning';
		}
		$response=array('success'=> $success,'msg'=>$msg,'error'=> $error,'last_query' =>$last_query,'insert_id'=>$insert_id);
		return json_encode($response);
	}	

	public function showMessage($type,$title,$text=NULL,$Button=false,$timer=1600)
	{
		ob_start();
		?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				swal({
					type: '<?php _e($type); ?>',
					title: '<?php _e($title); ?>',
					text: '<?php _e($text); ?>',
					showConfirmButton: '<?php _e($Button); ?>',
					timer: '<?php _e($timer); ?>'
				});
				
			});
		</script>
		<?php 
		$ReturnString = ob_get_contents(); ob_end_clean(); 
 		return $ReturnString;
	}

	
	

}




