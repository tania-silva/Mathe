SELECT student.id, COUNT(answer.id) as assessment_count FROM
	platform__students student
	LEFT JOIN platform__SFA__assanswer answer
	on student.id_stud = answer.id_stud
	GROUP BY student.id;
