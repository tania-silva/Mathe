SELECT
	student.id as student,
	question.question as question,
	question.correct as correct,
	ass.`level`,
	topic.name as topic,
	subtopic.name as subtopic,
	uni.country as country,
	student.uni_department as department
FROM (
	SELECT
		id as assessment_id,
		SPLIT_STR(unformatted_answer, "|", 1) as question,
		IF (SPLIT_STR(unformatted_answer, "|", 2) > 1, 1, 0) as correct
		FROM (
			SELECT id, qst01 as unformatted_answer FROM platform__SNA__assestment
			UNION ALL
			SELECT id, qst02 FROM platform__SNA__assestment
			UNION ALL
			SELECT id, qst03 FROM platform__SNA__assestment
			UNION ALL
			SELECT id, qst04 FROM platform__SNA__assestment
			UNION ALL
			SELECT id, qst05 FROM platform__SNA__assestment
			UNION ALL
			SELECT id, qst06 FROM platform__SNA__assestment
			UNION ALL
			SELECT id, qst07 FROM platform__SNA__assestment
			) as unformatted_answer
		WHERE unformatted_answer.unformatted_answer LIKE "%|%"
) as question
INNER JOIN platform__SNA__assestment ass on question.assessment_id = ass.id
INNER JOIN platform__students student on student.id = ass.id_stud
LEFT JOIN platform__university uni on uni.id = student.uni_name
LEFT JOIN platform__topic topic on topic.id = ass.topic
LEFT JOIN platform__subtopic subtopic on subtopic.id = ass.subtopic
WHERE ass.`level` in ("Basic", "Advanced");