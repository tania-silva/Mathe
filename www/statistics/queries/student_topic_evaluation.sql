SELECT student.id_stud, topic.name, topic.id as topic_id, COUNT(topic.id) as topic_interaction from 
	platform__students student
	LEFT JOIN platform__SFA__assanswer answer
	on answer.id_stud = student.id_stud
	LEFT JOIN platform__SFA__assestment assessment
	on assessment.id = answer.id_ass
	LEFT JOIN platform__SFA__assquestions questions
	on questions.id_ass = assessment.id
	LEFT JOIN platform__topic topic
	on topic.id = questions.topic
	GROUP BY student.id_stud, topic.id;
