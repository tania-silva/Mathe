SELECT topic.name, topic.id, question.`level`,COUNT(question.id) as use_count FROM
	platform__SFA__questions as question
	INNER JOIN platform__SFA__assquestions as assquestions
	on question.question = assquestions.question
	LEFT JOIN platform__SFA__assanswer as answer
	on assquestions.id_ass = answer.id_ass
	RIGHT JOIN platform__topic as topic
	on topic.id = question.topic
	GROUP BY topic.id, question.`level`;
