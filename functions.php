<?php 


/*
 * Our bad words validation function
 */
add_filter('gform_validation', 'custom_validation');
function custom_validation($validation_result){
    $form = $validation_result["form"];
 
	$stop_words = array(
		'outsource',
		'Sir/Madam',
		'Sir/ Madam',
		'Sir / Madam',
		'Sir /Madam',
		'long term relationship',
		'find your site',
		'lead generation',
		'SEO', 
		'SEO’s',
		'visitors',
		'Optimisation',
		'Optimization',
		'http',
		'https',
		'horny',
		'sex',
		'spelled wrong'
	);
 
	$stop_id = array();
 
	foreach($_POST as $id => $post)
	{
		if(strpos_arr($post, $stop_words))
		{
			/*
			 * We have a match so store the post ID and initiate validation error
			 */	
			 $stop_id[] = $id;
		}
	}
 
	if(sizeof($stop_id) > 0)
	{
		$validation_result['is_valid'] = false;
 
		foreach($form['fields'] as &$field) 
		{
			foreach($stop_id as $id)
			{
				$the_id = (int) str_replace('input_', '', $id);
 
				if($field['id'] == $the_id)
				{
					$field['failed_validation'] = true;
					$field['validation_message'] = 'Please do not send us unsolicited messages';
				}
			}
		}
	}
 
    //Assign modified $form object back to the validation result
    $validation_result["form"] = $form;
    return $validation_result;
 
}
