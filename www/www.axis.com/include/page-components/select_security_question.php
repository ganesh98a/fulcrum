<?php
function getSecurityQuestionSelectBox($selectedQuestion = '', $name = 'security_question', $tabindex = '0')
{
	//$selectedQuestion = html_entity_decode($selectedQuestion, ENT_QUOTES);
	$questionList = '<select style="Width: 185" size="1" name="'.$name.'" tabindex="'.$tabindex.'">';
	//$questionList .= '<option value="'.$selectedQuestion.'">'.$selectedQuestion.'</option>';
	
	$questionList .= '<option value=""></option>';

	//favorite movie
	if ($selectedQuestion == 'What is your favorite movie?') {
		$questionList .= '<option value="What is your favorite movie?" selected>What is your favorite movie?</option>';
	} else {
		$questionList .= '<option value="What is your favorite movie?">What is your favorite movie?</option>';
	}

	//pet's name
	if ($selectedQuestion == 'What is your pet&#039;s name?') {
		$questionList .= '<option value="What is your pet&#039;s name?" selected>What is your pet&#039;s name?</option>';
	} else {
		$questionList .= '<option value="What is your pet&#039;s name?">What is your pet&#039;s name?</option>';
	}

	//favorite game
	if ($selectedQuestion == 'What is your favorite game?') {
		$questionList .= '<option value="What is your favorite game?" selected>What is your favorite game?</option>';
	} else {
		$questionList .= '<option value="What is your favorite game?">What is your favorite game?</option>';
	}

	//Dad's middle name
	if ($selectedQuestion == 'What is your Dad&#039;s middle name?') {
		$questionList .= '<option value="What is your Dad&#039;s middle name?" selected>What is your Dad&#039;s middle name?</option>';
	} else {
		$questionList .= '<option value="What is your Dad&#039;s middle name?">What is your Dad&#039;s middle name?</option>';
	}

	//Mother's maiden name
	if ($selectedQuestion == 'What is your Mother&#039;s maiden name?') {
		$questionList .= '<option value="What is your Mother&#039;s maiden name?" selected>What is your Mother&#039;s maiden name?</option>';
	} else {
		$questionList .= '<option value="What is your Mother&#039;s maiden name?">What is your Mother&#039;s maiden name?</option>';
	}

	//City of birth
	if ($selectedQuestion == 'What city were you born in?') {
		$questionList .= '<option value="What city were you born in?" selected>What city were you born in?</option>';
	} else {
		$questionList .= '<option value="What city were you born in?">What city were you born in?</option>';
	}

	$questionList .= '</select>';
	echo $questionList;
}
?>