SELECT COUNT(question.id) as use_count, question.id, question.question FROM
	platform__SFA__questions as question
	LEFT JOIN platform__SFA__assquestions as assquestion 
	on assquestion.question = question.question
	LEFT JOIN platform__SFA__assanswer as answer
	on assquestion.id_ass = answer.id_ass
	GROUP BY question.id
	ORDER BY use_count DESC;
