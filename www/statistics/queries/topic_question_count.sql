SELECT topic.name, topic.id, question.`level`, COUNT(question.id) as question_count FROM
	platform__SFA__questions as question
	INNER JOIN platform__SFA__assquestions as assquestion
	on assquestion.question = question.question
	RIGHT JOIN platform__topic as topic
	on topic.id = question.topic
	GROUP BY topic.id, question.`level`;
